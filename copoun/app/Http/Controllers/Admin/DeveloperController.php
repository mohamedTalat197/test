<?php


namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Developer;
use Yajra\DataTables\DataTables;
use Auth, File;
use Illuminate\Support\Facades\Storage;


class DeveloperController extends Controller
{
    use \App\Traits\ApiResponseTrait;

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function allData(Request $request)
    {
        $data = Developer::orderBy('id','desc');
        $data=$data->get();
        return $this->mainFunction($data);
    }

    /***
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title='المطورين';
        return view('Admin.Developer.index',compact('title'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->save_Developer($request,new Developer);
        return $this->apiResponseMessage(1,'تمت الاضافة بنجاح',200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $Developer = Developer::find($request->id);
        $this->save_Developer($request,$Developer);
        return $this->apiResponseMessage(1,'تم التعديل بنجاح',200);
    }

    /**
     * @param $request
     * @param $Developer
     */
    public function save_Developer($request,$Developer){
        $Developer->name=$request->name;
        $Developer->title=$request->title;
        if($request->image){
            deleteFile('Developer',$Developer->image);
            $Developer->image=saveImage('Developer',$request->image);
        }
        $Developer->save();
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
            $Developer = Developer::whereIn('id', $ids)->get();
            foreach($Developer as $row){
                $this->deleteRow($row);
            }
        } else {
            $Developer = Developer::find($id);
            $this->deleteRow($Developer);
        }
        return response()->json(['errors' => false]);
    }

    /**
     * @param $Developer
     */
    private function deleteRow($Developer){
        $Developer->delete();
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function ChangeStatus(Request $request,$id){
        $user=Developer::find($id);
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
        $Developer = Developer::find($id);
        return $Developer;
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
            $options .= ' <button type="button" onclick="deleteFunction(' . $data->id . ',1)" class="btn btn-dribbble waves-effect btn-circle waves-light"><i class="'.getIcon(2).'"></i> </button></td>';
            return $options;
        })->addColumn('checkBox', function ($data) {
            $checkBox = '<td class="sorting_1">' .
                '<div class="custom-control custom-checkbox">' .
                '<input type="checkbox" class="mybox" id="checkBox_' . $data->id . '" onclick="check(' . $data->id . ')">' .
                '</div></td>';
            return $checkBox;
        })->editColumn('image', function ($data) {
            $image = '<a href="'. getImageUrl('Developer',$data->image).'" target="_blank">'
                .'<img  src="'. getImageUrl('Developer',$data->image) . '" width="50px" height="50px"></a>';
            return $image;
        })->rawColumns(['action' => 'action','checkBox'=>'checkBox','image'=>'image'])->make(true);
    }
}
