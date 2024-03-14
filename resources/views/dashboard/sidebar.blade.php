@Permission(['superadmin','hrd','employee'])
<li class="nav-item">
	<a href="{{route('home')}}" class="nav-link  {{Route::currentRouteName() == 'home' ? 'active':null}}">
		<i class="fas fa-camera mr-2 ml-1"></i>
		<p>Presensi Online</p>
	</a>
</li>
<li class="nav-item">
	<a href="{{route('absensi.sendiri')}}" class="nav-link  {{Route::currentRouteName() == 'absensi.sendiri' ? 'active':null}}">
		<i class="fas fa-calendar-check  mr-2 ml-1"></i>
		<p>Absensi Saya</p>
	</a>
</li>
<li class="nav-item">
	<a href="{{route('meeting.index')}}" class="nav-link {{Route::currentRouteName() == 'meeting.index' ? 'active':null}}">
		<i class="fas fa-comment-dots mr-2 ml-1 "></i>
		<p>Ruang Meeting</p>
	</a>
</li>
@endPermission

<li class="nav nav-item has-treeview {{Route::currentRouteName() == 'task' || Route::currentRouteName() == 'task.maintenance' || Route::currentRouteName() == 'notulensi'  ? 'menu-is-opening menu-open':null}}">
	<a href="#" class="nav-link">
		<i class="nav-icon fas fa-tasks mr-2"></i>
		<p>Task Projek
			<i class="right fas fa-angle-left"></i>
		</p>
	</a>
	<ul class="nav nav-treeview">
		@Permission(['superadmin','employee','hrd'])
		<li class="nav-item">
			<a href="{{route('task')}}" class="nav-link {{Route::currentRouteName() == 'task' ? 'active':null}}">
				<i class="far fa-circle nav-icon"></i>
				<p>Task Development</p>
			</a>
		</li>
		<li class="nav-item">
			<a href="{{route('task.maintenance')}}" class="nav-link {{Route::currentRouteName() == 'task.maintenance' ? 'active':null}}">
				<i class="far fa-circle nav-icon"></i>
				<p>Task Maintenance</p>
			</a>
		</li>
		@endPermission
		<li class="nav-item">
			<a href="#" data-toggle="modal" data-target="#modal-select-projek-notulen" class="nav-link {{Route::currentRouteName() == 'notulensi' ? 'active':null}}">
				<i class="far fa-circle nav-icon "></i>
				<p>Notulensi</p>
			</a>
		</li>
	</ul>
</li>
@Permission(['superadmin','employee'])

<li class="nav-item">
	<a href="{{route('ticketing.maintenance')}}" class="nav-link {{Route::currentRouteName() == 'ticketing.maintenance' ? 'active':null}}">
		<i class="fas fa-flag mr-2 "></i>
		<p>Kelola Ticketing</p>
	</a>
</li>
@endPermission
@Permission(['superadmin','owner','hrd'])
<li class="nav nav-item has-treeview {{Route::currentRouteName() == 'chart.absensi' || Route::currentRouteName() == 'chart.karyawan'  ? 'menu-is-opening menu-open':null}}">
	<a href="#" class="nav-link ">
		<i class="far fa-chart-bar mr-2"></i>
		<p>Chart
			<i class="right fas fa-angle-left"></i>
		</p>
	</a>
	<ul class="nav nav-treeview">
		<li class="nav-item">
			<a href="{{route('chart.absensi')}}" class="nav-link {{Route::currentRouteName() == 'chart.absensi' ? 'active':null}}">
				<i class="far fa-circle nav-icon"></i>
				<p>Absensi</p>
			</a>
		</li>
		<li class="nav-item">
			<a href="{{route('chart.karyawan')}}" class="nav-link {{Route::currentRouteName() == 'chart.karyawan' ? 'active':null}}">
				<i class="far fa-circle nav-icon"></i>
				<p>Karyawan</p>
			</a>
		</li>
		<li class="nav-item">
			<a href="#" href="#" data-toggle="modal" data-target="#modal-select-karyawan-chart" class="nav-link {{Route::currentRouteName() == 'chart.karyawan.pilih' ? 'active':null}}">
				<i class="far fa-circle nav-icon"></i>
				<p>Lihat detail Karyawan</p>
			</a>
		</li>
	</ul>
</li>
@endPermission
@Permission(['superadmin','hrd','owner'])
<li class="nav-item">
	<a href="#" data-toggle="modal" data-target="#modal-select-karyawan" class="nav-link {{Route::currentRouteName() == 'task.karyawan' ? 'active':null}}">
		<i class="fas fa-tasks mr-2 ml-1 "></i>
		<p>Lihat Task Karyawan</p>
	</a>
</li>
<li class="nav-item">
	<a href="{{route('absen')}}" class="nav-link {{Route::currentRouteName() == 'absen' ? 'active':null}}">
		<i class="fas fa-calendar-check mr-2 ml-1 "></i>
		<p>Kelola Absensi</p>
	</a>
</li>

@Permission(['superadmin','hrd'])
<li class="nav-item">
	<a href="{{route('karyawan')}}" class="nav-link {{Route::currentRouteName() == 'karyawan' ? 'active':null}}">
		<i class="fas fa-user-tie mr-2 ml-1 "></i>
		<p>Kelola Karyawan</p>
	</a>
</li>
@endPermission
@Permission(['superadmin'])
<li class="nav-item">
	<a href="{{route('task.maintenance.level')}}" class="nav-link {{Route::currentRouteName() == 'task.maintenance.level' ? 'active':null}}">
		<i class="fas fa-layer-group mr-2 ml-1 "></i>
		<p>Kelola Level Maintenance</p>
	</a>
</li>
@endPermission
@endPermission
@Permission(['superadmin'])
<li class="nav-item">
	<a href="{{route('project')}}" class="nav-link {{Route::currentRouteName() == 'project' ? 'active':null}}">
		<i class="fas fa-project-diagram mr-2 "></i>
		<p>Kelola Projek</p>
	</a>
</li>

<li class="nav-item has-treeview {{Route::currentRouteName() == 'pengguna' || Route::currentRouteName() == 'guest'  ? 'menu-is-opening menu-open':null}}">
	<a href="#" class="nav-link ">
		<i class="nav-icon fas fa-users"></i>
		<p>
			Kelola Pengguna
			<i class="right fas fa-angle-left"></i>
		</p>
	</a>
	<ul class="nav nav-treeview">
		<li class="nav-item">
			<a href="{{route('pengguna')}}" class="nav-link {{Route::currentRouteName() == 'pengguna' ? 'active':null}}">
				<i class="far fa-circle nav-icon"></i>
				<p>Pengguna Sistem</p>
			</a>
		</li>
		<li class="nav-item">
			<a href="{{route('guest')}}" class="nav-link {{Route::currentRouteName() == 'guest' ? 'active':null}}">
				<i class="far fa-circle nav-icon"></i>
				<p>Akun Tamu</p>
			</a>
		</li>
	</ul>
</li>
<li class="nav-item has-treeview {{Route::currentRouteName() == 'config.pulang' || Route::currentRouteName() == 'config.absensi'  ? 'menu-is-opening menu-open':null}}">
	<a href="#" class="nav-link">
		<i class="nav-icon fas fa-wrench mr-2"></i>
		<p>Setting<i class="right fas fa-angle-left"></i>
		</p>
	</a>
	<ul class="nav nav-treeview">
		<li class="nav-item">
			<a href="{{route('config.absensi')}}" class="nav-link {{Route::currentRouteName() == 'config.absensi' ? 'active':null}}">
				<i class="far fa-circle nav-icon"></i>
				<p>Absensi</p>
			</a>
		</li>
		<li class="nav-item">
			<a href="{{route('config.pulang')}}" class="nav-link {{Route::currentRouteName() == 'config.pulang' ? 'active':null}}">
				<i class="far fa-circle nav-icon"></i>
				<p>Pulang</p>
			</a>
		</li>
	</ul>
</li>
<li class="nav-item">
	<a href="{{route('logs')}}" class="nav-link {{Route::currentRouteName() == 'logs' ? 'active':null}}">
		<i class="fas fa-history mr-2 "></i>
		<p>Log Sistem</p>
	</a>
</li>
@endPermission
