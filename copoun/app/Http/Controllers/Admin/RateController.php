<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Rate;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Validator, Auth;

class RateController extends Controller
{

    /**
     * @param Request $request
     * @param $product_id
     * @return mixed
     * @throws \Exception
     */
    public function allData(Request $request)
    {
        if($request->type == 1) {
            $Product = Coupon::find($request->id);
        }
        if($request->type == 2) {
            $Product = Coupon::find($request->id);
        }
        $Product = $Product->rateRelation;
        return $this->dataFunction($Product);
    }

    /**


    /**
     * @param $rate
     * @return string
     */
    private function rate_div($rate){
        $rate_icon='';
        for($i=0;$i<$rate;$i++) {
            $rate_icon.= '<i class="fa fa-star"></i>';
        }
        return $rate_icon;
    }



    function index (Request $request)
    {
        $type= $request->type;
        $product = Coupon::find($request->id);

        return view('Admin.Rate.index',compact('product','type'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function destroy (Request $request, $id)
    {
        if ($request->type == 2) {
            $ids = explode(',', $id);
            $Ads = Rate::whereIn('id', $ids)->delete();
        } else {
            $Ads = Rate::find($id);
            if (is_null($Ads)) {
                return 5;
            }
            $Ads->delete();
        }
        return response()->json(['errors' => false]);

    }

    /**
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    private function dataFunction ($data)
    {
        return Datatables::of($data)->addColumn('action', function ($data) {
            $options = '<button type="button" onclick="deleteFunction(' . $data->pivot->id . ',1)" class="btn btn-danger waves-effect btn-circle waves-light"><i class=" fas fa-trash"></i> </button></td>';
            return $options;
        })->addColumn('checkBox', function ($data) {
            $checkBox = '<td class="sorting_1">' .
                '<div class="custom-control custom-checkbox">' .
                '<input type="checkbox" class="mybox" id="checkBox_' . $data->id . '" onclick="check(' . $data->id . ')">' .
                '</div></td>';
            return $checkBox;
        })->editColumn('user_id', function ($data) {
            return '<a onclick="UserInfo(' . $data->id . ')" style="color : blue ; cursor:pointer">' . $data->name . '</a>';
        })->addColumn('rate',function($data){
            $rate= '<a href="/manage/Product/get_rates/'.$data->id.'" title="اضغط لمشاهدة التقييمات" target="_blank">'.$this->rate_div($data->pivot->rate).'</a>';
            return $data->pivot->rate > 0 ? $rate : 'لا توجد تقييمات لهذا المنتج';
        })->addColumn('comment',function($data){
            return $data->pivot->comment;
        })->addColumn('created_at',function($data){
            return $data->pivot->updated_at ?  $data->pivot->updated_at : $data->pivot->created_at;
        })->rawColumns(['action' => 'action','comment'=>'comment', 'checkBox' => 'checkBox', 'rate'=>'rate', 'user_id' => 'user_id', 'created_at' => 'created_at'])->make(true);

    }
}
