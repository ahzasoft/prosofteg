@extends('layouts.app')
@section('title', __('superadmin::lang.superadmin') . ' | ' . __('superadmin::lang.packages'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang('superadmin::lang.packages') <small>@lang('superadmin::lang.all_packages')</small></h1>
    <!-- <ol class="breadcrumb">
        <a href="#"><i class="fa fa-dashboard"></i> Level</a><br/>
        <li class="active">Here<br/>
    </ol> -->
</section>

<!-- Main content -->
<section class="content">
	@include('superadmin::layouts.partials.currency')

	<div class="box">
        <div class="box-header">
            <h3 class="box-title">&nbsp;</h3>
        	<div class="box-tools">
                <a href="{{action('\Modules\Superadmin\Http\Controllers\PackagesController@create')}}" 
                    class="btn btn-block btn-primary">
                	<i class="fa fa-plus"></i> @lang( 'messages.add' )</a>
            </div>
        </div>

        <div class="box-body">
        	@foreach ($packages as $package)
                <div class="col-md-4">
                	
					<div class="box box-success hvr-grow-shadow">
						<div class="box-header with-border text-center">
							<h2 class="box-title">{{$package->name}}</h2>

							<div class="row">
								@if($package->is_active == 1)
									<span class="badge bg-green">
										@lang('superadmin::lang.active')
									</span>
								@else
									<span class="badge bg-red">
									@lang('superadmin::lang.inactive')
									</span>
								@endif
								

							</div>
						</div>
						<!-- /.box-header -->
						<div class="box-body text-center" style="text-align: right;line-height: initial;">

							@if($package->location_count == 0)
								@lang('superadmin::lang.unlimited')
							@else
								{{$package->location_count}}
							@endif

							@lang('business.business_locations')
							<br/>

							@if($package->user_count == 0)
								@lang('superadmin::lang.unlimited')
							@else
								{{$package->user_count}}
							@endif

							@lang('superadmin::lang.users')
							<br/>
						
							@if($package->product_count == 0)
								@lang('superadmin::lang.unlimited')
							@else
								{{$package->product_count}}
							@endif

							@lang('superadmin::lang.products')
							<br/>

							@if($package->invoice_count == 0)
								@lang('superadmin::lang.unlimited')
							@else
								{{$package->invoice_count}}
							@endif

							@lang('superadmin::lang.invoices')
							<br/>

							@if($package->trial_days != 0)
									@lang('superadmin::lang.trial_days') :{{$package->trial_days}}
								<br/>
							@endif
                               @if(!empty($package->basic_permissions))
								   @foreach($package->basic_permissions as $permission=>$key)
									<i class="fa fa-check"></i>	{{__('lang_v1.'.str_replace("'","",$permission))}}
									<br/>

								   @endforeach

								@endif
                            <hr>
							@if(!empty($package->custom_permissions))
								@foreach($package->custom_permissions as $permission => $value)
									@isset($permission_formatted[$permission])
										{{$permission_formatted[$permission]}}
										<br/>
									@endisset
								@endforeach
							@endif
							
							<h3 class="text-center">
								@if($package->price != 0)
									<span class="display_currency" >
										{{$package->price}}
									</span>

									<small>
										/ {{$package->interval_count}} {{__('lang_v1.' . $package->interval)}}
									</small>
								@else
									@lang('superadmin::lang.free_for_duration', ['duration' => $package->interval_count . ' ' . __('lang_v1.' . $package->interval)])
								@endif
							</h3>

						</div>
						<!-- /.box-body -->

						<div class="box-footer text-center">
							{{$package->description}}
						</div>
						<div class="packag-footer" style="margin-bottom: 20px;text-align: center;">
						<a href="{{action('\Modules\Superadmin\Http\Controllers\PackagesController@edit', [$package->id])}}" class="btn btn-primary" title="edit"><i class="fa fa-edit"></i></a>
							<a href="{{action('\Modules\Superadmin\Http\Controllers\PackagesController@destroy', [$package->id])}}" class="btn btn-danger link_confirmation" title="delete"><i class="fa fa-trash"></i></a>
						</div>
					</div>

                </div>
                @if($loop->iteration%3 == 0)
    				<div class="clearfix"></div>
    			@endif
            @endforeach


            <div class="col-md-12">
                {{ $packages->links() }}
            </div>
        </div>

    </div>

    <div class="modal fade brands_modal" tabindex="-1" role="dialog" 
    	aria-labelledby="gridSystemModalLabel">
    </div>

</section>
<!-- /.content -->

@endsection