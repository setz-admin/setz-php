@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Kunden</h1>
        <a href="{{ route('customers.create') }}" class="btn btn-primary" dusk="create-customer-button">Neuen Kunden erstellen</a>
    </div>

    @if($customers->isEmpty())
        <div class="alert alert-info" role="alert">
            Es sind noch keine Kunden vorhanden.
        </div>
    @else
        <table class="table table-bordered" dusk="customers-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>E-Mail</th>
                    <th>Telefonnummer</th>
                    <th>Adresse</th>
                    <th>Aktionen</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $customer)
                    <tr dusk="customer-row-{{ $customer->id }}">
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->phone}}</td>
                        <td>{{ $customer->address}}</td>
                        <td>
                            <a href="{{ route('customers.show', $customer) }}" class="btn btn-sm btn-info" dusk="view-customer-{{ $customer->id }}">Ansehen</a>
                            <a href="{{ route('customers.edit', $customer) }}" class="btn btn-sm btn-warning" dusk="edit-customer-{{ $customer->id }}">Bearbeiten</a>
                            <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Sind Sie sicher, dass Sie diesen Kunden löschen möchten?')" dusk="delete-customer-{{ $customer->id }}">Löschen</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
