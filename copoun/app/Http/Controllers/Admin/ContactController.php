<?php


namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use Yajra\DataTables\DataTables;
use Auth, File;

class ContactController extends Controller
{
    use \App\Traits\ApiResponseTrait;

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function allData(Request $request)
    {
        $data = Contact::orderBy('id','desc');
        $data=$data->get();
        return $this->mainFunction($data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title='رسائل تواصل معنا';
        return view('Admin.Contact.index',compact('title'));
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
            $Contact = Contact::whereIn('id', $ids)->get();
            foreach($Contact as $row){
                $this->deleteRow($row);
            }
        } else {
            $Contact = Contact::find($id);
            $this->deleteRow($Contact);
        }
        return response()->json(['errors' => false]);
    }

    /**
     * @param $Contact
     */
    private function deleteRow($Contact){
        deleteFile('Contact',$Contact->file);
        $Contact->delete();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit ($id)
    {
        $Contact = Contact::find($id);
        return $Contact;
    }


    /**
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    private function mainFunction($data)
    {
        return Datatables::of($data)->addColumn('action', function ($data) {
            $options = ' <button type="button" onclick="deleteFunction(' . $data->id . ',1)" class="btn btn-dribbble waves-effect btn-circle waves-light"><i class="'.getIcon(2).'"></i> </button></td>';
            return $options;
        })->addColumn('checkBox', function ($data) {
            $checkBox = '<td class="sorting_1">' .
                '<div class="custom-control custom-checkbox">' .
                '<input type="checkbox" class="mybox" id="checkBox_' . $data->id . '" onclick="check(' . $data->id . ')">' .
                '</div></td>';
            return $checkBox;
        })->rawColumns(['action' => 'action','checkBox'=>'checkBox','file'=>'file'])->make(true);
    }
}
