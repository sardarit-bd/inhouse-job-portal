<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\SiteSetting;

return new class extends Migration
{
    public function up()
    {
        // Insert favicon setting
        SiteSetting::firstOrCreate([
            'key' => 'favicon'
        ], [
            'value' => null,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    public function down()
    {
        SiteSetting::where('key', 'favicon')->delete();
    }
};