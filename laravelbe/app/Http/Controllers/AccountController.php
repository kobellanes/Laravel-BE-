<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function store(Request $request)
    {
        $accounts = Account::where('email', $request->email)->get();

        if(count($accounts)<=0){
            $account = new Account;

          
            $account->email = $request->email;
            $account->password = Hash::make($request->password);

            $newAccessToken = bin2hex(random_bytes(32));

            $account->accessToken = $newAccessToken;
          

            $account->save();
    
            $message =(object)[
                "status"=>"404zoejknolksiajk",
                "message"=>"You successfully created a new account!"
            ];
            return response()->json($message);
        }else{
            $message =(object)[
                "status"=>"404lryoynlaabtooopzld",
                "message"=>"Email already taken! Please create a unique one!"
            ];
            return response()->json($message);
        }
       
    }
    

    public function login(Request $request){
        if ($request->has(['email', 'password'])) {
            $email = $request->email;
            $enteredPassword = $request->password;

            $user = Account::where('email', $email)->first();
    
            if ($user && Hash::check($enteredPassword, $user->password)) {
                $message =(object)[
                    "status"=>"404zoejknolksiajk",
                    "message"=>"Login Authorized!"
                ];

                $response = [
                    'cvuud' => $user->id,
                    'yoie' => $user->status,
                    'message' => $message,
                ];

                return response()->json($response);
                
            }else{
                $message =(object)[
                    "status"=>"404lryoynlaabtooopzld",
                    "message"=>"Login Failed!"
                ];
                return response()->json($message);
            }
        }
        
        if ($request->has('accessToken')) {
            $accounts = Account::where([
                'accessToken' => $request->accessToken,
            ])->select('id','email', 'status', 'accessToken') ->get();
            
            return response()->json($accounts);
        }
    }

    public function logout(Request $request)
    {
        if ($request->has('accessToken')) {
            $account = Account::where('accessToken', $request->accessToken)->first();
    
            if ($account) {
                
                $newAccessToken = bin2hex(random_bytes(32));

                $account->update([
                    'accessToken' => $newAccessToken,
                ]);
    
                
            } else {
                return response()->json(['message' => 'No Account Found']);
            }
        }
      
    }

    public function update(Request $request)
    {

        if ($request->has(['id'])) {
            $account = Account::where([
                'id' => $request->id,
            ])->first();

            $account->accessToken = $request->accessToken;
    
            $account->save();
    
            $message =(object)[
                "status"=>'404zoejknolksiajk',
            ];
            return response()->json($message);
        }

    
        

    }
}