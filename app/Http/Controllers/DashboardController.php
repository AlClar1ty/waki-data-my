<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataUndangan;
use App\DataOutsite;
use App\DataTherapy;
use App\Branch;
use App\Mpc;
use Auth;

class DashboardController extends Controller
{
    public function index()
    {	
    	$user = Auth::user();

    	$TotalR1 = Mpc::where([['active', true],['branch_id', 1]])->count();
    	$TotalR2 = Mpc::where([['active', true],['branch_id', 2]])->count();
    	$TotalR3 = Mpc::where([['active', true],['branch_id', 3]])->count();
    	$TotalR4 = Mpc::where([['active', true],['branch_id', 4]])->count();
    	$TotalR5 = Mpc::where([['active', true],['branch_id', 5]])->count();
    	$R1 = Mpc::where([['active', true],['branch_id', 'R01']]);
    	$R2 = Mpc::where([['active', true],['branch_id', 'R02']]);
    	$R3 = Mpc::where([['active', true],['branch_id', 'R03']]);
    	$R4 = Mpc::where([['active', true],['branch_id', 'R04']]);
    	$R5 = Mpc::where([['active', true],['branch_id', 'R05']]);

        $branches = Branch::where([['country', $user->branch['country']],['active', true]])->orderBy('code')->get();

    	return view('dashboard', compact('TotalR1', 'TotalR2', 'TotalR3', 'TotalR4', 'TotalR5',
    				'R1', 'R2', 'R3', 'R4', 'R5', 'branches'));
    }
}
