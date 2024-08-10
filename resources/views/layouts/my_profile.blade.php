@extends(config('setting.body'))
@section('page-css')
@endsection
@section('content')
<form id="{{config('vars.my_profile_form')}}" enctype="multipart/form-data">
    @include(config("files.components_").'csrf')
    @include(config("files.components_").'form_type')
    @include(config("files.components_").'my_profile', [
        "prop" => ""
    ])
</form>
@endsection

@section('script')
<script>
    let profile_url = "{{ route('my_profile_ptch') }}";
    let submit_button = '{{ config("table.SubmitButton") }}';
    let my_profile_form = '{{ config("vars.my_profile_form") }}';

    debug_logs(`profile_url => ${profile_url}`);
    debug_logs(`SubmitButton => ${submit_button}`);
    debug_logs(`my_profile_form => ${my_profile_form}`);
</script>
<script src="{{ mix(config('setting.my_profile_js')) }}"></script>
@endsection