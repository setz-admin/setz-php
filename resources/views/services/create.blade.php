<h1>Neue Dienstleistung erstellen</h1>
<form action="{{ route('services.store') }}" method="POST">
    @csrf
    <label for="appointment_id">Termin:</label><br>
    <select id="appointment_id" name="appointment_id">
        @foreach ($appointments as $appointment)
            <option value="{{ $appointment->id }}">Termin #{{ $appointment->id }}</option>
        @endforeach
    </select><br>

    <label for="description">Beschreibung:</label><br>
    <input type="text" id="description" name="description"><br>

    <label for="price">Preis:</label><br>
    <input type="number" step="0.01" id="price" name="price"><br>

    <label for="payment_status">Zahlungsstatus:</label><br>
    <input type="text" id="payment_status" name="payment_status" value="open"><br>
    
    <label for="invoiced_at">Rechnungsdatum (optional):</label><br>
    <input type="datetime-local" id="invoiced_at" name="invoiced_at"><br>

    <button type="submit">Speichern</button>
</form>
