<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            //$table->id('goup_id');
            $table->string('OurBranchID');
            $table->string('GroupID');
            $table->string('GroupName');
            $table->string('GroupProductID');
            $table->string('DefaultLoanSchemeID');
            $table->string('FormationDate');
            $table->string('OpenDate');
            $table->string('GroupClassID')->nullable();
            $table->string('Officer1');
            $table->string('GroupFormedBy');
            $table->string('CityID')->nullable();
            $table->string('CenterID')->nullable();
            $table->string('VillageID')->nullable();
            $table->string('MeetingFrequencyID');
            $table->string('Day1')->nullable();
            $table->string('Day2')->nullable();
            $table->string('FirstMeetingDate')->nullable();
            $table->string('MeetingDayID')->nullable();
            $table->string('MeetingPlace')->nullable();
            $table->string('MeetingTime')->nullable();
            $table->string('NextMeetingDate')->nullable();
            $table->string('RegistrationNo')->nullable();
            $table->string('LoanCycleNo')->nullable();
            $table->string('NGOID')->nullable();
            $table->string('GroupLead1')->nullable();
            $table->string('GroupLead2')->nullable();
            $table->string('GroupLead3')->nullable();
            $table->string('CreatedBy')->nullable();
            $table->string('CreatedOn')->nullable();
            $table->string('ModifiedBy')->nullable();
            $table->string('SupervisedBy')->nullable();
            $table->string('SupervisedOn')->nullable();
            $table->string('UpdateCount')->nullable();
            $table->string('GroupStatusID')->nullable();
            $table->string('GroupCollectionAccountID')->nullable();
            $table->string('LegacyBranchID')->nullable();
            $table->string('LegacyGroupID')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groups');
    }
}