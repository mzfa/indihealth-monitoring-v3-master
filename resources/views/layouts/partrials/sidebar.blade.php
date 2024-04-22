@Permission(['superadmin','hrd','employee'])
<li class="nav-item">
	<a href="{{route('home')}}" class="nav-link  {{Route::currentRouteName() == 'home' ? 'active':null}}">
		<i class="fas fa-camera mr-2 "></i>
		<p>Presensi Online</p>
	</a>
</li>

<li class="nav-item item-sidebar">
	<a href="{{route('absensi.sendiri')}}" class="nav-link  {{Route::currentRouteName() == 'absensi.sendiri' ? 'active':null}}">
		<i class="fa fa-calendar-check  mr-2 "></i>
		<p>Absensi Saya</p>
	</a>
</li>
<li class="nav-item item-sidebar">
	<a href="{{route('meeting.index')}}" class="nav-link {{Route::currentRouteName() == 'meeting.index' ? 'active':null}}">
		<i class="fas fa-comments mr-2  "></i>
		<p>Ruang Meeting </p>
	</a>
</li>
{{-- <li class="nav-item item-sidebar">
	<a href="{{route('cloud')}}" class="nav-link {{Route::currentRouteName() == 'cloud' ? 'active':null}}">
		<i class="fas fa-cloud mr-2  "></i>
		<p>Penyimpanan Online</p>
	</a>
</li> --}}

@endPermission

@Permission(["superadmin","hrd", "employee"])

<li class="nav nav-item item-sidebar has-treeview {{Route::currentRouteName() == 'karyawan.cuti' || Route::currentRouteName() == 'izin'  ? 'menu-is-opening menu-open':null}}">
	<a href="#" class="nav-link">
		<i class="nav-icon fas fa-calendar-check mr-2"></i>
		@isset(auth()->user()->karyawan->join_date)
		<p>Pengajuan @if(UserHelper::joinAge(auth()->user()->karyawan->join_date) >= 1) Cuti dan @endif Izin 
			<i class="right fas fa-angle-left"></i>
		</p>
		@else
		<p>Pengajuan  Cuti dan Izin 
			<i class="right fas fa-angle-left"></i>
		</p>
		@endisset
	</a>
	<ul class="nav nav-treeview">
		@isset(auth()->user()->karyawan->join_date)
			@if(UserHelper::joinAge(auth()->user()->karyawan->join_date) >= 1)
			<li class="nav-item item-sidebar">
				<a href="{{route('cuti')}}" class="nav-link {{Route::currentRouteName() == 'karyawan.cuti' ? 'active':null}}">
					<i class="far fa-circle nav-icon"></i>
					<p>Cuti @if(UserHelper::cutiPending() > 0)<sup><span class="badge badge-danger">{{UserHelper::cutiPending()}}@endif</p>
				</a>
			</li>
			@endif
		@endisset
		<li class="nav-item item-sidebar">
			<a href="{{route('izin')}}" title="On Development" class="nav-link {{Route::currentRouteName() == 'izin' ? 'active':null}}">
				<i class="far fa-circle nav-icon"></i>
				<p>Izin / Sakit</p>
			</a>
		</li>
		@Permission(['superadmin','hrd'])
		<li class="nav-item item-sidebar">
			<a href="{{route('izin.data')}}" title="On Development" class="nav-link {{Route::currentRouteName() == 'izin.data' ? 'active':null}}">
				<i class="far fa-circle nav-icon"></i>
				<p>Data  Izin / Sakit</p>
			</a>
		</li>
		<li class="nav-item item-sidebar">
			<a href="{{route('absen_diluar')}}" title="On Development" class="nav-link {{Route::currentRouteName() == 'absen_diluar' ? 'active':null}}">
				<i class="far fa-circle nav-icon"></i>
				<p>Izin Absen Diluar</p>
			</a>
		</li>
		@endPermission
	
	
		
	</ul>
</li>
@endPermission


<li class="nav nav-item item-sidebar has-treeview {{Route::currentRouteName() == 'task' || Route::currentRouteName() == 'task.maintenance' || Route::currentRouteName() == 'notulensi'  ? 'menu-is-opening menu-open':null}}">
	<a href="#" class="nav-link">
		<i class="nav-icon fas fa-tasks mr-2"></i>
		<p>Projek Dan Tugas
			<i class="right fas fa-angle-left"></i>
		</p>
	</a>
	<ul class="nav nav-treeview">
		@Permission(['superadmin','employee','hrd'])
		<li class="nav-item item-sidebar">
			<a href="{{route('task.project.list')}}" class="nav-link {{Route::currentRouteName() == 'task.project.list' ? 'active':null}}">
				<i class="far fa-circle nav-icon"></i>
				<p>Task Project</p>
			</a>
		</li>
		<li class="nav-item item-sidebar">
			<a href="{{route('task.maintenance')}}" class="nav-link {{Route::currentRouteName() == 'task.maintenance' ? 'active':null}}">
				<i class="far fa-circle nav-icon"></i>
				<p>Task Maintenance</p>
			</a>
		</li>
		@if(TaskHelper::cekPM())
			<li class="nav-item item-sidebar">
				<a href="{{route('project.monitoring')}}" class="nav-link {{Route::currentRouteName() == 'project.monitoring' ? 'active':null}}">
					<i class="far fa-circle nav-icon"></i>
					<p>Manajemen Proyek</p>
				</a>
			</li>
		@endif
		@endPermission
		<li class="nav-item item-sidebar">
			<a href="#" data-toggle="modal" data-target="#modal-select-projek-notulen" class="nav-link {{Route::currentRouteName() == 'notulensi' ? 'active':null}}">
				<i class="far fa-circle nav-icon "></i>
				<p>Notulensi</p>
			</a>
		</li>
	</ul>
</li>
@Permission(['superadmin','employee'])
<li class="nav-item item-sidebar">
	<a href="{{route('ticketing.maintenance')}}" class="nav-link {{Route::currentRouteName() == 'ticketing.maintenance' ? 'active':null}}">
		<i class="fas fa-flag mr-2 "></i>
		<p>Kelola Ticketing</p>
	</a>
</li>
@endPermission
@Permission(['superadmin','owner','hrd'])
<li class="nav nav-item item-sidebar has-treeview {{Route::currentRouteName() == 'chart.absensi' || Route::currentRouteName() == 'chart.karyawan'  ? 'menu-is-opening menu-open':null}}">
	<a href="#" class="nav-link ">
		<i class="far fa-chart-bar mr-2"></i>
		<p>Chart
			<i class="right fas fa-angle-left"></i>
		</p>
	</a>
	<ul class="nav nav-treeview">
		<li class="nav-item item-sidebar">
			<a href="{{route('chart.absensi')}}" class="nav-link {{Route::currentRouteName() == 'chart.absensi' ? 'active':null}}">
				<i class="far fa-circle nav-icon"></i>
				<p>Absensi</p>
			</a>
		</li>
		<li class="nav-item item-sidebar">
			<a href="{{route('chart.karyawan')}}" class="nav-link {{Route::currentRouteName() == 'chart.karyawan' ? 'active':null}}">
				<i class="far fa-circle nav-icon"></i>
				<p>Karyawan</p>
			</a>
		</li>
		<li class="nav-item item-sidebar">
			<a href="#" href="#" data-toggle="modal" data-target="#modal-select-karyawan-chart" class="nav-link {{Route::currentRouteName() == 'chart.karyawan.pilih' ? 'active':null}}">
				<i class="far fa-circle nav-icon"></i>
				<p>Lihat detail Karyawan</p>
			</a>
		</li>
	</ul>
</li>
@endPermission
@Permission(['superadmin','hrd','owner'])
<li class="nav-item item-sidebar">
	<a href="#" data-toggle="modal" data-target="#modal-select-karyawan" class="nav-link {{Route::currentRouteName() == 'task.karyawan' ? 'active':null}}">
		<i class="fas fa-tasks mr-2  "></i>
		<p>Lihat Task Karyawan</p>
	</a>
</li>
<li class="nav-item item-sidebar">
	<a href="{{route('absen')}}" class="nav-link {{Route::currentRouteName() == 'absen' ? 'active':null}}">
		<i class="fas fa-calendar-check mr-2  "></i>
		<p>Kelola Absensi</p>
	</a>
</li>

@Permission(['superadmin','hrd'])
<li class="nav-item item-sidebar">
	<a href="{{route('karyawan')}}" class="nav-link {{Route::currentRouteName() == 'karyawan' ? 'active':null}}">
		<i class="fas fa-user-tie mr-2  "></i>
		<p>Kelola Karyawan</p>
	</a>
</li>
@endPermission
@Permission(['superadmin','hrd','owner'])
<li class="nav-item item-sidebar">
	<a href="{{route('penggajian')}}" class="nav-link {{Route::currentRouteName() == 'penggajian' ? 'active':null}}">
		<i class="fas fa-user-tie mr-2  "></i>
		<p>Kelola Penggajian</p>
	</a>
</li>
@endPermission
@Permission(['superadmin'])
<li class="nav-item item-sidebar">
	<a href="{{route('task.maintenance.level')}}" class="nav-link {{Route::currentRouteName() == 'task.maintenance.level' ? 'active':null}}">
		<i class="fas fa-layer-group mr-2  "></i>
		<p>Kelola Level Maintenance</p>
	</a>
</li>
@endPermission
@endPermission
@Permission(['superadmin'])
<li class="nav-item item-sidebar">
	<a href="{{route('project')}}" class="nav-link {{Route::currentRouteName() == 'project' ? 'active':null}}">
		<i class="fas fa-project-diagram mr-2 "></i>
		<p>Kelola Projek</p>
	</a>
</li>

<li class="nav-item item-sidebar has-treeview {{Route::currentRouteName() == 'pengguna' || Route::currentRouteName() == 'guest'  ? 'menu-is-opening menu-open':null}}">
	<a href="#" class="nav-link ">
		<i class="nav-icon fas fa-users"></i>
		<p>
			Kelola Pengguna
			<i class="right fas fa-angle-left"></i>
		</p>
	</a>
	<ul class="nav nav-treeview">
		<li class="nav-item item-sidebar">
			<a href="{{route('pengguna')}}" class="nav-link {{Route::currentRouteName() == 'pengguna' ? 'active':null}}">
				<i class="far fa-circle nav-icon"></i>
				<p>Pengguna Sistem</p>
			</a>
		</li>
		<li class="nav-item item-sidebar">
			<a href="{{route('guest')}}" class="nav-link {{Route::currentRouteName() == 'guest' ? 'active':null}}">
				<i class="far fa-circle nav-icon"></i>
				<p>Akun Tamu</p>
			</a>
		</li>
	</ul>
</li>
<li class="nav-item item-sidebar has-treeview {{Route::currentRouteName() == 'config.pulang' || Route::currentRouteName() == 'config.absensi'  ? 'menu-is-opening menu-open':null}}">
	<a href="#" class="nav-link">
		<i class="nav-icon fas fa-wrench mr-2"></i>
		<p>Setting<i class="right fas fa-angle-left"></i>
		</p>
	</a>
	<ul class="nav nav-treeview">
		<li class="nav-item item-sidebar">
			<a href="{{route('config.roles')}}" class="nav-link {{Route::currentRouteName() == 'config.roles' ? 'active':null}}">
				<i class="far fa-circle nav-icon"></i>
				<p>Roles</p>
			</a>
		</li>

		<li class="nav-item item-sidebar">
			<a href="{{route('config.url.mapping')}}" class="nav-link {{Route::currentRouteName() == 'config.url.mapping' ? 'active':null}}">
				<i class="far fa-circle nav-icon"></i>
				<p>Pages Mapping</p>
			</a>
		</li>

		<li class="nav-item item-sidebar">
			<a href="{{route('config.penggajian')}}" class="nav-link {{Route::currentRouteName() == 'config.penggajian' ? 'active':null}}">
				<i class="far fa-circle nav-icon"></i>
				<p>Penggajian</p>
			</a>
		</li>
		<li class="nav-item item-sidebar">
			<a href="{{route('config.absensi')}}" class="nav-link {{Route::currentRouteName() == 'config.absensi' ? 'active':null}}">
				<i class="far fa-circle nav-icon"></i>
				<p>Absensi</p>
			</a>
		</li>
		<li class="nav-item item-sidebar">
			<a href="{{route('config.sys')}}" class="nav-link {{Route::currentRouteName() == 'config.absensi' ? 'active':null}}">
				<i class="far fa-circle nav-icon"></i>
				<p>Sistem</p>
			</a>
		</li>
		<li class="nav-item item-sidebar">
			<a href="{{route('config.pulang')}}" class="nav-link {{Route::currentRouteName() == 'config.pulang' ? 'active':null}}">
				<i class="far fa-circle nav-icon"></i>
				<p>Pulang</p>
			</a>
		</li>
	</ul>
</li>
<li class="nav-item item-sidebar">
	<a href="{{route('logs')}}" class="nav-link {{Route::currentRouteName() == 'logs' ? 'active':null}}">
		<i class="fas fa-history mr-2 "></i>
		<p>Log Sistem</p>
	</a>
</li>
{{-- <li class="nav-item item-sidebar">
	<a href="{{route('system.update')}}" class="nav-link {{Route::currentRouteName() == 'system.update' ? 'active':null}}">
	<i class="fas fa-sync mr-2"></i>
		<p>Update System</p>
	</a>
</li> --}}
<li class="nav-item item-sidebar">
	<a href="{{route('appmon')}}" class="nav-link {{Route::currentRouteName() == 'appmon' ? 'active':null}}">
		<i class="fas fa-desktop mr-2"></i>
		<p>Application Monitoring</p>
	</a>
</li>
@endPermission
@if(!UserHelper::requiredAbsen())
	<script>
		$(".item-sidebar").hide();
	</script>
@endif
