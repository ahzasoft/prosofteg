
<div style="display: flex; flex-wrap: wrap;width: 100%">
@forelse($products as $product)
	<div class="product_list no-print" style="width: 25%;">
		<div class="product_box" data-variation_id="{{$product->id}}" title="{{$product->name}} @if($product->type == 'variable')- {{$product->variation}} @endif {{ '(' . $product->sub_sku . ')'}} @if(!empty($show_prices)) @lang('lang_v1.default') - @format_currency($product->selling_price) @foreach($product->group_prices as $group_price) @if(array_key_exists($group_price->price_group_id, $allowed_group_prices)) {{$allowed_group_prices[$group_price->price_group_id]}} - @format_currency($group_price->price_inc_tax) @endif @endforeach @endif">
       <div class="product-title">
		  {{number_format($product->selling_price,2,'.',',')}}
	   </div>
		<div class="image-container" 
			style="height: 100px;     background-image: url(
					@if(count($product->media) > 0)
						{{$product->media->first()->display_url}}
					@elseif(!empty($product->product_image))
	          @if(file_exists(public_path().'/uploads/img/' . rawurlencode($product->product_image)))
                  {{asset('/uploads/img/' . rawurlencode($product->product_image))}}
					@else
			              {{asset('/img/cart_1.png')}}
					@endif

    @else
        {{asset('/img/cart_1.png')}}
    @endif
);
background-repeat: no-repeat; background-position: center;
background-size: contain;">

</div>

<div class="text_div">
<small class="text text-muted">{{$product->name}}
@if($product->type == 'variable')
- {{$product->variation}}
@endif
</small>
{{--
<small class="text-muted">
({{$product->sub_sku}})
</small>--}}
</div>

</div>
</div>
@empty
<input type="hidden" id="no_products_found">
{{--<div class="col-md-12">
<h4 class="text-center">
@lang('lang_v1.no_products_to_display')
</h4>
</div>--}}
@endforelse
</div>