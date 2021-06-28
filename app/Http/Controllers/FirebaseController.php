<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FirebaseController extends Controller
{
    protected $db;
    public function __construct() {
        $this->db = app('firebase.firestore')->database();
    }

    public function index() {
        return "Hello world !!";
    }
}
