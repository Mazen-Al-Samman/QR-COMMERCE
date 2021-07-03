<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{

    public $url;
    public $request;
    /**
     * MainController constructor.
     */
    public function __construct()
    {
        $this->url = $this->checkUrl(new Request());
    }

    public function checkUrl(Request $request){
        $url = $request->fullUrl();
        preg_match('/\/api\//',$url,$matches);
        return count($matches) > 0;
    }
}
