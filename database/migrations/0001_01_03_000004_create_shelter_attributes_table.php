<?php

declare(strict_types=1);

use App\Models\Shelter;
use App\Models\Shelter\Attribute;
use App\Models\Shelter\Variable;
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

            $table->foreignIdFor(Attribute::class)
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

            $table->foreignIdFor(Variable::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->primary(['shelter_id', 'variable_id']);
        });
    }
};
