<?php

declare(strict_types=1);

use App\Models\Language;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->string('code')->primary();
            $table->boolean('enabled')->default(false);
        });

        Language::create(['code' => 'en', 'enabled' => true]);
    }
};
