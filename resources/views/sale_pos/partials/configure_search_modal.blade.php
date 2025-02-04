<div class="modal fade" id="configure_search_modal" tabindex="-1" role="dialog" 
	aria-labelledby="gridSystemModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">
					@lang('lang_v1.search_products_by')
				</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="checkbox">
							<label>
				              	{!! Form::checkbox('search_fields[]', 'name', true, ['class' => 'input-icheck search_fields']); !!} @lang('product.product_name')
				            </label>
						</div>
					</div>
					<div class="col-md-12">
						<div class="checkbox">
							<label>
				              	{!! Form::checkbox('search_fields[]', 'sku', true, ['class' => 'input-icheck search_fields']); !!} @lang('product.sku')
				            </label>
						</div>
					</div>
					@if(request()->session()->get('business.enable_lot_number') == 1)
					   <div class="col-md-12">
						<div class="checkbox">
							<label>
				              	{!! Form::checkbox('search_fields[]', 'lot', true, ['class' => 'input-icheck search_fields']); !!} @lang('lang_v1.lot_number')
				            </label>
						</div>
					</div>
					@endif
					@if (isset($pos_settings['enable_weighing_scale']) && $pos_settings['enable_weighing_scale'] == 1)
						<div class="col-md-12">
							<div class="checkbox">
								<label>
									{!! Form::checkbox('search_fields[]', 'weighing_scale_barcode', true, ['class' => 'input-icheck search_fields']); !!} @lang('lang_v1.weighing_scale_barcode')
								</label>
							</div>
						</div>
					@endif


				</div>
			</div>
			<div class="modal-footer">
			    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.close')</button>
			</div>
		</div>
	</div>
</div>