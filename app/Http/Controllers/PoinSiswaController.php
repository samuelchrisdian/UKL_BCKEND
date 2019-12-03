<?php

namespace App\Http\Controllers;
use DB;
use App\Quotation;

use App\PoinSiswa;
use App\Siswa;
use App\Pelanggaran;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PoinSiswaController extends Controller
{
    public function getAll($limit = 10, $offset = 0)
    {
        $data["count"] = PoinSiswa::count();
        $poin = array();
        $dataPoin = DB::table('poin_siswa')
        ->join('siswa','siswa.id','=','poin_siswa.id_siswa')
        ->join('pelanggaran','pelanggaran.id','=','poin_siswa.id_pelanggaran')
        ->select('poin_siswa.id','siswa.nama','siswa.kelas','siswa.nis'
        ,'pelanggaran.nama_pelanggaran','pelanggaran.kategori','pelanggaran.poin','pelanggaran.poin','poin_siswa.tanggal')
        ->get();

        foreach($dataPoin as $p){
            $item = [
                "id"                 => $p->id,
                "nama_siswa"         => $p->nama,
                "kelas"              => $p->kelas,
                "nis"                => $p->nis,
                "nama_pelanggaran"   => $p->nama_pelanggaran,
                "kategori"           => $p->kategori,
                "poin"               => $p->poin,
                "tanggal"            => $p->tanggal
            ];

            array_push($poin, $item);
        }
        $data["dataPoin"] = $dataPoin;
        $data["status"] = 1;
        return response($data);
    }

    public function add(Request $request)
    {
        $id_siswa               = $request->siswa; 
        $siswa                  = Siswa::where('id', $id_siswa)->first();
        $pelanggaran            = Pelanggaran::where('id', $request->id)->first();
        //saveData
            $poinsiswa = new PoinSiswa();
            $poinsiswa->id_siswa 	       = $id_siswa;
            $poinsiswa->id_pelanggaran	   = $request->id;
            $poinsiswa->tanggal            = date("y/m/d");
            $poinsiswa->keterangan         = $request->keterangan; 
            $poinsiswa->save();
            
            return response()->json([
                'status'	=> '1',
                'message'	=> 'Poin berhasil terinput'
            ], 201);
    }

    // public function detailPoin($limit = 10, $offset = 0)
    // {
    //     $data["count"] = PoinSiswa::count();
    //     $poin = array();
    //     $dataPoin = DB::table('poin_siswa')
    //     ->join('siswa','siswa.id','=','poin_siswa.id_siswa')
    //     ->join('pelanggaran','pelanggaran.id','=','poin_siswa.id_pelanggaran')
    //     ->select('poin_siswa.id','siswa.nama_siswa','siswa.kelas','siswa.nis'
    //     ,'pelanggaran.nama_pelanggaran','pelanggaran.kategori','pelanggaran.poin','pelanggaran.poin','poin_siswa.tanggal')
    //     ->get();
    //     foreach($dataPoin as $p){
    //         $item = [
    //             "id"                 => $p->id,
    //             "nama_siswa"         => $p->nama_siswa,
    //             "kelas"              => $p->kelas,
    //             "nis"                => $p->nis,
    //             "nama_pelanggaran"   => $p->nama_pelanggaran,
    //             "kategori"           => $p->kategori,
    //             "poin"               => $p->poin,
    //             "tanggal"            => $p->tanggal
    //         ];

    //         array_push($poin, $item);
    //     }
    //     $data["poin"] = $poin;
    //     $data["status"] = 1;
    //     return response($data);
    //     }
}    

