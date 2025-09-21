<h1>Rechnung #{{ $invoice->invoice_number }} bearbeiten</h1>
<form action="{{ route('invoices.update', $invoice) }}" method="POST">
    @csrf
    @method('PUT')
    
    <label for="customer_id">Kunde:</label><br>
    <select id="customer_id" name="customer_id">
        @foreach ($customers as $customer)
            <option value="{{ $customer->id }}" {{ $invoice->customer_id == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
        @endforeach
    </select><br>

    <label for="employee_id">Mitarbeiter:</label><br>
    <select id="employee_id" name="employee_id">
        @foreach ($employees as $employee)
            <option value="{{ $employee->id }}" {{ $invoice->employee_id == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
        @endforeach
    </select><br>

    <label for="invoice_number">Rechnungsnummer:</label><br>
    <input type="text" id="invoice_number" name="invoice_number" value="{{ $invoice->invoice_number }}"><br>

    <label for="issued_at">Ausstellungsdatum:</label><br>
    <input type="datetime-local" id="issued_at" name="issued_at" value="{{ $invoice->issued_at->format('Y-m-d\TH:i') }}"><br>

    <label for="total_amount">Gesamtbetrag:</label><br>
    <input type="number" step="0.01" id="total_amount" name="total_amount" value="{{ $invoice->total_amount }}"><br>

    <label for="status">Status:</label><br>
    <input type="text" id="status" name="status" value="{{ $invoice->status }}"><br>

    <button type="submit">Aktualisieren</button>
</form>
