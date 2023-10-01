<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('option_data', function (Blueprint $table) {
            $table->id();

            $table->enum('position', ['SLIDER', 'MIDDLE_CONTENT', 'FOOTER_CONTENT']);

            $table->text('image')->nullable();

            $table->string('middle_content_title')->nullable();
            $table->longText('middle_content')->nullable();

            $table->text('footer_content')->nullable();

            $table->tinyInteger('priority')->default(1);

            $table->softDeletes();
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
        Schema::dropIfExists('option_data');
    }
};
