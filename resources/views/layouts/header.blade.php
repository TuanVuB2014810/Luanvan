<header>
    <nav>
        <a href="{{ route('index')}}" class="{{ request()->is('/') ? 'active':'' }}">Trangcchu</a>
        <a href="{{ route('about')}}"  class="{{ request()->is('about') ? 'active':'' }}">Giới thiệu</a>
        {{-- <a href="{{ route('phongtro')}}"  class="{{ request()->is('phongtro') ? 'active':'' }}">Phong tro</a> --}}
    </nav>
</header>