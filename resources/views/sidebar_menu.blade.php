@php
    $id = $prop['id'] ?? "sidebar_menu";
    $sidebar_menu = $prop['id'] ."sidebar_menu";
    $menu = [
        [
            'priv' => [config("policy.can_be_admin")],
            'menu' => __('messages.dashboard'),
            config("vars.svg") => 'dashboard',
            config("vars.sub_menu") => [
                [
                    config('vars.url') => route('admin_chart'),
                    'html' => __('messages.summary'),
                    config("vars.priv") => [config("policy.can_be_admin")],
                ],
                [
                    config('vars.url') => route('admin_lands'),
                    'html' => __('messages.lands'),
                    config("vars.priv") => [config("policy.can_be_admin")]
                ],
            ],
        ],
        [
            config("vars.priv") => [config("policy.is_super_admin")],
            config("vars.menu") => __('messages.ap'),
            config("vars.svg") => 'profile',
            config("vars.sub_menu") => [
                [
                    config('vars.url') => route('create_admin'),
                    'html' => __('messages.sub_adns'),
                    config("vars.priv") => [config("policy.is_super_admin")],
                ],
                [
                    config('vars.url') => route('admin_op'),
                    'html' => __('messages.admin_op'),
                    config("vars.priv") => [config("policy.is_super_admin")],

                ],
                [
                    config('vars.url') => route('health', ["fresh" => 1]),
                    'html' => __('messages.health'),
                    config("vars.priv") => [config("policy.is_super_admin")],
                ],
                [
                    config('vars.url') => route('show_users'),
                    'html' => __('messages.Users'),
                    config("vars.priv") => [config("policy.is_super_admin")],
                ],
                [
                    config('vars.url') => "http://127.0.0.1:5500/resources/docs",
                    'html' => __('messages.phpdoc'),
                    config("vars.priv") => [config("policy.is_super_admin")],
                ],
            ]
        ]
    ];

@endphp
@include(config("files.components").".loader", ["prop" => [
    "id" => $id
]])
<ul id="{{$sidebar_menu}}" class="mb-6 flex flex-col gap-2.5 hidden">
    <!-- Menu Item Dashboard -->
    @include('sidebar_menu_list', ["menu" => $menu])
    <!-- Dropdown Menu End -->
    <!-- Menu Item Dashboard -->
</ul>
@include(config("files.components").".loader_script", ["prop" => ['id' => $id, "hide_el" => $sidebar_menu]])
