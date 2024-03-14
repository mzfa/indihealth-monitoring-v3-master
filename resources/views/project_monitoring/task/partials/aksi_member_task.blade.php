
 <div class="btn-group" role="group" aria-label="Group">

            <button type="button" class="btn mr-2 btn-danger btn-sm" onclick="memberUnlink({{$data->id}})"  id="delete-act-{{$data->id}}" data-id="{{$data->id}}">
                <i id="member-{{$data->id}}" class="fas  fa-unlink ">
                </i>
            </button>
            <button type="button" class="btn btn-success btn-sm"  title="Log Tugas" onclick="memberLog({{$data->user_id}},'{{strip_tags($data->member->karyawan->nama_lengkap)}}')"  id="memberlog-act-{{$data->id}}" data-id="{{$data->id}}">
                <i id="member-log-{{$data->id}}" class="fas  fa-tasks">
                </i>
            </button>
        </div>
