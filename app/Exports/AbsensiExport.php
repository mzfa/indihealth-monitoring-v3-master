<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Models\Absensi;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Auth;
use Maatwebsite\Excel\Concerns\WithEvents;

class AbsensiExport implements  FromView,ShouldAutoSize,WithColumnFormatting
{
   use Exportable;

    private $min;
    private $max;
    private $karyawan_id;

    function __construct($date_start=0,$date_end=1,$karyawan_id = null)
    {
        $this->min = $date_start;
        $this->max = $date_end;
        $this->karyawan_id = $karyawan_id;
    }
    public function columnFormats(): array
    {
        return [
            'B' => "@",
        ];
    }
    /** 
    $sheet->cells('A1:A5', function($cells) {
    * @return \Illuminate\Support\Collection
    */
    public function view(): view
    {       
        if($this->karyawan_id != "Semua" AND !empty($this->karyawan_id))
        {
            $data = Absensi::whereBetween('tanggal', [$this->min, $this->max])->where('karyawan_id',$this->karyawan_id)->orderBy('tanggal','DESC')->get();
            $avg_hours = Absensi::whereBetween('tanggal', [$this->min, $this->max])->where('karyawan_id',$this->karyawan_id)->avg('jam_kerja');
        }
        else{
            $data = Absensi::whereBetween('tanggal', [$this->min, $this->max])->orderBy('tanggal','DESC')->get();
            $avg_hours = Absensi::whereBetween('tanggal', [$this->min, $this->max])->avg('jam_kerja');
        }
        


        return view('excel.exports.absensi',['data' => $data,'avg_hours' => $avg_hours,'start' => $this->min,'end' => $this->max]);
    }

}
