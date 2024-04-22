<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LinkedProject;
use Hash;
use App\Helpers\JSon;
use App\Models\Karyawan;
use App\Models\Penggajian;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class PenggajianController extends Controller
{

   public function index()
   {
      if(auth()->user()->role_id == 5){
         $penggajian = DB::table('penggajian')->where('is_delete', 0)->where('status_penggajian', 'Diajukan')->get();
      }else{
         $penggajian = DB::table('penggajian')->where('is_delete', 0)->get();
      }
      return view('penggajian.index', compact('penggajian'));
   }

   public function detail($id)
   {
      // dump(auth()->user());
      $data = Karyawan::orderBy('created_at', 'DESC')->get();
      $datanya = [];
      $tanggal_awal = date("Y-m-01");
      $periode = date('2023-12');
      if (isset($_GET['periode'])) {
         $periode = $_GET['periode'];
      }
      $tanggal_akhir = date("Y-m-t", strtotime($periode));

      $jsonString = file_get_contents(storage_path('app/config/penggajian.json'));
      $dataJson = json_decode($jsonString, true);
      $gaji_pokok = $dataJson['gaji_pokok'];

      $tanggalan = '';
      $total_hari = 0;
      for ($i = 1; $i <= 31; $i++) {
         $tgl = $periode . '-' . sprintf('%02d', $i);
         $hari = date('l', strtotime($tgl));
         if ($hari != "Sunday" && $hari != "Saturday") {
            $tanggalan .= "'$tgl',";
            $total_hari += 1;
         }
         if ($tgl == $tanggal_akhir) {
            break;
         }
      }
      $tanggalan = substr($tanggalan, 0, -1);
      foreach ($data as $item) {
         $absen = DB::select("SELECT * FROM absensi WHERE karyawan_id = '$item->id' and tanggal in ($tanggalan)");
         $total_absen = 0;
         foreach ($absen as $item2) {
            $total_absen += 1;
         }
         $data_penggajian = DB::select("SELECT * FROM penggajian_detail WHERE karyawan_id = '$item->id' and penggajian_id='$id'");
         // echo "SELECT * FROM penggajian_detail WHERE karyawan_id = '$item->id' and penggajian_id='$id'";
         // dd($data_penggajian);
         $potongan = ($total_hari - $total_absen) * $dataJson['potongan_absen'];
         $datanya[] = [
            'id' => $item->id,
            'penggajian_detail_id' => $data_penggajian[0]->id ?? '',
            'status_penggajian' => $data_penggajian[0]->status_gaji ?? 'Belum di ajukan',
            'nip' => $item->nip,
            'nama_lengkap' => $item->nama_lengkap,
            'ttl' => $item->tempat_lahir . ', ' . date('d-m-Y', strtotime($item->tanggal_lahir)),
            'jabatan' => $item->jabatan->nama,
            'potongan' => $data_penggajian[0]->potongan ?? $potongan,
            'gaji_pokok' => $gaji_pokok,
            'total_terima' => $data_penggajian[0]->total_terima ?? $gaji_pokok - $potongan,
         ];
      }
      $data = DB::table('penggajian_detail')->where('id', $id)->get();
      return view('penggajian.detail', compact('datanya','data','id'));
   }

   public function show(Request $request)
   {
      $validate = [
         'id' => "required|exists:\App\Models\penggajian,id",
      ];
      $this->validate($request, $validate);
      $data['data'] = Penggajian::where('id', $request->id)->first();
      $data['messages'] = "Sukses menampilkan penggajian";


      return JSon::response(200, 'penggajian', $data, []);
   }

   public function save(Request $request)
   {
      $validate = [
         'nama_penggajian' => "required",
         'keterangan' => "required",
      ];
      $this->validate($request, $validate);

      $data = [
         'created_at' => now(),
         'nama_penggajian' => $request->nama_penggajian,
         'keterangan' => $request->keterangan,
         'status_penggajian' => '-',
      ];

      DB::table('penggajian')->insert($data);

      return Redirect::back()->with(['success' => 'Berhasil menyimpan penggajian!']);
   }
   public function pengajuan(Request $request)
   {
      // dd($request);
      if ($request->form_jenis == 'insert') {
         $data = [];
         foreach($request->karyawan_id as $key => $item){
            $data[] = [
               'penggajian_id' => $request->id,
               'karyawan_id' => $item,
               'gaji_pokok' => $request->gaji_pokok[$key],
               'potongan' => $request->potongan[$key],
               'total_terima' => $request->total_terima[$key],
               'status_gaji' => 'diproses',
               'updated_by' => auth()->user()->id,
            ];
         }
         DB::table('penggajian_detail')->insert($data);
         $data = [
            'status_penggajian' => 'Diajukan',
         ];
         DB::table('penggajian')->where(['id' => $request->id])->update($data);
         return Redirect::back()->with(['success' => 'Berhasil mengajukan penggajian!']);
      }elseif ($request->form_jenis == 'acc') {
         foreach($request->status_gaji as $key => $item){
            if($request->status == 'terima'){
               $status_gaji = 'diterima';
            }else{
               $status_gaji = 'ditolak';
            }
            // dd($status_gaji);
            $data = [
               'status_gaji' => $status_gaji,
               'updated_by' => auth()->user()->id,
            ];
            DB::table('penggajian_detail')->where(['id' => $item])->update($data);
         }
         return Redirect::back()->with(['success' => 'Penggajian berhasil '.$status_gaji]);
      }else{
         foreach($request->karyawan_id as $key => $item){
            $data = [
               'potongan' => $request->potongan[$key],
               'total_terima' => $request->total_terima[$key],
               'status_gaji' => 'diperbaiki',
               'updated_by' => auth()->user()->id,
            ];
            // dd($data,$request->penggajian_detail_id[$key]);
            DB::table('penggajian_detail')->where(['id' => $request->penggajian_detail_id[$key]])->update($data);
         }
         return Redirect::back()->with(['success' => 'Penggajian berhasil diperbaiki!']);


      }

   }

   public function edit($id)
   {
      // return('ok');
      $text = "Data tidak ditemukan";
      if ($data = DB::select("SELECT * FROM penggajian WHERE id='$id'")) {
         $text =
            '<div class="mb-3">' .
            '<label for="staticEmail" class="form-label">Nama Penggajian</label>' .
            '<input type="text" class="form-control" id="nama_penggajian" name="nama_penggajian" value="' . $data[0]->nama_penggajian . '" required>' .
            '</div>' .
            '<div class="mb-3">' .
            '<label for="staticEmail" class="form-label">Keterangan</label>' .
            '<input type="text" class="form-control" id="keterangan" name="keterangan" value="' . $data[0]->keterangan . '" required>' .
            '</div>' .
            '<input type="hidden" class="form-control" id="penggajian_id" name="penggajian_id" value="' . $data[0]->id . '" required>';
      }
      return $text;
      // return view('progress.edit');
   }

   public function update(Request $request)
   {
      $validate = [
         'nama_penggajian' => "required",
         'keterangan' => "required",
      ];
      $this->validate($request, $validate);

      $data = [
         'created_at' => now(),
         'nama_penggajian' => $request->nama_penggajian,
         'keterangan' => $request->keterangan,
         'updated_by' => auth()->user()->id,
      ];
      $penggajian_id = $request->penggajian_id;
      DB::table('penggajian')->where(['id' => $penggajian_id])->update($data);

      return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
      // return JSon::response(200, 'penggajian', $data, []);
   }
   public function delete($id)
   {
      $data = [
         'is_delete' => 1,
      ];
      DB::table('penggajian')->where(['id' => $id])->update($data);

      return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
      // return JSon::response(200, 'penggajian', $data, []);
   }
   public function slip_gaji($id)
   {
      $data = DB::table('penggajian_detail')->select('penggajian_detail.*','penggajian.nama_penggajian','karyawan.nama_lengkap','karyawan.tempat_lahir','karyawan.tanggal_lahir','karyawan.no_npwp','karyawan.nip','karyawan.no_ktp','karyawan.tipe_karyawan','karyawan.jabatan_id')->leftJoin('penggajian', 'penggajian_detail.penggajian_id', 'penggajian.id')->leftJoin('karyawan', 'penggajian_detail.karyawan_id', 'karyawan.id')->where(['penggajian_detail.id' => $id])->first();
      // dd($data);
      return view('penggajian.slip_gaji', compact('data','id'));
      // return JSon::response(200, 'penggajian', $data, []);
   }

   public function getDatapenggajian(Request $request)
   {

      $data = Penggajian::get();
      return \DataTables::of($data)
         ->editColumn("created_at", function ($data) {
            return $data->created_at;
         })
         ->addColumn('status', function ($data) {
            if ($data->is_banned && !empty($data->is_delete)) {
               return "<span class='badge badge-warning'>Non-aktif</span>";
            } elseif (!$data->is_banned && !empty($data->is_delete)) {
               return "<span class='badge badge-success'>Aktif</span>";
            } elseif (empty($data->is_delete)) {
               return "<span class='badge badge-light'>Belum diaktifasi</span>";
            }
         })
         ->addColumn('aksi', function ($data) {
            return view('penggajian.partials.aksi')->with(['data' => $data])->render();
         })
         ->rawColumns(['aksi', 'status'])
         ->make(true);
   }
   private function countProject($id)
   {
      return LinkedProject::where('penggajian_id', $id)->count();
   }
   private function params($request)
   {
      $params = [
         'name'                  => $request->name,
         'nama_perusahaan'       => $request->nama_perusahaan,
         'jabatan'            => $request->jabatan,
         'username'             => $request->username,
         'email'                => $request->email,
         'no_telp'             => $request->no_telp,
         'updated_by'          => auth()->user()->id,
      ];

      if (!empty($request->password)) {
         $params['password'] = Hash::make($request->password);
      }

      return $params;
   }
}
