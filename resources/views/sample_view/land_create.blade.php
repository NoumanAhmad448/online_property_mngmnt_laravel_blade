@extends(config('setting.body'))
@section('page-css')
<link rel="stylesheet" href="{{ mix(config('setting.land_create_css')) }}">
@endsection
@section('content')
    @include('session_msg')
@endsection
@section('script')
<script src="{{ mix(config('setting.land_create_js')) }}"></script>
@endsection
