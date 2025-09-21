<h1>Rechnungen</h1>

<table>
    <thead>
        <tr>
            <th>Rechnungsnummer</th>
            <th>Kunde</th>
            <th>Mitarbeiter</th>
            <th>Datum</th>
            <th>Betrag</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($invoices as $invoice)
            <tr>
                <td><a href="{{ route('invoices.show', $invoice) }}">{{ $invoice->invoice_number }}</a></td>
                <td>{{ $invoice->customer->name }}</td>
                <td>{{ $invoice->employee->name }}</td>
                <td>{{ $invoice->issued_at->format('Y-m-d H:i') }}</td>
                <td>{{ $invoice->total_amount }}</td>
                <td>{{ $invoice->status }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
