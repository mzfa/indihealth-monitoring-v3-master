@extends('layouts/master_dashboard')
@section('title','Project Plans')
@section('content')
  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" id="planProject-tab" data-toggle="tab" href="#planProject" role="tab" aria-controls="planProject" aria-selected="true">Plan Project</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" hrid="gantt-tab" data-toggle="tab" href="#gantt" role="tab" aria-controls="gantt" aria-selected="false">Gantt Chart <span class="badge badge-danger">BETA</span></a>
    </li>
  </ul>
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="planProject" role="tabpanel" aria-labelledby="planProject-tab">
      <div class="callout callout-success">
        Dibawah ini adalah rencana dari projek "{{$project->name}} ({{$project->client}})".<br> <p><b>Deskripsi Projek:</b><br>{{$project->description}}</p> <hr>Klik  card dibawah ini untuk melihat detail tugas
      </div>
      <div class="container">
          <div class="row">
              <div class="col-md-12" >

                  <div class="main-timeline">
                    <?php $i=1; ?>
                    @foreach($project->plans as $ps)

                      <div class="timeline">
                          <a href="{{route('project.plan.detail.view',['project_id' => $ps->project_id,'plan_id' => $ps->id])}}" class="timeline-content">
                              <div class="timeline-icon">
                                {{$i++}}

                              </div>
                              <div class="timeline-year">   {{number_format(TaskHelper::persenPlan($ps->id),0,',','.')}}%  </div>
                              <div class="inner-content">
                                  <h3 class="title">{{$ps->name}}</h3>
                                  <p class="description">
                                    <b>Mulai</b> : {{$ps->start_date}} |
                                    <b>Selesai</b> : {{$ps->end_date}}<br>

                                    <b>Jumlah Sub-Plan</b> : {{number_format(count($ps->projectPlanDetail))}}
                                    <hr>
                                    <small>Progress</small>
                                    <div class="progress progress-sm">
                                        <div
                                            class="progress-bar bg-blue"
                                            role="progressbar"
                                            aria-volumenow="{{number_format(TaskHelper::persenPlan($ps->id),0,',','.')}}"
                                            aria-volumemin="0"
                                            aria-volumemax="{{number_format(TaskHelper::persenPlan($ps->id),0,',','.')}}"
                                            style="width: {{number_format(TaskHelper::persenPlan($ps->id),0,',','.')}}%"></div>
                                    </div>

                                    </p>
                              </div>
                          </a>
                      </div>
                    @endforeach

                  </div>
              </div>
          </div>
      </div>
    </div>
    <div class="tab-pane fade" id="gantt" role="tabpanel" aria-labelledby="gantt-tab">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <textarea id="jsonData" class="d-none" rows="3" cols="100">{{$task_plan}}</textarea>
            <div class="granttChart" style="width: 100%;margin: 20px auto;border: 14px solid #ddd;position: relative;-webkit-border-radius: 6px;-moz-border-radius: 6px;border-radius: 6px;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    $(function() {
      let jsonData = $('textarea#jsonData').val();
      jsonData = JSON.parse(jsonData);
      var demoSource = jsonData;
      console.log(jsonData)

      // shifts dates closer to Date.now()
      // var offset = new Date().setHours(0, 0, 0, 0) - new Date(demoSource[0].values[0].from).setDate(35);
      // for (var i = 0, len = demoSource.length, value; i < len; i++) {
      //     demoSource[i].values[0].from += offset;
      //     demoSource[i].values[0].to += offset;
      // }


      $(".granttChart").gantt({
        source: demoSource,
        navigate: "scroll",
        scale: "weeks",
        maxScale: "months",
        minScale: "hours",
        itemsPerPage: 10,
        scrollToToday: false,
        useCookie: true,
      });

      setTimeout(() => {
        $('.nav-zoomIn').trigger('click');
      }, 2000);
    });
  </script>
@endsection
