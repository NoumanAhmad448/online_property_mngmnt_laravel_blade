@extends(config('setting.body'))
@include(config("files.lib")."import_pkgs")
@section('page-css')
@endsection
@section('content')

    @php
        $id = gen_str();
        $data["id"] = $id;
    @endphp
    @if ($data[config('vars.title')])
       <h1 class="mb-3"> {{ $data[config('vars.title')] }} </h1>
    @endif
    <hr>
    <h3 class="my-3"> {{ __("messages.update_pass")}} </h3>
    @include(config("files.forms").config("setting.update_password"),[
        config('vars.user_id') => auth()?->user()?->id,
        ])
    <hr >


@endsection
@section('script')
<script>
    let update_form = '{{ config("setting.update_password") }}';
    let user_update = '{{ route("updt_create_admin") }}';
    let update_field = "{{ config('form.update') }}";
</script>
<script src="{{ mix(config('setting.settings_js')) }}"></script>

@endsection
