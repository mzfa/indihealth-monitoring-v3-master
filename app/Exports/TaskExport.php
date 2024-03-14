<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Models\Task;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Auth;
use Maatwebsite\Excel\Concerns\WithEvents;

class TaskExport implements  FromView,ShouldAutoSize,WithColumnFormatting
{
   use Exportable;

	private $min;
	private $max;

	function __construct($date_start=0,$date_end=1)
	{
		$this->min = $date_start;
		$this->max = $date_end;
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

        $data = Task::whereBetween('tanggal', [$this->min, $this->max])->orderBy('karyawan_id','DESC')->orderBy('tanggal','DESC')->get();


        return view('excel.exports.task',['data' => $data,'start' => $this->min,'end' => $this->max]);
    }

}
