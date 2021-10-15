<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MasyarakatController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\TanggapanController;
use App\Http\Controllers\KategoriController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [LoginController::class, 'login']);
Route::post('register', [LoginController::class, 'register']);

Route::group(['middleware' => ['jwt.verify:admin,petugas,masyarakat']], function () {
    Route::get('login/check', [LoginController::class, 'loginCheck']);
    Route::post('logout', [LoginController::class, 'logout']);
});

//AKSES UNTUK HALAMAN PANEL ADMIN
Route::group(['middleware' => ['jwt.verify:admin']], function () { //untuk hak akses admin dan petugas
    //MASYARAKAT
    Route::get('masyarakat', [MasyarakatController::class, 'getAll']); //get all
    Route::get('masyarakat/{id}', [MasyarakatController::class, 'getById']); //get all
    Route::get('masyarakat/{limit}/{offset}', [MasyarakatController::class, 'getAll']); //get all dengan limit
    Route::put('masyarakat/{id_user}', [MasyarakatController::class, 'update']); //update
    Route::delete('masyarakat/{id_user}', [MasyarakatController::class, 'delete']); //delete

    //PETUGAS
    Route::get('petugas', [PetugasController::class, 'getAll']); //get all
    Route::get('petugas/{id}', [PetugasController::class, 'getById']); //get all
    Route::get('petugas/{limit}/{offset}', [PetugasController::class, 'getAll']); //get all dengan limit
    Route::post('petugas', [PetugasController::class, 'insert']); //insert
    Route::put('petugas/{id_user}', [PetugasController::class, 'update']); //update
    Route::delete('petugas/{id_user}', [PetugasController::class, 'delete']); //delete

    //KATEGORI PENGADUAN
    Route::get('kategori', [KategoriController::class, 'getAll']); //get all
    Route::get('kategori/{id_kategori}', [KategoriController::class, 'getById']); //get all
    Route::get('kategori/{limit}/{offset}', [KategoriController::class, 'getAll']); //get all dengan limit
    Route::post('kategori', [KategoriController::class, 'insert']); //insert
    Route::put('kategori/{id_user}', [KategoriController::class, 'update']); //update
    Route::delete('kategori/{id_user}', [KategoriController::class, 'delete']); //delete

    //REPORT
    Route::post('pengaduan/report', [PengaduanController::class, 'report']); //get all

});

Route::group(['middleware' => ['jwt.verify:admin,petugas']], function () {
    //PENGADUAN
    Route::get('pengaduan', [PengaduanController::class, 'getAllPengaduan']); //get all
    Route::get('pengaduan/{id_pengaduan}', [PengaduanController::class, 'getById']); //get all
    Route::get('pengaduan/{limit}/{offset}', [PengaduanController::class, 'getAllPengaduan']); //get all by limit
    Route::post('pengaduan/status', [PengaduanController::class, 'changeStatus']); //ubah status pengaduan
    Route::post('pengaduan/tanggapan', [TanggapanController::class, 'send']); //memasukan tanggapan


});

//AKSES UNTUK HALAMAN MASYARAKAT
Route::group(['middleware' => ['jwt.verify:masyarakat']], function () { //untuk hak akses masyarakat
    //PENGADUAN
    Route::get('masyarakat/pengaduan', [PengaduanController::class, 'getAllPengaduan']); //get all
    Route::get('masyarakat/pengaduan/{limit}/{offset}', [PengaduanController::class, 'getAllPengaduan']); //get all
    Route::post('masyarakat/pengaduan', [PengaduanController::class, 'insert']); //insert

});
