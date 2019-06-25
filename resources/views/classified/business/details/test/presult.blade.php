<table class="table table-bordered">   
    <tr>
        <th>Name</th>
        <th>Details</th>          
    </tr>
    @foreach ($products as $product)
    <tr>
        <td>{{ $product->title }}</td>
        <td>{{ $product->description }}</td>
    </tr>
    @endforeach
</table>
{!! $products->render() !!}