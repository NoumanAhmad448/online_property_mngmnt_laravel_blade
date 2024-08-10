@include(config('files.lib') . 'import_pkgs')
@include(config('files.lib') . 'custom_lib')
@yield('page-css')
</head>

<body>
    @include(config('files.components_') . 'form_loader')
    <!-- main Content -->
    <div class="font-sans text-gray-900 bg-gray-100 antialiased min-h-screen">
        @include(config('files.components_') . 'header')
        <main class="p-6 container max-w-screen-lg mx-auto">
            @yield('content')
        </main>
        @include(config('files.components_') . 'footer')
    </div>
    @yield('script')
</body>

</html>
