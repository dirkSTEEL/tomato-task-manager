<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Tomato Task Manager</title>

        <!-- Styles -->
        <link href="{{ URL::asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        @csrf
        <main>
            <div id="header" class="bg-secondary py-3">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <h1 class="text-center text-white mb-0">Tomato Task Manager</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div id="app" class="my-5">
                @yield('content')
            </div>
        </main>
        <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
    </body>
</html>
