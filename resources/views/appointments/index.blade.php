<h1>Termine</h1>

@foreach ($appointments as $appointment)
    <div>
        <p>Termin mit Kunde: {{ $appointment->customer->name }}</p>
        <p>Datum: {{ $appointment->scheduled_at }}</p>
    </div>
@endforeach
