<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class PerpusApiController extends Controller
{
    public function WalikelasView()
    {
        $walikelas = DB::table('wali_kelas')
                     ->join('kelas', 'kelas.id_kelas', '=', 'wali_kelas.id_kelas')
                     ->join('operator', 'operator.op_id', '=', 'wali_kelas.op_id')
                     ->get();

        return $walikelas;
    }

    public function kelas()
    {
        $kelas = DB::table('kelas')
                 ->where('status', '=', 1)
                 ->get();

        return $kelas;
    }

    public function WalikelasSearch(Request $request)
    {
        $username = $request->username;
        $fullname = $request->fullname;
        $kelas    = $request->kelas;
        $walikelas = DB::table('wali_kelas')
                     ->join('operator', 'operator.op_id', '=', 'wali_kelas.op_id')
                     ->join('kelas', 'kelas.id_kelas', '=', 'wali_kelas.id_kelas');
        if($username != NULL && $fullname != NULL && $kelas != NULL):
            if(is_numeric($username)): 
                $wali = $walikelas->where('op_id', '=', $username)
                        ->where('fullname', 'LIKE', '%'.$fullname.'%')
                        ->where('kelas.nama_kelas', 'LIKE', '%'.$kelas.'%')
                        ->get();
            else:
                $wali = $walikelas->where('username', 'LIKE', '%'.$username.'%')
                        ->where('fullname', 'LIKE', '%'.$fullname.'%')
                        ->where('kelas.nama_kelas', 'LIKE', '%'.$kelas.'%')
                        ->get();
            endif;
        elseif($username != NULL && $fullname != NULL):
            if(is_numeric($username)): 
                $wali = $walikelas->where('op_id', '=', $username)
                        ->where('fullname', 'LIKE', '%'.$fullname.'%')
                        ->get();
            else:
                $wali = $walikelas->where('username', 'LIKE', '%'.$username.'%')
                        ->where('fullname', 'LIKE', '%'.$fullname.'%')
                        ->get();
            endif;
        elseif($username != NULL && $kelas != NULL):
            if(is_numeric($username)): 
                $wali = $walikelas->where('op_id', '=', $username)
                        ->where('kelas.nama_kelas', 'LIKE', '%'.$kelas.'%')
                        ->get();
            else:
                $wali = $walikelas->where('username', 'LIKE', '%'.$username.'%')
                        ->where('kelas.nama_kelas', 'LIKE', '%'.$kelas.'%')
                        ->get();
            endif;
        elseif($fullname != NULL && $kelas != NULL):
                $wali = $walikelas->where('fullname', 'LIKE', '%'.$fullname.'%')
                        ->where('kelas.nama_kelas', 'LIKE', '%'.$kelas.'%')
                        ->get();
        elseif($username != NULL): 
            if(is_numeric($username)): 
                $wali = $walikelas->where('op_id', '=', $username)
                        ->get();
            else:
                $wali = $walikelas->where('username', 'LIKE', '%'.$username.'%')
                        ->get();
            endif;
        elseif($fullname != NULL):
                $wali = $walikelas->where('fullname', 'LIKE', '%'.$fullname.'%')
                        ->where('kelas.nama_kelas', 'LIKE', '%'.$kelas.'%')
                        ->get();
        elseif($kelas != NULL):
                $wali = $walikelas->where('kelas.nama_kelas', 'LIKE', '%'.$kelas.'%')
                        ->get();
        endif;

        return $wali;
    }

    public function siswaview()
    {
        $siswa = DB::table('siswa')
                 ->join('kelas', 'kelas.id_kelas', '=', 'siswa.id_kelas')
                 ->get();

        return $siswa;        
    }

    public function siswasearch(Request $request)
    {
        $siswa = $request->siswa;
        $kelas = $request->kelas;

        $data_siswa = DB::table('siswa')
                      ->join('kelas', 'kelas.id_kelas', '=', 'siswa.id_kelas');
        if($siswa != NULL && $kelas != NULL):
            if(is_numeric($siswa)): 
                $sw = $data_siswa->where('id_siswa', '=', $siswa)
                      ->where('kelas.nama_kelas', 'LIKE', '%'.$kelas.'%')
                      ->get(); 
            else: 
                $sw = $data_siswa->where('nama_siswa', 'LIKE', '%'.$siswa.'%')
                      ->where('kelas.nama_kelas', 'LIKE', '%'.$kelas.'%')
                      ->get(); 
            endif;
        elseif($siswa != NULL):
            if(is_numeric($siswa)): 
                $sw = $data_siswa->where('id_siswa', '=', $siswa)
                      ->get(); 
            else: 
                $sw = $data_siswa->where('nama_siswa', 'LIKE', '%'.$siswa.'%')
                      ->get(); 
            endif;
        elseif($kelas != NULL):
            $sw = $data_siswa->where('kelas.nama_kelas', 'LIKE', '%'.$kelas.'%')
                  ->get(); 
        endif;
        
        return $sw;        
    }

    public function bukuview()
    {
        $buku = DB::table('buku')
                ->get();
        return $buku;        
    }

    public function bukusearch(Request $request)
    {
        $buku      = $request->buku;
        $kelas     = $request->kelas;
        $tglminpen = $request->tglminpen;
        $tglmaxpen = $request->tglmaxpen;
        $tglminmsk = $request->tglminmsk;
        $tglmaxmsk = $request->tglmaxmsk;
        $databukuall = DB::table('buku');

        if($buku != NULL && $kelas != NULL && $tglminpen != NULL && $tglmaxpen != NULL && $tglminmsk  != NULL && $tglmaxmsk != NULL): 
            if(is_numeric($buku)):
                $databuku = $databukuall->where('buku_id', '=', $buku)
                            ->where('kelas', 'LIKE', '%'.$kelas.'%')
                            ->whereBetween('tanggal_terbit', [$tglminpen, $tglmaxpen])
                            ->whereBetween('timestamp', [$tglminmsk, $tglmaxmsk]) 
                            ->get();
            else: 
                $databuku = $databukuall->where('nama_buku', 'LIKE', '%'.$buku.'%')
                            ->where('kelas', 'LIKE', '%'.$kelas.'%')
                            ->whereBetween('tanggal_terbit', [$tglminpen, $tglmaxpen])
                            ->whereBetween('timestamp', [$tglminmsk, $tglmaxmsk]) 
                            ->get();
            endif;
        elseif($buku != NULL && $kelas != NULL && $tglminpen != NULL && $tglminmsk  != NULL && $tglmaxmsk != NULL): 
            if(is_numeric($buku)):
                $databuku = $databukuall->where('buku_id', '=', $buku)
                            ->where('kelas', 'LIKE', '%'.$kelas.'%')
                            ->whereBetween('tanggal_terbit', '>=', $tglminpen)
                            ->whereBetween('timestamp', [$tglminmsk, $tglmaxmsk]) 
                            ->get();
            else: 
                $databuku = $databukuall->where('nama_buku', 'LIKE', '%'.$buku.'%')
                            ->where('kelas', 'LIKE', '%'.$kelas.'%')
                            ->whereBetween('tanggal_terbit', '>=', $tglminpen)
                            ->whereBetween('timestamp', [$tglminmsk, $tglmaxmsk]) 
                            ->get();
            endif;
        elseif($buku != NULL && $kelas != NULL && $tglmaxpen != NULL && $tglminmsk  != NULL && $tglmaxmsk != NULL):
            if(is_numeric($buku)):
                $databuku = $databukuall->where('buku_id', '=', $buku)
                            ->where('kelas', 'LIKE', '%'.$kelas.'%')
                            ->whereBetween('tanggal_terbit', '<=', $tglmaxpen)
                            ->whereBetween('timestamp', [$tglminmsk, $tglmaxmsk]) 
                            ->get();
            else: 
                $databuku = $databukuall->where('nama_buku', 'LIKE', '%'.$buku.'%')
                            ->where('kelas', 'LIKE', '%'.$kelas.'%')
                            ->whereBetween('tanggal_terbit', '<=', $tglmaxpen)
                            ->whereBetween('timestamp', [$tglminmsk, $tglmaxmsk]) 
                            ->get();
            endif;
        elseif($buku != NULL && $tglminpen != NULL && $tglmaxpen != NULL && $tglminmsk  != NULL && $tglmaxmsk != NULL):
            if(is_numeric($buku)):
                $databuku = $databukuall->where('buku_id', '=', $buku)
                            ->whereBetween('tanggal_terbit', [$tglminpen, $tglmaxpen])
                            ->whereBetween('timestamp', [$tglminmsk, $tglmaxmsk]) 
                            ->get();
            else: 
                $databuku = $databukuall->where('nama_buku', 'LIKE', '%'.$buku.'%')
                            ->whereBetween('tanggal_terbit', [$tglminpen, $tglmaxpen])
                            ->whereBetween('timestamp', [$tglminmsk, $tglmaxmsk]) 
                            ->get();
            endif;
        elseif($kelas != NULL && $tglminpen != NULL && $tglmaxpen != NULL && $tglminmsk  != NULL && $tglmaxmsk != NULL): 
                $databuku = $databukuall->where('kelas', 'LIKE', '%'.$kelas.'%')
                            ->whereBetween('tanggal_terbit', [$tglminpen, $tglmaxpen])
                            ->whereBetween('timestamp', [$tglminmsk, $tglmaxmsk]) 
                            ->get();
        elseif($tglminpen != NULL && $tglmaxpen != NULL && $tglminmsk  != NULL && $tglmaxmsk != NULL):
                $databuku = $databukuall->whereBetween('tanggal_terbit', [$tglminpen, $tglmaxpen])
                            ->whereBetween('timestamp', [$tglminmsk, $tglmaxmsk]) 
                            ->get();
        elseif($buku != NULL && $kelas != NULL && $tglminmsk  != NULL && $tglmaxmsk != NULL):
            if(is_numeric($buku)):
                $databuku = $databukuall->where('buku_id', '=', $buku)
                            ->where('kelas', 'LIKE', '%'.$kelas.'%')
                            ->whereBetween('timestamp', [$tglminmsk, $tglmaxmsk]) 
                            ->get();
            else: 
                $databuku = $databukuall->where('nama_buku', 'LIKE', '%'.$buku.'%')
                            ->where('kelas', 'LIKE', '%'.$kelas.'%')
                            ->whereBetween('timestamp', [$tglminmsk, $tglmaxmsk]) 
                            ->get();
            endif;
        elseif($buku != NULL && $tglmaxpen != NULL && $tglminmsk  != NULL && $tglmaxmsk != NULL):
            if(is_numeric($buku)):
                $databuku = $databukuall->where('buku_id', '=', $buku)
                            ->whereBetween('tanggal_terbit', '<=', $tglmaxpen)
                            ->whereBetween('timestamp', [$tglminmsk, $tglmaxmsk]) 
                            ->get();
            else: 
                $databuku = $databukuall->where('nama_buku', 'LIKE', '%'.$buku.'%')
                            ->whereBetween('tanggal_terbit', '<=', $tglmaxpen)
                            ->whereBetween('timestamp', [$tglminmsk, $tglmaxmsk]) 
                            ->get();
            endif;
        elseif($buku != NULL && $tglminpen != NULL && $tglminmsk  != NULL && $tglmaxmsk != NULL):
            if(is_numeric($buku)):
                $databuku = $databukuall->where('buku_id', '=', $buku)
                            ->whereBetween('tanggal_terbit', '>=', $tglminpen)
                            ->whereBetween('timestamp', [$tglminmsk, $tglmaxmsk]) 
                            ->get();
            else: 
                $databuku = $databukuall->where('nama_buku', 'LIKE', '%'.$buku.'%')
                            ->whereBetween('tanggal_terbit', '>=', $tglminpen)
                            ->whereBetween('timestamp', [$tglminmsk, $tglmaxmsk]) 
                            ->get();
            endif;
        elseif( $kelas != NULL && $tglmaxpen != NULL && $tglminmsk  != NULL && $tglmaxmsk != NULL):
            $databuku = $databukuall->where('kelas', 'LIKE', '%'.$kelas.'%')
                        ->whereBetween('tanggal_terbit', '<=', $tglmaxpen)
                        ->whereBetween('timestamp', [$tglminmsk, $tglmaxmsk]) 
                        ->get();
        elseif($kelas != NULL && $tglminpen != NULL && $tglminmsk  != NULL && $tglmaxmsk != NULL):
            $databuku = $databukuall->where('kelas', 'LIKE', '%'.$kelas.'%')
                        ->whereBetween('tanggal_terbit', '>=', $tglminpen)
                        ->whereBetween('timestamp', [$tglminmsk, $tglmaxmsk]) 
                        ->get();
        elseif($tglmaxpen != NULL && $tglminmsk  != NULL && $tglmaxmsk != NULL):
            $databuku = $databukuall->whereBetween('tanggal_terbit', '<=', $tglmaxpen)
                        ->whereBetween('timestamp', [$tglminmsk, $tglmaxmsk]) 
                        ->get();
        elseif($tglminpen != NULL && $tglminmsk  != NULL && $tglmaxmsk != NULL):
            $databuku = $databukuall->whereBetween('tanggal_terbit', '>=', $tglminpen)
                        ->whereBetween('timestamp', [$tglminmsk, $tglmaxmsk]) 
                        ->get();
        elseif($kelas != NULL && $tglminmsk  != NULL && $tglmaxmsk != NULL):
            $databuku = $databukuall->where('kelas', 'LIKE', '%'.$kelas.'%')
                        ->whereBetween('timestamp', [$tglminmsk, $tglmaxmsk]) 
                        ->get();
        elseif($buku != NULL && $tglminmsk  != NULL && $tglmaxmsk != NULL):
            if(is_numeric($buku)):
                $databuku = $databukuall->where('buku_id', '=', $buku)
                            ->whereBetween('timestamp', [$tglminmsk, $tglmaxmsk]) 
                            ->get();
            else: 
                $databuku = $databukuall->where('nama_buku', 'LIKE', '%'.$buku.'%')
                            ->whereBetween('timestamp', [$tglminmsk, $tglmaxmsk]) 
                            ->get();
            endif;
        elseif($tglminmsk  != NULL && $tglmaxmsk != NULL):
            $databuku = $databukuall->whereBetween('timestamp', [$tglminmsk, $tglmaxmsk]) 
                        ->get();
        endif;

        return $databuku;
    }
}
