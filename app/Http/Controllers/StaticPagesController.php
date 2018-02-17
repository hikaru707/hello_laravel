<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPagesController extends Controller
{
    public function home() {
        return '主頁';
    }

    public function help() {
        return '幫助頁';
    }

    public function about() {
        return '關於頁';
    }
}
