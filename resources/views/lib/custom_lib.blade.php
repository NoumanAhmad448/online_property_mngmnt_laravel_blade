<!DOCTYPE html>
{{-- class="{{$theme == 'dark' ? 'dark' : ''}}" --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/> --}}

    <link rel="shortcut icon" href="{{ url(config('setting.im_log')) }}">
    <title id="seo_title"> {{ config('setting.app_name') }} </title>
    <meta id="seo_desc" name="description" content="{{ config('setting.default_desc') }}">
    <meta property="og:title" content="{{ config('app.name') }}">
    <meta id="seo_fb" property="og:description" content="{{ config('setting.default_desc') }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
    integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ mix(config('setting.app_css')) }}">

    {{-- should alway be in the end --}}
    <script>
        let debug = '{{ config("app.debug") || config("app.js_debug") ? 1 : 0 }}';
        debug = debug == "1" ? true : false;
        let err_msg = '{{ __('messages.err_msg') }}';
        let file_upload_ft = '{{ __('messages.file_upload_ft') }}';
        let en_typewriter = {{ config("setting.en_typewriter") }};
        let dash_lines = "{{ config("setting.dash_lines") }}";
        let fuas = "{{ config("setting.fuas") }}";
        let fuasm = "{{ __("messages.fuasm") }}";
        let img_val_rules =  {!! config("form.img_val_rules_json") !!};
        let api_message =  "{{ config('setting.message') }}";
        let api_is_success =  "{{ config('setting.is_success') }}";
        let default_timeout =  "{{ config('setting.default_timeout') }}";
        let domain_name =  "{{ config('app.url') }}";

    </script>

    {{-- add global js file here --}}
    <script src="{{ mix(config('setting.var_js')) }}"></script>
    <script src="{{ mix(config('setting.app_js')) }}"></script>
    <script src="{{ mix(config('setting.common_functions')) }}"></script>
    {{-- should not include after this line --}}
