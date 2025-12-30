<h1>Daily Sales Report</h1>

@foreach ($data as $item)
    <p>Product "{{ $item['name'] }}" sold {{ $item['quantity'] }}</p>
@endforeach
