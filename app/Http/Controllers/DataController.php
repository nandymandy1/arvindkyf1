<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Factory;
use Carbon\Carbon;
use App\DCkpi as CKPI;
use App\DSkpi as SKPI;
use App\DFkpi as FKPI;
use App\DQkpi as QKPI;
use App\DGKPI as GKPI;
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
        'no_stknife' => 'required'
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
        // Success Call Back on submission
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
    public function insertSewingData(Request $req)
    {
      // dd($req->all());
      $validation = Validator::make($req->all(), [
        'factory_id'  => 'required',
        'no_load'     => 'required',
        'no_line'    => 'required',
        'so_pl'       => 'required',
        'no_sew_mcs'  => 'required',
        'no_people'   => 'required',
        'no_help'     => 'required',
        'no_kaja'     => 'required',
        'no_opr'      => 'required',
        'sam'         => 'required',
        'no_send'     => 'required',
      ]);

      $elo = '';
      for($i=1; $i <= intval($req->input('no_line')); $i++){
        if($i == intval($req->input('no_line'))){
        $elo .= 'l'.$i.':'.$req->input('line'.$i);
        }
        else{
          $elo .= 'l'.$i.':'.$req->input('line'.$i).'-';
        }
      }

      $errors = array();
      $success = '';
      if($validation->fails()){
        foreach($validation->messages()->getMessages() as $fieldName => $messages){
          $errors [] = $messages;
        }
      }else{
        $skpi = new SKPI;
        $skpi->factory_id   = $req->input('factory_id');
        $skpi->no_load      = $req->input('no_load');
        $skpi->no_line      = $req->input('no_line');
        $skpi->elo          = $elo;
        $skpi->so_pl        = $req->input('so_pl');
        $skpi->no_sew_mcs   = $req->input('no_sew_mcs');
        $skpi->no_people    = $req->input('no_people');
        $skpi->no_help      = $req->input('no_help');
        $skpi->no_kaja      = $req->input('no_kaja');
        $skpi->no_opr       = $req->input('no_opr');
        $skpi->sam          = $req->input('sam');
        $skpi->no_send      = $req->input('no_send');
        $skpi->save();
        // Success Call Back on submission
        $success = '<div class="alert alert-success">
          Sewing Data Saved
        </div>';
      }
      $output = array(
        'error' => $errors,
        'success' => $success
      );
      echo json_encode($output); // Success Message


    }

    public function insertFinishingData(Request $req)
    {
      $validation = Validator::make($req->all(), [
        'factory_id' => 'required',
        'pcs_sew_wash' => 'required',
        'pcs_fed' => 'required',
        'pkd_pcs' => 'required',
      ]);

      $errors = array();
      $success = '';
      if($validation->fails()){
        foreach($validation->messages()->getMessages() as $fieldName => $messages){
          $errors [] = $messages;
        }
      }else{

        $fkpi = new FKPI;
        $fkpi->factory_id   = $req->input('factory_id');
        $fkpi->pcs_sew_wash = $req->input('pcs_sew_wash');
        $fkpi->pcs_fed      = $req->input('pcs_fed');
        $fkpi->pkd_pcs      = $req->input('pkd_pcs');
        $fkpi->save();

        // Success Call Back on submission
        $success = '<div class="alert alert-success">
          Finishing Data Saved
        </div>';
      }
      $output = array(
        'error' => $errors,
        'success' => $success
      );
      echo json_encode($output); // Success Message

    }

    public function insertStrengthData(Request $req)
    {
      $validation = Validator::make($req->all(), [
        'factory_id'      => 'required',
        'dhu'             => 'required',
        'people_payrole'  => 'required',
        'people_cont'     => 'required',
        'overtime_pay'    => 'required',
        'ot_sew'          => 'required',
        'ot_fin'          => 'required',
        'ot_cut'          => 'required',
        'absent'          => 'required',
      ]);

      $errors = array();
      $success = '';
      if($validation->fails()){
        foreach($validation->messages()->getMessages() as $fieldName => $messages){
          $errors [] = $messages;
        }
      }else{

        $qkpi = new QKPI;
        $gkpi = new GKPI;

        $qkpi->factory_id = $req->input('factory_id');
        $qkpi->dhu = $req->input('dhu');
        $gkpi->factory_id = $req->input('factory_id');
        $gkpi->poeple_payrole = $req->input('people_payrole');
        $gkpi->people_cont = $req->input('people_cont');
        $gkpi->overtime_pay = $req->input('overtime_pay');
        $gkpi->ot_sew = $req->input('ot_sew');
        $gkpi->ot_fin = $req->input('ot_fin');
        $gkpi->ot_cut = $req->input('ot_cut');
        $gkpi->absent = $req->input('absent');
        $qkpi->save();
        $gkpi->save();

        // Success Call Back on submission
        $success = '<div class="alert alert-success">
          Strength and Quality Data Saved
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
