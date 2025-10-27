<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBuildingToUsersTable extends Migration
{
    public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('building')->nullable()->after('address');
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('building');
    });
}
}
