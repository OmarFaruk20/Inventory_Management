@forelse( $template->values as $value )

    @include('product.partials.variation_value_row', ['variation_index' => $row_index, 'value_index' => $loop->index, 'variation_name' => $value->name, 'variation_value_id' => $value->id,  'profit_percent' => $profit_percent])

@empty

    @include('product.partials.variation_value_row', ['variation_index' => $row_index, 'value_index' => 0, 'profit_percent' => $profit_percent])

@endforelse