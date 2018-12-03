<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Branch;
use App\Cso;
// use App\Http\Requests\StoreBranch as StoreBranchRequest;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Auth;

class AjaxController extends Controller
{
    public function selectCountry(Request $request)
    {
    	$branches = Branch::where('country', $request->country)->orderBy('code')->get();
    	return response()->json($branches);
    }
    public function selectBranch(Request $request)
    {
        $csos = Cso::where('branch_id', $request->branch_id)->get();
        return response()->json($csos);
    }

    ///////////////KHUSUS STATE, CITY, and POSTCODE MALAYSIA///////////////
    public function selectCity(Request $request)
    {
        $city = DB::table('postcode')->where('state',$request->state)->distinct()->get(['city']);
        return response()->json($city);
    }
    public function selectPostcode(Request $request)
    {
        $postcode = DB::table('postcode')->where('city',$request->city)->get(['postcode']);
        return response()->json($postcode);
    }
    ///////////////////////////////////////////////////////////////////////

    public function checkBranchCode(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'code' => 'unique:branches',
        ]);

        if ($validator->fails()) {
            return "failed";
        }
        else
        {
            return "success";
        }
    }

    public function changePassword(Request $request){
        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);
 
        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();
 
        return redirect()->back()->with("success","Password changed successfully!");
 
    }

    public function checkChangePassword(Request $request)
    {
        $data = ['current-password' => '', 'new-password' => '', 'new-password-confirm' => ''];
        if (!(Hash::check($request->get('currentPass'), Auth::user()->password))) {
            // The passwords doesn't matches
            $data['current-password'] = 'error';
        }
        if(strcmp($request->get('currentPass'), $request->get('newPass')) == 0 && ($request->get('currentPass') != "" || $request->get('newPass') != "")){
            //Current password and new password are same
            $data['new-password'] = 'error';
        }
        if(strcmp($request->get('newPass'), $request->get('confirmPass')) != 0){
            //New password and new password confirm are not same
            $data['new-password-confirm'] = 'error';
        }
        return $data;
    }
}
