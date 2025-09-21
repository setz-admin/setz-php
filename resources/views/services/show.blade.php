<h1>Dienstleistung: {{ $service->description }}</h1>
<p>Termin: {{ $service->appointment->title ?? 'Nicht zugewiesen' }}</p>
<p>Preis: {{ $service->price }}</p>
<p>Zahlungsstatus: {{ $service->payment_status }}</p>
<p>Rechnungsdatum: {{ $service->invoiced_at ? $service->invoiced_at->format('Y-m-d H:i') : 'N/A' }}</p>
<a href="{{ route('services.edit', $service) }}">Bearbeiten</a>
