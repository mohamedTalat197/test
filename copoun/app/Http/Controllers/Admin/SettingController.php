<?php


namespace App\Http\Controllers\Admin;

use App\Models\Categories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Yajra\DataTables\DataTables;
use Auth, File;
use Illuminate\Support\Facades\Storage;


class SettingController extends Controller
{
    use \App\Traits\ApiResponseTrait;

    /**
     * @return mixed
     * @throws \Exception
     */
    public function allData(Request $request)
    {
        $data = Setting::get();
        return $this->mainFunction($data,$request->type);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $type = $request->type;
        $title = 'مواقع التواصل';
        if ($type == 2)
            $title = 'عن الشركة';
        if ($type == 3)
            $title = 'سياسة الخصوصية';
        if ($type == 4)
            $title = 'المطورين';
        if ($type == 15)
            $title = 'من نحن';
        return view('Admin.Setting.index', compact('type', 'title'));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $Product = Setting::find($id);
        return $Product;
    }

    /*****
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $Product = Setting::find($request->id);
        $this->save_Setting($request, $Product);
        return $this->apiResponseMessage(1, 'تم تعديل المعلومات بنجاح', 200);
    }

    /**
     * @param $request
     * @param $brand
     */
    public function save_Setting($request, $Product)
    {
        if ($request->about_ar)
            $Product->about_ar = $request->about_ar;
        if ($request->about_en)
            $Product->about_en = $request->about_en;
        if ($request->terms_ar)
            $Product->terms_ar = $request->terms_ar;
        if ($request->terms_en)
            $Product->terms_en = $request->terms_en;
        if ($request->aboutCompany_ar)
            $Product->aboutCompany_ar = $request->aboutCompany_ar;
        if ($request->aboutCompany_en)
            $Product->aboutCompany_en = $request->aboutCompany_en;
        if ($request->phone)
            $Product->phone = $request->phone;
        if ($request->facebook)
            $Product->facebook = $request->facebook;
        if ($request->twitter)
            $Product->twitter = $request->twitter;
        if ($request->snap)
            $Product->snap = $request->snap;
        if ($request->whatsApp)
            $Product->whatsApp = $request->whatsApp;
        if ($request->telgram)
            $Product->telgram = $request->telgram;
        if ($request->phoneD)
            $Product->phoneD = $request->phoneD;
        if ($request->emailD)
            $Product->emailD = $request->emailD;
        if ($request->companyLogo) {
            deleteFile('Setting', $Product->companyLogo);
            $Product->companyLogo = saveImage('Setting', $request->companyLogo);
        }
        if ($request->aboutImage) {
            deleteFile('Setting', $Product->aboutImage);
            $Product->aboutImage = saveImage('Setting', $request->aboutImage);
        }
        if ($request->imageD) {
            deleteFile('Setting', $Product->imageD);
            $Product->imageD = saveImage('Setting', $request->imageD);
        }

        $Product->save();
    }

    /****
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    private function mainFunction($data,$type)
    {
        return Datatables::of($data)->addColumn('action', function ($data) use ($type) {
            $options='';
            if(!in_array($type,[2,4]))
                $options = '<td class="sorting_1"><button  class="btn btn-info waves-effect btn-circle waves-light" onclick="editFunction(' . $data->id . ')" type="button" ><i class="fa fa-spinner fa-spin" id="loadEdit_' . $data->id . '" style="display:none"></i><i class="sl-icon-wrench"></i></button>';
            return $options;
        })->addColumn('checkBox', function ($data) {
            $checkBox = '<td class="sorting_1">' .
                '<div class="custom-control custom-checkbox">' .
                '<input type="checkbox" class="mybox" id="checkBox_' . $data->id . '" onclick="check(' . $data->id . ')">' .
                '</div></td>';
            return $checkBox;
        })->editColumn('companyLogo', function ($data) {
            $icon = '<a href="' . getImageUrl('Setting', $data->companyLogo) . '" target="_blank">'
                . '<img  src="' . getImageUrl('Setting', $data->companyLogo) . '" width="50px" height="50px"></a>';
            return $icon;

        })->editColumn('aboutImage', function ($data) {
            $icon = '<a href="' . getImageUrl('Setting', $data->aboutImage) . '" target="_blank">'
                . '<img  src="' . getImageUrl('Setting', $data->aboutImage) . '" width="50px" height="50px"></a>';
            return $icon;

        })->rawColumns(['action' => 'action', 'checkBox' => 'checkBox', 'companyLogo' => 'companyLogo', 'aboutImage' => 'aboutImage'])->make(true);
    }
}
