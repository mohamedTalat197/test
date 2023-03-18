<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\CountryResource;
use App\Http\Resources\DeveloperResource;
use App\Http\Resources\FaqsResource;
use App\Http\Resources\SettingResource;
use App\Interfaces\UserInterface;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Country;
use App\Models\Developer;
use App\Models\Question;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator,Auth,Artisan,Hash,File,Crypt;
use App\Http\Resources\UserResource;
use App\Models\User;

class GeneralController extends Controller
{
    use \App\Traits\ApiResponseTrait;

    /****
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function countries(){
        return $this->apiResponseData(CountryResource::collection(Country::orderBy('id','desc')->get()),'success');
    }

    /***
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function categories(){
        return $this->apiResponseData(CategoryResource::collection(Category::orderBy('id','desc')->get()),'success');

    }

    /***
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function aboutApp(Request $request){
        $about=Setting::first();
        return $this->apiResponseData(new SettingResource($about),'success');
    }

    /****
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function developers(){
        $developers=Developer::all();
        return $this->apiResponseData(new DeveloperResource(null),'success');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function Faqs(){
        $Faqs=Question::orderBy('id','desc')->get();
        return $this->apiResponseData(FaqsResource::collection($Faqs),'success');
    }

    /***
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function contactUs(Request $request){
        $contactUs=new Contact();
        $contactUs->name=$request->name;
        $contactUs->email=$request->email;
        $contactUs->message=$request->message;
        $contactUs->save();
        $msg=$request->header('lang') =='ar' ? 'تم حفظ رسالتك بنجاح'  : 'your message saved successfully';
        return $this->apiResponseMessage(1,$msg);
    }

}

