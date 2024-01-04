@php
    use App\Models\Colors;

    $menuBackgroundColor = Colors::where('name', 'menu_background_color')->value('color') ?? '#000000';
    $menuTextColor = Colors::where('name', 'menu_text_color')->value('color') ?? '#000000';

@endphp
<style>
    .custom-navbar {
        font-family: 'Poppins', sans-serif;
        font-size: 1.1rem; 
        background-color: {{ $menuBackgroundColor }}!important;
    }
    .custom-navbar .nav-link {
        color: {{ $menuTextColor }}!important; 
        transition: color 0.3s, transform 0.3s; 
    }
    .custom-navbar .nav-link:hover {
        color: #007bff;
        transform: translateY(-2px);
    }
    .custom-navbar .nav-item {
        margin: 0 15px; 
    }

</style>

@foreach ($menus as $menu)
    @if ($menu->menuItems->count())
        <nav class="navbar navbar-expand navbar-light bg-light custom-navbar">
            <div class="container-fluid justify-content-center">
                <ul class="navbar-nav">
                    @foreach ($menu->menuItems as $menuItem) 
                        <li class="nav-item">
                            <a class="nav-link" href="{{ $menuItem->url }}">{{ $menuItem->title }}</a>
                        </li>
                    @endforeach

                    {{-- Authentication Links --}}
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        @if (Route::has('register')) 
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Register</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </nav>
    @else
        <p>No items in this menu.</p>
    @endif
@endforeach
