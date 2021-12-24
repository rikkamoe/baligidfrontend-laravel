<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;

class DashboardController extends Controller
{
    /**
     * View Index.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $token = Session::get('token');
        $request->session()->keep(['token']);
        if(empty($token)) {
            Alert::error('Error Login', 'Hey Anda Mau Ngapain ? :v');
            return redirect('admin/login');
        }
        else {
            $apirequest = Http::withToken($token)->get('http://127.0.0.1:8000/api/auth/user-profile', [
            ]);

            $response = json_decode($apirequest->getBody());
            $name = $response->name;

            return view('admin/index')->with(compact('name'));
        }
    }

    /**
     * Logout User.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout($token)
    {
        $apirequest = Http::withToken($token)->post('http://127.0.0.1:8000/api/auth/logout', [
        ]);

        return redirect('admin/login');
    }
}
