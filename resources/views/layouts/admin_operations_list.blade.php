@php
    $id = gen_str();
@endphp
<div class="grid grid-cols-4 sm:grid-cols-5">
    @foreach ($records as $index => $rec)
        @php
            debug_logs("{$id}{$index}");
            debug_logs(is_key_exists(config("vars.alert"),$rec) && $rec[config("vars.alert")]);
        @endphp
        @if(is_key_exists(config("vars.priv"),$rec)
            && $rec[config("vars.priv")]
        )
            @include(config('files.components_') . 'loader', [
                'prop' => [
                    'id' => "{$id}{$index}",
                ],
            ])

            <section class="p-4 border border-stroke hidden mt-10 flex items-center
                    hover:transition hover:ease-in-out hover:delay-150 hover:animate-pulse
                    @if(is_key_exists(config("vars.alert"),$rec) && $rec[config("vars.alert")])
                     {{ 'bg-red-500' }}
                    @endif
                    "
                    id="{{ $index }}section">
                <section class="">
                    <h3> {{ $rec[config("vars.title")] }} </h3>

                    <a href='{{$rec[config("vars.url")]}}' target="_blank" class="hover:underline">
                        {{ $rec[config("vars.title")]}}
                    </a>
                </section>
            </section>

            @include(config('files.components_') . 'loader_script', [
                'prop' => [
                    'id' => "{$id}{$index}",
                    'hide_el' => "{$index}section",
                ],
            ])
        @endif
    @endforeach
</div>
