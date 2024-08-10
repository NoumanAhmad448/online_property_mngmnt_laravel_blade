@php
    $id = gen_str();
@endphp
<div class="grid grid-cols-4 sm:grid-cols-5">
    @foreach ($records as $index => $rec)
        @php
            debug_logs("{$id}{$index}");
        @endphp
        @if(is_key_exists(config('vars.details'),$rec) && is_key_exists(config("vars.priv"),$rec)
            && $rec[config("vars.priv")]
        )
            @include(config('files.components_') . 'loader', [
                'prop' => [
                    'id' => "{$id}{$index}",
                ],
            ])
            @if(is_key_exists(config("vars.url"), $rec))
                <a href='{{$rec[config("vars.url")]}}' target="_blank" class="hover:underline">
            @endif
            <section class="p-4 border border-stroke hidden mt-10 flex items-center
                    hover:transition hover:ease-in-out hover:delay-150 hover:animate-pulse
            " id="{{ $index }}section">
                <section class="">
                    @include($rec[config('vars.svg')])
                </section>
                <div class="ml-3"> {{ $rec[config('vars.details')] }} </div>
            </section>
            @if(is_key_exists(config("vars.url"), $rec))
                </a>
            @endif
            @include(config('files.components_') . 'loader_script', [
                'prop' => [
                    'id' => "{$id}{$index}",
                    'hide_el' => "{$index}section",
                ],
            ])
        @endif
    @endforeach
</div>
