<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\HealthCheckResultsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LandCreateController;
use App\Http\Controllers\SuperAdmin;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

$land_path = '/land';
$admin_path = '/admin';

Route::get('/test', function () {
    return 'test';
})->name('test-url');
Route::get('/', [HomeController::class, 'index'])->name('index');
Route::post('/logout', [HomeController::class, 'logout'])->name('logout');
Route::get('/login', [HomeController::class, 'login'])->name('login');

// for login route checkout fortifyserviceprovider class boot method

Route::middleware('auth')->group(function () {
    Route::get('/my-profile', [UserController::class, 'myProfile'])->name('my_profile');
    Route::patch('/my-profile', [UserController::class, 'myProfilePatch'])->name('my_profile_ptch');
    Route::get('/settings', [UserController::class, 'setting'])->name('setting');
    Route::patch('/sub-admins', [SuperAdmin::class, 'UpdatesubAdmin'])->name('updt_create_admin');
});

Route::prefix($land_path)->group(function () {
    $land_create_route = '/create';
    $land_update_route = '/{land}';
    $land_blk_update = 'blk_update';
    Route::middleware('auth')->get('/', [LandCreateController::class, 'land'])->name('land_index');
    Route::get($land_create_route, [LandCreateController::class, 'landCreate'])->name('land_create');
    Route::post($land_create_route, [LandCreateController::class, 'landSave'])->name('land_save');
    Route::middleware('auth')->get($land_update_route, [LandCreateController::class, 'landUpdateShow'])->name('land_updateshow');
    Route::patch($land_blk_update, [LandCreateController::class, 'landUpdateBulk'])->name('land_update_blk');
    Route::patch($land_update_route, [LandCreateController::class, 'landUpdate'])->name('land_update');
    Route::delete($land_update_route, [LandCreateController::class, 'landDelete'])->name('land_delete');
});
Route::prefix($admin_path)->group(function () {
    Route::get('/login', [Admin::class, 'login'])->name('admin_login');
    Route::post('/logout', [Admin::class, 'logout'])->name('admin_logout');
    Route::post('/login', [Admin::class, 'adminLogin'])->name('admin_login_post');
});
Route::prefix($admin_path)->middleware(config('middlewares.admin'))->group(function () {
    Route::get('/chart', [Admin::class, 'chart'])->name('admin_chart');
    Route::get('/lands', [Admin::class, 'lands'])->name('admin_lands');
    Route::get('/show-users', [UserController::class, 'showUsers'])->name('show_users');

});

Route::prefix($admin_path)->middleware(config('middlewares.super_admin'))->group(function () {
    Route::get('/health', HealthCheckResultsController::class)->name('health');
    Route::get('/optimize-logs', [Admin::class, 'optimize'])->name('optimize');
    Route::get('/clear-storage-logs', [Admin::class, 'clearLogs'])->name('clear_logs');
    Route::get('/clear-files', [Admin::class, 'clearFiles'])->name('clear_files');
    Route::get('/clear-cache', [Admin::class, 'clearCache'])->name('clear_cache');
    Route::get('/admin-operations', [Admin::class, 'adminOp'])->name('admin_op');
    Route::get('/sub-admins', [SuperAdmin::class, 'subAdmin'])->name('create_admin');
    Route::delete('/sub-admins', [SuperAdmin::class, 'DelsubAdmin'])->name('del_create_admin');
    Route::post('/sub-admins', [SuperAdmin::class, 'CreatesubAdmin'])->name('crte_admin');
    Route::get('/land-logs', [SuperAdmin::class, 'landLogs'])->name('land_logs');
    Route::get('/comment-logs', [SuperAdmin::class, 'commentLogs'])->name('comment_logs');
    Route::get('/documentation', [SuperAdmin::class, 'documentation'])->name('documentation');

});
