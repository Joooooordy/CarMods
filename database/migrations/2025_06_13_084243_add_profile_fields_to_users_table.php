<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfileFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable()->after('name');
            $table->date('birthdate')->nullable()->after('avatar');
            $table->foreignId('address_id')->nullable()->after('birthdate')->constrained('addresses')->nullOnDelete();
            $table->string('bank_account')->nullable()->after('address_id');
            // voeg eventueel extra velden toe
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['avatar', 'birthdate', 'address', 'bank_account']);
        });
    }
}
