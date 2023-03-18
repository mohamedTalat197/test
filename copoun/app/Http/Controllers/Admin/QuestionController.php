<?php


namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Question;
use Yajra\DataTables\DataTables;
use Auth, File;
use Illuminate\Support\Facades\Storage;


class QuestionController extends Controller
{
    use \App\Traits\ApiResponseTrait;

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function allData(Request $request)
    {
        $data = Question::orderBy('id','desc');
        $data=$data->get();
        return $this->mainFunction($data);
    }

    /***
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title='الاساله الشائعه';
        return view('Admin.Question.index',compact('title'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->save_Question($request,new Question);
        return $this->apiResponseMessage(1,'تمت الاضافة بنجاح',200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $Question = Question::find($request->id);
        $this->save_Question($request,$Question);
        return $this->apiResponseMessage(1,'تم التعديل بنجاح',200);
    }

    /**
     * @param $request
     * @param $Question
     */
    public function save_Question($request,$Question){
        $Question->question_ar=$request->question_ar;
        $Question->question_en=$request->question_en;
        $Question->answer_ar=$request->answer_ar;
        $Question->answer_en=$request->answer_en;
        $Question->save();
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
            $Question = Question::whereIn('id', $ids)->get();
            foreach($Question as $row){
                $this->deleteRow($row);
            }
        } else {
            $Question = Question::find($id);
            $this->deleteRow($Question);
        }
        return response()->json(['errors' => false]);
    }

    /**
     * @param $Question
     */
    private function deleteRow($Question){
        $Question->delete();
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function ChangeStatus(Request $request,$id){
        $user=Question::find($id);
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
        $Question = Question::find($id);
        return $Question;
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
        })->rawColumns(['action' => 'action','checkBox'=>'checkBox','image'=>'image'])->make(true);
    }
}
