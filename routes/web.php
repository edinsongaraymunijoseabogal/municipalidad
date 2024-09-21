<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\PostCrud;
use App\Livewire\Admin\VideoCrud;
use App\Livewire\Admin\DocumentCrud;
use App\Livewire\Admin\UserCrud;
use App\Livewire\Admin\SettingsCrud;

use App\Livewire\Web\Documents;
use App\Livewire\Web\Directory;
use App\Livewire\Web\AboutUs;
use App\Livewire\Web\Posts;
use App\Livewire\Web\Videos;
use App\Livewire\Web\HomePage;
use App\Livewire\Web\ContactUs;


Route::name('web.')->group(function () {
    Route::get('/', HomePage::class)->name('home');
    Route::get('noticias', Posts::class)->name('posts');
    Route::get('videos', Videos::class)->name('videos');
    Route::get('documentos', Documents::class)->name('documents');
    Route::get('directorio', Directory::class)->name('directory');
    Route::get('sobre-nosotros', AboutUs::class)->name('aboutUs');
    Route::get('contactanos', ContactUs::class)->name('contactUs');
});

Auth::routes();

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', Dashboard::class)->name('index');
    Route::get('posts', PostCrud::class)->name('posts.index');
    Route::get('videos', VideoCrud::class)->name('videos.index');
    Route::get('documents', DocumentCrud::class)->name('documents.index');
    Route::get('users', UserCrud::class)->name('users.index');
    Route::get('settings', SettingsCrud::class )->name('settings.index');
});



