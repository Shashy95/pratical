<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class Auth_ApiController extends Controller
{
   
   
    
    public function login(Request $request)
    {
        //validation 
        $rules = [
            'email'=>'required|string',
            'password'=>'required'
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            if($validator->errors()->first('email')){
                $massage =$validator->errors()->first('email');
            }
            else if($validator->errors()->first('password')){
                $massage =$validator->errors()->first('password');
            }
            $response=['success'=>false,'error'=>true,'message'=>$massage];
            return response()->json($response,200);

        }
        
        //Authentication done when all fields are validated
        $user=User::where('email', $request->email)->first();
        
    
        
        if($user && Hash::check($request->password,$user->password))
        {
            $request->session()->put('user_id', $user->id); // Store user ID in session
            $response=['success'=>true,'error'=>false,'message'=>'User login successfully','user'=>$user, 'token' => $user->createToken('token-name')->plainTextToken];

            return response()->json($response,200);
            /*
            return response()->json([
                'user_id' => $user->id,
                'token' => $user->createToken('MyApp')->plainTextToken
            ]);

            */
        }else{
            $response=['success'=>false,'error'=>true,'message'=>'incorrect email or password'];
            return response()->json($response,200);
        }

        
        
        
        
    }
   
   
    public function register(Request $request)
    {
        //validation 
        $rules = [
            'name' => 'required|string', 
            'email' => 'required|string|unique:users',
            'password' => 'required|string|min:8|confirmed'
        ];
        
        $validator = Validator::make($request->all(),$rules);
        // taking each message of field error
        if($validator->fails())
        {
            if($validator->errors()->first('name')){
                $massage =$validator->errors()->first('name');
            }
            else if($validator->errors()->first('email')){
                $massage =$validator->errors()->first('email');
            }
         
            else if($validator->errors()->first('password')){
                $massage =$validator->errors()->first('password');
            }
           
            else{
                $massage =$validator->errors();
            }
            $response=['success'=>false,'error'=>true,'message'=>$massage];
            return response()->json($response,200);
        }

        try {
            $user =  User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            
         
            if($user){
                
                $register_as = 'Test';
                
                $response=['success'=>true,'error'=>false,'message'=>'User registered successfully','user'=>$user];

                return response()->json($response,200);
            }else{
                $response=['success'=>false,'error'=>true,'message'=>'User registered fail'];
                return response()->json($response,200);
            }
        } catch (Exception $e) {
            $response=['success'=>false,'error'=>true,'message'=> $e];
          
        }
        
        return response()->json($response,500);
       
    }
    
   

 
   
}