@extends(config('setting.body'))
@php
$land = $land ?? [];
debug_logs($land);
@endphp
@section('page-css')
<link rel="stylesheet" href="{{ mix(config('setting.land_create_css')) }}">
@endsection
@section('content')
    <form id="land_reg" enctype="multipart/form-data">
        @include(config("files.components_").'csrf')
        @include(config("files.components_").'register_land',[
            "land" => $land
        ])
    </form>
@endsection
@section('script')
<script>
    let land_save = `@if($land){{route('land_update',['land' => $land?->uuid])}}
                        @else {{route('land_save')}}@endif`;
</script>
<script src="{{ mix(config('setting.land_create_js')) }}"></script>
@endsection
