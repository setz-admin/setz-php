<h1>Termin Details</h1>

<div>
    <p>Termin mit Kunde: {{ $appointment->customer->name }}</p>
    <p>Datum: {{ $appointment->scheduled_at->format('Y-m-d H:i') }}</p>
</div>
