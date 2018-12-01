<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMpcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mpcs', function (Blueprint $table) {
            $table->increments('id');
            $table->date('registration_date');
            $table->string('code')->unique();//nomor form
            $table->string('member_no')->unique();
            $table->string('name');
            $table->string('idcard')->unique();
            $table->string('status');
            $table->string('gender');
            $table->date('birth_date');
            $table->string('address');
            $table->string('postcode');
            $table->string('city');
            $table->string('state');
            $table->string('house_phone')->nullable();
            $table->string('mobile_phone')->nullable();
            $table->string('contact_method')->nullable();
            $table->string('fb_name')->nullable();
            $table->string('email')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mpcs');
    }
}
