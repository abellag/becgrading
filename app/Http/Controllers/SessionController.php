<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;

class SessionController extends Controller
{
    //
    
    public function storeAllSessionData($request){
        Session::push('userdetails', $request);
        return true;
    }
    
    public function retrieveData(){
        $data = $request->session()->all();
        return $data;
    }
}
