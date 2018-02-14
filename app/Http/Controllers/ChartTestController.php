<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Charts;
use App\DCkpi as CD;

class ChartTestController extends Controller
{
    //
    public function index()
    {
      // Static Charts
      $chart1 = Charts::multi('bar', 'material')
            // Setup the chart settings
            ->title("My Cool Chart")
            // A dimension of 0 means it will take 100% of the space
            ->dimensions(0, 400) // Width x Height
            // This defines a preset of colors already done:)
            ->template("material")
            // You could always set them manually
            // ->colors(['#2196F3', '#F44336', '#FFC107'])
            // Setup the diferent datasets (this is a multi chart)
            ->dataset('Element 1', [5,20,100])
            ->dataset('Element 2', [15,30,80])
            ->dataset('Element 3', [25,10,40])
            // Setup what the values mean
            ->labels(['One', 'Two', 'Three']);
      // Static Charts
      $chart2 = Charts::create('line', 'highcharts')
          ->title('My nice chart')
          ->labels(['First', 'Second', 'Third'])
          ->values([5,10,20])
          ->dimensions(0,500);





/*






      $i=0;
      foreach ($ckpis as $ckpi) {
          $mmr[] = ($ckpi->people/$ckpi->mcs_used)/100;
          $dates[] = date("d/m/Y", strtotime($ckpi->created_at));
          $fusing_out[] = $ckpi->fusing_out;
          $cut_qty[] = $ckpi->cut_qty;

          $temp = explode("-",$ckpi->consumption);
          // dd($temp);
          foreach ($temp as $c) {
            $cc[] = explode(":", $c);
          }
          dd($cc);

      }

*/



// Dynamic database charts
$ckpis = CD::all()->where('factory_id', 1);
      $dates = [];
      $cut_qty = [];
      $fusing_out = [];
      $pcs_e_s = [];
      $c_men = [];
      $men = 0;
      $machine = 0;
      $bandknife = [];
      $stknife = [];
      $fusing = [];


      foreach ($ckpis as $ckpi) {
        $dates [] = date("d/m/Y", strtotime($ckpi->created_at));
        $cut_qty[] = $ckpi->cut_qty;
        $fusing_out[] = $ckpi->fusing_out;
        $pcs_e_s[] = $ckpi->pcs_sew_emb;
        $men += $ckpi->people;
        $machine += $ckpi->mcs_used;
        $stknife[] = $ckpi->no_stknife;
        $bandknife[] = $ckpi->no_bandkife;
        $fusing[] = $ckpi->no_fusing;
      }

    $chart4 = Charts::create('donut', 'highcharts')
              ->title('Man Machine ratio')
              ->labels(['Man', 'Machines'])
              ->values([$men, $machine])
              ->dimensions(1000,500)
              ->responsive(false);


    $chart3 = Charts::multi('bar', 'highcharts')
            ->title('Cutting Staus')
            ->labels($dates)
            ->dataset('Cutting Quantity', $cut_qty)
            ->dataset('Fusing Output', $fusing_out)
            ->dataset('Pieces sent for washing or sewing', $pcs_e_s);



    $chart5 = Charts::multi('bar', 'highcharts')
            ->title('Machine Ussage')
            ->labels($dates)
            ->dataset('Straight Knife', $stknife)
            ->dataset('Band Kife', $bandknife)
            ->dataset('Fusing Machines', $fusing);


      return view('chartexample', ['chart3' => $chart3, 'chart4'=> $chart4, 'chart5'=> $chart5]);

    }

}
