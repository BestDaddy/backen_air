<?php

namespace App\Http\Controllers\Web\Support;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocalizationController extends Controller
{
    public function index($locale){
        error_log($locale);
        App::setLocale($locale);
        Session::put('locale', $locale);

        error_log(App::getLocale());

//        app()->setLocale($locale);
//        session()->put('locale', $locale);
        return redirect()->back();
    }
}
