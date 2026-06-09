<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Service;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function FormRegister(){
         $services = Service::all();
         $branches  = Branch::all();
        return view('Frontend.index',compact('services','branches'));
    }
}
