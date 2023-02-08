<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $all_data = \App\Models\Data::all();
        $regexp = '/(http|https)\:\/\/((www)|(maps\.app))?(\.)?((goo\.gl)|(google\.[a-z]{2,3}))\/[^\s]+/i';
        foreach ($all_data as $data) {
            $match = preg_match($regexp, $data->address, $matches);
            if (!$match) continue;
            $data->update([
               'maps_link' => $matches[0]
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
