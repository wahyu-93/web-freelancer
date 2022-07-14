<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('includes.landing._meta')

        <title>@yield('title') | SERV</title>
        
        @stack('before-style')

        @include('includes.landing._style')

        @stack('after-style')
    </head>
    <body class="antialiased">
        <div class="relative">
            @include('includes.landing._header')

                @include('sweetalert::alert')

                @yield('content')

            @include('includes.landing._footer')

            @stack('before-script')

            @include('includes.landing._script')
    
            @stack('after-script')

            {{-- modeal --}}
            @include('components.modal.login')
            @include('components.modal.register')
            @include('components.modal.register-success')
        </div>
    </body>
</html>