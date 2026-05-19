<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true // Tambahan indikator waktu berjalan biar estetik
                });
                   
                @if(Session::has('message'))
                    var type = "{{ Session::get('alert-type') }}";
                    var msg = "{{ Session::get('message') }}";
                    
                    switch (type) {
                        case 'info':
                            Toast.fire({ icon: 'info', title: msg });
                            break;
                        case 'success':
                            Toast.fire({ icon: 'success', title: msg });
                            break;
                        case 'warning':
                            Toast.fire({ icon: 'warning', title: msg });
                            break;
                        case 'error':
                            Toast.fire({ icon: 'error', title: msg });
                            break;
                        case 'dialog_error':
                            Swal.fire({
                                icon: 'error',
                                title: "Ooops",
                                text: msg,
                                confirmButtonText: 'Oke'
                            });
                            break;
                    }
                @endif

                @if ($errors->any())
                    @php $list = ''; @endphp
                    @foreach($errors->all() as $error)
                        @php $list .= '<li>'. addslashes($error) .'</li>'; @endphp
                    @endforeach
                    
                    Swal.fire({
                        icon: 'error',       // PERBAIKAN: Diubah dari 'type' menjadi 'icon'
                        title: "Ooops",
                        html: "<ul style='text-align: left; padding-left: 15px;'>{!! $list !!}</ul>",
                        confirmButtonText: 'Perbaiki'
                    });
                @endif
            });
        </script>
    </body>
</html>