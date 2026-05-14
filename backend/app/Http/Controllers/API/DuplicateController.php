<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DuplicateGroup;
use App\Models\DuplicateGroupItem;
use App\Models\PriceList;
use App\Models\MergeLog;
use App\Models\AuditLog;
use Illuminate\Support\Facades\DB;

class DuplicateController extends Controller
{
    public function index()
    {
        $groups = DuplicateGroup::with('items')->orderBy('created_at', -1)->get()->map(function ($group) {
            $group->items_count = $group->items ? $group->items->count() : 0;
            return $group;
        });
        return response()->json($groups);
    }

    public function show($id)
    {
        $group = DuplicateGroup::with(['items.priceList'])->findOrFail($id);
        return response()->json($group);
    }

    public function merge(Request $request, $id)
    {
        $request->validate([
            'canonical_id' => 'required|exists:price_lists,id'
        ]);

        $group = DuplicateGroup::findOrFail($id);
        
        DB::transaction(function () use ($group, $request) {
            $canonicalId = $request->canonical_id;
            $items = DuplicateGroupItem::where('duplicate_group_id', $group->id)->get();
            $mergedIds = [];

            foreach ($items as $item) {
                $priceList = PriceList::find($item->price_list_id);
                if ($priceList->id == $canonicalId) {
                    $priceList->is_canonical = true;
                    $priceList->status = 'active';
                } else {
                    $priceList->is_canonical = false;
                    $priceList->status = 'merged';
                    $priceList->duplicate_of_id = $canonicalId;
                    $mergedIds[] = $priceList->id;
                }
                $priceList->save();
            }

            $group->status = 'resolved';
            $group->save();

            MergeLog::create([
                'duplicate_group_id' => $group->id,
                'canonical_price_list_id' => $canonicalId,
                'merged_price_list_ids' => $mergedIds,
                'merged_by' => $request->user()->id,
                'notes' => 'Merged via Duplicate Review UI',
            ]);

            AuditLog::create([
                'user_id' => $request->user()->id,
                'action' => 'merge',
                'description' => "Merged duplicate group {$group->group_code}",
                'metadata' => ['group_id' => $group->id, 'canonical_id' => $canonicalId]
            ]);
        });

        return response()->json(['message' => 'Merge successful']);
    }

    public function reject(Request $request, $id)
    {
        $group = DuplicateGroup::findOrFail($id);
        
        $group->status = 'ignored';
        $group->save();

        $items = DuplicateGroupItem::where('duplicate_group_id', $group->id)->get();
        foreach ($items as $item) {
            $priceList = PriceList::find($item->price_list_id);
            $priceList->status = 'active'; 
            $priceList->is_canonical = true;
            $priceList->save();
        }

        AuditLog::create([
            'user_id' => $request->user()->id,
            'action' => 'reject',
            'description' => "Rejected duplicate group {$group->group_code}",
            'metadata' => ['group_id' => $group->id]
        ]);

        return response()->json(['message' => 'Duplicates rejected']);
    }

    public function needsReview(Request $request, $id)
    {
        $group = DuplicateGroup::findOrFail($id);
        $group->status = 'pending';
        $group->save();

        return response()->json(['message' => 'Marked for review']);
    }
}
