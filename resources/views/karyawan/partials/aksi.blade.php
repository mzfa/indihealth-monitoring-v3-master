<div class="btn-group" role="group" aria-label="Basic example">
<a href="{{route('karyawan.edit',['id' => $data->id])}}" title="Ubah data" class="btn btn-warning"><i class="fas fa-edit"></i></a>
<a href="{{route('chart.karyawan.pilih',['id' => $data->id])}}" title="Detail Info"  class="btn btn-info"><i class="far fa-chart-bar"></i></a>
<a href="{{route('chart.karyawan.pilih',['id' => $data->id])}}" title="Lokasi Untuk Absen"  class="btn btn-primary"><i class="fas fa-map-marker-alt"></i></a>
<a href="#" title="hapus" data-toggle="modal" data-target="#delete-{{$data->id}}" class="btn btn-danger"><i class="fas fa-trash"></i></a>
</div>

<!-- Modal -->
<div class="modal fade" id="delete-{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Konfirmasi Penghapusan {{$data->nama_lengkap}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" align="center">
        <label>Apakah anda yakin ingin menghapus ini?</label>
        <form action="{{route('karyawan.hapus')}}" method="POST">
          @csrf
          <input type="hidden" name="id" value="{{$data->id}}">
        	<button type="submit" class="btn btn-danger"><i class="fas fa-trash mr-2"></i>Hapus</button>
        	<button type="button" data-dismiss="modal" class="btn btn-secondary">Batal</button>
        </form>
      </div>
     
    </div>
  </div>
</div>