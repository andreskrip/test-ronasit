<?php

namespace App\Http\Controllers;

use App\Weather;

class HomeController extends Controller
{
    public function main()
    {
        return view('home');
    }

    public function viewWeather()
    {
        $weather = Weather::apiRequest($_POST);
        return view('home')->with('weather', $weather);
    }
}
