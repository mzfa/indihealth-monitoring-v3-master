@if($data->is_pm) <span class="badge badge-primary">PM</span> @else <span class="badge badge-secondary">TM</span> @endif {{Str::limit($data->user->name, 60)}}
