<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Factory;

class DataController extends Controller
{
    // Factory Controller to return all the list of factories to the register page
    public function fetchFactory(Request $req)
    {
      $factory = Factory::all('name');
       return response()->json($factory);
    }

    public function CuttingData()
    {
      
    }


}
