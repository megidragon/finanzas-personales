<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Initialization extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            /**
             * Tabla de usuarios principal orientado al contro de sesiones.
             */
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('email')->unique();
                $table->string('password');
                $table->boolean('is_admin')->default(false);
                $table->rememberToken();
                $table->timestamps();
                $table->softDeletes();
            });

            /**
             * Tabla de clientes donde va la info del cliente.
             */
            Schema::create('clients', function (Blueprint $table) {
                $table->id();
                $table->string('full_name')->nullable();
                $table->string('birth_at')->nullable();
                $table->string('profile_image')->nullable();
                $table->unsignedBigInteger('user_id');
                $table->timestamps();
                $table->softDeletes();
            });

            Schema::table('clients', function(Blueprint $table) {
                $table->foreign('user_id')->references('id')->on('users');
            });

            /**
             * Tabla de monedas.
             */
            Schema::create('currencies', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('symbol')->unique();
                $table->timestamps();
                $table->softDeletes();
            });

            /**
             * Tabla de categorias, ya sean personales o globales.
             */
            Schema::create('categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->unsignedBigInteger('client_id')->nullable();
                $table->enum('type', ['deposit', 'spending']);
                $table->timestamps();
                $table->softDeletes();
            });

            Schema::table('categories', function(Blueprint $table) {
                $table->foreign('client_id')->references('id')->on('clients');
            });

            /**
             * Tabla de movimientos.
             */
            Schema::create('movements', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->longText('description')->nullable();
                $table->float('amount');
                $table->unsignedBigInteger('category_id');
                $table->unsignedBigInteger('client_id');
                $table->unsignedBigInteger('currency_id');
                $table->timestamps();
            });

            Schema::table('movements', function(Blueprint $table) {
                $table->foreign('client_id')->references('id')->on('clients');
                $table->foreign('category_id')->references('id')->on('categories');
                $table->foreign('currency_id')->references('id')->on('currencies');
            });
            
        }catch(PDOException $ex){
            $this->down();
            throw $ex;
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('users');
        Schema::dropIfExists('clients');
        Schema::dropIfExists('currencies');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('movements');
        Schema::enableForeignKeyConstraints();
    }
}
