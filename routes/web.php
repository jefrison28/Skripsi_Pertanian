<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PetaniController;
use App\Http\Controllers\LahanController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Lahan;
use App\Models\PekerjaanLahan;
use App\Models\ProgressPekerjaanLahan;

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

Route::get('/', function () {
    $petani = User::where('role', 'petani')->count();
    $diproses = Lahan::where('status', false)->count();
    $selesai = Lahan::where('status', true)->count();
    $lahan = Lahan::count();
    return Inertia::render('Welcome', [
        'petani' => $petani,
        'diproses' => $diproses,
        'selesai' => $selesai,
        'lahan' => $lahan,
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

// Route::get('/dashboard', function () {
    
//     return Inertia::render('Dashboard', [
//         'datas' => 'vobaa'
//     ]);
// })->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/dashboard',[AdminController::class, 'dashboardIndex'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//admin controller
Route::get('/dashboard/petani-page',[AdminController::class, 'petanipage'])->name('petanipage.view')->middleware(['middleware' => 'role:admin']);
Route::get('/dashboard/petani-page/view/{id}',[AdminController::class, 'viewPetani'])->name('petanipage.viewbyId')->middleware(['middleware' => 'role:admin']);
Route::get('/dashboard/petani-page/edit/{id}',[AdminController::class, 'editPetani'])->name('petanipage.edit')->middleware(['middleware' => 'role:admin']);
Route::post('updateuser',[AdminController::class, 'updateUser'])->name('updateUser')->middleware(['middleware' => 'role:admin']);
Route::post('approvePekerjaan/{id}',[AdminController::class, 'approvePekerjaan'])->name('approvePekerjaan')->middleware(['middleware' => 'role:admin']);
Route::post('regisuser',[AdminController::class, 'regisUser'])->name('regisUser')->middleware(['middleware' => 'role:admin']);
Route::delete('deletepetani/{id}',[AdminController::class, 'deletePetani'])->name('deletePetani')->middleware(['middleware' => 'role:admin']);

Route::get('/dashboard/lahan-page',[AdminController::class, 'lahanpage'])->name('lahanpage.view')->middleware(['middleware' => 'role:admin']);
Route::patch('/editInfoLahan',[AdminController::class, 'editInfoLahan'])->name('informasiLahan.update')->middleware(['middleware' => 'role:admin']);
Route::get('/dashboard/lahan-page/manage/{id}',[AdminController::class, 'manageLahan'])->name('manageLahan.view')->middleware(['middleware' => 'role:admin']);
Route::get('/dashboard/lahan-page/manage/lahan/{id}',[AdminController::class, 'lahanPekerjaan'])->name('lahanPekerjaan.view')->middleware(['middleware' => 'role:admin']);
Route::get('/dashboard/lahan-page/edit/{id}',[AdminController::class, 'editPemilikLahan'])->name('lahanpage.edit')->middleware(['middleware' => 'role:admin']);
Route::delete('deletelahan/{id}',[AdminController::class, 'deleteLahan'])->name('deleteLahan')->middleware(['middleware' => 'role:admin']);
Route::delete('hapusPekerjaan',[AdminController::class, 'deletePekerjaan'])->name('hapusPekerjaan')->middleware(['middleware' => 'role:admin']);
Route::delete('deletePetaniLahan',[AdminController::class, 'deletePetaniLahan'])->name('deletePetaniLahan')->middleware(['middleware' => 'role:admin']);
Route::put('updatePekerjaan',[AdminController::class, 'updatePekerjaan'])->name('updatePekerjaan')->middleware(['middleware' => 'role:admin']);
Route::post('addPekerjaan',[AdminController::class, 'addPekerjaan'])->name('addPekerjaan')->middleware(['middleware' => 'role:admin']);
Route::post('addPetani',[AdminController::class, 'addPetani'])->name('addPetani')->middleware(['middleware' => 'role:admin']);
Route::delete('destroyLahan',[AdminController::class, 'deleteLahanPartial'])->name('destroyLahan')->middleware(['middleware' => 'role:admin']);
Route::get('/maps/{id}',[AdminController::class, 'mapsLahan'])->name('mapsLahan.view')->middleware(['middleware' => 'auth']);
Route::post('insertLahan',[AdminController::class, 'insertLahan'])->name('insertLahan')->middleware(['middleware' => 'role:admin']);
Route::get('/dashboard/tambah-lahan/{id}',[AdminController::class, 'tambahLahan'])->name('tambahlahan')->middleware(['middleware' => 'role:admin']);

//petani route
Route::get('/pekerjaan/{id}',[PetaniController::class, 'lahanPekerjaan'])->name('lahanPekerjaan.view')->middleware(['middleware' => 'role:petani']);
Route::post('checkpekerjaan',[PetaniController::class, 'checkPekerjaan'])->name('checkPekerjaan')->middleware(['middleware' => 'role:petani']);

//pemilik lahan
Route::get('/lahanpemilik/{id}',[LahanController::class, 'lahanPekerjaan'])->name('lahanPekerjaan.view')->middleware(['middleware' => 'role:pemilik_lahan']);

require __DIR__.'/auth.php';

