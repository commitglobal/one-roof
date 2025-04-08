<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shelter_attributes', function (Blueprint $table) {
            $table->boolean('is_listed')
                ->default(false)
                ->after('is_enabled');
        });
    }
};
