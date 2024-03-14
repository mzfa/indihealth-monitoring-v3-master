@extends('layouts/master_dashboard_guest')
@section('title','Projek yang dibagikan ('.$project->project->name.")")
@section('content')

<div class="row justify-content-md-center" >
  <div class="col-md-6 col-sm-12">
    <div class="card">
      <div class="card-header border-0">
        <div class="d-flex justify-content-between">
          <h3 class="card-title"><b>{{$project->project->name}}</b></h3>
        </div>
      </div>
      <div class="card-body">
        @if($project->shareable_task_dev)
        <div class="col-md-12">
          <a href="{{route('guest.project.task.development',['project_id' => $project->project_id])}}" class="">Task Development</a>
          <div class="progress progress-sm">
            <div class="progress-bar bg-blue" role="progressbar" aria-volumenow="{{$project->getPercentProject()}}" aria-volumemin="0" aria-volumemax="{{$project->getPercentProject()}}" style="width: {{$project->getPercentProject()}}%">
            </div>
          </div>
          <small>
          {{number_format($project->getPercentProject(),1,',','.')}}% Selesai
          </small>
        </div>
        @endif
        @if($project->shareable_task_mt)
        <div class="col-md-12">
          <a href="#" class="">Task Maintenance</a>
          <div class="progress progress-sm">
            <div class="progress-bar bg-blue" role="progressbar" aria-volumenow="0" aria-volumemin="0" aria-volumemax="100" style="width: 0%">
            </div>
          </div>
          <small>
          0% Selesai
          </small>
        </div>
        @endif 
        @if($project->shareable_notulen)
        <div class="col-md-12">
          <a href="{{route('guest.project.notulensi',['project_id' => $project->project_id])}}" class="btn btn-outline-primary btn-block">Notulensi</a>
        </div>
        @endif

         @if(!$project->shareable_notulen && !$project->shareable_task_mt && !$project->shareable_task_dev)
         <div class="col-md-12">
         <div class="alert alert-light" align="center">Tidak ada yang dibagikan</div>
         @endif
      </div>
    </div>
  </div>
</div>
@endsection
@section('javascript')

@endsection