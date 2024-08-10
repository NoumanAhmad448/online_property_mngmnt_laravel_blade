@extends(config('setting.admin_body'))
@section('page-css')
@endsection
@section('content')
    <!-- ===== Main Content Start ===== -->
    @if ($data['title'])
        <h1> {{ $data['title'] }} </h1>
    @endif
    @php
        $records = [
            [
                config("vars.priv") => isSuperAdmin(false),
                config("vars.svg") => config("files.svg").'profile',
                config("vars.url") => route("show_users"),
                config("vars.details") => __("messages.Users"). $data['users']
            ],
            [
                config("vars.priv") => isSuperAdmin(false),
                config("vars.svg") => config("files.svg").'profile',
                config("vars.url") => route("show_users"),
                config("vars.details") => __("messages.active_users"). $data['active_users']
            ],
            [
                config("vars.priv") => isSuperAdmin(false),
                config("vars.svg") => config("files.svg").'profile',
                config("vars.url") => route("show_users"),
                config("vars.details") => __("messages.inactive_users"). (int)$data['users'] - (int)$data['active_users']
            ],
            [
                config("vars.url") => route("admin_lands"),
                config("vars.priv") => true,
                config("vars.svg") => config("files.svg").'dashboard',
                config("vars.details") => __("messages.Lands").$data['lands']
            ],
            [
                config("vars.url") => route("create_admin"),
                config("vars.priv") => isSuperAdmin(false),
                config("vars.svg") => config("files.svg").'profile',
                config("vars.details") => __("messages.Admins").$data['admins']
            ],
            [
                config("vars.url") => route("create_admin"),
                config("vars.priv") => isSuperAdmin(false),
                config("vars.svg") => config("files.svg").'profile',
                config("vars.details") => __("messages.active_admins").$data['active_admins']
            ],
            [
                config("vars.priv") => isSuperAdmin(false),
                config("vars.svg") => config("files.svg").'profile',
                config("vars.url") => route("create_admin"),
                config("vars.details") => __("messages.inactive_admins").(int)$data['admins'] - (int)$data['active_admins']
            ],

        ];
    @endphp
    @include("admin_chart_list", ["records" => $records])
    <!-- ===== Main Content End ===== -->
@endsection
@section('script')
@endsection
