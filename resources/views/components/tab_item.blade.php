<li class="nav-item">
    <a class="nav-link {{ Route::is($route) ? 'active' : '' }}" href="{{ route($route) }}">{{ $slot }}</a>
</li>