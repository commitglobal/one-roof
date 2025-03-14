<?php

declare(strict_types=1);

use App\Models\Shelter;
use App\Models\ShelterAttribute;
use App\Models\ShelterVariable;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shelter_attributes', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->string('type');
            $table->boolean('is_enabled')->default(true);
            $table->timestamps();
        });

        Schema::create('shelter_variables', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(ShelterAttribute::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->json('name');

            $table->boolean('is_enabled')->default(true);

            $table->tinyInteger('order')->unsigned();

            $table->timestamps();
        });

        Schema::create('shelter_shelter_variable', function (Blueprint $table) {
            $table->foreignIdFor(Shelter::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignIdFor(ShelterVariable::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->primary(['shelter_id', 'shelter_variable_id']);
        });
    }
};
