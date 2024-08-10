@extends(config('setting.admin_body'))
@section('page-css')
@endsection
@section('content')
    @if ($data['title'])
        <h1> {{ $data['title'] }} </h1>
    @endif
    @php
        $records = [
            [
                config("vars.priv") => isSuperAdmin(false),
                config("vars.title") => __("messages.cls_cache"),
                config("vars.url") => route("clear_cache"),
            ],
            [
                config("vars.priv") => isSuperAdmin(false),
                config("vars.title") =>  __("messages.cls_logs"),
                config("vars.url") => route("clear_logs"),
            ],
            [
                config("vars.priv") => isSuperAdmin(false),
                config("vars.title") =>  __("messages.cls_files"),
                config("vars.url") => route("clear_files"),
                config("vars.alert") => true,
            ],
            [
                config("vars.priv") => isSuperAdmin(false),
                config("vars.title") =>  __('messages.optimize'),
                config("vars.url") => route("optimize"),
            ],
        ];
    @endphp
    @include(config("setting.admn_oprtn_list"), ["records" => $records])
@endsection
