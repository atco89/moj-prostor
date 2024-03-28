<x-mail::message>
{{-- Greeting --}}
@isset($greeting)
{{ $greeting }}
@endisset

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}
@endforeach

{{-- Action Button --}}
@isset($actionText)
<x-mail::button
    :url="$actionUrl">{{ $actionText }}</x-mail::button>
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
<p style="position: static;">
    <strong>{{ $line }}</strong>
</p>
@endforeach

{{-- Salutation --}}
@isset($salutation)
{!! $salutation !!}
@endisset

{{-- Subcopy --}}
@isset($actionText)
<x-slot:subcopy>
    @lang('email.If you\'re having trouble clicking the button, copy and paste the URL below into your web browser:')
    <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
</x-slot:subcopy>
@endisset
</x-mail::message>
