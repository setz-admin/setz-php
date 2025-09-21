<h1>Mitarbeiterliste</h1>

@foreach ($employees as $employee)
    <div>
        <a href="{{ route('employees.show', $employee) }}">
            <p>Name: {{ $employee->name }}</p>
        </a>
        <p>E-Mail: {{ $employee->email }}</p>
    </div>
@endforeach
