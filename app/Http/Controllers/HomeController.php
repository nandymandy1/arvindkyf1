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

    public static function toFraction($number) {

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
                  $ckpis = CKPI::all()
                              ->where('factory_id', Auth::user()->factory_id)
                              ->take(30);

                        $dates = [];
                        $cut_qty = [];
                        $fusing_out = [];
                        $pcs_s = [];
                        $c_men = [];
                        $men = 0;
                        $machine = 0;
                        $bandknife = [];
                        $stknife = [];
                        $fusing = [];
                        $pcs_e = [];

                        foreach ($ckpis as $ckpi) {
                          $dates [] = date("d/m/Y", strtotime($ckpi->created_at));
                          $cut_qty[] = $ckpi->cut_qty;
                          $fusing_out[] = $ckpi->fusing_out;
                          $pcs_s[] = $ckpi->pcs_sew;
                          $men += $ckpi->people;
                          $machine += $ckpi->mcs_used;
                          $stknife[] = $ckpi->no_stknife;
                          $fusing[] = $ckpi->no_fusing;
                          $pcs_e[] = $ckpi->pcs_emb;
                        }
                      $charts = [];
                      $charts[] = Charts::create('donut', 'highcharts')
                                ->title('Man Machine ratio')
                                ->labels(['Man', 'Machines'])
                                ->values([$men, $machine])
                                ->height(300)
                                ->responsive(false);

                      $charts[] = Charts::multi('bar', 'highcharts')
                              ->title('Cutting Staus')
                              ->labels($dates)
                              ->dataset('Cutting Quantity', $cut_qty)
                              ->dataset('Fusing Output', $fusing_out)
                              ->dataset('Pieces sent for Sewing', $pcs_s)
                              ->dataset('Pieces sent for Embroidary', $pcs_e)
                              ->height(300)
                              ->responsive(false);

                  break;

                case 'sewing':
                  $redirect = 'factory.sewing';
                  $skpis = SKPI::all()
                          ->where('factory_id', Auth::user()->factory_id)
                          ->take(30);

                  $dates = [];
                  $no_lines = [];
                  $elo = [[]];
                  $so_pl = [];
                  $no_sew_mcs = [];
                  $no_people = [];
                  $no_help = [];
                  $no_kaja = [];
                  $no_opr = [];
                  $sam = [];
                  $no_send = [];
                  $productivity = [];
                  $efficiency =[];
                  $temp_eff = [];
                  $target = [];
                  $actual = [];

                  foreach ($skpis as $skpi) {
                    $dates [] = date("d/m/Y", strtotime($skpi->created_at));
                    $no_lines [] = $skpi->no_line;
                    $str1 = explode(':',$skpi->elo);
                    $elo[] = $str1;
                    $so_pl[] = $skpi->so_pl;
                    $no_sew_mcs[] = $skpi->no_sew_mcs;
                    $no_people[] = $skpi->no_people;
                    $no_help[] = $skpi->no_help;
                    $no_kaja[] = $skpi->no_kaja;
                    $no_opr[] = $skpi->no_opr;
                    $sam[] = $skpi->sam;
                    $no_send[] = $skpi->no_send;
                    $productivity[] = (round((array_sum($str1)/$skpi->no_people), 2));
                    $efficiency[] = round((((array_sum($str1)*$skpi->sam)/(540*$skpi->no_people))*100),2);
                    $target[] = $skpi->target;
                    $actual[] = $skpi->actual;
                  }
                  $charts = [];
                  // Chart for the productivity
                  $charts[] = Charts::multi('line', 'highcharts')
                            ->title('Daily Productivity')
                            ->labels($dates)
                            ->dataset('Productivity', $productivity)
                            ->height(300)
                            ->responsive(false);

                  // Chart for the line efficiency
                  $charts[] = Charts::multi('line', 'highcharts')
                            ->title('Daily Efficiency')
                            ->labels($dates)
                            ->dataset('Efficiency', $efficiency)
                            ->height(300)
                            ->responsive(false);

                // MMR chart
                 $charts[] = Charts::create('donut', 'highcharts')
                            ->title('Man Machine Ratio')
                            ->labels(['Man', 'Machine'])
                            ->values([array_sum($no_people), array_sum($no_sew_mcs)])
                            ->height(300)
                            ->responsive(false);

                // Actual vs Target
                $charts[] = Charts::multi('areaspline', 'highcharts')
                             ->title('Target vs Actual Production')
                             ->labels($dates)
                             ->dataset('Target Production', $target)
                             ->dataset('Actual Production', $actual)
                             ->height(300)
                             ->responsive(false);

                  break;

                case 'finishing':
                  $redirect = 'factory.finishing';
                  $fkpis = FKPI::all()
                              ->where('factory_id', Auth::user()->factory_id)
                              ->take(30);
                  $dates = [];
                  $pcs_r = [];
                  $pcs_f = [];
                  $pkd = [];
                  foreach ($fkpis as $fkpi) {
                    $dates [] = date("d/m/Y", strtotime($fkpi->created_at));
                    $pcs_r[] = $fkpi->pcs_sew_wash;
                    $pcs_f[] = $fkpi->pcs_fed;
                    $pkd[] = $fkpi->pkd_pcs;
                  }
                  $charts = [];
                  $charts[] = Charts::multi('line', 'highcharts')
                              ->title('Daily Finishing Data')
                              ->labels($dates)
                              ->dataset('Pieces Recieved from Sewing', $pcs_r)
                              ->dataset('Pieces Fed into Finishing', $pcs_f)
                              ->dataset('Pieces Packed', $pkd)
                              ->height(300)
                              ->responsive(false);

                  break;

                case 'strength':

                  $redirect = 'factory.qua-strength';
                  $gkpis = GKPI::all()
                            ->where('factory_id', Auth::user()->factory_id)
                            ->take(30);
                  $qkpis = QKPI::all()
                            ->where('factory_id', Auth::user()->factory_id)
                            ->take(30);
                  $dates_g = [];
                  $dates_q = [];
                  $dhu = [];
                  $poeple_payrole = [];
                  $people_cont = [];
                  $ot_sew = [];
                  $ot_fin = [];
                  $ot_cut = [];
                  $abs = [];
                  $failed=[];
                  $inspected=[];

                  foreach ($gkpis as $gkpi) {
                    $dates_g[] = date("d/m/Y", strtotime($gkpi->created_at));
                    $poeple_payrole[] = $gkpi->poeple_payrole;
                    $people_cont[] = $gkpi->people_cont;
                    $ot_sew[] = $gkpi->ot_sew;
                    $ot_fin[] = $gkpi->ot_fin;
                    $ot_cut[] = $gkpi->ot_cut;
                    $abs[]  = $gkpi->absent;
                  }
                  foreach ($qkpis as $qkpi) {
                    $dates_q[] = date("d/m/Y", strtotime($qkpi->created_at));
                    $dhu[] = $qkpi->dhu;
                    $failed[] = $qkpi->failed;
                    $inspected[] = $qkpi->inspected;
                  }

                  $charts = [];
                  $charts[] = Charts::multi('line', 'highcharts')
                              ->title('Daily Quality Report')
                              ->labels($dates_q)
                              ->dataset('Defect Per Hundred', $dhu)
                              ->height(300)
                              ->responsive(false);

                  $charts[] = Charts::multi('bar', 'highcharts')
                              ->title('Overtime')
                              ->labels($dates_g)
                              ->dataset('Cutting Overtime', $ot_cut)
                              ->dataset('Sewing Overtime', $ot_sew)
                              ->dataset('Finishing Overtime', $ot_fin)
                              ->height(300)
                              ->responsive(false);

                  $charts[] = Charts::multi('line', 'highcharts')
                            ->title('Absentism')
                            ->labels($dates_g)
                            ->dataset('Absentism', $abs)
                            ->height(300)
                            ->responsive(false);

                  $charts[] = Charts::multi('line', 'highcharts')
                            ->title('Contract vs Payrole')
                            ->labels($dates_g)
                            ->dataset('Contract People', $people_cont)
                            ->dataset('Payrole People', $poeple_payrole)
                            ->height(300)
                            ->responsive(false);

                  $charts[] = Charts::multi('line', 'highcharts')
                              ->title('Failed Vs Inspected')
                              ->labels($dates_q)
                              ->dataset('Failed Quantity', $failed)
                              ->dataset('Inspected Quantity', $inspected)
                              ->height(300)
                              ->responsive(false);
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
