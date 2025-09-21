<h1>Rechnung #{{ $invoice->invoice_number }}</h1>
<p>Kunde: {{ $invoice->customer->name }}</p>
<p>Mitarbeiter: {{ $invoice->employee->name }}</p>
<p>Ausstellungsdatum: {{ $invoice->issued_at->format('Y-m-d H:i') }}</p>
<p>Bezahlt am: {{ $invoice->paid_at ? $invoice->paid_at->format('Y-m-d H:i') : 'N/A' }}</p>
<p>Gesamtbetrag: {{ $invoice->total_amount }}</p>
<p>Status: {{ $invoice->status }}</p>
