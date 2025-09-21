<h1>Dienstleistungen</h1>

<table>
    <thead>
        <tr>
            <th>Termin</th>
            <th>Beschreibung</th>
            <th>Preis</th>
            <th>Zahlungsstatus</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($services as $service)
            <tr>
                <td><a href="{{ route('services.show', $service) }}">Termin #{{ $service->appointment_id }}</a></td>
                <td>{{ $service->description }}</td>
                <td>{{ $service->price }}</td>
                <td>{{ $service->payment_status }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<a href="{{ route('services.create') }}">Neue Dienstleistung erstellen</a>
