<h1>Kundenliste</h1>

@foreach ($customers as $customer)
    <div>
        <a href="{{ route('customers.show', $customer) }}">
            <p>Name: {{ $customer->name }}</p>
        </a>
        <p>E-Mail: {{ $customer->email }}</p>
    </div>
@endforeach
