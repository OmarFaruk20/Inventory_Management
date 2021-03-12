@forelse ($products as $product)
    <tr>
        <td>
            {{$product->product_name}}

            @if($product->variation_name != "DUMMY")
                <b>{{$product->variation_name}}</b>
            @endif
            <input type="hidden" name="products[{{$loop->index + $index}}][product_id]" value="{{$product->product_id}}">
            <input type="hidden" name="products[{{$loop->index + $index}}][variation_id]" value="{{$product->variation_id}}">
        </td>
        <td>
            <input type="number" class="form-control" min=1
            name="products[{{$loop->index + $index}}][quantity]" value="@if(isset($product->quantity)){{$product->quantity}}@else{{1}}@endif">
        </td>
    </tr>
@empty

@endforelse