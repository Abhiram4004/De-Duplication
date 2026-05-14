<?php

namespace App\Http\Controllers;

use App\Models\PriceList;

class PriceListController extends Controller
{
    public function index()
    {
        $records = PriceList::orderBy('created_at', -1)->paginate(50);
        return view('price_lists.index', compact('records'));
    }
}
