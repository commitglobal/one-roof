<?php

declare(strict_types=1);

use App\Models\Country;
use App\Models\Location;
use App\Models\Organization;
use App\Models\Shelter;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shelters', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->mediumInteger('capacity')->unsigned();

            $table->foreignIdFor(Organization::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignIdFor(Country::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignIdFor(Location::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->string('address');

            $table->json('coordinator')->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();
        });

        Schema::create('shelter_user', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Shelter::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignIdFor(User::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->string('role')->nullable();

            $table->timestamps();

            $table->unique(['shelter_id', 'user_id']);
        });

        // Schema::create('shelter_invitations', function (Blueprint $table) {
        //     $table->id();

        //     $table->foreignIdFor(Shelter::class)
        //         ->constrained()
        //         ->cascadeOnDelete();

        //     $table->string('email');

        //     $table->string('token');

        //     $table->timestamps();
        // });
    }
};
