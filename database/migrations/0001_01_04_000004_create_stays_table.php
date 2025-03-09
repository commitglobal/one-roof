<?php

declare(strict_types=1);

use App\Models\Beneficiary;
use App\Models\Request;
use App\Models\Shelter;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stays', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Beneficiary::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignIdFor(Shelter::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->date('start_date');
            $table->date('end_date');

            $table->tinyInteger('children_count')->nullable();
            $table->text('children_notes')->nullable();

            // TODO: Group
            $table->foreignIdFor(Request::class)
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }
};
