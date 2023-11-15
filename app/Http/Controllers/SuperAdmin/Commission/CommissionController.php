<?php

namespace App\Http\Controllers\SuperAdmin\Commission;

use App\Http\Controllers\ImageController;
use App\Models\Model\SuperAdmin\Commission\Commission;
use App\Models\Service\SuperAdmin\Commission\CommissionService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
class CommissionController extends Controller
{
   protected $commission;
    protected $imageController;
    function __construct(CommissionService $commission, ImageController $imageController)
    {
        $this->commission=$commission;
        $this->imageController=$imageController;
    }

    public function index()
    {
        $commissionLists =Commission::where('agent_id', Auth::user()->id)->orderBy('order','desc')->get()->unique('order_no');
        return view('super-admin.commission-list.index',compact('commissionLists'));
    }
    public function detail($id)
    {
        $commissionLists =Commission::where('agent_id', $id)->orderBy('order','desc')->get()->unique('order_no');
        $totalAmount =Commission::where('agent_id', $id)->orderBy('order','desc')->get()->sum('amount');
        return view('super-admin.commission-list.single',compact('commissionLists', 'totalAmount'));
    }


}
