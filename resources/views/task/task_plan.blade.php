@extends('layouts/master_dashboard')
@section('title','Detail Plan Project '.$project->name)
@section('content')
  @if(count($project->projectPlanDetail) == 0)

    <div class="callout callout-warning">
       Detail Tugas masih kosong
    </div>
  @else
  <div class="callout callout-info">
      Dibawah ini adalah detail dari project plan "{{$project->name}}"<hr> Klik untuk melihat / memberikan tugas
  </div>
<div class="container">
    <div class="row">
      @foreach($project->projectPlanDetail as $p)
        <div class="col-md-3" >
          <a href="{{route('project.plan.tasks',['project_id' => $project->project_id,'plan_id' => $p->id])}}" >
          <div class="info-box">
            <span class="info-box-icon bg-success">{{TaskHelper::initials($p->name)}}</span>
            <div class="info-box-content">
            <span class="info-box-text">{{$p->name}}</span>
            <span class="info-box-number"><small>Progress</small><div class="progress progress-sm">
                <div
                    class="progress-bar bg-blue"
                    role="progressbar"
                    aria-volumenow="50"
                    aria-volumemin="0"
                    aria-volumemax="50"
                    style="width: 50%"></div>
                  </div></span>
            </div>

          </div>
        </a>
        </div>
      @endforeach
</div>
</div>
@endif
@endsection
