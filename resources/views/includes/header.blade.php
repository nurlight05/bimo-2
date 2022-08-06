<div class="header">
    <h2><strong>@yield('title')</strong></h2>
    <div class="breadcrumb-wrapper">
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}">Главная</a></li>
            <li class="active">@yield('title')</li>
        </ol>
    </div>
</div>