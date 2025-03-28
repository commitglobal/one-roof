<?php

declare(strict_types=1);

use App\Models\Group;
use App\Models\Shelter;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->foreignIdFor(Shelter::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->timestamps();
        });

        Schema::table('stays', function (Blueprint $table) {
            $table->foreignIdFor(Group::class)
                ->nullable()
                ->constrained()
                ->nullOnDelete();
        });
    }
};
