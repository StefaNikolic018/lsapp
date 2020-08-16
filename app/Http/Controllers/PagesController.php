<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function about(){
        $title="Ovo je stranica o nama";
        return view('pages.about')->with('title',$title);
    }

    public function services(){
        $data=array(
            'title'=> 'Services',
            'services'=>['Web Design','Programiranje', 'SEO']
        );
        return view('pages.services')->with($data);
    }
}
