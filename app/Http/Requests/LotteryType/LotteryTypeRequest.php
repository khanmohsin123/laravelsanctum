<?php

namespace App\Http\Requests\LotteryType;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\failedValidation;


class LotteryTypeRequest extends FormRequest
{
	use failedValidation; // gives response when validation failed

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'type' => 'required|min:3|max:50|unique:lottery_types', // field as per your need 
            'image' => 'required|mimes:jpg,png,jpeg,gif|max:3048',
            'description' => 'min:3|max:500', // field as per your need 

        ];
    }

	public function setFields()
    {
        $image = 'no_image.png';
        if($this->hasFile('image')){
           $image = $this->image->getClientOriginalName();
           $this->image->move(public_path('uploads/lottery_type/'),$image);
           $image = url('uploads/lottery_type/'. $image) ;
        }

        return [
            'type' => $this->type, // field as per your need 
            'image' => $image,
            'description' =>$this->description,
            'is_Active' =>$this->is_Active

        ];
    }

}