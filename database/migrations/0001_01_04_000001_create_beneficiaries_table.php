<?php

declare(strict_types=1);

use App\Models\Country;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('beneficiaries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('date_of_birth');
            $table->string('gender');

            $table->foreignIdFor(Country::class, 'nationality_id')
                ->constrained()
                ->cascadeOnDelete();

            // TODO: ethnicity

            $table->string('id_type')->nullable();
            $table->string('id_number')->nullable();

            $table->foreignIdFor(Country::class, 'residence_country_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('phone')->nullable();
            $table->string('email')->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }
};
