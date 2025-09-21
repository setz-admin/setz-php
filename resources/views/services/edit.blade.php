<h1>Dienstleistung: {{ $service->description }} bearbeiten</h1>
<form action="{{ route('services.update', $service) }}" method="POST">
    @csrf
    @method('PUT')
    
    <label for="appointment_id">Termin:</label><br>
    <select id="appointment_id" name="appointment_id">
        @foreach ($appointments as $appointment)
            <option value="{{ $appointment->id }}" {{ $service->appointment_id == $appointment->id ? 'selected' : '' }}>Termin #{{ $appointment->id }}</option>
        @endforeach
    </select><br>

    <label for="description">Beschreibung:</label><br>
    <input type="text" id="description" name="description" value="{{ $service->description }}"><br>

    <label for="price">Preis:</label><br>
    <input type="number" step="0.01" id="price" name="price" value="{{ $service->price }}"><br>

    <label for="payment_status">Zahlungsstatus:</label><br>
    <input type="text" id="payment_status" name="payment_status" value="{{ $service->payment_status }}"><br>
    
    <label for="invoiced_at">Rechnungsdatum (optional):</label><br>
    <input type="datetime-local" id="invoiced_at" name="invoiced_at" value="{{ $service->invoiced_at ? $service->invoiced_at->format('Y-m-d\TH:i') : '' }}"><br>

    <button type="submit">Aktualisieren</button>
</form>
