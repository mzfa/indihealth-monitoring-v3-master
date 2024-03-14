@extends('layouts/master_dashboard_guest') @section('title') Projek Saya
@endsection @section('content')
<div class="callout callout-info">
    Dibawah ini adalah daftar projek yang terkait dengan akun anda.
</div>
<div class="row">
    @foreach($linked as $l)
    <div class="col-md-3 col-sm-6">
        <div class="card">
            <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">
                        <b>{{$l->project->name}}</b>
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    @if($l->shareable_task_dev)
                    <div class="col-md-12">
                        <a
                            href="{{route('guest.project.task.development',['project_id' => $l->project_id])}}"
                            class="">Task Development</a>
                        <div class="progress progress-sm">
                            <div
                                class="progress-bar bg-blue"
                                role="progressbar"
                                aria-volumenow="{{$l->getPercentProject()}}"
                                aria-volumemin="0"
                                aria-volumemax="{{$l->getPercentProject()}}"
                                style="width: {{$l->getPercentProject()}}%"></div>
                        </div>
                        <small>
                            {{number_format($l->getPercentProject(),1,',','.')}}% Selesai
                        </small>
                    </div>
                    @endif
                    {{-- @if($l->shareable_task_mt)
        <div class="col-md-12 mb-2">
          <a href="{{route('guest.project.task.maintenance',['project_id' => $l->project_id])}}"  class="btn btn-outline-primary btn-block">Task Maintenance</a>
        </div>
        @endif  --}}
                    @if($l->shareable_notulen)
                    <div class="col-md-12">
                        <a
                            href="{{route('guest.project.notulensi',['project_id' => $l->project_id])}}"
                            class="btn btn-outline-primary btn-block">Notulensi</a>
                    </div>
                    @endif @if(!$l->shareable_notulen && !$l->shareable_task_mt &&
                    !$l->shareable_task_dev)
                    <div class="col-md-12">
                        <div class="alert alert-light" align="center">Tidak ada yang dibagikan</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach @if(empty($linked))
    <div class="col-md-12">
        <div class="alert alert-warning">Tidak ada data yang dapat ditampilkan.</div>
    </div>
    @endif
</div>
@endsection
@section('javascript')
@endsection