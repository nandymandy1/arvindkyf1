<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Auth;
use Charts;
use App\Factory;
use App\User;
use App\BMCkpi as BCKPI;
use App\BMQkpi as BQKPI;
use App\BMSkpi as BSKPI;
use App\DCkpi as CKPI;
use App\DFkpi as FKPI;
use App\DGkpi as GKPI;
use App\DQkpi as QKPI;
use App\DSkpi as SKPI;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          if(Auth::user()->isActive)
          {

            if(Auth::user()->type == 'admin')
            {
              $redirect = 'admin.dashboard';
            }
            else {
              $factory = Factory::find(Auth::user()->factory_id);
              // Check for the Factory User type and Reports Array Generation
              switch (Auth::user()->job) {
                case 'master':
                  $redirect = 'factory.dashboard';
                  $report_cut = CKPI::where('factroy_id', Auth::user()->factory_id)->orderBy('created_at', 'desc')->take(30);
                  $report_sew = SKPI::where('factroy_id', Auth::user()->factory_id)->orderBy('created_at', 'desc')->take(30);
                  $report_gen = GKPI::where('factroy_id', Auth::user()->factory_id)->orderBy('created_at', 'desc')->take(30);
                  $report_finish = FKPI::where('factroy_id', Auth::user()->factory_id)->orderBy('created_at', 'desc')->take(30);
                  $report_quality = QKPI::where('factroy_id', Auth::user()->factory_id)->orderBy('created_at', 'desc')->take(30);
                  $reports = [
                    'cutting' => $report_cut,
                    'sewing'  => $report_sew,
                    'finish'  => $report_finish,
                    'general' => $report_gen,
                    'quality' => $report_quality
                  ];
                  break;

                case 'cutting':
                  $redirect = 'factory.cutting';

                  // Dynamic database charts
                  $ckpis = CKPI::all()->where('factory_id', Auth::user()->factory_id)->take(30);

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

                      $chart1 = Charts::create('donut', 'highcharts')
                                ->title('Man Machine ratio')
                                ->labels(['Man', 'Machines'])
                                ->values([$men, $machine])
                                ->height(300)
                                ->responsive(false);

                      $chart2 = Charts::multi('bar', 'highcharts')
                              ->title('Cutting Staus')
                              ->labels($dates)
                              ->dataset('Cutting Quantity', $cut_qty)
                              ->dataset('Fusing Output', $fusing_out)
                              ->dataset('Pieces sent for washing or sewing', $pcs_e_s)
                              ->height(300)
                              ->responsive(false);

                      $chart3 = Charts::multi('line', 'highcharts')
                              ->title('Machine Ussage')
                              ->labels($dates)
                              ->dataset('Straight Knife', $stknife)
                              ->dataset('Band Kife', $bandknife)
                              ->dataset('Fusing Machines', $fusing)
                              ->height(300)
                              ->responsive(false);

                      

                          $charts[] = $chart1;
                          $charts[] = $chart2;
                          $charts[] = $chart3;
                  break;

                case 'sewing':
                  $redirect = 'factory.sewing';
                  $charts = sewingKPI(Auth::user()->factory_id);
                  break;

                case 'finishing':
                  $redirect = 'factory.finishing';
                  $charts = finishingKPI(Auth::user()->factory_id);
                  break;

                case 'strength':
                  $redirect = 'factory.qua-strength';
                  $charts = qualityStrength(Auth::user()->factory_id);
                  break;

                default:
                  $redirect = 'service.noauth';
                  break;
              }
            }
          }
          // if the user is not active
          else {
            $redirect = 'service.isnotactive';
          }
          // Redirects to the default views

        if(isset($charts)) {
          return view($redirect)->with('charts', $charts);
        }
        else{
          return view($redirect);
        }

    }


}
