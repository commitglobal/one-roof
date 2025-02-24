<?php

declare(strict_types=1);

use App\Models\Country;
use App\Models\Location;
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
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('legal_name');

            $table->foreignIdFor(Country::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignIdFor(Location::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->string('address');
            $table->string('type');
            $table->string('identifier')->nullable();

            $table->json('representative')->nullable();
            $table->json('contact')->nullable();

            $table->text('notes')->nullable();

            $table->string('status');
            $table->timestamps();
        });
    }
};
