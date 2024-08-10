<?php

use App\Models\UserAnnModel;
use App\Models\Categories;
use Illuminate\Support\Facades\Cache;


?>
        @include("lib.custom_lib")
        @yield('page-css')
    </head>
    <body
        x-data="{ page: 'signin', 'loaded': true, 'darkMode': true, 'stickyMenu': false,
         'sidebarToggle': true, 'scrollTop': false }"
        x-init="
            darkMode = JSON.parse(localStorage.getItem('darkMode'));
            $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
        :class="{'dark text-bodydark bg-boxdark-2': darkMode === true}"
    >
        @include(config("files.components").'.form_loader')
            <!-- ===== Preloader Start ===== -->
                @include(config("files.partials").'.preloader')
            <!-- ===== Preloader End ===== -->
            <!-- ===== Page Wrapper Start ===== -->
        <div class="flex h-screen overflow-hidden">
            <!-- ===== Sidebar Start ===== -->
            @include(config('files.partials').".sidebar")
            <!-- ===== Sidebar End ===== -->


      <!-- ===== Content Area Start ===== -->
      <div
      class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden"
    >
      <!-- ===== Header Start ===== -->
      @include(config('files.partials_')."header")
      <!-- ===== Header End ===== -->

      <!-- ===== Main Content Start ===== -->
            <main class="m-2">
                @yield('content')
            </main>
    <!-- ===== Main Content End ===== -->
          </div>
    <!-- ===== Content Area End ===== -->
    </div>
    <!-- ===== Page Wrapper End ===== -->
    @yield('script')
    </body>
</html>
