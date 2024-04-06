<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chirps', function (Blueprint $table) {
            $table->id();
            // deze regel van code zorgt ervoor dat voor elke rij in de huidige tabel, 
            // er een bijbehorende rij moet zijn in de users tabel. En als die bijbehorende rij in de users tabel wordt verwijderd,
            //  dan wordt ook de rij in de huidige tabel verwijderd
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chirps');
    }
};
