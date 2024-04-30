<?php

use App\Http\Controllers\Api\V1\CompanyController;
use Illuminate\Support\Facades\Route;

Route::get('companies', [CompanyController::class, 'index']);
Route::get('companies/{company:slug}', [CompanyController::class, 'show']);
Route::get('companies/user/{id}', [CompanyController::class, 'showCompanyByUserId']);
Route::get('/company-with-jobs', [CompanyController::class, 'showCompanyWithJob']);
Route::get('/companies/{id}/jobs', [CompanyController::class, 'showJobs']);
Route::get('/companies/{id}/posts', [CompanyController::class, 'showPosts']);
