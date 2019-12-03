<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pelanggaran;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class PelanggaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll($limit = 10, $offset = 0)
    {
        $data["count"] = Pelanggaran::count();
        $pelanggaran = array();

        foreach (Pelanggaran::take($limit)->skip($offset)->get() as $p) {
            $item = [
                "id"          => $p->id,
                "nama_pelanggaran"        => $p->nama_pelanggaran,
                "kategori"       => $p->kategori,
                "poin"         => $p->poin,
                "created_at"  => $p->created_at,
                "updated_at"  => $p->updated_at
            ];

            array_push($pelanggaran, $item);
        }
        $data["pelanggaran"] = $pelanggaran;
        $data["status"] = 1;
        return response($data);
    }

    public function tambah(Request $request)
    {       
        // $validator = Validator::make($request->all(), [
        //     'nama_pelanggaran'          => 'required|string|max:255',
        //     // 'kategori'         => 'required|enum|max:255',
        //     'poin'           => 'required|integer',
        // ]);

        // if($validator->fails()){
		// 	return response()->json([
		// 		'status'	=> '0',
		// 		'message'	=> $validator->errors()
		// 	]);
		// }

        $data = new Pelanggaran();
        $data->nama_pelanggaran        = $request->input('nama_pelanggaran');
        $data->kategori       = $request->input('kategori');
        $data->poin         = $request->input('poin');
        $data->save();

            return response()->json([
                'status' => '1',
                'message' => 'Tambah data pelanggaran berhasil!',
            ]);
    }
    public function find(Request $request, $limit = 10, $offset = 0)
    {
        $find = $request->find;
        $pelanggaran = Pelanggaran::where("id","like","%$find%")
        ->orWhere("nama_pelanggaran","like","%$find%")
        ->orWhere("kategori","like","%$find%");
        $data["count"] = $pelanggaran->count();
        $pelanggarans = array();
        foreach ($pelanggaran->skip($offset)->take($limit)->get() as $p) {
          $item = [
                "id"          => $p->id,
                "nama_pelanggaran"        => $p->nama_pelanggaran,
                "kategori"       => $p->kategori,
                "poin"         => $p->poin,
                "created_at"  => $p->created_at,
                "updated_at"  => $p->updated_at
          ];
          array_push($siwas,$item);
        }
        $data["pelanggaran"] = $pelanggarans;
        $data["status"] = 1;
        return response($data);
    }

    public function update(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'nama_pelanggaran'          => 'required|string|max:255',
        //     'kategori'         => 'required|string|max:255',
        //     'nis'           => 'required|string',
        // ]);

        // if($validator->fails()){
		// 	return response()->json([
		// 		'status'	=> '0',
		// 		'message'	=> $validator->errors()
		// 	]);
		// }   

		//proses update data
		$pelanggaran = Pelanggaran::where('id', $request->id)->first();
		$pelanggaran->nama_pelanggaran 	     = $request->nama_pelanggaran;
        $pelanggaran->kategori        = $request->kategori;      
        $pelanggaran->poin        = $request->poin;
		$pelanggaran->save();


		return response()->json([
			'status'	=> '1',
			'message'	=> 'Data Pelanggaran berhasil diubah'
		], 201);
    }

    public function delete($id)
    {
        try{

            Pelanggaran::where("id", $id)->delete();

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
