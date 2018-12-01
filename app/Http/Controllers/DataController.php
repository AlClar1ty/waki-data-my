<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\DataUndangan;
use App\DataOutsite;
use App\DataTherapy;
use App\HistoryUndangan;
use App\Location;
use App\TypeCust;
use App\Mpc;
use App\Branch;
use App\Cso;
use App\Bank;
use App\User;
use Auth;
use DB;

class DataController extends Controller
{
    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
    /*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++    BUAT INDEX DATA    ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

    public function index(Request $request)
    {
        //FOR ENCRYPT PHONE AT FIRST IMPORT THE DATABASE
        // for ($i = 1; $i<=474; $i++)
        // {
        //     $data = DB::table('data_outsites')->where('id', $i)->first();
        //     DB::table('data_outsites')
        //     ->where('id', $i)
        //     ->update(['phone' => $this->Encr($data->phone)]);
        // }

        // DECRYPT NAME
        // $data = DB::table('data_undangans')->where('code', 'qwe')->first();
        // DB::table('data_undangans')
        //     ->where('code', 'qwe')
        //     ->update(['name' => $this->DecryptName($data->name)]);

        $user = Auth::user();

        /*percabngan bisa masuk salah satu index data
        * kalo bisa masuk all-country atau all branch
        * maka dia bisa buka table salah satu data tersebut
        * sample : "if(all-branch-mpc || all-country-mpc)"
        */
        if($user->can('browse-mpc'))
        {
            $dataMpcs = $this->IndexMpc($request, $user);
        }
        if($user->can('browse-data-undangan'))
        {
            $dataUndangans = $this->IndexUndangan($request, $user);
        }
        if($user->can('browse-data-outsite'))
        {
            $dataOutsites = $this->IndexOutsite($request, $user);
        }
        if($user->can('browse-data-therapy'))
        {
            $dataTherapies = $this->IndexTherapy($request, $user);
        }

        $branches = Branch::where([['country', $user->branch['country']],['active', true]])->orderBy('code')->get();
        $csos = Cso::where('active', true)->orderBy('name')->get();
        $type_custs = TypeCust::where('active', true)->get();
        $banks = Bank::where('active', true)->get();
        $locations = Location::where('active', true)->get();

        return view('data', compact('dataMpcs', 'dataOutsites', 'dataTherapies', 'dataUndangans', 'csos', 'branches', 'type_custs', 'banks', 'locations'));
    }

    /*Function untuk menampilkan data index MPC
    * menggunakan parameter request dan auth pada user itu sendiri
    * jika ada parameter request->keywordMpc, maka
    * akan di cari berdasarkan keyword yang ada di Mpc
    * mengembalikan return data $mpcs
    */
    function IndexMpc(Request $request, User $user)
    {
        if($user->can('all-branch-mpc'))
        {
            if($user->can('all-country-mpc'))
            {
                $mpcs = Mpc::when($request->keywordMpc, function ($query) use ($request) {
                    $query->where('mpcs.code', 'like', "%{$request->keywordMpc}%")
                        ->where('mpcs.active', true)
                        ->orWhere('mpcs.member_no', 'like', "%{$request->keywordMpc}%")
                        ->where('mpcs.active', true)
                        ->orWhere('mpcs.name', 'like', "%{$request->keywordMpc}%")
                        ->where('mpcs.active', true)
                        ->orWhere('mpcs.idcard', 'like', "%{$request->keywordMpc}%")
                        ->where('mpcs.active', true)
                        ->orWhere('mpcs.status', 'like', "%{$request->keywordMpc}%")
                        ->where('mpcs.active', true)
                        ->orWhere('mpcs.gender', 'like', "%{$request->keywordMpc}%")
                        ->where('mpcs.active', true)
                        ->orWhere('mpcs.address', 'like', "%{$request->keywordMpc}%")
                        ->where('mpcs.active', true)
                        ->orWhere('mpcs.postcode', 'like', "%{$request->keywordMpc}%")
                        ->where('mpcs.active', true)
                        ->orWhere('mpcs.city', 'like', "%{$request->keywordMpc}%")
                        ->where('mpcs.active', true)
                        ->orWhere('mpcs.state', 'like', "%{$request->keywordMpc}%")
                        ->where('mpcs.active', true)
                        ->orWhere('mpcs.house_phone', 'like', "%{$request->keywordMpc}%")
                        ->where('mpcs.active', true)
                        ->orWhere('mpcs.mobile_phone', 'like', "%{$request->keywordMpc}%")
                        ->where('mpcs.active', true)
                        ->orWhere('mpcs.fb_name', 'like', "%{$request->keywordMpc}%")
                        ->where('mpcs.active', true)
                        ->orWhere('mpcs.email', 'like', "%{$request->keywordMpc}%")
                        ->where('mpcs.active', true)
                        ->orWhere('branches.name', 'like', "%{$request->keywordMpc}%")
                        ->where('mpcs.active', true)
                        ->orWhere('branches.code', 'like', "%{$request->keywordMpc}%")
                        ->where('mpcs.active', true)
                        ->orWhere('users.name', 'like', "%{$request->keywordMpc}%")
                        ->where('mpcs.active', true);
                })->where('mpcs.active', true)
                ->join('branches', 'mpcs.branch_id', '=', 'branches.id')
                ->join('users', 'mpcs.user_id', '=', 'users.id')
                ->orderBy('mpcs.registration_date', 'desc')
                ->select('mpcs.*')
                ->paginate(10);

                $mpcs->appends($request->only('keywordMpc'));
            }
            else
            {
                $mpcs = Mpc::when($request->keywordMpc, function ($query) use ($request, $user) {
                    $query->where('mpcs.code', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('mpcs.member_no', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('mpcs.name', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('mpcs.idcard', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('mpcs.status', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('mpcs.gender', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('mpcs.address', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('mpcs.postcode', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('mpcs.city', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('mpcs.state', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('mpcs.house_phone', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('mpcs.mobile_phone', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('mpcs.fb_name', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('mpcs.email', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('branches.name', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('branches.code', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('users.name', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['branches.country', $user->branch['country']]
                        ]);
                })->where([['mpcs.active', true],
                        ['branches.country', $user->branch['country']]])
                ->join('branches', 'mpcs.branch_id', '=', 'branches.id')
                ->join('users', 'mpcs.user_id', '=', 'users.id')
                ->orderBy('mpcs.registration_date', 'desc')
                ->select('mpcs.*')
                ->paginate(10);

                $mpcs->appends($request->only('keywordMpc'));
            }
        }
        else
        {
            $mpcs = Mpc::when($request->keywordMpc, function ($query) use ($request, $user) {
                $query->where('mpcs.code', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['mpcs.branch_id', $user->branch_id]
                        ])
                        ->orWhere('mpcs.member_no', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['mpcs.branch_id', $user->branch_id]
                        ])
                        ->orWhere('mpcs.name', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['mpcs.branch_id', $user->branch_id]
                        ])
                        ->orWhere('mpcs.idcard', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['mpcs.branch_id', $user->branch_id]
                        ])
                        ->orWhere('mpcs.status', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['mpcs.branch_id', $user->branch_id]
                        ])
                        ->orWhere('mpcs.gender', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['mpcs.branch_id', $user->branch_id]
                        ])
                        ->orWhere('mpcs.address', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['mpcs.branch_id', $user->branch_id]
                        ])
                        ->orWhere('mpcs.postcode', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['mpcs.branch_id', $user->branch_id]
                        ])
                        ->orWhere('mpcs.city', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['mpcs.branch_id', $user->branch_id]
                        ])
                        ->orWhere('mpcs.state', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['mpcs.branch_id', $user->branch_id]
                        ])
                        ->orWhere('mpcs.house_phone', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['mpcs.branch_id', $user->branch_id]
                        ])
                        ->orWhere('mpcs.mobile_phone', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['mpcs.branch_id', $user->branch_id]
                        ])
                        ->orWhere('mpcs.fb_name', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['mpcs.branch_id', $user->branch_id]
                        ])
                        ->orWhere('mpcs.email', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['mpcs.branch_id', $user->branch_id]
                        ])
                        ->orWhere('branches.name', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['mpcs.branch_id', $user->branch_id]
                        ])
                        ->orWhere('branches.code', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['mpcs.branch_id', $user->branch_id]
                        ])
                        ->orWhere('users.name', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['mpcs.branch_id', $user->branch_id]
                        ]);
            })->where([
                ['mpcs.active', true],
                ['mpcs.branch_id', $user->branch_id]
            ])
            ->join('csos', 'mpcs.cso_id', '=', 'csos.id')
            ->join('users', 'mpcs.user_id', '=', 'users.id')
            ->orderBy('mpcs.id', 'desc')
            ->select('mpcs.*')
            ->paginate(10);

            $mpcs->appends($request->only('keywordMpc'));
        }

        return $mpcs;
    }

    //blom selesai masih ada masalah dengan history nya...
    function IndexUndangan(Request $request, User $user)
    {
        if($user->can('all-branch-data-undangan'))
        {
            if($user->can('all-country-data-undangan'))
            {
                $data_undangans = DataUndangan::when($request->keywordDataUndangan, function ($query) use ($request) {
                    $query->where('code', 'like', "%{$request->keywordDataUndangan}%")
                        ->where('active', true)
                        ->orWhere('name', 'like', "%{$request->keywordDataUndangan}%")
                        ->where('active', true)
                        ->orWhere('address', 'like', "%{$request->keywordDataUndangan}%")
                        ->where('active', true)
                        ->orWhere('phone', 'like', "%{$this->Encr($request->keywordDataUndangan)}%")
                        ->where('active', true)
                        ->orWhere('registration_date', 'like', "%{$request->keywordDataUndangan}%")
                        ->where('active', true)
                        ->orWhere('birth_date', 'like', "%{$request->keywordDataUndangan}%")
                        ->where('active', true);
                })->where('active', true)
                ->orderBy('id', 'desc')
                ->paginate(10);

                $data_undangans->appends($request->only('keywordDataUndangan'));
            }
            else
            {
                $data_undangans = DataUndangan::when($request->keywordDataUndangan, function ($query) use ($request, $user) {
                    $query->where('data_undangans.code', 'like', "%{$request->keywordDataUndangan}%")
                        ->where([
                            ['data_undangans.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('data_undangans.name', 'like', "%{$request->keywordDataUndangan}%")
                        ->where([
                            ['data_undangans.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('data_undangans.address', 'like', "%{$request->keywordDataUndangan}%")
                        ->where([
                            ['data_undangans.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('data_undangans.phone', 'like', "%{$this->Encr($request->keywordDataUndangan)}%")
                        ->where([
                            ['data_undangans.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('data_undangans.registration_date', 'like', "%{$request->keywordDataUndangan}%")
                        ->where([
                            ['data_undangans.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('data_undangans.birth_date', 'like', "%{$request->keywordDataUndangan}%")
                        ->where([
                            ['data_undangans.active', true],
                            ['branches.country', $user->branch['country']]
                        ]);
                })
                ->where([['data_undangans.active', true],
                        ['branches.country', $user->branch['country']]])
                ->join('history_undangans', 'data_undangans.id', '=', 'history_undangans.data_undangan_id')
                ->leftjoin('banks', 'history_undangans.bank_id', '=', 'banks.id')
                ->join('branches', 'history_undangans.branch_id', '=', 'branches.id')
                ->join('csos', 'history_undangans.cso_id', '=', 'csos.id')
                ->join('type_custs', 'history_undangans.type_cust_id', '=', 'type_custs.id')
                ->orderBy('data_undangans.id', 'desc')
                ->select('data_undangans.*')
                ->paginate(10);

                $data_undangans->appends($request->only('keywordDataUndangan'));
            }
        }
        else
        {
            $data_undangans = DataUndangan::when($request->keywordDataUndangan, function ($query) use ($request, $user) {
                $query->where('data_undangans.code', 'like', "%{$request->keywordDataUndangan}%")
                    ->where([
                        ['data_undangans.active', true],
                        ['history_undangans.branch_id', $user->branch_id]
                    ])
                    ->orWhere('data_undangans.name', 'like', "%{$request->keywordDataUndangan}%")
                    ->where([
                        ['data_undangans.active', true],
                        ['history_undangans.branch_id', $user->branch_id]
                    ])
                    ->orWhere('data_undangans.address', 'like', "%{$request->keywordDataUndangan}%")
                    ->where([
                        ['data_undangans.active', true],
                        ['history_undangans.branch_id', $user->branch_id]
                    ])
                    ->orWhere('data_undangans.phone', 'like', "%{$this->Encr($request->keywordDataUndangan)}%")
                    ->where([
                        ['data_undangans.active', true],
                        ['history_undangans.branch_id', $user->branch_id]
                    ])
                    ->orWhere('data_undangans.registration_date', 'like', "%{$request->keywordDataUndangan}%")
                    ->where([
                        ['data_undangans.active', true],
                        ['history_undangans.branch_id', $user->branch_id]
                    ])
                    ->orWhere('data_undangans.birth_date', 'like', "%{$request->keywordDataUndangan}%")
                    ->where([
                        ['data_undangans.active', true],
                        ['history_undangans.branch_id', $user->branch_id]
                    ]);
            })
            ->where([
                ['data_undangans.active', true],
                ['history_undangans.branch_id', $user->branch_id]
            ])
            ->join('history_undangans', 'data_undangans.id', '=', 'history_undangans.data_undangan_id')
            ->leftjoin('banks', 'history_undangans.bank_id', '=', 'banks.id')
            ->join('branches', 'history_undangans.branch_id', '=', 'branches.id')
            ->join('csos', 'history_undangans.cso_id', '=', 'csos.id')
            ->join('type_custs', 'history_undangans.type_cust_id', '=', 'type_custs.id')
            ->orderBy('data_undangans.id', 'desc')
            ->select('data_undangans.*')
            ->paginate(10);

            $data_undangans->appends($request->only('keywordDataUndangan'));
        }
        return $data_undangans;
    }

    function IndexOutsite(Request $request, User $user)
    {
        if($user->can('all-branch-data-outsite'))
        {
            if($user->can('all-country-data-outsite'))
            {
                $data_outsites = DataOutsite::when($request->keywordDataOutsite, function ($query) use ($request) {
                    $query->where('data_outsites.code', 'like', "%{$request->keywordDataOutsite}%")
                        ->where('data_outsites.active', true)
                        ->orWhere('data_outsites.name', 'like', "%{$request->keywordDataOutsite}%")
                        ->where('data_outsites.active', true)
                        ->orWhere('data_outsites.phone', 'like', "%{$this->Encr($request->keywordDataOutsite)}%")
                        ->where('data_outsites.active', true)
                        ->orWhere('data_outsites.province', 'like', "%{$request->keywordDataOutsite}%")
                        ->where('data_outsites.active', true)
                        ->orWhere('data_outsites.district', 'like', "%{$request->keywordDataOutsite}%")
                        ->where('data_outsites.active', true)
                        ->orWhere('data_outsites.registration_date', 'like', "%{$request->keywordDataOutsite}%")
                        ->where('data_outsites.active', true)
                        ->orWhere('branches.name', 'like', "%{$request->keywordDataOutsite}%")
                        ->where('data_outsites.active', true)
                        ->orWhere('branches.country', 'like', "%{$request->keywordDataOutsite}%")
                        ->where('data_outsites.active', true)
                        ->orWhere('csos.name', 'like', "%{$request->keywordDataOutsite}%")
                        ->where('data_outsites.active', true)
                        ->orWhere('locations.name', 'like', "%{$request->keywordDataOutsite}%")
                        ->where('data_outsites.active', true)
                        ->orWhere('type_custs.name', 'like', "%{$request->keywordDataOutsite}%")
                        ->where('data_outsites.active', true);
                })->where('data_outsites.active', true)
                ->join('branches', 'data_outsites.branch_id', '=', 'branches.id')
                ->join('csos', 'data_outsites.cso_id', '=', 'csos.id')
                ->leftjoin('locations', 'data_outsites.location_id', '=', 'locations.id')
                ->join('type_custs', 'data_outsites.type_cust_id', '=', 'type_custs.id')
                ->orderBy('data_outsites.id', 'desc')
                ->select('data_outsites.*')
                ->paginate(10);

                $data_outsites->appends($request->only('keywordDataOutsite'));
            }
            else
            {
                $data_outsites = DataOutsite::when($request->keywordDataOutsite, function ($query) use ($request, $user) {
                    $query->where('data_outsites.code', 'like', "%{$request->keywordDataOutsite}%")
                        ->where([
                            ['data_outsites.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('data_outsites.name', 'like', "%{$request->keywordDataOutsite}%")
                        ->where([
                            ['data_outsites.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('data_outsites.phone', 'like', "%{$this->Encr($request->keywordDataOutsite)}%")
                        ->where([
                            ['data_outsites.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('data_outsites.province', 'like', "%{$request->keywordDataOutsite}%")
                        ->where([
                            ['data_outsites.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('data_outsites.district', 'like', "%{$request->keywordDataOutsite}%")
                        ->where([
                            ['data_outsites.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('data_outsites.registration_date', 'like', "%{$request->keywordDataOutsite}%")
                        ->where([
                            ['data_outsites.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        //------------------------------------------------------------
                        ->orWhere('branches.name', 'like', "%{$request->keywordDataOutsite}%")
                        ->where([
                            ['data_outsites.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('csos.name', 'like', "%{$request->keywordDataOutsite}%")
                        ->where([
                            ['data_outsites.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('locations.name', 'like', "%{$request->keywordDataOutsite}%")
                        ->where([
                            ['data_outsites.active', true],
                            ['branches.country', $user->branch['country']]
                        ])                        
                        ->orWhere('type_custs.name', 'like', "%{$request->keywordDataOutsite}%")
                        ->where([
                            ['data_outsites.active', true],
                            ['branches.country', $user->branch['country']]
                        ]);
                })
                ->where([['data_outsites.active', true],
                        ['branches.country', $user->branch['country']]])
                ->join('branches', 'data_outsites.branch_id', '=', 'branches.id')
                ->join('csos', 'data_outsites.cso_id', '=', 'csos.id')
                ->leftjoin('locations', 'data_outsites.location_id', '=', 'locations.id')
                ->join('type_custs', 'data_outsites.type_cust_id', '=', 'type_custs.id')
                ->orderBy('data_outsites.id', 'desc')
                ->select('data_outsites.*')
                ->paginate(10);

                $data_outsites->appends($request->only('keywordDataOutsite'));
            }
        }
        else
        {
            $data_outsites = DataOutsite::when($request->keywordDataOutsite, function ($query) use ($request, $user) {
                $query->where('data_outsites.code', 'like', "%{$request->keywordDataOutsite}%")
                    ->where([
                        ['data_outsites.active', true],
                        ['data_outsites.branch_id', $user->branch_id]
                    ])
                    ->orWhere('data_outsites.name', 'like', "%{$request->keywordDataOutsite}%")
                    ->where([
                        ['data_outsites.active', true],
                        ['data_outsites.branch_id', $user->branch_id]
                    ])
                    ->orWhere('data_outsites.phone', 'like', "%{$this->Encr($request->keywordDataOutsite)}%")
                    ->where([
                        ['data_outsites.active', true],
                        ['data_outsites.branch_id', $user->branch_id]
                    ])
                    ->orWhere('data_outsites.province', 'like', "%{$request->keywordDataOutsite}%")
                    ->where([
                        ['data_outsites.active', true],
                        ['data_outsites.branch_id', $user->branch_id]
                    ])
                    ->orWhere('data_outsites.district', 'like', "%{$request->keywordDataOutsite}%")
                    ->where([
                        ['data_outsites.active', true],
                        ['data_outsites.branch_id', $user->branch_id]
                    ])
                    ->orWhere('data_outsites.registration_date', 'like', "%{$request->keywordDataOutsite}%")
                    ->where([
                        ['data_outsites.active', true],
                        ['data_outsites.branch_id', $user->branch_id]
                    ])
                    //------------------------------------------------------------------------------------------
                    ->orWhere('branches.name', 'like', "%{$request->keywordDataOutsite}%")
                    ->where([
                        ['data_outsites.active', true],
                        ['branches.country', $user->branch_id]
                    ])
                    ->orWhere('csos.name', 'like', "%{$request->keywordDataOutsite}%")
                    ->where([
                        ['data_outsites.active', true],
                        ['branches.country', $user->branch_id]
                    ])
                    ->orWhere('locations.name', 'like', "%{$request->keywordDataOutsite}%")
                    ->where([
                        ['data_outsites.active', true],
                        ['branches.country', $user->branch_id]
                    ])                        
                    ->orWhere('type_custs.name', 'like', "%{$request->keywordDataOutsite}%")
                    ->where([
                        ['data_outsites.active', true],
                        ['branches.country', $user->branch_id]
                    ]);
            })
            ->where([
                ['data_outsites.active', true],
                ['data_outsites.branch_id', $user->branch_id]
            ])
            ->join('csos', 'data_outsites.cso_id', '=', 'csos.id')
            ->join('branches', 'data_outsites.branch_id', '=', 'branches.id')
            ->leftjoin('locations', 'data_outsites.location_id', '=', 'locations.id')
            ->join('type_custs', 'data_outsites.type_cust_id', '=', 'type_custs.id')
            ->orderBy('data_outsites.id', 'desc')
            ->select('data_outsites.*')
            ->paginate(10);

            $data_outsites->appends($request->only('keywordDataOutsite'));
        }

        return $data_outsites;
    }

    function IndexTherapy(Request $request, User $user)
    {
        if($user->can('all-branch-data-therapy'))
        {
            if($user->can('all-country-data-therapy'))
            {
                $data_therapies = DataTherapy::when($request->keywordDataTherapy, function ($query) use ($request) {
                    $query->where('data_therapies.code', 'like', "%{$request->keywordDataTherapy}%")
                        ->where('data_therapies.active', true)
                        ->orWhere('data_therapies.name', 'like', "%{$request->keywordDataTherapy}%")
                        ->where('data_therapies.active', true)
                        ->orWhere('data_therapies.phone', 'like', "%{$this->Encr($request->keywordDataTherapy)}%")
                        ->where('data_therapies.active', true)
                        ->orWhere('data_therapies.province', 'like', "%{$request->keywordDataTherapy}%")
                        ->where('data_therapies.active', true)
                        ->orWhere('data_therapies.district', 'like', "%{$request->keywordDataTherapy}%")
                        ->where('data_therapies.active', true)
                        ->orWhere('data_therapies.registration_date', 'like', "%{$request->keywordDataTherapy}%")
                        ->where('data_therapies.active', true)
                        ->orWhere('data_therapies.address', 'like', "%{$request->keywordDataTherapy}%")
                        ->where('data_therapies.active', true)
                        //----------------------------------------------------------
                        ->orWhere('branches.name', 'like', "%{$request->keywordDataTherapy}%")
                        ->where('data_therapies.active', true)
                        ->orWhere('branches.country', 'like', "%{$request->keywordDataTherapy}%")
                        ->where('data_therapies.active', true)
                        ->orWhere('csos.name', 'like', "%{$request->keywordDataTherapy}%")
                        ->where('data_therapies.active', true)
                        ->orWhere('type_custs.name', 'like', "%{$request->keywordDataTherapy}%")
                        ->where('data_therapies.active', true);
                })->where('data_therapies.active', true)
                ->join('branches', 'data_therapies.branch_id', '=', 'branches.id')
                ->join('csos', 'data_therapies.cso_id', '=', 'csos.id')
                ->join('type_custs', 'data_therapies.type_cust_id', '=', 'type_custs.id')
                ->orderBy('data_therapies.id', 'desc')
                ->select('data_therapies.*')
                ->paginate(10);

                $data_therapies->appends($request->only('keywordDataTherapy'));
            }
            else
            {
                $data_therapies = DataTherapy::when($request->keywordDataTherapy, function ($query) use ($request, $user) {
                    $query->where('data_therapies.code', 'like', "%{$request->keywordDataTherapy}%")
                        ->where([
                            ['data_therapies.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('data_therapies.name', 'like', "%{$request->keywordDataTherapy}%")
                        ->where([
                            ['data_therapies.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('data_therapies.phone', 'like', "%{$this->Encr($request->keywordDataTherapy)}%")
                        ->where([
                            ['data_therapies.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('data_therapies.province', 'like', "%{$request->keywordDataTherapy}%")
                        ->where([
                            ['data_therapies.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('data_therapies.district', 'like', "%{$request->keywordDataTherapy}%")
                        ->where([
                            ['data_therapies.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('data_therapies.registration_date', 'like', "%{$request->keywordDataTherapy}%")
                        ->where([
                            ['data_therapies.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('data_therapies.address', 'like', "%{$request->keywordDataTherapy}%")
                        ->where([
                            ['data_therapies.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        //------------------------------------------------------------
                        ->orWhere('branches.name', 'like', "%{$request->keywordDataTherapy}%")
                        ->where([
                            ['data_therapies.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('csos.name', 'like', "%{$request->keywordDataTherapy}%")
                        ->where([
                            ['data_therapies.active', true],
                            ['branches.country', $user->branch['country']]
                        ])                      
                        ->orWhere('type_custs.name', 'like', "%{$request->keywordDataTherapy}%")
                        ->where([
                            ['data_therapies.active', true],
                            ['branches.country', $user->branch['country']]
                        ]);
                })
                ->where([['data_therapies.active', true],
                        ['branches.country', $user->branch['country']]])
                ->join('branches', 'data_therapies.branch_id', '=', 'branches.id')
                ->join('csos', 'data_therapies.cso_id', '=', 'csos.id')
                ->join('type_custs', 'data_therapies.type_cust_id', '=', 'type_custs.id')
                ->orderBy('data_therapies.id', 'desc')
                ->select('data_therapies.*')
                ->paginate(10);

                $data_therapies->appends($request->only('keywordDataTherapy'));
            }
        }
        else
        {
            $data_therapies = DataTherapy::when($request->keywordDataTherapy, function ($query) use ($request, $user) {
                $query->where('data_therapies.code', 'like', "%{$request->keywordDataOutsite}%")
                    ->where([
                        ['data_therapies.active', true],
                        ['data_therapies.branch_id', $user->branch_id]
                    ])
                    ->orWhere('data_therapies.name', 'like', "%{$request->keywordDataOutsite}%")
                    ->where([
                        ['data_therapies.active', true],
                        ['data_therapies.branch_id', $user->branch_id]
                    ])
                    ->orWhere('data_therapies.address', 'like', "%{$request->keywordDataOutsite}%")
                    ->where([
                        ['data_therapies.active', true],
                        ['data_therapies.branch_id', $user->branch_id]
                    ])
                    ->orWhere('data_therapies.phone', 'like', "%{$this->Encr($request->keywordDataOutsite)}%")
                    ->where([
                        ['data_therapies.active', true],
                        ['data_therapies.branch_id', $user->branch_id]
                    ])
                    ->orWhere('data_therapies.province', 'like', "%{$request->keywordDataOutsite}%")
                    ->where([
                        ['data_therapies.active', true],
                        ['data_therapies.branch_id', $user->branch_id]
                    ])
                    ->orWhere('data_therapies.district', 'like', "%{$request->keywordDataOutsite}%")
                    ->where([
                        ['data_therapies.active', true],
                        ['data_therapies.branch_id', $user->branch_id]
                    ])
                    ->orWhere('data_therapies.registration_date', 'like', "%{$request->keywordDataOutsite}%")
                    ->where([
                        ['data_therapies.active', true],
                        ['data_therapies.branch_id', $user->branch_id]
                    ])
                    //------------------------------------------------------------------------------------------
                    ->orWhere('branches.name', 'like', "%{$request->keywordDataTherapy}%")
                    ->where([
                        ['data_therapies.active', true],
                        ['branches.country', $user->branch_id]
                    ])
                    ->orWhere('csos.name', 'like', "%{$request->keywordDataTherapy}%")
                    ->where([
                        ['data_therapies.active', true],
                        ['branches.country', $user->branch_id]
                    ])                      
                    ->orWhere('type_custs.name', 'like', "%{$request->keywordDataTherapy}%")
                    ->where([
                        ['data_therapies.active', true],
                        ['branches.country', $user->branch_id]
                    ]);
            })
            ->where([
                ['data_therapies.active', true],
                ['data_therapies.branch_id', $user->branch_id]
            ])
            ->join('branches', 'data_therapies.branch_id', '=', 'branches.id')
            ->join('csos', 'data_therapies.cso_id', '=', 'csos.id')
            ->join('type_custs', 'data_therapies.type_cust_id', '=', 'type_custs.id')
            ->orderBy('data_therapies.id', 'desc')
            ->select('data_therapies.*')
            ->paginate(10);

            $data_therapies->appends($request->only('keywordDataOutsite'));
        }

        return $data_therapies;
    }

    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
    /*++++++++++++++++++++++++++++++++++++++++++++++++++++++++    BUAT STORE DATA BARU    +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

    /*Function store untuk menambah data pada table DATA UNDANGAN
    * menggunakan parameter request langsung
    * jadi gk pake request dia jenis nya apa tapi langsung di panggil di route nya
    * user_id bisa di dapet dari Auth->usernya yg lagi online sekarang atau login
    * pertama kali masukin di buat langsung sama masuk ke history-nya
    */

    /*Function enkripsi & dekripsi nomor telpon*/
    function Encr(string $x)
    {
        $pj = strlen($x);
        $hasil = '';
        for($i=0; $i<$pj; $i++)
        {
            $ac = ord(substr($x, $i, 1));
            $hs = $ac*2-4;
            if($hs > 255)
            {
                $hs = $hs-255;
            }
            $hasil .= chr($hs);
        }
        return $hasil;
    }

    public static function Decr(string $x)
    {
        $pj = mb_strlen($x);
        //return $pj;
        $hasil = '';
        //return mb_chr('8223');
        //return ord('†'); //#226
        // return mb_ord('†'); //#8224
        // return mb_chr(134); //
        for($i=0; $i<$pj; $i++)
        {
            $ac = ord(substr($x, $i, 1))+4;
            //return $ac. "-";
            if($ac % 2 == 1)
            {
                $ac+=255;
            }
            $hs = $ac/2;
            //return $hs . "-";
            $hasil .= chr($hs);
        }
        return $hasil;
    }

    public static function DecryptName(string $x)
    {
        $char = array('~', '€', '‚', '„', '†', 'ˆ', 'Š', 'Œ', 'Ž', '', '’', '”', '–', '˜', 'š', 'œ', 'ž', ' ', '¢', '¤', '¦', '¨', 'ª', '¬', '®', '°', '<');
        $huruf = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', ' ');

        $hasil = '';
        $pj = mb_strlen($x);
        for($i=0; $i<$pj; $i++)
        {
            // $idx=0;
            // while (mb_substr($x, $i, 1)!=$char[$idx]) {
            //     $idx++;
            //     if($idx==27)
            //     {
            //         break;
            //     }
            // }
            //return array_keys($char, $x[$i])[0];
            $index = array_keys($char, mb_substr($x, $i, 1))[0];
            $hasil .= $huruf[$index];
        }
        $hasil = rtrim(preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $hasil));
        return $hasil;
    }

    public function storeDataUndangan(Request $request)
    {
        if ($request->has('phone') && $request->phone != null)
            $request->merge(['phone'=> ($this->Encr($request->phone))]);

        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'registration_date' => 'required',
            'phone' => [
                'required',
                Rule::unique('data_undangans')->where('active', 1),
            ],
            'province' => 'required',
            'district' => 'required',
            'branch' => 'required',
            'country' => 'required',
            'birth_date' => 'required',
            'cso' => 'required',
            'type_cust' => 'required',
        ]);

        if($request->type_cust == 13){
            $validator = \Validator::make($request->all(), [
                'name' => 'required',
                'address' => 'required',
                'registration_date' => 'required',
                'phone' => [
                    'required',
                    Rule::unique('data_undangans')->where('active', 1),
                ],
                'bank_name' => 'required',
                'province' => 'required',
                'district' => 'required',
                'branch' => 'required',
                'country' => 'required',
                'birth_date' => 'required',
                'cso' => 'required',
                'type_cust' => 'required',
            ]);
        }

        if ($validator->fails())
        {
            $arr_Errors = $validator->errors()->all();
            $arr_Keys = $validator->errors()->keys();
            $arr_Hasil = [];
            for ($i=0; $i < count($arr_Keys); $i++) { 
                $arr_Hasil[$arr_Keys[$i]] = $arr_Errors[$i];
            }
            return response()->json(['errors'=>$arr_Hasil]);
        }
        else {
            $user = Auth::user();
            $count = DataUndangan::all()->count();
            $count++;

            $data = $request->only('code', 'registration_date', 'name', 'birth_date', 'address', 'phone', 'province', 'district');
            $data['name'] = strtoupper($data['name']);
            $data['address'] = strtoupper($data['address']);

            //Khusus untuk Bank Input
            if($request->bank_name != null || $request->bank_name != ""){
                if(Bank::where([['name', $request->bank_name],['active', true]])->count() == 0){
                    $tempBank['name'] = strtoupper($request->bank_name);
                    $bankObj = Bank::create($tempBank);
                    $data['bank_id'] = $bankObj->id;
                }
                else {
                    $bankObj = Bank::where([['name', $request->bank_name],['active', true]])->get();
                    $bankObj = $bankObj[0];
                    $data['bank_id'] = $bankObj->id;
                }
            }

            //pembentukan kode data undangan
            $name = strtoupper(substr(str_slug($request->get('name'), ""), 0, 3));
            for($i=strlen($count); $i<4; $i++)
            {
                $count = "0".$count;
            }
            $codeDepan = "INV";
            $code = $codeDepan . $name . $count;
            $data['code'] = $code;

            //masukin data ke data_undangan duluan
            $idDataUndangan = DataUndangan::create($data);

            //ngemasukin data ke array $data
            $data['branch_id'] = $request->get('branch');
            $data['cso_id'] = $request->get('cso');
            $data['type_cust_id'] = $request->get('type_cust');
            $data['data_undangan_id'] = $idDataUndangan->id;
            $data['date'] = $data['registration_date'];

            HistoryUndangan::create($data);

            return response()->json(['success'=>'Berhasil !!']);
        }
    }

    /*Function store untuk menambah data pada table DATA OUTSITE
    * menggunakan parameter request langsung
    * jadi gk pake request dia jenis nya apa tapi langsung di panggil di route nya
    * user_id bisa di dapet dari Auth->usernya yg lagi online sekarang atau login
    */
    public function storeDataOutsite(Request $request)
    {
        if ($request->has('phone') && $request->phone != null)
            $request->merge(['phone'=> ($this->Encr($request->phone))]);

        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'registration_date' => 'required',
            'phone' => [
                'required',
                Rule::unique('data_outsites')->where('active', 1),
            ],
            'province' => 'required',
            'district' => 'required',
            'branch' => 'required',
            'country' => 'required',
            'cso' => 'required',
            'type_cust' => 'required',
        ]);

        if($request->type_cust == 3 || $request->type_cust == 5){ //DEMO OR MGM
            $validator = \Validator::make($request->all(), [
                'name' => 'required',
                'registration_date' => 'required',
                'phone' => [
                    'required',
                    Rule::unique('data_outsites')->where('active', 1),
                ],
                'branch' => 'required',
                'country' => 'required',
                'cso' => 'required',
                'type_cust' => 'required',
            ]);
        }

        if($request->type_cust == 2 || $request->type_cust == 4 ){ //MS RUMAH & CFD
            $validator = \Validator::make($request->all(), [
                'name' => 'required',
                'location_name' => 'required',
                'registration_date' => 'required',
                'phone' => [
                    'required',
                    Rule::unique('data_outsites')->where('active', 1),
                ],
                'province' => 'required',
                'district' => 'required',
                'branch' => 'required',
                'country' => 'required',
                'cso' => 'required',
                'type_cust' => 'required',
            ]);
        }

        if ($validator->fails())
        {
            $arr_Errors = $validator->errors()->all();
            $arr_Keys = $validator->errors()->keys();
            $arr_Hasil = [];
            for ($i=0; $i < count($arr_Keys); $i++) { 
                $arr_Hasil[$arr_Keys[$i]] = $arr_Errors[$i];
            }
            return response()->json(['errors'=>$arr_Hasil]);
        }
        else {
            $user = Auth::user();
            $count = DataOutsite::all()->count();
            $count++;

            $data = $request->only('code', 'registration_date', 'name', 'location_name', 'phone');
            $data['name'] = strtoupper($data['name']);

            if($request->get('province') != null && $request->get('province') != "")
            {
                $data['province'] = $request->get('province');
            }
            if($request->get('district') != null && $request->get('district') != "")
            {
                $data['district'] = $request->get('district');
            }

            //Khusus untuk Location Input
            if($request->location_name != null || $request->location_name != ""){
                if(Location::where([['name', $request->location_name],['active', true]])->count() == 0){
                    $tempLocation['name'] = strtoupper($request->location_name);
                    $countryTemp = Branch::where([['id', $request->branch], ['active', true]])->get();
                    $tempLocation['country'] = $countryTemp[0]['country'];
                    $locationObj = Location::create($tempLocation);
                    $data['location_id'] = $locationObj->id;
                }
                else {
                    $countryTemp = Branch::where([['id', $request->branch], ['active', true]])->get();
                    $locationObj = location::where([['name', $request->location_name], ['country', $countryTemp[0]['country']], ['active', true]])->get();
                    $locationObj = $locationObj[0];
                    $data['location_id'] = $locationObj->id;
                }
            }

            //pembentukan kode data outsite
            $name = strtoupper(substr(str_slug($request->get('name'), ""), 0, 3));
            for($i=strlen($count); $i<4; $i++)
            {
                $count = "0".$count;
            }
            $codeDepan = "OUT";
            $code = $codeDepan . $name . $count;
            $data['code'] = $code;

            //ngemasukin data ke array $data
            $data['branch_id'] = $request->get('branch');
            $data['cso_id'] = $request->get('cso');
            $data['type_cust_id'] = $request->get('type_cust');

            //masukin data ke data_outsite
            DataOutsite::create($data);

            return response()->json(['success'=>'Berhasil !!']);
        }
    }

    /*Function store untuk menambah data pada table DATA THERAPY
    * menggunakan parameter request langsung
    * jadi gk pake request dia jenis nya apa tapi langsung di panggil di route nya
    * user_id bisa di dapet dari Auth->usernya yg lagi online sekarang atau login
    */
    public function storeDataTherapy(Request $request)
    {
        if ($request->has('phone') && $request->phone != null)
            $request->merge(['phone'=> ($this->Encr($request->phone))]);

        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'registration_date' => 'required',
            'phone' => [
                'required',
                Rule::unique('data_therapies')->where('active', 1),
            ],
            'province' => 'required',
            'district' => 'required',
            'branch' => 'required',
            'country' => 'required',
            'cso' => 'required',
            'type_cust' => 'required',
        ]);

        if ($validator->fails())
        {
            $arr_Errors = $validator->errors()->all();
            $arr_Keys = $validator->errors()->keys();
            $arr_Hasil = [];
            for ($i=0; $i < count($arr_Keys); $i++) { 
                $arr_Hasil[$arr_Keys[$i]] = $arr_Errors[$i];
            }
            return response()->json(['errors'=>$arr_Hasil]);
        }
        else {
            $user = Auth::user();
            $count = DataTherapy::all()->count();
            $count++;

            $data = $request->only('code', 'registration_date', 'name', 'address', 'phone', 'province', 'district');
            $data['name'] = strtoupper($data['name']);

            //pembentukan kode data therapy
            $name = strtoupper(substr(str_slug($request->get('name'), ""), 0, 3));
            for($i=strlen($count); $i<4; $i++)
            {
                $count = "0".$count;
            }
            $codeDepan = "THP";
            $code = $codeDepan . $name . $count;
            $data['code'] = $code;

            //ngemasukin data ke array $data
            $data['branch_id'] = $request->get('branch');
            $data['cso_id'] = $request->get('cso');
            $data['type_cust_id'] = $request->get('type_cust');

            //masukin data ke data_therapy
            DataTherapy::create($data);

            return response()->json(['success'=>'Berhasil !!']);
        }
    }

    /*Function store untuk menambah data pada table MPC
    * menggunakan parameter request langsung
    * jadi gk pake request dia jenis nya apa tapi langsung di panggil di route nya
    * user_id bisa di dapet dari Auth->usernya yg lagi online sekarang atau login
    */
    public function storeMpc(Request $request)
    {
        if ($request->has('phone') && $request->phone != null)
            $request->merge(['phone'=> ($this->Encr($request->phone))]);

        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'ktp' => 'required',
            'code' => [
                'required',
                Rule::unique('mpcs')->where('active', 1),
            ],
            'address' => 'required',
            'gender' => 'required',
            'registration_date' => 'required',
            'birth_date' => 'required',
            'phone' => [
                'required',
                Rule::unique('mpcs')->where('active', 1),
            ],
            'province' => 'required',
            'district' => 'required',
            'branch' => 'required',
            'country' => 'required',
            'cso' => 'required',
        ]);

        if ($validator->fails())
        {
            $arr_Errors = $validator->errors()->all();
            $arr_Keys = $validator->errors()->keys();
            $arr_Hasil = [];
            for ($i=0; $i < count($arr_Keys); $i++) { 
                $arr_Hasil[$arr_Keys[$i]] = $arr_Errors[$i];
            }
            return response()->json(['errors'=>$arr_Hasil]);
        }
        else {
            $user = Auth::user();

            $data = $request->only('code', 'ktp', 'birth_date', 'registration_date', 'name', 'gender', 'address', 'phone', 'province', 'district');
            $data['name'] = strtoupper($data['name']);
            $data['code'] = strtoupper($data['code']);

            //ngemasukin data ke array $data
            $data['branch_id'] = $request->get('branch');
            $data['cso_id'] = $request->get('cso');
            $data['user_id'] = $user->id;

            //masukin data ke Mpc
            Mpc::create($data);

            return response()->json(['success'=>'Berhasil !!']);
        }
    }

    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
    /*++++++++++++++++++++++++++++++++++++++++++++++++++++++++    BUAT EDIT/UPDATE DATA    ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

    /*Function update untuk merubah data pada table DATA UNDANGAN
    * menggunakan parameter request langsung
    * jadi gk pake request dia jenis nya apa tapi langsung di panggil di route nya
    * user_id bisa di dapet dari Auth->usernya yg lagi online sekarang atau login
    * pertama kali masukin di buat langsung sama masuk ke history-nya
    */
    public function updateDataUndangan(Request $request)
    {
        if ($request->has('phone') && $request->phone != null)
            $request->merge(['phone'=> ($this->Encr($request->phone))]);

        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'phone' => [
                'required',
                Rule::unique('data_undangans')->whereNot('id', $request->get('id'))->where('active', 1),
            ],
            'birth_date' => 'required',
        ]);

        if ($validator->fails())
        {
            $arr_Errors = $validator->errors()->all();
            $arr_Keys = $validator->errors()->keys();
            $arr_Hasil = [];
            for ($i=0; $i < count($arr_Keys); $i++) { 
                $arr_Hasil[$arr_Keys[$i]] = $arr_Errors[$i];
            }
            return response()->json(['errors'=>$arr_Hasil]);
        }
        else {
            $data = $request->only('name', 'birth_date', 'address', 'phone');
            $data['name'] = strtoupper($data['name']);
            $data['address'] = strtoupper($data['address']);

            //update data ke data_undangan
            $DataUndanganNya = DataUndangan::find($request->get('id'));
            $DataUndanganNya->fill($data)->save();

            return response()->json(['success'=>'Berhasil !!']);
        }
    }

    /*Function update untuk merubah data pada table HISTORY UNDANGAN
    * menggunakan parameter request langsung
    */
    public function updateHistoryUndangan(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'date' => 'required',
            'province' => 'required',
            'district' => 'required',
            'branch' => 'required',
            'country' => 'required',
            'cso' => 'required',
            'type_cust' => 'required',
        ]);

        if($request->type_cust == 13){
            $validator = \Validator::make($request->all(), [
                'date' => 'required',
                'bank_name' => 'required',
                'province' => 'required',
                'district' => 'required',
                'branch' => 'required',
                'country' => 'required',
                'cso' => 'required',
                'type_cust' => 'required',
            ]);
        }

        if ($validator->fails())
        {
            $arr_Errors = $validator->errors()->all();
            $arr_Keys = $validator->errors()->keys();
            $arr_Hasil = [];
            for ($i=0; $i < count($arr_Keys); $i++) { 
                $arr_Hasil[$arr_Keys[$i]] = $arr_Errors[$i];
            }
            return response()->json(['errors'=>$arr_Hasil]);
        }
        else {
            $data = $request->only('date', 'province', 'district');

            //Khusus untuk Bank Input
            if($request->bank_name != null || $request->bank_name != ""){
                if(Bank::where([['name', $request->bank_name],['active', true]])->count() == 0){
                    $tempBank['name'] = strtoupper($request->bank_name);
                    $bankObj = Bank::create($tempBank);
                    $data['bank_id'] = $bankObj->id;
                }
                else {
                    $bankObj = Bank::where([['name', $request->bank_name],['active', true]])->get();
                    $bankObj = $bankObj[0];
                    $data['bank_id'] = $bankObj->id;
                }
            }

            //ngemasukin data ke array $data
            $data['branch_id'] = $request->get('branch');
            $data['cso_id'] = $request->get('cso');
            $data['type_cust_id'] = $request->get('type_cust');
            $data['data_undangan_id'] = $request->idDataUndangan;

            //masukin data ke data_outsite
            $HistoryUndanganNya = HistoryUndangan::find($request->get('id'));
            $HistoryUndanganNya->fill($data)->save();

            return response()->json(['success'=>'Berhasil !!']);
        }
    }

    /*Function update untuk merubah data pada table DATA OUTSITE
    * menggunakan parameter request langsung
    * jadi gk pake request dia jenis nya apa tapi langsung di panggil di route nya
    */
    public function updateDataOutsite(Request $request)
    {
        if ($request->has('phone') && $request->phone != null)
            $request->merge(['phone'=> ($this->Encr($request->phone))]);

        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'registration_date' => 'required',
            'phone' => [
                'required',
                Rule::unique('data_outsites')->whereNot('id', $request->get('id'))->where('active', 1),
            ],
            'province' => 'required',
            'district' => 'required',
            'branch' => 'required',
            'country' => 'required',
            'cso' => 'required',
            'type_cust' => 'required',
        ]);

        if($request->type_cust == 2 || $request->type_cust == 4 ){
            $validator = \Validator::make($request->all(), [
                'name' => 'required',
                'location_name' => 'required',
                'registration_date' => 'required',
                'phone' => [
                    'required',
                    Rule::unique('data_outsites')->whereNot('id', $request->get('id'))->where('active', 1),
                ],
                'province' => 'required',
                'district' => 'required',
                'branch' => 'required',
                'country' => 'required',
                'cso' => 'required',
                'type_cust' => 'required',
            ]);
        }

        if ($validator->fails())
        {
            $arr_Errors = $validator->errors()->all();
            $arr_Keys = $validator->errors()->keys();
            $arr_Hasil = [];
            for ($i=0; $i < count($arr_Keys); $i++) { 
                $arr_Hasil[$arr_Keys[$i]] = $arr_Errors[$i];
            }
            return response()->json(['errors'=>$arr_Hasil]);
        }
        else {
            $data = $request->only('code', 'registration_date', 'name', 'location_name', 'phone', 'province', 'district');
            $data['name'] = strtoupper($data['name']);

            //Khusus untuk Location Input
            if($request->location_name != null || $request->location_name != ""){
                if(Location::where([['name', $request->location_name],['active', true]])->count() == 0){
                    $tempLocation['name'] = strtoupper($request->location_name);
                    $countryTemp = Branch::where([['id', $request->branch], ['active', true]])->get();
                    $tempLocation['country'] = $countryTemp[0]['country'];
                    $locationObj = Location::create($tempLocation);
                    $data['location_id'] = $locationObj->id;
                }
                else {
                    $countryTemp = Branch::where([['id', $request->branch], ['active', true]])->get();
                    $locationObj = location::where([['name', $request->location_name], ['country', $countryTemp[0]['country']], ['active', true]])->get();
                    $locationObj = $locationObj[0];
                    $data['location_id'] = $locationObj->id;
                }
            }
            else {
                $data['location_id'] = null;
            }

            //ngemasukin data ke array $data
            $data['branch_id'] = $request->get('branch');
            $data['cso_id'] = $request->get('cso');
            $data['type_cust_id'] = $request->get('type_cust');

            //masukin data ke data_outsite
            $DataOutsiteNya = DataOutsite::find($request->get('id'));
            $DataOutsiteNya->fill($data)->save();

            return response()->json(['success'=>'Berhasil !!']);
        }
    }

    /*Function update untuk merubah data pada table DATA THERAPY
    * menggunakan parameter request langsung
    * jadi gk pake request dia jenis nya apa tapi langsung di panggil di route nya
    */
    public function updateDataTherapy(Request $request)
    {
        if ($request->has('phone') && $request->phone != null)
            $request->merge(['phone'=> ($this->Encr($request->phone))]);

        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'registration_date' => 'required',
            'phone' => [
                'required',
                Rule::unique('data_therapies')->whereNot('id', $request->get('id'))->where('active', 1),
            ],
            'province' => 'required',
            'district' => 'required',
            'branch' => 'required',
            'country' => 'required',
            'cso' => 'required',
            'type_cust' => 'required',
        ]);

        if ($validator->fails())
        {
            $arr_Errors = $validator->errors()->all();
            $arr_Keys = $validator->errors()->keys();
            $arr_Hasil = [];
            for ($i=0; $i < count($arr_Keys); $i++) { 
                $arr_Hasil[$arr_Keys[$i]] = $arr_Errors[$i];
            }
            return response()->json(['errors'=>$arr_Hasil]);
        }
        else {
            $data = $request->only('registration_date', 'name', 'address', 'phone', 'province', 'district');
            $data['name'] = strtoupper($data['name']);
            $data['address'] = strtoupper($data['address']);

            //ngemasukin data ke array $data
            $data['branch_id'] = $request->get('branch');
            $data['cso_id'] = $request->get('cso');
            $data['type_cust_id'] = $request->get('type_cust');

            //masukin data ke data_therapy
            $DataTherapyNya = DataTherapy::find($request->get('id'));
            $DataTherapyNya->fill($data)->save();

            return response()->json(['success'=>'Berhasil !!']);
        }
    }

    /*Function update untuk merubah data pada table MPC
    * menggunakan parameter request langsung
    */
    public function updateMpc(Request $request)
    {
        if ($request->has('phone') && $request->phone != null)
            $request->merge(['phone'=> ($this->Encr($request->phone))]);

        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'ktp' => 'required',
            'code' => [
                'required',
                Rule::unique('mpcs')->whereNot('id', $request->get('id'))->where('active', 1),
            ],
            'address' => 'required',
            'gender' => 'required',
            'registration_date' => 'required',
            'birth_date' => 'required',
            'phone' => [
                'required',
                Rule::unique('mpcs')->whereNot('id', $request->get('id'))->where('active', 1),
            ],
            'province' => 'required',
            'district' => 'required',
            'branch' => 'required',
            'country' => 'required',
            'cso' => 'required',
        ]);

        if ($validator->fails())
        {
            $arr_Errors = $validator->errors()->all();
            $arr_Keys = $validator->errors()->keys();
            $arr_Hasil = [];
            for ($i=0; $i < count($arr_Keys); $i++) { 
                $arr_Hasil[$arr_Keys[$i]] = $arr_Errors[$i];
            }
            return response()->json(['errors'=>$arr_Hasil]);
        }
        else {
            $user = Auth::user();

            $data = $request->only('code', 'ktp', 'birth_date', 'registration_date', 'name', 'gender', 'address', 'phone', 'province', 'district');
            $data['name'] = strtoupper($data['name']);
            $data['code'] = strtoupper($data['code']);
            $data['address'] = strtoupper($data['address']);

            //ngemasukin data ke array $data
            $data['branch_id'] = $request->get('branch');
            $data['cso_id'] = $request->get('cso');
            $data['user_id'] = $user->id;

            //masukin data ke Mpc
            $MpcNya = Mpc::find($request->get('id'));
            $MpcNya->fill($data)->save();

            return response()->json(['success'=>'Berhasil !!']);
        }
    }

    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
    /*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++    BUAT FIND DATA    +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

    /*Function mencari data MPC
    * menggunakan parameter request langsung
    */
    public function findMpc(Request $request)
    {
        if ($request->has('phone') && $request->phone != null)
            $request->merge(['phone'=> ($this->Encr($request->phone))]);

        $MpcNya = Mpc::where([['phone', $request->phone],['active', true]])->first();
        if($MpcNya != null){
            return response()->json(['success'=>$MpcNya]);
        }
        else{
            return response()->json(['errors'=>'Data Tidak di Temukan !!']);
        }
    }

    /*Function mencari data DATA OUTSITE
    * menggunakan parameter request langsung
    */
    public function findDataOutsite(Request $request)
    {
        if ($request->has('phone') && $request->phone != null)
            $request->merge(['phone'=> ($this->Encr($request->phone))]);

        $DataOutsiteNya = DataOutsite::where([['phone', $request->phone],['active', true]])->first();
        if($DataOutsiteNya != null && $DataOutsiteNya != "")
        {
            $DataOutsiteNya['location'] = Location::find($DataOutsiteNya['location_id']);
            $DataOutsiteNya['type_cust'] = TypeCust::find($DataOutsiteNya['type_cust_id']);
            $DataOutsiteNya['phone'] = $this->Decr($DataOutsiteNya['phone']);
        }
        if($DataOutsiteNya != null){
            return response()->json(['success'=>$DataOutsiteNya]);
        }
        else{
            return response()->json(['errors'=>'Data Tidak di Temukan !!']);
        }
    }
    
    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
    /*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++    BUAT DELETE DATA    +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
    
    // public function delete(DataOutsite $data_outsite)
    // {
    //     $data_outsite->active = false;
    //     $data_outsite->save();
    //     return redirect()->route('data');
    // }
}