<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/*--------- Peminjaman Buku --------- */
Route::get('/walikelas/pemijamanview', 'WalikelasApiController@peminjamanview');
Route::get('/walikelas/data_siswapeminjaman', 'WalikelasApiController@siswapeminjaman');
Route::get('/walikelas/data_bukupeminjaman', 'WalikelasApiController@namabuku');
Route::get('/walikelas/peminjamansearch', 'WalikelasApiController@peminjamansearch');
/*--------- End Peminjaman Buku --------- */

/*--------- Pengembalian Buku --------- */
Route::get('/walikelas/pengembalianview', 'WalikelasApiController@pengembalianview');
Route::get('/walikelas/pengembaliansearch', 'WalikelasApiController@pengembaliansearch');
Route::get('/walikelas/data_siswapengembalian', 'WalikelasApiController@datasiswapengembalian');
Route::get('/walikelas/data_peminjamanpengembalian', 'WalikelasApiController@datapeminjamankepengembalian');
Route::get('/Walikelas/data_bukupengembalian', 'WalikelasApiController@pengembalianallbuku');
/*--------- End Pengembalian Buku --------- */

/*--------- Buku Hilang --------- */
Route::get('/walikelas/bukuhilangview', 'WalikelasApiController@bukuhilangview');
Route::get('/walikelas/bukuhilangsearch', 'WalikelasApiController@bukuhilangsearch');
/*--------- EndBuku Hilang --------- */


/*--------- Wali kelas --------- */
Route::get('/perpus/walikelasview', 'PerpusApiController@WalikelasView');
Route::get('/perpus/walikelassearch', 'PerpusApiController@WalikelasSearch');
/*--------- End wali kelas --------- */


Route::get('/kelas', 'PerpusApiController@kelas');
/*--------- siswa --------- */
Route::get('/perpus/siswaview', 'PerpusApiController@siswaview');
Route::get('/perpus/siswasearch', 'PerpusApiController@siswasearch');
/*--------- End siswa --------- */

/*--------- Buku --------- */
Route::get('/perpus/bukuview', 'PerpusApiController@bukuview');
Route::get('/perpus/bukusearch', 'PerpusApiController@bukusearch');
/*--------- End Buku --------- */
