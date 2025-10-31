<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsUser;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\PromptController;
use App\Http\Controllers\User\SubscriptionController; 
use App\Http\Controllers\User\NotificationController; 
use App\Http\Controllers\Admin\AdminTemplateController;
use App\Http\Controllers\User\TemplateController; 
use App\Http\Controllers\User\ImagePromptController; 

Route::get('/', function () {
    return view('home.index');
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

Route::controller(SubscriptionController::class)->group(function(){
    Route::get('/pending/subscription','PendingSubscription')->name('pending.subscription'); 
    Route::put('/subscription/status/update/{subscription}','SubscriptionStatusUpdate')->name('subscription.status.update');
   Route::get('/approved/subscription','ApprovedSubscription')->name('approved.subscription');
    
});


Route::controller(AdminTemplateController::class)->group(function(){
    Route::get('/admin/templates/index','AdminTemplatesIndex')->name('admin.templates.index'); 
    Route::get('/admin/templates/show/{template}','AdminTemplatesShow')->name('admin.templates.show');
    Route::get('/admin/templates/edit/{template}','AdminTemplatesEdit')->name('admin.templates.edit');

    Route::put('/admin/templates/update/{template}','AdminTemplatesUpdate')->name('admin.templates.update');
    Route::delete('/admin/templates/delete/{template}','AdminTemplatesDelete')->name('admin.templates.delete');

    Route::post('/admin/templates/status/update/{template}','AdminTemplatesUpdateStatus')->name('admin.templates.status.update');
    Route::post('/admin/templates/featured/update/{template}','AdminTemplatesUpdateFeatured')->name('admin.templates.featured.update');
    
    Route::get('/admin/templates/create','AdminTemplatesCreate')->name('admin.templates.create');
    Route::post('/admin/templates/store','AdminTemplatesStore')->name('admin.templates.store');
    
});




});

//// End All Admin Protected Routes



Route::middleware('check.subscription')->group(function () {

    Route::get('/prompts/index/page', [PromptController::class, 'PromptIndexPage'])->name('prompts.page');
    Route::get('/prompts/create', [PromptController::class, 'PromptsCreate'])->name('prompts.create');
    Route::post('/prompts/store', [PromptController::class, 'PromptsStore'])->name('prompts.store');

    Route::get('/prompts/{prompt}', [PromptController::class, 'PromptsShow'])->name('prompts.show');
    
    Route::post('/prompts/{prompt}/copy', [PromptController::class, 'PromptsCopy'])->name('prompts.copy');
    Route::get('/prompts/{prompt}/export', [PromptController::class, 'PromptsExport'])->name('prompts.export');

    Route::get('/prompts/{prompt}/edit', [PromptController::class, 'PromptsEdit'])->name('prompts.edit');

    Route::put('/prompts/{prompt}', [PromptController::class, 'PromptsUpdate'])->name('prompts.update');
    Route::delete('/prompts/{prompt}', [PromptController::class, 'PromptsDelete'])->name('prompts.delete');
   


Route::controller(SubscriptionController::class)->group(function(){
    Route::get('/subscriptions/index','SubscriptionsIndex')->name('subscriptions.index');
    Route::get('/subscriptions/create','SubscriptionsCreate')->name('subscriptions.create');
    Route::post('/subscriptions/store','SubscriptionsStore')->name('subscriptions.store');
    
}); 


Route::controller(NotificationController::class)->group(function(){
    Route::post('/notifications/{id}/read','MarkAsRead')->name('notifications.mark-read'); 
    Route::delete('/notifications/{id}','NotificationsDelete')->name('notifications.delete');
    
}); 


Route::controller(TemplateController::class)->group(function(){
    Route::get('/template/prompts/index','TemplatePromptsIndex')->name('template.prompts.index'); 
    Route::get('/template/prompts/show/{template}','TemplatePromptsShow')->name('template.prompts.show'); 
    Route::get('/template/prompts/use/{template}','TemplatePromptsUse')->name('template.prompts.use');
    Route::post('/template/prompts/generate/{template}','TemplatePromptsGenerate')->name('template.prompts.generate'); 
    
}); 


Route::controller(TemplateController::class)->group(function(){
    Route::get('/template/my/variations','TemplateMyVariations')->name('template.my.variations'); 
    Route::get('/template/variation/details/{variation}','TemplateVariationsDetails')->name('template.variation.details');
    
    Route::post('/variation/favorite/{variation}','VariationsFavorite')->name('variation.favorite');
    Route::delete('/variation/delete/{variation}','VariationsDelete')->name('variation.delete');
    
}); 



 Route::controller(ImagePromptController::class)->group(function(){
    Route::get('/image/prompts/index','ImagePromptsIndex')->name('image.prompts.index');  
    Route::get('/image/prompts/create','ImagePromptsCreate')->name('image.prompts.create');
    Route::post('/image/prompts/store','ImagePromptsStore')->name('image.prompts.store');
    Route::get('/image/prompts/show/{imagePrompt}','ImagePromptsShow')->name('image.prompts.show');
    
}); 
 


});








Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
