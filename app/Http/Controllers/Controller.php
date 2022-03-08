<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function process($action,$job,$model,$id = null)
    { 
        try {
            $m = '\\App\\' . $model;
            $last_id = gettype($job) == 'object' ? $job->id : $id;

            $response = [
				'status'  => true,
				'record' => $m::find($last_id), 
                'message' => $model . ' has been ' . $action,
            ];
    
            return response()->json($response,200);

        } catch (\Throwable $th) { throw $th; }
    }


	// use this if your model class in app/models

	public static function process_new($action,$job,$model,$id = null)
    { 
        try {
            $m = '\\App\\Models\\' . $model;
            $last_id = gettype($job) == 'object' ? $job->id : $id;

            $response = [
				'status'  => true,
				'record' => $m::find($last_id), 
                'message' => $model . ' has been ' . $action,
            ];
    
            return response()->json($response,200);

        } catch (\Throwable $th) { throw $th; }
    }

	public function process_login($model, $request)
	{
		$user = $model::with(['role'])
			->where('mobile_number', $request->user_name)
			->orWhere('email', $request->user_name)
			->orWhere('name', $request->user_name)
			->first();
		if($user && $user->IsActive != 1){
			return response()->json(['error'=>'You account is deactivated. Please contact to admin'], 422); 	
		}
		if (! $user || !\Hash::check($request->password, $user->password)) {
			return response()->json(['error'=>'email or password is incorrect'], 422); 		
		}
	
		if($user && $user->assigned_permissions){
			$user->permissions = $user->assigned_permissions->permissions_array;
		}
		else{
			$user->permissions = [];
		}
		
		return response()->json([
			'token' => $user->createToken('myApp')->plainTextToken,
			'user' => $user
		], 200); 
	}
}
