<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Auth;
use App\Factory;
use App\User;
use App\BMCkpi as BCKPI;
use App\BMQkpi as BQKPI;
use App\BMSkpi as BSKPI;
use App\DCkpi as CKPI;
use App\DFkpi as DKPI;
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
                  $reports = CKPI::where('factroy_id', Auth::user()->factory_id)->orderBy('created_at', 'desc')->take(30);
                  break;

                case 'sewing':
                  $redirect = 'factory.sewing';
                  $reports = SKPI::where('factroy_id', Auth::user()->factory_id)->orderBy('created_at', 'desc')->take(30);
                  break;

                case 'finishing':
                  $redirect = 'factory.finishing';
                  $reports = FKPI::where('factroy_id', Auth::user()->factory_id)->orderBy('created_at', 'desc')->take(30);
                  break;

                case 'strength':
                  $redirect = 'factory.qua-strength';
                  $reports[] = QKPI::where('factroy_id', Auth::user()->factory_id)->orderBy('created_at', 'desc')->take(30);
                  $reporst[] = GKPI::where('factroy_id', Auth::user()->factory_id)->orderBy('created_at', 'desc')->take(30);
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

        if(isset($reports)) {
          return view($redirect)->with('reports', $reports);
        }
        else{
          return view($redirect);
        }

    }
}
