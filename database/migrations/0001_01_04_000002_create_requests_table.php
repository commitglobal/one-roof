<?php

declare(strict_types=1);

use App\Models\Country;
use App\Models\Shelter;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->string('status');

            $table->json('requester')->nullable();
            $table->json('beneficiary')->nullable();
            // $table->smallInteger('group_size')->unsigned();

            $table->smallInteger('group_size')->unsigned()
                ->virtualAs('JSON_LENGTH(`group`) + 1');

            $table->json('group');

            $table->foreignIdFor(Shelter::class)
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();

            // TODO: languages

            $table->foreignIdFor(Country::class, 'departure_country_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();

            // TODO: region

            $table->foreignIdFor(Country::class, 'nationality_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();

            $table->string('gender')->nullable();
            $table->tinyInteger('age')->unsigned()->nullable();

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->json('special_needs')->nullable();
            $table->text('special_needs_notes')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }
};
