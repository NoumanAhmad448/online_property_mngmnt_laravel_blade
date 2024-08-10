@if (Auth::user())
    @if (Auth::user()->profile_photo_path)
        {{ url(Auth::user()->profile_photo_path) }}
    @else
        {{ Auth::user()->defaultProfilePhotoUrl() }}
    @endif

@endif
