<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;

class ViewController extends Controller
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
            
            return view('admin/view')->with(compact('token', 'name'));
        }
    }

    /**
     * Create data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $token = Session::get('token');
        $request->session()->keep(['token']);

        $image = $request->file('img');

        $fileimage = fopen($request->file('img'), 'r');
        $nameimage = time().".".$image->getClientOriginalExtension();

        $apirequest = Http::attach('img', $fileimage, $nameimage)->withToken($token)->post('http://127.0.0.1:8000/api/auth/wisata',[
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'rating' => $request->rating,
            'address' => $request->address,
            'telephone' => $request->telephone,
            'website' => $request->website,
        ]);

        $apirequest = Http::withToken($token)->get('http://127.0.0.1:8000/api/auth/user-profile', [
        ]);

        $response = json_decode($apirequest->getBody());
        $name = $response->name;

        return view('admin/view')->with(compact('token', 'name'));
    }
}




