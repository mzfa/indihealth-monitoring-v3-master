<li class="nav-item">
	<a href="{{route('guest.dashboard')}}"  class="nav-link">
	 <i class="fas  fa-project-diagram mr-2"></i>
	  <p>Projects Saya</p>
	</a>
</li>
<li class="nav-item has-treeview">
	<a href="#" class="nav-link">
		<i class="fas  fa-flag mr-2"></i>
	<p>Ticketing Maintenance
			<i class="right fas fa-angle-left"></i>
		</p>
	</a>
	<ul class="nav nav-treeview">
		<li class="nav-item">
			<a href="{{route('guest.ticketing.request')}}" class="nav-link">
				<i class="far fa-circle nav-icon"></i>
				<p>Buat Ticketing</p>
			</a>
		</li>
		<li class="nav-item">
			<a href="{{route('guest.ticketing.status')}}" class="nav-link">
				<i class="far fa-circle nav-icon"></i>
				<p>Ticketing status</p>
			</a>
		</li>

	</ul>
</li>
