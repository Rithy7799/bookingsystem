<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Use raw SQL for maximum compatibility
        try {
            // Try to drop the foreign key if it exists
            DB::statement('ALTER TABLE bookings DROP FOREIGN KEY IF EXISTS bookings_service_id_foreign');
        } catch (Exception $e) {
            // Continue if foreign key doesn't exist
        }

        try {
            // Try alternative foreign key name
            DB::statement('ALTER TABLE bookings DROP FOREIGN KEY IF EXISTS bookings_service_id_fk');
        } catch (Exception $e) {
            // Continue if foreign key doesn't exist
        }

        // Drop the column if it exists
        if (Schema::hasColumn('bookings', 'service_id')) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->dropColumn('service_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'service_id')) {
                $table->unsignedBigInteger('service_id')->nullable();
                $table->foreign('service_id')->references('id')->on('services')->cascadeOnDelete();
            }
        });
    }
};
