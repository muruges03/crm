<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <link href="{{env('APP_URL')}}/assets/modocrm-icon.png" rel="icon" style="border-radius: 50%;">
        <!-- <link href="{{ asset('assets/modocrm-icon.png') }}" rel="apple-touch-icon" style="border-radius: 50%;"> -->
        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <!-- Select2 CSS -->


        <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />  -->
{{--        <!-- jQuery --> <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>--}}
        <!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script> -->
        <!-- endSelect2 JS -->
        <!-- <script src="//cdnjs.cloudflare.com/ajax/libs/vue/2.5.2/vue.min.js"></script>-->
        <!-- CDNJS :: Sortable (https://cdnjs.com/) -->
        <!-- <script src="//cdn.jsdelivr.net/npm/sortablejs@1.8.4/Sortable.min.js"></script> -->
        <!-- CDNJS :: Vue.Draggable (https://cdnjs.com/) -->

{{--    <link href="https://unpkg.com/@tailwindcss/custom-forms/dist/custom-forms.min.css" rel="stylesheet" />--}}
{{--        <script src="//cdnjs.cloudflare.com/ajax/libs/Vue.Draggable/2.20.0/vuedraggable.umd.min.js"></script>--}}
{{--        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">--}}
{{--        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>--}}
        <!-- Scripts -->
            @routes
            <script src="//cdnjs.cloudflare.com/ajax/libs/vue/2.5.2/vue.min.js"></script>
            <!-- CDNJS :: Sortable (https://cdnjs.com/) -->
            <script src="//cdn.jsdelivr.net/npm/sortablejs@1.8.4/Sortable.min.js"></script>
            <!-- CDNJS :: Vue.Draggable (https://cdnjs.com/) -->
{{--            <script src="//cdnjs.cloudflare.com/ajax/libs/Vue.Draggable/2.20.0/vuedraggable.umd.min.js"></script>--}}
        <script src="{{ asset('js/app.js') }}" defer></script>
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    </head>
    <body class="font-sans antialiased">
        @inertia

        <!-- @env ('local')
            <script src="http://localhost:3000/browser-sync/browser-sync-client.js"></script>
        @endenv -->
        <div class="container">
            @yield('content')
        </div>
    </body>
</html>
