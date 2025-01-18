<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


class ProductMylistController extends Controller
{

    public function show()
    {
        return view('product.mylist'); // 独自の会員登録ビュー
    }
}
