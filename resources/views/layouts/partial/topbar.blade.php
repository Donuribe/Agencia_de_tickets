<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
		<li class="nav-item">
			<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
		</li>
    </ul>
    <ul class="navbar-nav ml-auto align-items-center">
        @if (Auth::check())
		<li class="nav-item user-panel mt-2 pb-3 d-flex">
			<div class="profile-chip">
                <div class="image">
				@php
                    $userPhotoPath = 'uploads/users/' . Auth::user()->photo;
                @endphp
                @if (!empty(Auth::user()->photo) && file_exists(public_path($userPhotoPath)))
                    <img class="img-circle elevation-2" src="{{ asset($userPhotoPath) }}" alt="{{ Auth::user()->name }}">
                @else
                    <img src="{{ asset('backend/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="">
                @endif
			    </div>
			    <div class="info" style="color:#334155; font-weight:600;">
				    {{ Auth::user()->name }}
                    @if(Auth::user()->tipoUsuario)
                        <span style="font-weight:400; font-size:0.8rem; color:#64748b;">"{{ Auth::user()->tipoUsuario->nombre_tipo }}"</span>
                    @endif
			    </div>
            </div>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" title="Cerrar Sesión" role="button">
				<i class='fas fa-power-off' style='font-size:22px; color:#ef4444'></i>
			</a>
			<form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none">
				@csrf
			</form>
		</li>
        @endif
    </ul>
</nav>
