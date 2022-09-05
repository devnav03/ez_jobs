<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/admin/ez-jobs', [App\Http\Controllers\Auth\AuthController::class, 'getLogin'])->name('admin');

Route::post('/admin/login', [App\Http\Controllers\Auth\AuthController::class, 'postLogin']);
Route::get('/admin/logout', [App\Http\Controllers\Auth\AuthController::class, 'adminLogout'])->name('admin-logout');
Route::group(['middleware' => 'auth', 'after' => 'no-cache'], function () {

    Route::prefix('admin')->group(function () {

         // Route::get('dashboard', ['as' => 'dashboard', 'uses' => "App\Http\Controllers\DashboardController::class, 'index'"]);
         Route::get('dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');


            // Change Password Routes
            Route::any('myaccount', ['as' => 'setting.manage-account',
                'uses' => 'App\Http\Controllers\SettingController@myAccount']);
            // Change Password Routes

            // Login Logs route start
            Route::resource('login-logs','App\Http\Controllers\LoginLogController', [
                'names' => [
                    'index'     => 'login-logs.index',
                    'create'    => 'login-logs.create',
                ],
                'except' => ['show','destroy']
            ]);

            Route::any('login-logs/paginate/{page?}', ['as' => 'login-logs.paginate',
                'uses' => 'App\Http\Controllers\LoginLogController@login_logsPaginate']);
            Route::any('login-logs/action', ['as' => 'login-logs.action',
                'uses' => 'App\Http\Controllers\LoginLogController@login_logsAction']);
            // Login Logs route end

            // Category Master route start
            Route::resource('category', 'App\Http\Controllers\CategoryController', [
                'names' => [
                    'index'     => 'category.index',
                    'create'    => 'category.create',
                    'store'     => 'category.store',
                    'edit'      => 'category.edit',
                    'update'    => 'category.update',
                ],
                'except' => ['show','destroy']
            ]);

            Route::any('category/paginate/{page?}', ['as' => 'category.paginate',
                'uses' => 'App\Http\Controllers\CategoryController@categoryPaginate']);
            Route::any('category/action', ['as' => 'category.action',
                'uses' => 'App\Http\Controllers\CategoryController@categoryAction']);
            Route::any('category/toggle/{id?}', ['as' => 'category.toggle',
                'uses' => 'App\Http\Controllers\CategoryController@categoryToggle']);
            Route::any('category/drop/{id?}', ['as' => 'category.drop',
                'uses' => 'category@drop']);

            Route::any('category/upload-category', 'CustomerController@upload_category')->name('upload-category');
            Route::any('category/import', 'CustomerController@ImportCategory')->name('category.import');
            // Category Master route end


            // Designations Master route start
            Route::resource('designation', 'App\Http\Controllers\DesignationController', [
                'names' => [
                    'index'     => 'designation.index',
                    'create'    => 'designation.create',
                    'store'     => 'designation.store',
                    'edit'      => 'designation.edit',
                    'update'    => 'designation.update',
                ],
                'except' => ['show','destroy']
            ]);

            Route::any('designation/paginate/{page?}', ['as' => 'designation.paginate',
                'uses' => 'App\Http\Controllers\DesignationController@designationPaginate']);
            Route::any('designation/action', ['as' => 'designation.action',
                'uses' => 'App\Http\Controllers\DesignationController@designationAction']);
            Route::any('designation/toggle/{id?}', ['as' => 'designation.toggle',
                'uses' => 'App\Http\Controllers\DesignationController@designationToggle']);
            Route::any('designation/drop/{id?}', ['as' => 'designation.drop',
                'uses' => 'designation@drop']);
            // Designations


            // Plans Master route start
            Route::resource('plans', 'App\Http\Controllers\PlanController', [
                'names' => [
                    'index'     => 'plans.index',
                    'create'    => 'plans.create',
                    'store'     => 'plans.store',
                    'edit'      => 'plans.edit',
                    'update'    => 'plans.update',
                ],
                'except' => ['show','destroy']
            ]);

            Route::any('plans/paginate/{page?}', ['as' => 'plans.paginate',
                'uses' => 'App\Http\Controllers\PlanController@Paginate']);
            Route::any('plans/action', ['as' => 'plans.action',
                'uses' => 'App\Http\Controllers\PlanController@Action']);
            Route::any('plans/toggle/{id?}', ['as' => 'plans.toggle',
                'uses' => 'App\Http\Controllers\PlanController@Toggle']);
            Route::any('plans/drop/{id?}', ['as' => 'plans.drop',
                'uses' => 'plans@drop']);
            // Plans


            // job seekers route start
            Route::resource('job-seekers', 'App\Http\Controllers\CustomerController', [
                'names' => [
                    'index'     => 'job-seekers.index',
                    'create'    => 'job-seekers.create',
                    'store'     => 'job-seekers.store',
                    'edit'      => 'job-seekers.edit',
                    'update'    => 'job-seekers.update',
                ],
                'except' => ['show','destroy']
            ]);

            Route::any('job-seekers/paginate/{page?}', ['as' => 'customer.paginate',
                'uses' => 'App\Http\Controllers\CustomerController@customerPaginate']);
            Route::any('job-seekers/action', ['as' => 'customer.action',
                'uses' => 'App\Http\Controllers\CustomerController@customerAction']);
            Route::any('job-seekers/toggle/{id?}', ['as' => 'customer.toggle',
                'uses' => 'App\Http\Controllers\CustomerController@customerToggle']);
            Route::any('job-seekers/drop/{id?}', ['as' => 'customer.drop',
                'uses' => 'customer@drop']);
            // job seekers


            // Employer route start
            Route::resource('employer', 'App\Http\Controllers\EmployerController', [
                'names' => [
                    'index'     => 'employer.index',
                    'create'    => 'employer.create',
                    'store'     => 'employer.store',
                    'edit'      => 'employer.edit',
                    'update'    => 'employer.update',
                ],
                'except' => ['show','destroy']
            ]);

            Route::any('employer/paginate/{page?}', ['as' => 'employer.paginate',
                'uses' => 'App\Http\Controllers\EmployerController@Paginate']);
            Route::any('employer/action', ['as' => 'employer.action',
                'uses' => 'App\Http\Controllers\EmployerController@Action']);
            Route::any('employer/toggle/{id?}', ['as' => 'employer.toggle',
                'uses' => 'App\Http\Controllers\EmployerController@Toggle']);
            Route::any('employer/drop/{id?}', ['as' => 'employer.drop',
                'uses' => 'employer@drop']);
            // Employer

            // Education route start
            Route::resource('education', 'App\Http\Controllers\EducationController', [
                'names' => [
                    'index'     => 'education.index',
                    'create'    => 'education.create',
                    'store'     => 'education.store',
                    'edit'      => 'education.edit',
                    'update'    => 'education.update',
                ],
                'except' => ['show','destroy']
            ]);

            Route::any('education/paginate/{page?}', ['as' => 'education.paginate',
                'uses' => 'App\Http\Controllers\EducationController@Paginate']);
            Route::any('education/action', ['as' => 'education.action',
                'uses' => 'App\Http\Controllers\EducationController@Action']);
            Route::any('education/toggle/{id?}', ['as' => 'education.toggle',
                'uses' => 'App\Http\Controllers\EducationController@Toggle']);
            Route::any('education/drop/{id?}', ['as' => 'education.drop',
                'uses' => 'education@drop']);
            // Education

            // Jobs List route start
            Route::resource('jobs-list', 'App\Http\Controllers\JobsListController', [
                'names' => [
                    'index'     => 'jobs-list.index',
                    'create'    => 'jobs-list.create',
                    'store'     => 'jobs-list.store',
                    'edit'      => 'jobs-list.edit',
                    'update'    => 'jobs-list.update',
                ],
                'except' => ['show','destroy']
            ]);

            Route::any('jobs-list/paginate/{page?}', ['as' => 'jobs-list.paginate',
                'uses' => 'App\Http\Controllers\JobsListController@Paginate']);
            Route::any('jobs-list/action', ['as' => 'jobs-list.action',
                'uses' => 'App\Http\Controllers\JobsListController@Action']);
            Route::any('jobs-list/toggle/{id?}', ['as' => 'jobs-list.toggle',
                'uses' => 'App\Http\Controllers\JobsListController@Toggle']);
            Route::any('jobs-list/drop/{id?}', ['as' => 'jobs-list.drop',
                'uses' => 'jobs-list@drop']);
            // Jobs List

            // Transaction route start
            Route::resource('transaction', 'App\Http\Controllers\TransactionController', [
                'names' => [
                    'index'     => 'transaction.index',
                    // 'create'    => 'transaction.create',
                    // 'store'     => 'transaction.store',
                    // 'edit'      => 'transaction.edit',
                    // 'update'    => 'transaction.update',
                ],
                'except' => ['show','destroy']
            ]);

            Route::any('transaction/paginate/{page?}', ['as' => 'transaction.paginate',
                'uses' => 'App\Http\Controllers\TransactionController@Paginate']);
            Route::any('transaction/action', ['as' => 'transaction.action',
                'uses' => 'App\Http\Controllers\TransactionController@Action']);
            Route::any('transaction/toggle/{id?}', ['as' => 'transaction.toggle',
                'uses' => 'App\Http\Controllers\TransactionController@Toggle']);
            Route::any('transaction/drop/{id?}', ['as' => 'transaction.drop',
                'uses' => 'transaction@drop']);
            // Transaction List


            // Testimonials List route start
            Route::resource('testimonials', 'App\Http\Controllers\TestimonialController', [
                'names' => [
                    'index'     => 'testimonials.index',
                    'create'    => 'testimonials.create',
                    'store'     => 'testimonials.store',
                    'edit'      => 'testimonials.edit',
                    'update'    => 'testimonials.update',
                ],
                'except' => ['show','destroy']
            ]);

            Route::any('testimonials/paginate/{page?}', ['as' => 'testimonials.paginate',
                'uses' => 'App\Http\Controllers\TestimonialController@Paginate']);
            Route::any('testimonials/action', ['as' => 'testimonials.action',
                'uses' => 'App\Http\Controllers\TestimonialController@Action']);
            Route::any('testimonials/toggle/{id?}', ['as' => 'testimonials.toggle',
                'uses' => 'App\Http\Controllers\TestimonialController@Toggle']);
            Route::any('testimonials/drop/{id?}', ['as' => 'testimonials.drop',
                'uses' => 'testimonials@drop']);
            // Testimonials List

   });

});

Route::any('/', [App\Http\Controllers\Front\HomeController::class, 'index'])->name('home');
Route::any('login', [App\Http\Controllers\Front\HomeController::class, 'login'])->name('login');
Route::any('register', [App\Http\Controllers\Front\HomeController::class, 'register'])->name('register');
Route::any('save-register', [App\Http\Controllers\Front\HomeController::class, 'save_register'])->name('save-register');
Route::any('jobs', [App\Http\Controllers\Front\HomeController::class, 'jobs'])->name('jobs');
Route::any('job-filter', [App\Http\Controllers\Front\HomeController::class, 'jobs'])->name('jobs');
Route::any('job-filter', [App\Http\Controllers\Front\HomeController::class, 'job_filter'])->name('job-filter');
Route::any('candidate-filter', [App\Http\Controllers\Front\HomeController::class, 'candidate_filter'])->name('candidate-filter');


Route::any('companies', [App\Http\Controllers\Front\HomeController::class, 'companies'])->name('companies');

Route::any('/email-verify/{id}', [App\Http\Controllers\Front\HomeController::class, 'emailverify'])->name('emailverify');
Route::any('/approval-waiting/{id}', [App\Http\Controllers\Front\HomeController::class, 'approval_waiting'])->name('approval-waiting');
Route::any('log-in', [App\Http\Controllers\Front\HomeController::class, 'postLogin'])->name('log-in');

Route::get('getState', [App\Http\Controllers\CategoryController::class, 'getState'])->name('getState');
Route::get('getCity', [App\Http\Controllers\CategoryController::class, 'getCity'])->name('getCity');
Route::get('live_search', [App\Http\Controllers\Front\HomeController::class, 'action'])->name('live_search');

Route::any('/search-job/{search}/{country_id}', [App\Http\Controllers\Front\HomeController::class, 'search_job'])->name('search-job');

Route::group(['middleware' => 'user-auth', 'after' => 'no-cache'], function () {

Route::any('membership-plan', [App\Http\Controllers\Front\PlanController::class, 'membership_plan'])->name('membership-plan');

Route::any('buy', [App\Http\Controllers\Front\PlanController::class, 'buy'])->name('buy');

Route::get('payment-status', [App\Http\Controllers\Front\PlanController::class, 'show'])->name('payment_status');

Route::any('logout', [App\Http\Controllers\Front\HomeController::class, 'logout'])->name('logout');
Route::any('my-profile', [App\Http\Controllers\Front\HomeController::class, 'profileShow'])->name('my-profile');

Route::any('update-profile', [App\Http\Controllers\Front\HomeController::class, 'update_profile'])->name('update-profile');

Route::any('employer-profile-update', [App\Http\Controllers\Front\HomeController::class, 'employer_profile_update'])->name('employer-profile-update');

Route::any('job-post', [App\Http\Controllers\Front\JobController::class, 'index'])->name('job-post');
Route::any('post-a-new-job', [App\Http\Controllers\Front\JobController::class, 'new_job'])->name('post-a-new-job');
Route::any('create-job', [App\Http\Controllers\Front\JobController::class, 'create_job'])->name('create-job');
Route::any('update-job', [App\Http\Controllers\Front\JobController::class, 'update_job'])->name('update-job');

Route::any('billing-information', [App\Http\Controllers\Front\PlanController::class, 'billing_information'])->name('billing-information');
Route::any('edit-job/{id}', [App\Http\Controllers\Front\JobController::class, 'edit_job'])->name('edit-job');

Route::get('getQuantity', [App\Http\Controllers\Front\PlanController::class, 'getQuantity'])->name('getQuantity');

Route::get('saveJob', [App\Http\Controllers\Front\JobController::class, 'saveJob'])->name('saveJob');
Route::get('applyjob', [App\Http\Controllers\Front\JobController::class, 'applyjob'])->name('applyjob');
Route::any('candidates', [App\Http\Controllers\Front\HomeController::class, 'candidates'])->name('candidates');
Route::get('saveCandidate', [App\Http\Controllers\Front\JobController::class, 'saveCandidate'])->name('saveCandidate');



});


Route::get('getSubcategory', [App\Http\Controllers\Front\HomeController::class, 'getSubcategory'])->name('getSubcategory');

Route::get('reset', function (){
    Artisan::call('route:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');
});




