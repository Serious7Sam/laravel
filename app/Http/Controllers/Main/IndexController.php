<?php

namespace App\Http\Controllers\Main;

use App\Entity\Product;
use App\Entity\Voucher;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        return view('page.index');
    }
}
