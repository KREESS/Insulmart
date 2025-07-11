@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            {{ config('app.name') }}
        @endcomponent
    @endslot

    {{-- Body --}}
    {{ $slot }}

    {{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            {{-- ✅ GANTI BAGIAN INI --}}
            Salam hangat,<br>
            <strong style="color: #8B0000;">Tim Insulmart</strong><br><br>
            &copy; {{ date('Y') }} Insulmart. All rights reserved.
        @endcomponent
    @endslot
@endcomponent
