<aside
  :class="sidebarToggle ? 'block' : 'hidden'"
  class="absolute left-0 top-0 z-9999 flex h-screen w-80 flex-col overflow-y-hidden dark:bg-dark
    bg-white dark:text-white
  duration-300 ease-linear dark:bg-boxdark lg:static lg:translate-x-0"
  {{-- @click.outside="sidebarToggle = false" --}}
>
  <!-- SIDEBAR HEADER -->
  <div class="flex items-center justify-between gap-2 px-6 py-5.5 lg:py-6.5">
    <a href="{{route('index')}}">
      <img width="100" src="{{url(config('setting.im_log'))}}"
       alt="{{config('app.name')}}" />
    </a>

    <button
      class="block lg:hidden"
      type="button" title="Toggle Button"
      @click.stop="sidebarToggle = !sidebarToggle;"
    >
      @include(config("files.svg")."sidebar_toggle")
    </button>
  </div>
  <!-- SIDEBAR HEADER -->

  <div
    class="no-scrollbar flex flex-col overflow-y-auto duration-300 ease-linear"
  >
    <!-- Sidebar Menu -->
    <nav
      class="mt-5 px-4 py-4 lg:mt-9 lg:px-6"
      x-data="{selected: $persist('{{__('messages.dashboard')}}')}"
    >
      <!-- Menu Group -->
      <div>
        <h3 class="mb-4 ml-4 text-sm font-medium text-bodydark2">{{ __("messages.menu") }} </h3>
        @include("sidebar_menu", ["prop" => [ "id" => gen_str() ]])
      </div>
    </nav>
    <!-- Sidebar Menu -->
  </div>
</aside>
