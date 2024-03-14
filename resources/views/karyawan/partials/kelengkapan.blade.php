@if(!empty($data->no_ktp))
<span style="cursor:default;" class="badge badge-success" title="No KTP sudah diinputkan ">KTP</span>
@else
<span style="cursor:default;" class="badge badge-secondary" title="No KTP belum diinputkan">KTP</span>
@endif

@if(!empty($data->no_npwp))
<span style="cursor:default;" class="badge badge-success" title="No NPWP sudah diinputkan">NPWP</span>
@else
<span style="cursor:default;" class="badge badge-secondary" title="No NPWP belum diinputkan">NPWP</span>
@endif
@if(!empty($data->cv))
 <a href="{{route('karyawan.cv',['cv' => $data->cv])}}" title="Tampilkan CV" target="_blank">
	<span class="badge badge-success" title="CV / Portofolio / Resume sudah diupload">CV</span>
</a>
@else
<span style="cursor:default;" class="badge badge-secondary" title="CV / Portofolio / Resume belum diupload">CV</span>
@endif
