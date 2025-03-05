<?php

declare(strict_types=1);

use App\Models\Form;
use App\Models\Form\Field;
use App\Models\Form\Response;
use App\Models\Form\Section;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->string('type');
            $table->string('status');
            $table->json('description')->nullable();
            $table->timestamps();
        });

        Schema::create('form_sections', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Form::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->json('name');
            $table->json('description')->nullable();
            $table->tinyInteger('order')->unsigned();

            $table->timestamps();
        });

        Schema::create('form_fields', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Section::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->string('type');
            $table->json('label');
            $table->json('help')->nullable();
            $table->boolean('required')->default(false);
            $table->json('options')->nullable();
            $table->integer('min')->unsigned()->nullable();
            $table->integer('max')->unsigned()->nullable();
            $table->tinyInteger('order')->unsigned();

            $table->timestamps();
        });

        Schema::create('form_responses', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Form::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->nullableMorphs('model');

            $table->timestamps();
        });

        Schema::create('form_field_responses', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Response::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignIdFor(Field::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->json('value')->nullable();
        });

        Schema::create('model_has_forms', function (Blueprint $table) {
            $table->id();

            $table->morphs('model');

            $table->foreignIdFor(Form::class)
                ->constrained()
                ->cascadeOnDelete();
        });
    }
};
