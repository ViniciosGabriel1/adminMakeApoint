<?php

namespace App\Http\Controllers;

use App\Models\WhatsappInstance;
use Illuminate\Http\Request;

class ManageWhatsappController extends Controller
{
    //

    public function index() {

        // $instance = WhatsappInstance::where('user_id',auth()->id())->first();
        
        // if($instance == null){

        //     dd('null');
            
        // }

        // dd('é null não');

        return view('manage-whatsapp.index');
    }       
}
