<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::name('user.')->group(function () {
    Route::get('/', User\MainController::class)->name('index');
    Route::get('/blogs', [User\BlogController::class, 'index'])->name('blogs.index');
    Route::get('/blogs/{blog:slug}', [User\BlogController::class, 'show'])->name('blogs.show');
    Route::get('/books', [User\BookController::class, 'index'])->name('books.index');
    Route::get('/books/{book:slug}', User\BookController::class)->name('books.show');
});

Route::prefix('/admin')->name('admin.')->group(function () {
    Route::group(['middleware' => ['auth']], function () {
        Route::get('/dashboard', Admin\DashboardController::class)->name('dashboard');

        Route::controller(Admin\HeroSectionController::class)->name('hero_sections.')->group(function () {
            Route::get('/hero-sections', 'index')->name('index');
            Route::put('/hero-sections', 'update')->name('update');
        });

        Route::controller(Admin\BlogController::class)->name('blogs.')->group(function () {
            Route::get('/blogs', 'index')->name('index');
            Route::get('/blogs/create', 'create')->name('create');
            Route::post('/blogs', 'store')->name('store');
            Route::post('/blogs/upload-image', 'uploadImageEditor')->name('upload_image');
            Route::get('/blogs/{blog}/edit', 'edit')->name('edit');
            Route::put('/blogs/{blog}', 'update')->name('update');
            Route::delete('/blogs/{blog}', 'destroy')->name('destroy');
        });

        Route::controller(Admin\BlogAdController::class)->name('blog_ads.')->group(function () {
            Route::get('/blog-ads', 'index')->name('index');
            Route::post('/blog-ads', 'store')->name('store');
            Route::put('/blog-ads/{blogAd}', 'update')->name('update');
            Route::delete('/blog-ads/{blogAd}', 'destroy')->name('destroy');
        });

        Route::controller(Admin\BookController::class)->name('books.')->group(function () {
            Route::get('/books', 'index')->name('index');
            Route::get('/books/create', 'create')->name('create');
            Route::post('/books', 'store')->name('store');
            Route::get('/books/{book}/edit', 'edit')->name('edit');
            Route::put('/books/{book}', 'update')->name('update');
            Route::delete('/books/{book}', 'destroy')->name('destroy');
        });

        Route::controller(Admin\TestimonialController::class)->name('testimonials.')->group(function () {
            Route::get('/testimonials', 'index')->name('index');
            Route::post('/testimonials', 'store')->name('store');
            Route::put('/testimonials/{testimonial}', 'update')->name('update');
            Route::delete('/testimonials/{testimonial}', 'destroy')->name('destroy');
        });

        Route::controller(Admin\AdvantageController::class)->name('advantages.')->group(function () {
            Route::get('/advantages', 'index')->name('index');
            Route::post('/advantages', 'store')->name('store');
            Route::put('/advantages/{advantage}', 'update')->name('update');
            Route::delete('/advantages/{advantage}', 'destroy')->name('destroy');
        });

        Route::controller(Admin\ProcessStepController::class)->name('process_steps.')->group(function () {
            Route::get('/process-steps', 'index')->name('index');
            Route::put('/process-steps', 'update')->name('update');
        });

        Route::controller(Admin\FaqController::class)->name('faqs.')->group(function () {
            Route::get('/faqs', 'index')->name('index');
            Route::get('/faqs/create', 'create')->name('create');
            Route::post('/faqs', 'store')->name('store');
            Route::get('/faqs/{faq}/edit', 'edit')->name('edit');
            Route::put('/faqs/{faq}', 'update')->name('update');
            Route::delete('/faqs/{faq}', 'destroy')->name('destroy');
        });

        Route::controller(Admin\ManuscriptCategoryController::class)->name('manuscript_categories.')->group(function () {
            Route::get('/manuscript-categories', 'index')->name('index');
            Route::get('/manuscript-categories/create', 'create')->name('create');
            Route::post('/manuscript-categories', 'store')->name('store');
            Route::get('/manuscript-categories/{manuscriptCategory}/edit', 'edit')->name('edit');
            Route::put('/manuscript-categories/{manuscriptCategory}', 'update')->name('update');
            Route::delete('/manuscript-categories/{manuscriptCategory}', 'destroy')->name('destroy');
        });

        Route::controller(Admin\ServiceController::class)->name('services.')->group(function () {
            Route::get('/services', 'index')->name('index');
            Route::get('/services/create', 'create')->name('create');
            Route::post('/services', 'store')->name('store');
            Route::post('/services/upload-image', 'uploadImageEditor')->name('upload_image');
            Route::get('/services/{service}/edit', 'edit')->name('edit');
            Route::put('/services/{service}', 'update')->name('update');
            Route::delete('/services/{service}', 'destroy')->name('destroy');
        });
        
        Route::middleware('root.admin')->controller(Admin\UserController::class)->name('users.')->group(function () {
            Route::get('/users', 'index')->name('index');
            Route::post('/users', 'store')->name('store');
            Route::put('/users/{user}', 'update')->name('update');
            Route::delete('/users/{user}', 'destroy')->name('destroy');
        });

        Route::middleware('root.admin')->controller(Admin\SettingController::class)->name('settings.')->group(function () {
            Route::get('/settings', 'index')->name('index');
            Route::put('/settings', 'update')->name('update');
        });

        Route::controller(Admin\AccountController::class)->name('account.')->group(function () {
            Route::get('/account', 'index')->name('index');
            Route::put('/account/{account}', 'update')->name('update');
        });
    });
});
