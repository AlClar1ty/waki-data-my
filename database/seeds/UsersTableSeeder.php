<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
        	'code' => 'EMP-0001',
        	'name' => 'ADMIN',
        	'username' => 'ADMIN',
        	'password' => Hash::make('metro299admin'),
        	'branch_id' => '6', //darmo park
        	'permissions' => json_encode([
                //MPC
        		'add-mpc' => true,
                'browse-mpc' => true,
                'find-mpc' => true,
        		'edit-mpc' => true,
                'delete-mpc' => true,
                'all-branch-mpc' => true,
                'all-country-mpc' => false,
                //DATA_UNDANGAN
        		'add-data-undangan' => false,
                'browse-data-undangan' => false,
                'find-data-undangan' => false,
        		'edit-data-undangan' => false,
                'delete-data-undangan' => false,
                'all-branch-data-undangan' => false,
                'all-country-data-undangan' => false,
                //DATA_OUTSITE
        		'add-data-outsite' => false,
                'browse-data-outsite' => false,
                'find-data-outsite' => false,
        		'edit-data-outsite' => false,
                'delete-data-outsite' => false,
                'all-branch-data-outsite' => false,
                'all-country-data-outsite' => false,
                //DATA_THERAPY
        		'add-data-therapy' => false,
                'browse-data-therapy' => false,
                'find-data-therapy' => false,
        		'edit-data-therapy' => false,
                'delete-data-therapy' => false,
                'all-branch-data-therapy' => false,
                'all-country-data-therapy' => false,
                //TYPE_CUST
                'add-type-cust' => false,
                'browse-type-cust' => false,
        		'edit-type-cust' => false,
                'delete-type-cust' => false,
                //CSO
        		'add-cso' => false,
                'browse-cso' => false,
        		'edit-cso' => false,
                'delete-cso' => false,
                'all-branch-cso' => false,
                'all-country-cso' => false,
                //BRANCH
                'add-branch' => true,
                'browse-branch' => true,
                'edit-branch' => true,
                'delete-branch' => true,
                'all-country-branch' => true,
                //USER
                'add-user' => true,
                'browse-user' => true,
                'edit-user' => true,
                'delete-user' => true,
                'all-branch-user' => true,
                'all-country-user' => true,
        	]),
        ]);
        $admin->roles()->attach(1);

        $supervisor = User::create([
            'code' => 'EMP-0002',
            'name' => 'SUPERVISOR',
            'username' => 'SUPERVISOR',
            'password' => Hash::make('123123'),
            'branch_id' => '6', //darmo park
            'permissions' => json_encode([
                //MPC
                'add-mpc' => false,
                'browse-mpc' => true,
                'find-mpc' => true,
                'edit-mpc' => false,
                'delete-mpc' => false,
                'all-branch-mpc' => true,
                'all-country-mpc' => false,
                //DATA_UNDANGAN
                'add-data-undangan' => false,
                'browse-data-undangan' => true,
                'find-data-undangan' => true,
                'edit-data-undangan' => false,
                'delete-data-undangan' => false,
                'all-branch-data-undangan' => true,
                'all-country-data-undangan' => false,
                //DATA_OUTSITE
                'add-data-outsite' => false,
                'browse-data-outsite' => true,
                'find-data-outsite' => true,
                'edit-data-outsite' => false,
                'delete-data-outsite' => false,
                'all-branch-data-outsite' => true,
                'all-country-data-outsite' => false,
                //DATA_THERAPY
                'add-data-therapy' => false,
                'browse-data-therapy' => true,
                'find-data-therapy' => true,
                'edit-data-therapy' => false,
                'delete-data-therapy' => false,
                'all-branch-data-therapy' => true,
                'all-country-data-therapy' => false,
                //TYPE_CUST
                'add-type-cust' => false,
                'browse-type-cust' => false,
                'edit-type-cust' => false,
                'delete-type-cust' => false,
                //CSO
                'add-cso' => false,
                'browse-cso' => true,
                'edit-cso' => false,
                'delete-cso' => false,
                'all-branch-cso' => true,
                'all-country-cso' => false,
                //BRANCH
                'add-branch' => false,
                'browse-branch' => false,
                'edit-branch' => false,
                'delete-branch' => false,
                'all-country-branch' => false,
                //USER
                'add-user' => false,
                'browse-user' => false,
                'edit-user' => false,
                'delete-user' => false,
                'all-branch-user' => false,
                'all-country-user' => false,
            ]),
        ]);
        $supervisor->roles()->attach(2);

        $operator = User::create([
            'code' => 'EMP-0003',
            'name' => 'OPERATOR',
            'username' => 'OPERATOR',
            'password' => Hash::make('123123'),
            'branch_id' => '6', //darmo park
            'permissions' => json_encode([
                //MPC
                'add-mpc' => false,
                'browse-mpc' => false,
                'find-mpc' => true,
                'edit-mpc' => false,
                'delete-mpc' => false,
                'all-branch-mpc' => false,
                'all-country-mpc' => false,
                //DATA_UNDANGAN
                'add-data-undangan' => false,
                'browse-data-undangan' => false,
                'find-data-undangan' => true,
                'edit-data-undangan' => false,
                'delete-data-undangan' => false,
                'all-branch-data-undangan' => false,
                'all-country-data-undangan' => false,
                //DATA_OUTSITE
                'add-data-outsite' => false,
                'browse-data-outsite' => false,
                'find-data-outsite' => true,
                'edit-data-outsite' => false,
                'delete-data-outsite' => false,
                'all-branch-data-outsite' => false,
                'all-country-data-outsite' => false,
                //DATA_THERAPY
                'add-data-therapy' => false,
                'browse-data-therapy' => false,
                'find-data-therapy' => true,
                'edit-data-therapy' => false,
                'delete-data-therapy' => false,
                'all-branch-data-therapy' => false,
                'all-country-data-therapy' => false,
                //TYPE_CUST
                'add-type-cust' => false,
                'browse-type-cust' => false,
                'edit-type-cust' => false,
                'delete-type-cust' => false,
                //CSO
                'add-cso' => false,
                'browse-cso' => false,
                'edit-cso' => false,
                'delete-cso' => false,
                'all-branch-cso' => false,
                'all-country-cso' => false,
                //BRANCH
                'add-branch' => false,
                'browse-branch' => false,
                'edit-branch' => false,
                'delete-branch' => false,
                'all-country-branch' => false,
                //USER
                'add-user' => false,
                'browse-user' => false,
                'edit-user' => false,
                'delete-user' => false,
                'all-branch-user' => false,
                'all-country-user' => false,
            ]),
        ]);
        $operator->roles()->attach(3);
    }
}
