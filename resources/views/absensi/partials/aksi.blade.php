<button type="button" title="Lihat Detail" onclick="details({{$data->id}})" class="btn btn-primary"><i id="icon-{{$data->id}}" class="fas fa-eye"></i></button>
@Permission(['superadmin'])
@if(!empty($data->request_absen_keluar) AND empty($data->is_req_acc))
  <button type="button" title="Setujui absen keluar" onclick="accAbsen({{$data->id}})" class="btn btn-success"><i id="icon-req-{{$data->id}}" class="fas fa-check"></i></button>
@endif
@endif
