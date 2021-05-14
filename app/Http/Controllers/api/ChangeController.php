<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRegisterController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
// use Validator;
// use Illuminate\Support\Facades\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;


class ChangeController extends ApiResponseController
{
    public function index()
    {
        $pokemons = Pokemon::orderBy('created_at','desc')->paginate(10);
        return $this->successResponse($pokemons);
    }
    
    public function update(Request $request) {
        // dd($request->all()['nick']);
        $validator = Validator::make($request->all(), StoreRegisterController::myRules2());

        $nick=$request->all()['nick'];
        $email=$request->all()['email'];
        // $nick=$request->input('nick');
        // return $this->successResponse($nick);

        // dd($nick);
        if ($validator->fails()) {
            // return $validator->errors();
            return $this->errorResponse($validator->errors($validator));
        }else{
            $id=\Auth::user()->id;
            $user=DB::table('users')->where('id',$id)->update([
                'nick' => $nick,
                'email' => $email,
            ]);
            // dd($validator->validated()); 

            return $this->successResponse("exito");
            }

            
        
    }

    public function reset(Request $request) {
        
        $validator = Validator::make($request->all(), StoreRegisterController::myRules3());
        $password=$request->all()['password'];
        $opassword=$request->all()['opassword'];
        $id=\Auth::user()->id;
        $user = DB::table('users')->where('id',$id)->first();
        $pass=$user->password;
        $hashedPassword=$pass;
        if ($validator->fails() || (!(Hash::check($opassword, $hashedPassword)))) {
            // return $validator->errors();
            return $this->errorResponse($validator->errors($validator));
        } else {
            $user=DB::table('users')->where('id',$id)->update([
                'password' => Hash::make($password),
            ]);
            return  $this->successResponse("exito");
        }
        
    }

}
