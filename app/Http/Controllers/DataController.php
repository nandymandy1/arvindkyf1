<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Factory;
use Carbon\Carbon;
use App\DCkpi as CKPI;
use Validator;

class DataController extends Controller
{
    // Factory Controller to return all the list of factories to the register page
    public function fetchFactory(Request $req)
    {
      $factory = Factory::all('name');
       return response()->json($factory);
    }

    public function insertCuttingData(Request $req)
    {
      $consumption = '';
      if($req->has('shirt')){
        $consumption .= 'S:' . $req->input('shirt');
      }else{
        $consumption .= 'S:' . '0';
      }
      if($req->has('woman')){
        $consumption .= 'W:' . $req->input('woman');
      }else{
        $consumption .= 'W:' . '0';
      }
      if($req->has('knit')){
        $consumption .= 'K:' . $req->input('knit');
      }else{
        $consumption .= 'K:' . '0';
      }
      if($req->has('jean')){
        $consumption .= 'J:' . $req->input('jean');
      }else{
        $consumption .= 'J:' . '0';
      }
      if($req->has('trouser')){
        $consumption .= 'T:' . $req->input('trouser');
      }else{
        $consumption .= 'T:' . '0';
      }

      $validation = Validator::make($req->all(), [
        'factory_id'=> 'required',
        'cut_qty'=> 'required',
        'people' => 'required',
        'pcs_sew_emb' => 'required',
        'c_men' => 'required',
        'mcs_used' => 'required',
        'no_bandkife' => 'required',
        'no_fusing' => 'required',
        'fusing_out' => 'required',
        'no_stknife' => 'required',
      ]);
      $errors = array();
      $success = '';
      if($validation->fails()){
        foreach($validation->messages()->getMessages() as $fieldName => $messages){
          $errors [] = $messages;
        }
      }else{
        $ckpi = new CKPI;
        $ckpi->factory_id = $req->input('factory_id');
        $ckpi->cut_qty = $req->input('cut_qty');
        $ckpi->consumption = $consumption;
        $ckpi->people = $req->input('people');
        $ckpi->pcs_sew_emb = $req->input('pcs_sew_emb');
        $ckpi->c_men = $req->input('c_men');
        $ckpi->mcs_used = $req->input('mcs_used');
        $ckpi->no_bandkife = $req->input('no_bandkife');
        $ckpi->no_stknife = $req->input('no_stknife');
        $ckpi->no_fusing = $req->input('no_fusing');
        $ckpi->fusing_out = $req->input('fusing_out');
        $ckpi->save();
        $success = '<div class="alert alert-success">
          Cutting Data Saved
        </div>';
      }
      $output = array(
        'error' => $errors,
        'success' => $success
      );
      echo json_encode($output); // Success Message
    }


}

?>
