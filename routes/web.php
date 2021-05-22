<?php

use App\Http\Controllers\ClassController;
use Illuminate\Support\Facades\Route;

Route::prefix("periods/5")->group(function(){

    Route::get("/students/{ra}", function(int $ra){
        return json_encode(["academyRegistry"=> $ra]);
    })->where(["ra" => "[0-9]+"]);

    Route::get("/subjects/{idsubjects}", function(int $idsubjects){
        return json_encode(["idsubjects"=> $idsubjects]);
    })->where(["idsubjects" => "[1]{1}[0-9]*"]);

    Route::get("/teachers/{cpf}", function(string $cpf){
        return view("teachers", ["cpf" => $cpf]);
    })->where(["cpf" => "[0-9]{11}"]);
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function(){
    Route::get("classes", [ClassController::class, 'index']);
    Route::get("classes/new", [ClassController::class, 'create']);
    Route::post("classes", [ClassController::class, 'store']);
    Route::get("classes/{id}/edit", [ClassController::class, 'edit']);
    Route::put("classes/{id}", [ClassController::class,'update']);
    Route::delete("classes/{class}", [ClassController::class,'destroy']);
});

