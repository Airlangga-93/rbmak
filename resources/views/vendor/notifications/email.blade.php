<x-mail::message>
{{-- Header Kustom --}}
<div style="text-align: center; margin-bottom: 20px;">
<h2 style="color: #0F172A; font-family: 'Plus Jakarta Sans', sans-serif;">Booking <span style="color: #FF5F00;">Tower</span></h2>
</div>

{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# @lang('Halo!')
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}
@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    // Memaksa warna menjadi orange sesuai tema
    $color = 'primary';
?>
<x-mail::button :url="$actionUrl" color="primary">
{{ $actionText }}
</x-mail::button>
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}
@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@lang('Salam Hangat,')<br>
**{{ config('app.name') }} Team**
@endif

{{-- Subcopy --}}
@isset($actionText)
<x-slot:subcopy>
<div style="font-size: 12px; color: #64748b;">
@lang(
    "Jika Anda mengalami kesulitan mengklik tombol \":actionText\", silakan salin dan tempel URL di bawah ini\n".
    "ke browser web Anda:",
    [
        'actionText' => $actionText,
    ]
)
<br>
<span class="break-all" style="color: #FF5F00;">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
</div>
</x-slot:subcopy>
@endisset
</x-mail::message>
