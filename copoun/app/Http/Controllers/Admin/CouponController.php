<?php


namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Country;
use App\Reposatries\CouponReposatry;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Yajra\DataTables\DataTables;
use Auth, File;
use Illuminate\Support\Facades\Storage;


class CouponController extends Controller
{
    use \App\Traits\ApiResponseTrait;

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function allData(Request $request)
    {
        $data = new Coupon;
        if($request->cat_id)
            $data=$data->where('cat_id',$request->cat_id);
        if($request->country_id)
            $data=$data->where('country_id',$request->country_id);
        if($request->isSpecial)
            $data=$data->where('isSpecial',$request->isSpecial);
        if($request->status)
            $data=$data->where('status',$request->status);
        if($request->user_id)
            $data=$data->where('user_id','!=',null);
        if($request->userClick ==1)
            $data=$data->orderBy('activeCount','desc');
        if($request->userClick ==2)
            $data=$data->orderBy('unActiveCount','desc');
        if(!$request->userClick)
            $data=$data->orderBy('id','desc');
        $data=$data->get();
        return $this->mainFunction($data);
    }

    /***
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user_id=$request->user_id;
        $title='الكوبونات';
        if($user_id)
            $title='كوبونات الاعضاء';
        $cats=Category::all();
        $countries=Country::all();
        return view('Admin.Coupon.index',compact('title','cats','countries','user_id'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->save_Coupon($request,new Coupon);
        return $this->apiResponseMessage(1,'تمت الاضافة بنجاح',200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $Coupon = Coupon::find($request->id);
        $this->save_Coupon($request,$Coupon);
        return $this->apiResponseMessage(1,'تم التعديل بنجاح',200);
    }

    /**
     * @param $request
     * @param $Coupon
     */
    public function save_Coupon($request,$Coupon){
        $Coupon->storeName=$request->storeName;
        $Coupon->name=$request->name;
        $Coupon->endDate=$request->endDate;
        $Coupon->link=$request->link;
        $Coupon->code=$request->code;
        $Coupon->description=$request->description;
        $Coupon->status=$request->status;
        $Coupon->isSpecial=$request->isSpecial;
        $Coupon->cat_id=$request->cat_id;
        $Coupon->country_id=$request->country_id;
        if($request->storeLogo){
            deleteFile('Coupon',$Coupon->storeLogo);
            $Coupon->storeLogo=saveImage('Coupon',$request->storeLogo);
        }
        $Coupon->save();
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id,Request $request)
    {
        if ($request->type == 2) {
            $ids = explode(',', $id);
            $Coupon = Coupon::whereIn('id', $ids)->get();
            foreach($Coupon as $row){
                $this->deleteRow($row);
            }
        } else {
            $Coupon = Coupon::find($id);
            $this->deleteRow($Coupon);
        }
        return response()->json(['errors' => false]);
    }

    /**
     * @param $Coupon
     */
    private function deleteRow($Coupon){
        $Coupon->delete();
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function ChangeStatus(Request $request,$id){
        $Coupon=Coupon::find($id);
        $Coupon->status=$request->status;
        $Coupon->save();
        return $this->apiResponseMessage(1,'تم تغيير الحالة بنجاح',200);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit ($id)
    {
        $Coupon = Coupon::find($id);
        $Coupon['country_name']=$Coupon->country ? $Coupon->country->name_ar : 'لا يوجد';
        $Coupon['cat_name']=$Coupon->cat ? $Coupon->cat->name_ar : 'لا يوجد';
        $Coupon['user_name']=$Coupon->user ? $Coupon->user->name : 'بوساطة الادارة';
        return $Coupon;
    }


    /**
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    private function mainFunction($data)
    {
        return Datatables::of($data)->addColumn('action', function ($data) {
            $options = '<td class="sorting_1"><button  class="btn btn-info waves-effect btn-circle waves-light" onclick="editFunction(' . $data->id . ')" type="button" ><i class="fa fa-spinner fa-spin" id="loadEdit_' . $data->id . '" style="display:none"></i><i class="'.getIcon(1).'"></i></button>';
            $options .= ' <button title="رؤية التفاصيل" class="btn btn-primary waves-effect btn-circle waves-light" onclick="showData(' . $data->id . ')" type="button" ><i class="fa fa-spinner fa-spin" id="loadShow_' . $data->id . '" style="display:none"></i><i class="icon-Eye-Visible"></i></button>';
            $options .= ' <button type="button" onclick="deleteFunction(' . $data->id . ',1)" class="btn btn-dribbble waves-effect btn-circle waves-light"><i class="'.getIcon(2).'"></i> </button></td>';
            return $options;
        })->addColumn('checkBox', function ($data) {
            $checkBox = '<td class="sorting_1">' .
                '<div class="custom-control custom-checkbox">' .
                '<input type="checkbox" class="mybox" id="checkBox_' . $data->id . '" onclick="check(' . $data->id . ')">' .
                '</div></td>';
            return $checkBox;
        })->editColumn('storeLogo', function ($data) {
            $storeLogo = '<a href="'. getImageUrl('Coupon',$data->storeLogo).'" target="_blank">'
                .'<img  src="'. getImageUrl('Coupon',$data->storeLogo) . '" width="50px" height="50px"></a>';
            return $storeLogo;
        })->editColumn('status', function ($data) {
            if ($data->status == 1)
                $status = '<button class="btn waves-effect waves-light btn-rounded btn-success statusBut" style="cursor:pointer !important" onclick="ChangeStatus(0,'.$data->id.')" title="اضغط هنا لالغاء التفعيل">مفعل</button>';
            else
                $status = '<button class="btn waves-effect waves-light btn-rounded btn-danger statusBut" onclick="ChangeStatus(1,'.$data->id.')" style="cursor:pointer !important" title="اضغط هنا للتفعيل">غير مفعل</button>';
            return $status;
        })->editColumn('cat_id', function ($data) {
            return $data->cat ? $data->cat->name_ar : '';
        })->editColumn('country_id', function ($data) {
            return $data->country ? $data->country->name_ar : '';
        })->editColumn('rate',function($data){
            $rate= '<a href="/Admin/Rate/index?id='.$data->id.'&type=1" title="اضغط لمشاهدة التقييمات" target="_blank">'.$this->rate_div($data->rate).'</a>';
            return $data->rate > 0 ? $rate : 'لا توجد تقييمات ';
        })->editColumn('activeCount',function($data){
            return $data->activeCount   ? $data->activeCount : 0;
        })->editColumn('unActiveCount',function($data){
            return $data->unActiveCount   ? $data->unActiveCount : 0;
        })->rawColumns(['action' => 'action','checkBox'=>'checkBox','storeLogo'=>'storeLogo','status'=>'status','rate'=>'rate'])->make(true);
    }

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
}
