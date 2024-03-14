@if($data->status == "PENDING")
  <span class="badge badge-secondary"><i class="fas fa-spinner fa-spin"></i> Menunggu Konfirmasi</span>
@elseif($data->status == "UNDER-INVESTIGATION")
  <span class="badge badge-info"><i class="fas fa-search"></i> Sedang Diinsvestigasi</span>
@elseif($data->status == "FIXING")
  <span class="badge badge-primary"><i class="fas fa-wrench"></i> Sedang Memperbaiki</span>
@elseif($data->status == "DONE")
  <span class="badge badge-success"><i class="fas fa-check"></i> Selesai</span>
@elseif($data->status == "CONFIRMED")
  <span class="badge badge-success"><i class="fas fa-handshake"></i> Terkonfirmasi</span>
@else
  <span class="badge badge-light">Unknown</span>
@endif
