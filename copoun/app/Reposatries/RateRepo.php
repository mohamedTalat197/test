<?php

namespace App\Reposatries;

use App\Interfaces\RateInterface;
use App\Models\Like;
use App\Models\Product;
use App\Models\Rate;
use App\Models\Reporting;
use App\User;
use Auth, Validator;

class RateRepo
{
    use \App\Traits\ApiResponseTrait;

    public function rating($type, $request, $model)
    {
        $validate_rate = $this->validate_rate($request);
        if (isset($validate_rate)) {
            return $validate_rate;
        }
        $msg = $this->save_rate($model, $request, $type);
        $this->cal_rate($model, $request->rate);
        return $this->apiResponseMessage(1, $msg, 200);
    }

    /**
     * @param $data
     * @param $request
     * @param $type
     * @param $lang
     * @return string
     */
    private function save_rate($data, $request, $type)
    {
        $user = Auth::user();
        $rate = Rate::where('user_id', $user->id)->where('RateRelation_id', $data->id)->where('RateRelation_type', $type)->first();
        if (is_null($rate)) {
            $rate = new Rate();
            $rate->rate = $request->rate;
            if ($request->comment)
                $rate->comment = $request->comment;
            $rate->user_id = $user->id;
            $rate->RateRelation_id = $data->id;
            $rate->RateRelation_type = $type;
            $rate->save();
            $msg = get_user_lang() == 'en' ? 'rate add successfully' : 'تم اضافة التقييم بنجاح';
        } else {
            $rate->rate = $request->rate;
            $rate->created_at = now();
            if ($request->comment)
                $rate->comment = $request->comment;
            $rate->save();
            $msg = get_user_lang() == 'en' ? 'rate add successfully' : 'تم اضافة التقييم بنجاح';
        }
        return $msg;
    }

    /**
     * @param $data
     * @param $rate
     */
    private function cal_rate($data, $rate)
    {
        if ($data->rate == 0) {
            $newRate = $rate;
        } else {
            $newRate = ($rate + $data->rate) / 2;
        }
        $data->rate = $newRate;
        $data->save();
    }


    private function validate_rate($request)
    {
        $input = $request->all();
        $validationMessages = [
            'rate.required' => get_user_lang() == 'en' ? 'rate is required' : 'من فضلك ادخل التقييم',
        ];

        $validator = Validator::make($input, [
            'rate' => 'required|integer|between:1,5',
        ], $validationMessages);

        if ($validator->fails()) {
            return $this->apiResponseMessage(0, $validator->messages()->first(), 200);
        }
    }


}
