@extends(config('setting.body'))
@section('page-css')
@endsection
@section('content')
    <!-- ====== Forms Section Start -->
    <form id="admin_login" enctype="multipart/form-data">
        @include(config('files.components') . '.csrf')
        <div class=" mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10 mt-28">
            <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="flex flex-wrap items-center">
                    <div class="hidden w-full xl:block xl:w-1/2">
                        <div class="px-26 py-17.5 text-center">
                            <a class="mb-5.5 inline-block" href="{{ route('index') }}">
                                <img class="hidden dark:block" src="{{ url(config('setting.im_log')) }}"
                                    alt="{{ config('app.name') }}" />
                                <img class="dark:hidden" src="{{ url(config('setting.im_log')) }}"
                                    alt="{{ config('app.name') }}" />
                            </a>

                            <p class="font-medium 2xl:px-20">
                                {{ __('messages.wel_desc') }}
                            </p>
                        </div>
                    </div>
                    <div class="w-full border-stroke dark:border-strokedark xl:w-1/2 xl:border-l-2">
                            <div class="w-full p-4 sm:p-12.5 xl:p-17.5">
                                <span class="mb-1.5 block font-medium">{{ __('messages.sfh') }}</span>
                                <h2 class="mb-9 text-2xl font-bold text-black dark:text-white sm:text-title-xl2">
                                    {{ __('messages.ap') }}
                                </h2>
                                <div class="mb-4">
                                    @include(config('files.components') . '.forms.email', [
                                        'is_form' => false,
                                    ])
                                </div>
                                <div class="mb-6">
                                    @include(config('files.components') . '.forms.password', [
                                        'is_form' => false,
                                    ])
                                </div>
                                <div class="mb-5">
                                  @if(config("setting.en_gc"))
                                      @include(config("files.components").'.forms.col',
                                      ['input' => config("files.components").'.forms.captcha',
                                      ])
                                  @endif
                                </div>
                                <div class="mb-5">
                                @include(config('files.forms') . 'col', [
                                    'input' => config('files.forms') . 'submit',
                                    'move_btn_right' => true,
                                    'id' => 'submit',
                                    "text" => __("messages.login")
                                ])
                                </div>
                </div>
            </div>
        </div>
        </div>
        </div>
    </form>
    <!-- ====== Forms Section End -->
@endsection
@section('script')
<script>
  let login_form = "{{route('admin_login_post')}}";
  let admin_panel = "{{route('admin_chart')}}";
</script>
<script src="{{ mix(config('setting.admin_login_js')) }}"></script>
@endsection
