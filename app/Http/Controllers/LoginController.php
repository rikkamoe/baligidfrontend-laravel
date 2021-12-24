<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    /**
     * View Login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin/login');
    }

    /**
     * View Login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $apirequest = Http::post('http://127.0.0.1:8000/api/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        $response = json_decode($apirequest->getBody());
        $token = $response->access_token;

        if(empty($token)) {
            Alert::error('Error Login', 'Salah Email dan Password !!');
            return view('admin/login');
        }
        else {
            $apirequest2 = Http::withToken($token)->get('http://127.0.0.1:8000/api/auth/user-profile', [
            ]);

            $response2 = json_decode($apirequest2->getBody());
            $name = $response2->name;

            return redirect()->route('dashboard')->with(['token' => $token, 'name' => $name]);
        }
    }
}
