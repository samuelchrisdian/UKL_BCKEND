<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Siswa;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll($limit = 10, $offset = 0)
    {
        $data["count"] = Siswa::count();
        $siswa = array();

        foreach (Siswa::take($limit)->skip($offset)->get() as $p) {
            $item = [
                "id"          => $p->id,
                "nama"        => $p->nama,
                "kelas"       => $p->kelas,
                "nis"         => $p->nis,
                "created_at"  => $p->created_at,
                "updated_at"  => $p->updated_at
            ];

            array_push($siswa, $item);
        }
        $data["siswa"] = $siswa;
        $data["status"] = 1;
        return response($data);
    }

    public function daftar(Request $request)
    {       
        $validator = Validator::make($request->all(), [
            'nama'          => 'required|string|max:255',
            'kelas'         => 'required|string|max:255',
            'nis'           => 'required|string',
        ]);

        if($validator->fails()){
			return response()->json([
				'status'	=> '0',
				'message'	=> $validator->errors()
			]);
		}

        $data = new Siswa();
        $data->nama        = $request->input('nama');
        $data->kelas       = $request->input('kelas');
        $data->nis         = $request->input('nis');
        $data->save();

            return response()->json([
                'status' => '1',
                'message' => 'Tambah data siswa berhasil!',
            ]);
    }
    public function find(Request $request, $limit = 10, $offset = 0)
    {
        $find = $request->find;
        $siswa = Siswa::where("id","like","%$find%")
        ->orWhere("nama","like","%$find%")
        ->orWhere("kelas","like","%$find%");
        $data["count"] = $siswa->count();
        $siswas = array();
        foreach ($siswa->skip($offset)->take($limit)->get() as $p) {
          $item = [
                "id"          => $p->id,
                "nama"        => $p->nama,
                "kelas"       => $p->kelas,
                "nis"         => $p->nis,
                "created_at"  => $p->created_at,
                "updated_at"  => $p->updated_at
          ];
          array_push($siwas,$item);
        }
        $data["siswa"] = $siswas;
        $data["status"] = 1;
        return response($data);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama'          => 'required|string|max:255',
            'kelas'         => 'required|string|max:255',
            'nis'           => 'required|string',
        ]);

        if($validator->fails()){
			return response()->json([
				'status'	=> '0',
				'message'	=> $validator->errors()
			]);
		}   

		//proses update data
		$siswa = Siswa::where('id', $request->id)->first();
		$siswa->nama 	     = $request->nama;
        $siswa->kelas        = $request->kelas;      
        $siswa->nis          = $request->nis  ;
		$siswa->save();


		return response()->json([
			'status'	=> '1',
			'message'	=> 'Data Siswa berhasil diubah'
		], 201);
    }

    public function delete($id)
    {
        try{

            Siswa::where("id", $id)->delete();

            return response([
            	"status"	=> 1,
                "message"   => "Data berhasil dihapus."
            ]);
        } catch(\Exception $e){
            return response([
            	"status"	=> 0,
                "message"   => $e->getMessage()
            ]);
        }
    }
}
