@extends('layouts.app')
@section('title', 'Purchase Details')

@section('content')
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
          Purchase Details
          <small class="pull-right"><b>Date:</b> {{ date( 'd/m/Y', strtotime( $purchase->transaction_date ) ) }}</small>
        </h2>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-4">
        <b>Reference No:</b> #{{ $purchase->ref_no }}<br>
        <b>Location:</b> {{ $purchase->location->name }}<br>
        <b>Status:</b> {{ ucfirst( $purchase->status ) }}<br>
        <b>Payment Status:</b> {{ ucfirst( $purchase->payment_status ) }}<br>
      </div>
      <div class="col-sm-4">
        <b>Supplier:</b> {{ $purchase->contact->name }}<br>
        <b>Business:</b> {{ $purchase->contact->supplier_business_name }}<br>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-xs-12">
        <div class="table-responsive">
          <table class="table bg-gray">
            <tr class="bg-green">
              <th>#</th>
              <th>Product</th>
              <th>Quantity</th>
              <th>Unit Cost Price (Before Tax)</th>
              <th>Subtotal (Before Tax)</th>
              <th>Tax</th>
              <th>Unit Cost Price (After Tax)</th>
              <th>Unit Selling Price</th>
              <th>Subtotal</th>
            </tr>
            @php 
              $total_before_tax = 0.00;
            @endphp
            @foreach($purchase->purchase_lines as $purchase_line)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                  {{ $purchase_line->product->name }}
                   @if( $purchase_line->product->type == 'variable')
                    - {{ $purchase_line->variations->product_variation->name}}
                    - {{ $purchase_line->variations->name}}
                   @endif
                </td>
                <td>{{ $purchase_line->quantity }}</td>
                <td><span class="display_currency" data-currency_symbol="true">{{ $purchase_line->purchase_price }}</span></td>
                <td><span class="display_currency" data-currency_symbol="true">{{ $purchase_line->quantity * $purchase_line->purchase_price }}</span></td>
                <td><span class="display_currency" data-currency_symbol="true">{{ $purchase_line->item_tax }} </span> @if($purchase_line->tax_id) ( {{ $taxes[$purchase_line->tax_id]}} ) @endif</td>
                <td><span class="display_currency" data-currency_symbol="true">{{ $purchase_line->purchase_price_inc_tax }}</span></td>
                <td><span class="display_currency" data-currency_symbol="true">{{ $purchase_line->variations->default_sell_price }}</span></td>
                <td><span class="display_currency" data-currency_symbol="true">{{ $purchase_line->purchase_price_inc_tax * $purchase_line->quantity }}</span></td>
              </tr>
              @php 
                $total_before_tax += ($purchase_line->quantity * $purchase_line->purchase_price);
              @endphp
            @endforeach
          </table>
        </div>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-xs-6">
        <p><b>Shipping details:</b></p>
        <p class="well well-sm no-shadow bg-gray" style="border-radius: 0px;">
         {{ $purchase->shipping_details }}
        </p>
        <p><b>Notes:</b></p>
        <p class="well well-sm no-shadow bg-gray" style="border-radius: 0px;">
         {{ $purchase->additional_notes }}
        </p>
      </div>
      <div class="col-xs-6">
        <div class="table-responsive">
          <table class="table bg-gray">
            <tr>
              <th>Total Before Tax: </th>
              <td></td>
              <td><span class="display_currency pull-right">{{ $total_before_tax }}</span></td>
            </tr>
            <tr>
              <th>Total After Tax: </th>
              <td></td>
              <td><span class="display_currency pull-right">{{ $total_before_tax }}</span></td>
            </tr>
            <tr>
              <th>Purchase Tax:</th>
              <td><b>(+)</b></td>
              <td><span class="display_currency pull-right">{{ $purchase->tax_amount }}</span></td>
            </tr>
            <tr>
              <th>Discount:</th>
              <td><b>(-)</b></td>
              <td><span class="display_currency pull-right">{{ $purchase->discount_amount }}</span></td>
            </tr>
            @if( !empty( $purchase->shipping_charges ) )
              <tr>
                <th>Additional Shipping charges:</th>
                <td><b>(+)</b></td>
                <td><span class="display_currency pull-right" >{{ $purchase->shipping_charges }}</span></td>
              </tr>
            @endif
            <tr>
              <th>Purchase Total:</th>
              <td></td>
              <td><span class="display_currency pull-right" data-currency_symbol="true" >{{ $purchase->final_total }}</span></td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->
@endsection