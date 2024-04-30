<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request){
    return $request->user();
});

Route::middleware(['api'])->prefix('v1')->group(function (){
    require_once 'v1/auth.php';
    require_once 'v1/widget.php';
    require_once 'v1/category.php';
    require_once 'v1/language.php';
    require_once 'v1/education.php';
    require_once 'v1/candidate.php';
    require_once 'v1/resume.php';
    require_once 'v1/post.php';
    require_once 'v1/apply_job.php';
    require_once 'v1/job.php';
    require_once 'v1/skill.php';
    require_once 'v1/company.php';
    require_once 'v1/user.php';
    require_once 'v1/contact.php';
    require_once 'v1/major.php';
    require_once 'v1/job_type.php';
    require_once 'v1/address.php';
    require_once 'v1/experience.php';
    require_once 'v1/post_comment.php';
    require_once 'v1/post_like.php';
//    require_once 'v1/saved_job.php';
});
