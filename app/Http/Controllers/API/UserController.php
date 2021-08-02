<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class UserController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $userData = $request->only('name','email', 'password' , 'phone' , 'password_confirmation');

        $validator = Validator::make($userData , [
            'name' => 'required|string',
            'email' => 'required|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'phone' => 'unique:users,phone',
        ]);

        if($validator->fails()){
            return response()->json([
                "error" => true,
                "message" => $validator->errors()->first()
            ]);
        }

        $userData["password"] = Hash::make($userData["password"]);

        $user = User::create($request);

        return response()->json([
            'error' => false ,
            'data'  => $user ,
            'message' => $user != null ? 'user_created' : 'error found',
        ] , 200);
    }

    public function search(Request $request){
        $search = $request->search;

        $user = User::where('id' , '=' , $search)
            ->orWhere('phone' , 'Like' , '%'.$search.'%')->get();
        return response()->json([
                'error' => false ,
                'data'  => $user ,
                'message' => $user != null ? 'user_created' : 'error found',
            ]);
    }

    public function downloadpdf(Request $request)
    {
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($request->htmlView);
        return $pdf->download();

    }
}
