<?php

declare(strict_types=1);

use App\Models\Country;
use App\Models\Location;
use App\Models\Organization;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
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
            $table->string('type')->nullable();
            $table->string('identifier')->nullable();

            $table->json('representative')->nullable();
            $table->json('contact');

            $table->text('notes')->nullable();

            $table->string('status');
            $table->timestamps();
        });

        Schema::create('model_has_organizations', function (Blueprint $table) {
            $table->id();

            $table->morphs('model');

            $table->foreignIdFor(Organization::class)
                ->constrained()
                ->cascadeOnDelete();
        });
    }
};
