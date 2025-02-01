<?php

use App\Models\Category;
use App\Models\User;
use App\Models\Wallet;
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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('amount')->default(0);
            $table->text('description')->nullable();
            $table->boolean('is_draft')->default(true);

            //When a wallet is deleted, delete all the transactions in it
            $table->foreignIdFor(Wallet::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();

            // When a category is deleted, set the transaction's category to null
            $table->foreignIdFor(Category::class)->nullable()->constrained()->nullOnDelete()->cascadeOnUpdate();

            // When a User is deleted, set the transaction's user to null
            $table->foreignIdFor(User::class)->nullable()->constrained()->nullOnDelete()->cascadeOnUpdate();

            $table->timestamp('transacted_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
