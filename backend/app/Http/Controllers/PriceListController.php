<?php

namespace App\Http\Controllers;

use App\Models\PriceList;

class PriceListController extends Controller
{
    public function index()
    {
        $records = PriceList::latest()->paginate(50);
        return view('price_lists.index', compact('records'));
    }
}
