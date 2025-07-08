<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('message_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('subject')->nullable();
            $table->longText('content');
            $table->string('type')->default('email');
            $table->integer('data_id')->comment('1 = PI Email, 2 = Uphold Email, 3 = Remediation Email, 4 = First Email, 5 - Second Email, 6 = Automated Email Passed ');
            $table->boolean('is_active')->default(true);
            $table->string('uphold_type')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_templates');
    }
};
