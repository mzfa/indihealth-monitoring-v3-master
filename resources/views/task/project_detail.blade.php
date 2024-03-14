@extends('layouts/master_dashboard')
@section('title','Detail Plan Project ')
@section('content')
    @if(count($linked) > 0)
  <div class="callout callout-info">
      Dibawah ini adalah daftar projek yang terhubung dengan anda.
  </div>
@endif

<div class="row">
  <div class="col"></div>
  <div class="col"></div>
  <div class="col">
    <form action="{{route('task.project.list')}}" method="GET">
      <div class="form-group d-flex">
        <label for="name" class="mt-2 mr-5">Search:</label>
        <input type="text" class="form-control" id="name" name="search" placeholder="Masukan kata kunci..." value="{{Request::get('search')}}">
      </div>
    </form>
  </div>
</div>
  <div class="row">
    @if(count($linked) == 0)
        <div class="col-12" align='center'>
          <div class="alert alert-warning">
            Tidak ada projek yang terkait dengan anda.
          </div>
        </div>
    @endif

    

    @foreach($linked as $l)
      <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="card">
              <div class="card-header border-0">
                  <div class="d-flex justify-content-between">
                      <h3 class="card-title">
                          <b>{{$l->project->name}}</b>
                      </h3>
                  </div>
              </div>
              <div class="card-body" @if(count($l->project->plans) == 0) style="filter: blur(10px);" @endif>

                  <div class="row">

                      <div class="col-md-12 ">
                          <a
                              href="{{route('task',['project_id' => $l->project_id])}}"
                               class="btn btn-primary btn-sm mb-2">Detail Tugas</a>
                          @if(strtolower($l->project->name)!='internal')     
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
                          @endif
                      </div>
                      <div class="col-md-12">
                          <small>Anggota Tim</small><br>
                          {{-- <div style="width:100%; overflow-x:auto;"> --}}
                          @foreach(TaskHelper::showMember($l->project_id,14) as $sm)
                              <img @if(TaskHelper::cekPMProject($sm->user->id,$l->project_id)) style="border:#8bc34a 4px solid" title="Project Manager / Leader ({{$sm->user->name}}) " @else title="{{$sm->user->name}}" @endif   data-src="{{route('showFotoKaryawan',['file' => empty($sm->user->karyawan)?'default.jpg':$sm->user->karyawan->foto])}}" class="lazyload img-circle"  title="{{$sm->user->name}}" width="30px" height="30px" src=" data:image/gif;base64,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">
                          @endforeach
                        {{-- </div> --}}
                      </div>
                      <div class="col-12 mt-2">
                     
                      <a  target="_blank" href="{{route('cloud',['project_id' => $l->project_id,'upload' => 1])}}" class="btn btn-outline-primary btn-block btn-sm" style="  @if(count($l->project->plans) == 0) opacity: 0; @endif" ><i class="fas mr-2 fa-cloud"></i> Penyimpanan Dokumen</a>
                      <a target="_blank" href="{{route('notulensi',['id' => $l->project_id])}}" class="btn btn-outline-success btn-block btn-sm" style="  @if(count($l->project->plans) == 0) opacity: 0; @endif" ><i class="fas fa-sticky-note mr-2"></i>Buka Notulensi</a>
                    </div>

              </div>
              </div>

              @if(count($l->project->plans) == 0)
              <div class="overlay dark text-dark " align="center">

                <h5 class="bg-warning">&nbsp;&nbsp;Plan Project Belum ditetapkan oleh PM&nbsp;&nbsp;</h5>
              </div>
            @endif
              </div>


  </div>
  @endforeach
  </div>
  {{ $linked->links() }}
@endsection
