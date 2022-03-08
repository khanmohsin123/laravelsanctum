<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LotteryType as Model;
use App\Http\Requests\LotteryType\LotteryTypeRequest as ModelRequest;
use App\Http\Requests\LotteryType\LotteryTypeUpdateRequest as ModelUpdateRequest;

class LotteryTypeController extends Controller
{
	public function dsr(Request $request,Model $model)
    {        
		return $this->process_new('deleted', $model->whereIn('id', $request->ids)->delete(), class_basename($model));
    }
    public function index(Model $model,Request $request)
    {
    	return $model->orderBy('id','desc')->paginate($request->per_page);
    }		
    public function store(ModelRequest $request, Model $model)
    { 
        return $this->process_new('added',$model->create($request->setFields()), class_basename($model));
    }
    public function update(ModelUpdateRequest $request, Model $model,$id)
    {
        return $this->process_new('updated',$model->whereId($id)->update($request->setFields()),class_basename($model),$id);
    }
    public function destroy(Model $model,$id)
    {
        return $this->process_new('deleted', $model::find($id)->delete(), class_basename($model));
    }
}