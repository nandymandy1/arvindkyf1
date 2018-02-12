<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\User;
use App\Factory;
use DataTables;

class AdminController extends Controller
{
    //
      public function getFactories()
      {
        $factories = Factory::select('id','name', 'contact', 'email', 'isActive');
        return Datatables::of($factories)->addColumn('action', function($factory){
          $draw = '';
          if($factory->isActive){
            $draw .=  '<a href="#" class="badge badge-success" id="'.$factory->id.'"><i class=""></i></a> ';
          }
          else{
            $draw .= '<a href="#" class="badge badge-danger" id="'.$factory->id.'"><i class=""></i></a> ';
          }
          $draw .= '<a href="#" class="btn btn-outline-info btn-sm message" id="' .$factory->id. '"><i class="glyphicon glyphicon-"></i>Message</a>
          <a href="#" class="btn btn-outline-primary btn-sm edit" id="' .$factory->id. '"><i class="glyphicon glyphicon-edit"></i>Edit</a>
          <a href="#" class="btn btn-outline-danger btn-sm delete" id="' .$factory->id. '"><i class="glyphicon glyphicon-remove"></i>Delete</a>
          ';
          return $draw;
        })->make(true);
      }

      public function addFactory(Request $req)
      {
        $validation = Validator::make([

        ]);
      }
}
?>
