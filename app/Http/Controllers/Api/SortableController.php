<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class SortableController extends Controller
{
    public function sortable()
    {
        $orders = explode(',', Request::get('orders'));
        $ids_order = Request::get('ids_order');
//        return $ids_order;
        $ids_order = str_replace('sortable%5B%5D=', '', $ids_order);
//        $ids_order = substr($ids_order, 1);
        $ids_order = explode('&', $ids_order);
        for ($i = 0; $i < sizeof($ids_order); $i++) {
            DB::table(Request::get('table'))
                ->where('id', $ids_order[$i])
                ->update(array('order' => $orders[$i]));
        }
    }
}
