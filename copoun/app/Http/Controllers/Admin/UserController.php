<?php


namespace App\Http\Controllers\Admin;

use App\Reposatries\UserReposatry;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Yajra\DataTables\DataTables;
use Auth, File;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    use \App\Traits\ApiResponseTrait;

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function allData(Request $request)
    {
        $data = User::orderBy('id','desc');
        $data=$data->get();
        return $this->mainFunction($data);
    }

    /***
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title='الاعضاء';
        return view('Admin.User.index',compact('title'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function create(Request $request,UserReposatry $reposatry)
    {
        $validate_user=$reposatry->validate_user($request,0);
        if(isset($validate_user)){
            return $validate_user;
        }
        $this->save_User($request,new User);
        return $this->apiResponseMessage(1,'تمت الاضافة بنجاح',200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function update(Request $request,UserReposatry $reposatry)
    {
        $validate_user=$reposatry->validate_user($request,$request->id);
        if(isset($validate_user)){
            return $validate_user;
        }
        $User = User::find($request->id);
        $this->save_User($request,$User);
        return $this->apiResponseMessage(1,'تم التعديل بنجاح',200);
    }

    /**
     * @param $request
     * @param $User
     */
    public function save_User($request,$User){
        $User->name=$request->name;
        $User->phone=$request->phone;
        $User->email=$request->email;
        $User->dateOfBirth=$request->dateOfBirth;
        $User->gender=$request->gender;
        $User->status=1;
        if($request->password)
            $User->password=Hash::make($request->password);
        if($request->image){
            deleteFile('User',$User->image);
            $User->image=saveImage('User',$request->image);
        }
        $User->save();
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
            $User = User::whereIn('id', $ids)->get();
            foreach($User as $row){
                $this->deleteRow($row);
            }
        } else {
            $User = User::find($id);
            $this->deleteRow($User);
        }
        return response()->json(['errors' => false]);
    }

    /**
     * @param $User
     */
    private function deleteRow($User){
        $User->delete();
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function ChangeStatus(Request $request,$id){
        $user=User::find($id);
        $user->status=$request->status;
        $user->save();
        return $this->apiResponseMessage(1,'تم تغيير الحالة بنجاح',200);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit ($id)
    {
        $User = User::find($id);
        return $User;
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
        })->editColumn('image', function ($data) {
            $image = '<a href="'. getImageUrl('User',$data->image).'" target="_blank">'
                .'<img  src="'. getImageUrl('User',$data->image) . '" width="50px" height="50px"></a>';
            return $image;
        })->editColumn('status', function ($data) {
            if ($data->status == 1)
                $status = '<button class="btn waves-effect waves-light btn-rounded btn-success statusBut" style="cursor:pointer !important" onclick="ChangeStatus(0,'.$data->id.')" title="اضغط هنا لالغاء التفعيل">مفعل</button>';
            else
                $status = '<button class="btn waves-effect waves-light btn-rounded btn-danger statusBut" onclick="ChangeStatus(1,'.$data->id.')" style="cursor:pointer !important" title="اضغط هنا للتفعيل">غير مفعل</button>';
            return $status;
        })->rawColumns(['action' => 'action','checkBox'=>'checkBox','image'=>'image','status'=>'status'])->make(true);
    }
}
