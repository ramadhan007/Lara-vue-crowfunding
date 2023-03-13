<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\otp;
use Carbon\Carbon;
use App\Events\UserRegiteredEvent;



class AuthController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'email'=> 'required|email|unique:users,email',
            'password'=> 'required|confirmed|min:8',
            'name'=>'required'
        ]);
        $user = User::create([
            'email'=>$request['email'],
            'name'=>$request['name'],
            'password'=>Hash::make($request->password),
        ]);
        $data['user']=$user;

        event(new UserRegiteredEvent($user));
        
        return response()->json([
            'response_code'=>'00',
            'response_message'=>'user created',
            'data'=>$user
        ],201);
    }

    public function login(Request $request){
        $request->validate([
            'email'=> 'required',
            'password'=> 'required',
            
        ]);

        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Email and Password Invalid'], 401);
        }

        $data['token']=$token;

        return response()->json([
            'response_code'=>'00',
            'response_message'=>'User Login',
            'data'=>[
                'token'=>$token
            ]
        ],201);
    }

    public function logout(){
        auth()->logout();

        return response()->json(['message'=>'User Logout']);
    }

    public function me(){
        return response()->json(auth()->user());
    }

    public function updateProfile(Request $request){
        $user = auth()->user();
        if($request->hasFile('photo_profile')){

            $photo_profile = $request->file('photo_profile');
            $photo_profile_extension = $photo_profile->getClientOriginalExtension();
            $photo_profile_name= Str::slug($user->name, '-').'-'.$user->id.".".$photo_profile_extension;
            $photo_profile_folder = '/photo/users/photo-profile/';
            $photo_profile_location=$photo_profile_folder . $photo_profile_name;

            try{
                $photo_profile->move(public_path($photo_profile_folder),$photo_profile_name);
                $user->update([
                    'photo_profile'=>$photo_profile_location,
                ]);
            }catch(\Throwable $th){
                    return response()->json([
                        'response_code'=>'01',
                        'response_message'=>'Profile Fail Update',
                    ],200);
            }
        }

        $user->update([
            'name'=>$request->name,
        ]);

        $data['user']=$user;        
        return response()->json([
            'response_code'=>'01'
        ],200);
    }

    public function updatePassword(Request $request){
        $this->validate($request,[
            'email' => 'email|required',
            'password'=>'required|confirmed|min:6'
        ]);

        User::where('email',$request->email)->update([
            'password'=> Hash::make($request->password)
        ]);

        return response()->json([
            'response_code'=>'00',
            'response_message'=>'Password Updated',
        ],200);
    }
    public function generateOTP(Request $request){
        $request->validate(
            [
                'email'=>'email|required'
            ]
            );  
            $user = User::where('email', $request->email)->first();
            $user->generate_otp_code();
            $data['user']=$user;


            return response()->json([
                'response_code'=>'00',
                'response_message'=>'OTP Generated',
                'data'=>$data
            ],200);
    }
    public function verifikasiEmail(Request $request){
        $request->validate([
            'otp'=>'required'
        ]);
        $otp_code = otp::where('otp', $request->otp)->first();
        if(!$otp_code){
            return response()->json([
                'response_code'=>'01',
                'response_message'=>'OTP Code Not Found',
               
            ],400);  
        }
        $now = Carbon::now();
        if($now>$otp_code->valid_until){
            return response()->json([
                'response_code'=>'01',
                'response_message'=>'OTP cannot use, Must Generate',
               
            ],400);    
        }
        //update user
        $user = User::find($otp_code->user_id);
        $user->email_verified_at = $now;
        $user->save();

        //delete otp code

    $otp_code->delete();

    return response()->json([
        'response_code'=>'00',
        'response_message'=>'Email Verified',
       
    ],200);  

    }
    //
}
