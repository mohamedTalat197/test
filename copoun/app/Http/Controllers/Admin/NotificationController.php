<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\NotificationMethods;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Auth, File;
use Illuminate\Support\Facades\Storage;


class NotificationController extends Controller
{
    use \App\Traits\ApiResponseTrait;

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function allData(Request $request)
    {
        $data = Notification::orderBy('id', 'desc')->where('admin', 1);
        $data = $data->get();
        return $this->mainFunction($data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title = 'الاشعارات';
        $users=User::all();
        return view('Admin.Notification.index', compact('title','users'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->save_Notification($request, new Notification);
        if ($request->type == 1) {
            $users = User::all();
            foreach ($users as $row)
                NotificationMethods::senNotification($row, $request->title, $request->desc, null, 2);
        }
        if ($request->type == 2) {
            $User = User::where('id',$request->user_id)->first();
            NotificationMethods::senNotification($User, $request->title, $request->desc, null, 2);
        }
        if ($request->type == 3) {
            $users = User::whereIn('id',$request->user_id)->get();
            foreach ($users as $row)
                NotificationMethods::senNotification($row, $request->title, $request->desc, null, 2);
        }

        return $this->apiResponseMessage(1, 'تمت الاضافة بنجاح', 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $Notification = Notification::find($request->id);
        $this->save_Notification($request, $Notification);
        return $this->apiResponseMessage(1, 'تم التعديل بنجاح', 200);
    }

    /**
     * @param $request
     * @param $Notification
     */
    public function save_Notification($request, $Notification)
    {
        $Notification->title = $request->title;
        $Notification->user_id =$request->type ;
        $Notification->desc = $request->desc;
        $Notification->admin = 1;
        $Notification->save();

    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id, Request $request)
    {
        if ($request->type == 2) {
            $ids = explode(',', $id);
            $Notification = Notification::whereIn('id', $ids)->get();
            foreach ($Notification as $row) {
                $this->deleteRow($row);
            }
        } else {
            $Notification = Notification::find($id);
            $this->deleteRow($Notification);
        }
        return response()->json(['errors' => false]);
    }

    /**
     * @param $Notification
     */
    private function deleteRow($Notification)
    {
        $Notification->delete();
    }


    /**
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    private function mainFunction($data)
    {
        return Datatables::of($data)->addColumn('action', function ($data) {
            $options = ' <button type="button" onclick="deleteFunction(' . $data->id . ',1)" class="btn btn-dribbble waves-effect btn-circle waves-light"><i class="' . getIcon(2) . '"></i> </button></td>';
            return $options;
        })->addColumn('checkBox', function ($data) {
            $checkBox = '<td class="sorting_1">' .
                '<div class="custom-control custom-checkbox">' .
                '<input type="checkbox" class="mybox" id="checkBox_' . $data->id . '" onclick="check(' . $data->id . ')">' .
                '</div></td>';
            return $checkBox;
        })->editColumn('user_id', function ($data) {
            return $data->type ==1 ?   'كل الاعضاء' : 'عضو محدد';
        })->rawColumns(['action' => 'action', 'checkBox' => 'checkBox'])->make(true);
    }
}
