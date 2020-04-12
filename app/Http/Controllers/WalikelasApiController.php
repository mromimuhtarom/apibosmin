<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class WalikelasApiController extends Controller
{
    public function peminjamanview(Request $request)
    {
        $op_id      = $request->op_id;

        $peminjaman = DB::table('peminjaman')
                      ->join('siswa', 'siswa.id_siswa', '=', 'peminjaman.id_siswa')
                      ->join('buku', 'buku.buku_id', '=', 'peminjaman.buku_id')
                      ->join('kelas', 'kelas.id_kelas', '=', 'siswa.id_kelas')
                      ->select(
                          'siswa.nama_siswa',
                          'buku.nama_buku',
                          'kelas.nama_kelas as kelas',
                          'peminjaman.*'
                      )
                      ->where('peminjaman.op_id', '=', $op_id)
                      ->orderBy('tgl_peminjaman', 'desc')
                      ->get();
        return $peminjaman;
    }

    public function siswapeminjaman(Request $request)
    {
        $kelas = $request->kelas;
        $siswa = DB::table('siswa')
                 ->where('id_kelas', '=', $kelas)
                 ->get();
        
        return $siswa;
    }

    public function namabuku(Request $request)
    {
        $kelas = $request->kelas;
        $buku = DB::table('buku')
                ->where('kelas', '=', $kelas)
                ->get();

        return $buku;
    }

    public function peminjamansearch(Request $request)
    {
        $nama_siswa = $request->nama_siswa;
        $nama_buku  = $request->nama_buku;
        $tgl_min    = $request->tgl_min;
        $tgl_maks   = $request->tgl_maks;
        $op_id      = $request->op_id;

        $peminjaman_buku = DB::table('peminjaman')
                      ->join('siswa', 'siswa.id_siswa', '=', 'peminjaman.id_siswa')
                      ->join('buku', 'buku.buku_id', '=', 'peminjaman.buku_id')
                      ->join('kelas', 'kelas.id_kelas', '=', 'siswa.id_kelas')
                      ->select(
                        'siswa.nama_siswa',
                        'kelas.nama_kelas as kelas',
                        'buku.nama_buku',
                        'peminjaman.*'
                      );
        
        if($nama_siswa !== NULL && $nama_buku !== NULL && $tgl_min !== NULL && $tgl_maks !== NULL): 
            if(is_numeric($nama_siswa) === true && is_numeric($nama_buku) === true): 
                $peminjaman = $peminjaman_buku->where('peminjaman.id_siswa', '=', $nama_siswa)
                              ->where('peminjaman.buku_id', '=', $nama_buku)
                              ->wherebetween('tgl_peminjaman', [$tgl_min.' 00:00:00', $tgl_maks.' 23:59:59'])
                              ->where('peminjaman.op_id', '=', $op_id)
                              ->orderBy('tgl_peminjaman', 'desc')
                              ->get();
            else: 
                $peminjaman = $peminjaman_buku->where('nama_siswa', 'LIKE', '%'.$nama_siswa.'%')
                              ->where('nama_buku', 'LIKE', '%'.$nama_buku.'%')
                              ->wherebetween('tgl_peminjaman', [$tgl_min.' 00:00:00', $tgl_maks.' 23:59:59'])
                              ->where('peminjaman.op_id', '=', $op_id)
                              ->orderBy('tgl_peminjaman', 'desc')
                              ->get();
            endif;
        elseif($nama_buku !== NULL && $tgl_min !== NULL && $tgl_maks !== NULL):
            if(is_numeric($nama_buku) === true): 
                $peminjaman = $peminjaman_buku->where('peminjaman.buku_id', '=', $nama_buku)
                              ->wherebetween('tgl_peminjaman', [$tgl_min.' 00:00:00', $tgl_maks.' 23:59:59'])
                              ->where('peminjaman.op_id', '=', $op_id)
                              ->orderBy('tgl_peminjaman', 'desc')
                              ->get();
            else: 
                $peminjaman = $peminjaman_buku->where('nama_buku', 'LIKE', '%'.$nama_buku.'%')
                              ->wherebetween('tgl_peminjaman', [$tgl_min.' 00:00:00', $tgl_maks.' 23:59:59'])
                              ->where('peminjaman.op_id', '=', $op_id)
                              ->orderBy('tgl_peminjaman', 'desc')
                              ->get();
            endif;
        elseif($nama_siswa !== NULL && $tgl_min !== NULL && $tgl_maks !== NULL):
            if(is_numeric($nama_siswa) === true): 
                $peminjaman = $peminjaman_buku->where('peminjaman.id_siswa', '=', $nama_siswa)
                              ->wherebetween('tgl_peminjaman', [$tgl_min.' 00:00:00', $tgl_maks.' 23:59:59'])
                              ->where('peminjaman.op_id', '=', $op_id)
                              ->orderBy('tgl_peminjaman', 'desc')
                              ->get();
            else: 
                $peminjaman = $peminjaman_buku->where('nama_siswa', 'LIKE', '%'.$nama_siswa.'%')
                              ->wherebetween('tgl_peminjaman', [$tgl_min.' 00:00:00', $tgl_maks.' 23:59:59'])
                              ->where('peminjaman.op_id', '=', $op_id)
                              ->orderBy('tgl_peminjaman', 'desc')
                              ->get();
            endif;
        elseif($tgl_min !== NULL && $tgl_maks !== NULL):
            $peminjaman = $peminjaman_buku->wherebetween('tgl_peminjaman', [$tgl_min.' 00:00:00', $tgl_maks.' 23:59:59'])
                          ->where('peminjaman.op_id', '=', $op_id)
                          ->orderBy('tgl_peminjaman', 'desc')
                          ->get();
        endif;

        return $peminjaman;
    }

    public function pengembalianview(Request $request)
    {
        $op_id      = $request->op_id;

        $pengembalian = DB::table('pengembalian')
                      ->join('siswa', 'siswa.id_siswa', '=', 'pengembalian.id_siswa')
                      ->join('buku', 'buku.buku_id', '=', 'pengembalian.buku_id')
                      ->join('kelas', 'kelas.id_kelas', '=', 'siswa.id_kelas')
                      ->select(
                          'siswa.nama_siswa',
                          'buku.nama_buku',
                          'kelas.nama_kelas as kelas',
                          'pengembalian.*'
                      )
                      ->where('pengembalian.op_id', '=', $op_id)
                      ->orderBy('tgl_pengembalian', 'desc')
                      ->get();
        return $pengembalian;
    }

    public function datasiswapengembalian(Request $request)
    {
        $op_id = $request->op_id;
        $siswa = DB::table('peminjaman')
                 ->join('siswa', 'siswa.id_siswa', '=', 'peminjaman.id_siswa')
                 ->select(
                     'siswa.nama_siswa',
                     'peminjaman.*'
                 )
                 ->where('op_id', '=', $op_id)
                 ->groupBy('peminjaman.id_siswa')
                 ->orderBy('tgl_peminjaman', 'desc')
                 ->get();

        return $siswa;
    }

    public function datapeminjamankepengembalian(Request $request)
    {
        $siswa = $request->id_siswa;
        $buku = $request->buku_id;

        if($siswa != NULL && $buku != NULL):
            $pengembalian = DB::table('peminjaman')
                            ->join('siswa', 'siswa.id_siswa', '=', 'peminjaman.id_siswa')
                            ->join('buku', 'buku.buku_id', '=', 'peminjaman.buku_id')
                            ->join('kelas', 'kelas.id_kelas', '=', 'siswa.id_kelas')
                            ->select(
                                'siswa.nama_siswa',
                                'kelas.nama_kelas as kelas',
                                'buku.nama_buku',
                                'peminjaman.*'
                            )
                            ->where('peminjaman.id_siswa', '=', $siswa)
                            ->where('peminjaman.buku_id', '=', $buku)
                            ->get();
        elseif($siswa != NULL):
            $pengembalian = DB::table('peminjaman')
                            ->join('siswa', 'siswa.id_siswa', '=', 'peminjaman.id_siswa')
                            ->join('buku', 'buku.buku_id', '=', 'peminjaman.buku_id')
                            ->join('kelas', 'kelas.id_kelas', '=', 'siswa.id_kelas')
                            ->select(
                                'siswa.nama_siswa',
                                'kelas.nama_kelas as kelas',
                                'buku.nama_buku',
                                'peminjaman.*'
                            )
                            ->where('peminjaman.buku_id', '=', $buku)
                            ->get();
        elseif($buku != NULL):
            $pengembalian = DB::table('peminjaman')
                            ->join('siswa', 'siswa.id_siswa', '=', 'peminjaman.id_siswa')
                            ->join('buku', 'buku.buku_id', '=', 'peminjaman.buku_id')
                            ->join('kelas', 'kelas.id_kelas', '=', 'siswa.id_kelas')
                            ->select(
                                'siswa.nama_siswa',
                                'kelas.nama_kelas as kelas',
                                'buku.nama_buku',
                                'peminjaman.*'
                            )
                            ->where('peminjaman.buku_id', '=', $buku)
                            ->get();
        endif;

        return $pengembalian;
    }

    public function pengembalianallbuku(Request $request)
    {
        $buku = DB::table('buku')->get();

        return $buku;
    }

    public function pengembaliansearch(Request $request)
    {
        $nama_siswa = $request->nama_siswa;
        $nama_buku  = $request->nama_buku;
        $tgl_min    = $request->tgl_min;
        $tgl_maks   = $request->tgl_maks;
        $op_id      = $request->op_id;

        $pengembalian_buku = DB::table('pengembalian')
                      ->join('siswa', 'siswa.id_siswa', '=', 'pengembalian.id_siswa')
                      ->join('buku', 'buku.buku_id', '=', 'pengembalian.buku_id')
                      ->join('kelas', 'kelas.id_kelas', '=', 'siswa.id_kelas')
                      ->select(
                        'siswa.nama_siswa',
                        'buku.nama_buku',
                        'kelas.nama_kelas as kelas',
                        'pengembalian.*'
                      );
        
        if($nama_siswa !== NULL && $nama_buku !== NULL && $tgl_min !== NULL && $tgl_maks !== NULL): 
            if(is_numeric($nama_siswa) === true && is_numeric($nama_buku) === true): 
                $pengembalian = $pengembalian_buku->where('pengembalian.id_siswa', '=', $nama_siswa)
                              ->where('pengembalian.buku_id', '=', $nama_buku)
                              ->wherebetween('tgl_pengembalian', [$tgl_min.' 00:00:00', $tgl_maks.' 23:59:59'])
                              ->where('pengembalian.op_id', '=', $op_id)
                              ->orderBy('tgl_pengembalian', 'desc')
                              ->get();
            else: 
                $pengembalian = $pengembalian_buku->where('nama_siswa', 'LIKE', '%'.$nama_siswa.'%')
                              ->where('nama_buku', 'LIKE', '%'.$nama_buku.'%')
                              ->wherebetween('tgl_pengembalian', [$tgl_min.' 00:00:00', $tgl_maks.' 23:59:59'])
                              ->where('pengembalian.op_id', '=', $op_id)
                              ->orderBy('tgl_pengembalian', 'desc')
                              ->get();
            endif;
        elseif($nama_buku !== NULL && $tgl_min !== NULL && $tgl_maks !== NULL):
            if(is_numeric($nama_buku) === true): 
                $pengembalian = $pengembalian_buku->where('pengembalian.buku_id', '=', $nama_buku)
                              ->wherebetween('tgl_pengembalian', [$tgl_min.' 00:00:00', $tgl_maks.' 23:59:59'])
                              ->where('pengembalian.op_id', '=', $op_id)
                              ->orderBy('tgl_pengembalian', 'desc')
                              ->get();
            else: 
                $pengembalian = $pengembalian_buku->where('nama_buku', 'LIKE', '%'.$nama_buku.'%')
                              ->wherebetween('tgl_pengembalian', [$tgl_min.' 00:00:00', $tgl_maks.' 23:59:59'])
                              ->where('pengembalian.op_id', '=', $op_id)
                              ->orderBy('tgl_pengembalian', 'desc')
                              ->get();
            endif;
        elseif($nama_siswa !== NULL && $tgl_min !== NULL && $tgl_maks !== NULL):
            if(is_numeric($nama_siswa) === true): 
                $pengembalian = $pengembalian_buku->where('pengembalian.id_siswa', '=', $nama_siswa)
                              ->wherebetween('tgl_pengembalian', [$tgl_min.' 00:00:00', $tgl_maks.' 23:59:59'])
                              ->where('pengembalian.op_id', '=', $op_id)
                              ->orderBy('tgl_pengembalian', 'desc')
                              ->get();
            else: 
                $pengembalian = $pengembalian_buku->where('nama_siswa', 'LIKE', '%'.$nama_siswa.'%')
                              ->wherebetween('tgl_pengembalian', [$tgl_min.' 00:00:00', $tgl_maks.' 23:59:59'])
                              ->where('pengembalian.op_id', '=', $op_id)
                              ->orderBy('tgl_pengembalian', 'desc')
                              ->get();
            endif;
        elseif($tgl_min !== NULL && $tgl_maks !== NULL):
            $pengembalian = $pengembalian_buku->wherebetween('tgl_pengembalian', [$tgl_min.' 00:00:00', $tgl_maks.' 23:59:59'])
                          ->where('pengembalian.op_id', '=', $op_id)
                          ->orderBy('tgl_pengembalian', 'desc')
                          ->get();
        endif;

        return $pengembalian;
    }

    public function bukuhilangview(Request $request)
    {
        $op_id      = $request->op_id;

        $buku_hilang = DB::table('buku_hilang')
                      ->join('siswa', 'siswa.id_siswa', '=', 'buku_hilang.id_siswa')
                      ->join('buku', 'buku.buku_id', '=', 'buku_hilang.buku_id')
                      ->join('kelas', 'kelas.id_kelas', '=', 'siswa.id_kelas')
                      ->select(
                          'siswa.nama_siswa',
                          'buku.nama_buku',
                          'kelas.nama_kelas as kelas',
                          'buku_hilang.*'
                      )
                      ->where('buku_hilang.op_id', '=', $op_id)
                      ->orderBy('tgl_kehilangan', 'desc')
                      ->get();
        return $buku_hilang;
    }

    public function bukuhilangsearch(Request $request)
    {
        $nama_siswa = $request->nama_siswa;
        $nama_buku  = $request->nama_buku;
        $tgl_min    = $request->tgl_min;
        $tgl_maks   = $request->tgl_maks;
        $op_id      = $request->op_id;

        $buku_hilang = DB::table('buku_hilang')
                      ->join('siswa', 'siswa.id_siswa', '=', 'buku_hilang.id_siswa')
                      ->join('buku', 'buku.buku_id', '=', 'buku_hilang.buku_id')
                      ->join('kelas', 'kelas.id_kelas', '=', 'siswa.id_kelas')
                      ->select(
                        'siswa.nama_siswa',
                        'buku.nama_buku',
                        'kelas.nama_kelas as kelas',
                        'buku_hilang.*'
                      );
        
        if($nama_siswa !== NULL && $nama_buku !== NULL && $tgl_min !== NULL && $tgl_maks !== NULL): 
            if(is_numeric($nama_siswa) === true && is_numeric($nama_buku) === true): 
                $kehilangan = $buku_hilang->where('buku_hilang.id_siswa', '=', $nama_siswa)
                              ->where('buku_hilang.buku_id', '=', $nama_buku)
                              ->wherebetween('tgl_kehilangan', [$tgl_min.' 00:00:00', $tgl_maks.' 23:59:59'])
                              ->where('buku_hilang.op_id', '=', $op_id)
                              ->orderBy('tgl_kehilangan', 'desc')
                              ->get();
            else: 
                $kehilangan = $buku_hilang->where('nama_siswa', 'LIKE', '%'.$nama_siswa.'%')
                              ->where('nama_buku', 'LIKE', '%'.$nama_buku.'%')
                              ->wherebetween('tgl_kehilangan', [$tgl_min.' 00:00:00', $tgl_maks.' 23:59:59'])
                              ->where('buku_hilang.op_id', '=', $op_id)
                              ->orderBy('tgl_kehilangan', 'desc')
                              ->get();
            endif;
        elseif($nama_buku !== NULL && $tgl_min !== NULL && $tgl_maks !== NULL):
            if(is_numeric($nama_buku) === true): 
                $kehilangan = $buku_hilang->where('buku_hilang.buku_id', '=', $nama_buku)
                              ->wherebetween('tgl_kehilangan', [$tgl_min.' 00:00:00', $tgl_maks.' 23:59:59'])
                              ->where('buku_hilang.op_id', '=', $op_id)
                              ->orderBy('tgl_kehilangan', 'desc')
                              ->get();
            else: 
                $kehilangan = $buku_hilang->where('nama_buku', 'LIKE', '%'.$nama_buku.'%')
                              ->wherebetween('tgl_kehilangan', [$tgl_min.' 00:00:00', $tgl_maks.' 23:59:59'])
                              ->where('buku_hilang.op_id', '=', $op_id)
                              ->orderBy('tgl_kehilangan', 'desc')
                              ->get();
            endif;
        elseif($nama_siswa !== NULL && $tgl_min !== NULL && $tgl_maks !== NULL):
            if(is_numeric($nama_siswa) === true): 
                $kehilangan = $buku_hilang->where('buku_hilang.id_siswa', '=', $nama_siswa)
                              ->wherebetween('tgl_kehilangan', [$tgl_min.' 00:00:00', $tgl_maks.' 23:59:59'])
                              ->where('buku_hilang.op_id', '=', $op_id)
                              ->orderBy('tgl_kehilangan', 'desc')
                              ->get();
            else: 
                $kehilangan = $buku_hilang->where('nama_siswa', 'LIKE', '%'.$nama_siswa.'%')
                              ->wherebetween('tgl_kehilangan', [$tgl_min.' 00:00:00', $tgl_maks.' 23:59:59'])
                              ->where('buku_hilang.op_id', '=', $op_id)
                              ->orderBy('tgl_kehilangan', 'desc')
                              ->get();
            endif;
        elseif($tgl_min !== NULL && $tgl_maks !== NULL):
            $kehilangan = $buku_hilang->wherebetween('tgl_kehilangan', [$tgl_min.' 00:00:00', $tgl_maks.' 23:59:59'])
                          ->where('buku_hilang.op_id', '=', $op_id)
                          ->orderBy('tgl_kehilangan', 'desc')
                          ->get();
        endif;

        return $kehilangan;
    }
}
