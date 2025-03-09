<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'Page Title'}}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
    @livewireScripts
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.tiny.cloud/1/u8796ra33q2xzev2yc0sk74jz87306h16mmdidnrskwfwusb/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/airbnb.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>
<body class="selection-bg">
    @yield('content')

    <x-toaster-hub />

    <img src="{{ asset('assets/logo.png') }}" alt="" class="fixed sm:block hidden sm:-bottom-1/6 sm:-left-1/6 rotate-90  z-10  ">
    @stack('scripts')

</body>
</html>
