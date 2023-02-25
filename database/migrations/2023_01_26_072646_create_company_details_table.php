<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->string('company_location_state')->nullable();
            $table->string('company_location_title')->nullable();
            $table->string('company_location_event')->nullable();
            $table->string('company_group')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('company_website_url')->nullable();
            $table->string('company_destination_url')->nullable();
            $table->string('company_button_text')->nullable();
            $table->string('company_ftp_protocol')->nullable();
            $table->string('company_ftp_host')->nullable();
            $table->string('company_ftp_username')->nullable();
            $table->string('company_ftp_password')->nullable();
            $table->string('company_ftp_directory')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->index(['company_id']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_details');
    }
}
