<?php


namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Yajra\DataTables\DataTables;
use Auth, File;
use Illuminate\Support\Facades\Storage;


class CategoryController extends Controller
{
    use \App\Traits\ApiResponseTrait;

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function allData(Request $request)
    {
        $data = Category::orderBy('id','desc');
        $data=$data->get();
        return $this->mainFunction($data);
    }

    /***
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title='البلاد';
        return view('Admin.Category.index',compact('title'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->save_Category($request,new Category);
        return $this->apiResponseMessage(1,'تمت الاضافة بنجاح',200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $Category = Category::find($request->id);
        $this->save_Category($request,$Category);
        return $this->apiResponseMessage(1,'تم التعديل بنجاح',200);
    }

    /**
     * @param $request
     * @param $Category
     */
    public function save_Category($request,$Category){
        $Category->name_ar=$request->name_ar;
        $Category->name_en=$request->name_en;
        if($request->image){
            deleteFile('Category',$Category->image);
            $Category->image=saveImage('Category',$request->image);
        }
        $Category->save();
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
            $Category = Category::whereIn('id', $ids)->get();
            foreach($Category as $row){
                $this->deleteRow($row);
            }
        } else {
            $Category = Category::find($id);
            $this->deleteRow($Category);
        }
        return response()->json(['errors' => false]);
    }

    /**
     * @param $Category
     */
    private function deleteRow($Category){
        $Category->delete();
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function ChangeStatus(Request $request,$id){
        $user=Category::find($id);
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
        $Category = Category::find($id);
        return $Category;
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
            $image = '<a href="'. getImageUrl('Category',$data->image).'" target="_blank">'
                .'<img  src="'. getImageUrl('Category',$data->image) . '" width="50px" height="50px"></a>';
            return $image;
        })->rawColumns(['action' => 'action','checkBox'=>'checkBox','image'=>'image'])->make(true);
    }
}
