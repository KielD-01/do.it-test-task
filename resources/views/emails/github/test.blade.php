<h1>Hello!</h1>
<div style="width : 95%; margin : 15px auto;">
    <p>We want to greet You and send You next message:</p>
    <p style="font-style: italic; font-weight: 700;">{{ $text }}</p>
    @if($weatherSignature)
        <hr>
        <p>Weather JSON in {{ $location }}, huh?</p>
        <p>
            {!! $weatherSignature !!}
        </p>
    @endif
</div>
