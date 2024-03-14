<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Models\Karyawan;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Auth;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;

class CutiExport implements  FromView,ShouldAutoSize,WithColumnFormatting,WithEvents
{
   use Exportable;

	private $min;
	private $max;

	function __construct($year)
	{
		$this->year = $year;
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

        $data = Karyawan::where('tipe_karyawan','FULL-TIME')->whereHas('jabatan',function($query)
              {
                $query->whereNotIn('nama',['Owner']);
              })->whereNull('resign_date')->get();


        return view('excel.exports.cuti',['year' => $this->year,'karyawan' => $data]);
    }

    public function registerEvents(): array
    {
        $count = Karyawan::where('tipe_karyawan','FULL-TIME')->whereHas('jabatan',function($query)
              {
                $query->whereNotIn('nama',['Owner']);
              })->whereNull('resign_date')->count();
        return [
            AfterSheet::class    => function(AfterSheet $event)use($count) {
                 $styleArray = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ];

                $event->sheet->getStyle('A3:P'.($count+3))->applyFromArray($styleArray);
            },
        ];
    }

}
