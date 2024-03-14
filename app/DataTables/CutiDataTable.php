<?php

namespace App\DataTables;

use App\Models\Cuti;
use App\Models\User;
use App\Models\Karyawan;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Auth;
use Permission;

class CutiDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('nama_karyawan', function(Cuti $cuti) {
                return Karyawan::find($cuti->karyawan_id)->nama_lengkap;
            })
            ->addColumn('status', function(Cuti $cuti) {
                if($cuti->status == 0) {
                    return "Menunggu";
                }else{
                    if(Auth::user()->role_id == 1 || Auth::user()->role_id == 3) {
                        return view("cuti.partials.hrdpov.status", ["cuti"=>$cuti]);
                    }else {
                        return view("cuti.partials.modal",  ["cuti"=>$cuti]);
                    }
                }
                // if ($cuti->status != 0) {
                //     if($cuti->status == 1)
                //         return "Approved:$cuti->status";
                //     if($cuti->status == 2)
                //         if(Auth::user()->role_id != 3) { 
                //             // see reason button
                //             return view("cuti.partials.modal", [
                //                 "cuti"=>$cuti
                //             ]);
                //         }else {
                //             return "Rejected:$cuti->status";
                //         }
                // }else {
                //     return "waiting for HR approval";
                // }
            })
            ->addColumn('Jumlah (hari)', function(Cuti $cuti) {
                return $cuti->jumlah;
            })
            ->addColumn('reason_cuti', function(Cuti $cuti) {
                return view("cuti.partials.reason_detail", ["cuti"=>$cuti]);
            })
            ->addColumn('status_by', function(Cuti $cuti) {
                if($cuti->status == 1 or $cuti->status == 2) {
                    return $cuti->status_by;
                }else {
                    return ".....";
                }
            })
            ->addColumn('status_by (name)', function(Cuti $cuti) {
                if($cuti->status_by != null) {
                    return User::find($cuti->status_by)->name;
                }else {
                    return "n/a";
                }
            })

            ->addColumn('action', function(Cuti $cuti) {
                return view("cuti.partials.hrdpov.action", [
                    "cuti" => $cuti
                ]);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Cuti $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Cuti $model)
    {
       
            $user = Auth::user();

            if (Permission::for(['superadmin','hrd'])) {
                return $model->newQuery()->orderBy('status');
            }else {
                return $model::where([
                    ["karyawan_id", "=", $user->karyawan_id]
                ])->orderBy('status');
            }
        
        
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('cuti-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('create'),
                        Button::make('export'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $user = Auth::user();

        if($user->role_id == '1' || $user->role_id == '3') {
            return [
                Column::make('id'),
                // Column::make('karyawan_id'),
                Column::make('nama_karyawan'),
                Column::make('start'),
                Column::make('end'),
                Column::make('Jumlah (hari)'),
                Column::make('reason_cuti'),
                Column::make('status_by'),
                Column::make('status_by (name)'),
                Column::make("status"),
                Column::make('action')
            ];
        }else {
            return [
                // Column::computed('action')
                //       ->exportable(false)
                //       ->printable(false)
                //       ->width(60)
                //       ->addClass('text-center'),
                Column::make('id'),
                // Column::make('karyawan_id'),
                // Column::make('nama_karyawan'),
                Column::make('start'),
                Column::make('end'),
                Column::make('Jumlah (hari)'),
                Column::make('reason_cuti'),
                Column::make('status_by'),
                Column::make('status_by (name)'),
                Column::make("status"),
                // Column::make('created_at'),
                // Column::make('updated_at'),
            ];
        }
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Cuti_' . date('YmdHis');
    }
}
