<?php

// app/Http/Controllers/InvoiceController.php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with(['customer', 'employee'])->get();
        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $customers = Customer::all();
        $employees = Employee::all();
        return view('invoices.create', compact('customers', 'employees'));
    }

    public function store(Request $request)
    {
        // 1. Validate all incoming data, including the 'services' array
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'employee_id' => 'required|exists:employees,id',
            'invoice_number' => 'required|unique:invoices,invoice_number',
            'status' => 'required|string',
            'total_amount' => 'nullable|numeric',
            'issued_at' => 'required|date',
            'paid_at' => 'nullable|date',
            'services' => 'array', // services is a valid key for the request
        ]);

        // 2. Extract the services array before creating the invoice
        // This array is not accepted with laravel ==> Mass Assignment
        $services = $validated['services'] ?? [];

        // 3. Remove the 'services' key from the validated data.
        // This is the CRUCIAL step to avoid the MassAssignmentException.
        unset($validated['services']);

        // 4. Create the Invoice model with the modified data.
        // This data now only contains columns that exist in the 'invoices' table.
        $invoice = Invoice::create($validated);

        // 5. Attach the services to the invoice using the relationship.
        $invoice->services()->attach($services);

        // 6. Redirect to the index page.
        return redirect()->route('invoices.index');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load('customer', 'employee');
        return view('invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $customers = Customer::all();
        $employees = Employee::all();
        return view('invoices.edit', compact('invoice', 'customers', 'employees'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'employee_id' => 'required|exists:employees,id',
            'invoice_number' => 'required|unique:invoices,invoice_number,' . $invoice->id,
            'status' => 'required|string',
            'total_amount' => 'nullable|numeric',
            'issued_at' => 'required|date',
            'paid_at' => 'nullable|date',
            'services' => 'array',
        ]);

        $invoice->update($validated);
        return redirect()->route('invoices.index');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index');
    }
}
