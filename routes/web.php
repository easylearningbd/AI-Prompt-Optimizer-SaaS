<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsUser;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\PromptController;

Route::get('/', function () {
    return view('welcome');
});

//// All User Protected Routes

Route::middleware(['auth', IsUser::class])->group(function(){

 Route::get('/dashboard', function () {
    return view('client.index');
})->middleware(['auth', 'verified'])->name('dashboard');


 Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');
 Route::get('/user/profile', [UserController::class, 'UserProfile'])->name('user.profile');
 Route::post('/user/profile/store', [UserController::class, 'UserProfileStore'])->name('user.profile.store');
 
  Route::get('/user/change/password', [UserController::class, 'UserChangePassword'])->name('user.change.password');

  Route::post('/user/password/update', [UserController::class, 'UserPasswordUpdate'])->name('user.password.update'); 

});


//// End All User Protected Routes



//// All Admin Protected Routes

Route::middleware(['auth', IsAdmin::class])->group(function(){

  Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
  Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
  Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
  Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');

  Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');

  Route::post('/admin/password/update', [AdminController::class, 'AdminPasswordUpdate'])->name('admin.password.update');



Route::controller(CategoryController::class)->group(function(){
    Route::get('/all/category','AllCategory')->name('all.category');
    Route::get('/add/category','AddCategory')->name('add.category');
    Route::post('/store/category','StoreCategory')->name('store.category');
    Route::get('/edit/category/{id}','EditCategory')->name('edit.category');
    Route::post('/update/category/{id}','UpdateCategory')->name('update.category');
    Route::get('/delete/category/{id}','DeleteCategory')->name('delete.category');
});






});

//// End All Admin Protected Routes



Route::middleware('check.subscription')->group(function () {
    Route::get('/prompts/index/page', [PromptController::class, 'PromptIndexPage'])->name('prompts.page');
   
});








Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
