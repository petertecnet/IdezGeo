<?php

use App\Http\Controllers\MunicipalitiesController;

Route::get('/municipalities/{uf}', [MunicipalitiesController::class, 'index']);
