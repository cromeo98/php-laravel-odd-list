<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Cosa sto facendo? Nella tabella posts
        Schema::table('posts', function (Blueprint $table) {
            //aggiungo una colonna "category_id", che può avere valore nullo e che dovrà mettersi di fianco alla colonna 'id'
            $table->unsignedBigInteger('category_id')->nullable()->after('id');
            //category_id è una chiave esterna che fa riferimento alla colonna id della tabella categories e che nel momento in cui dovesse venire eliminata riporteà valore null
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign('category_id');
        });
    }
}
