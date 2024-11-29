<?php

namespace App\Controllers;

class TestController extends Controller
{

    public function index()
    {
        $this->render('test/index', ['title' => 'Tests PHP']);
    }
}
