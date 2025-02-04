@extends('layouts.app')
@section('title', __('lang_v1.'.$type.'s'))
@php
    $api_key = env('GOOGLE_MAP_API_KEY');
@endphp
@if(!empty($api_key))
    @section('css')
        @include('contact.partials.google_map_styles')
    @endsection
@endif
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> @lang('lang_v1.'.$type.'s')
        <small>@lang( 'contact.manage_your_contact', ['contacts' =>  __('lang_v1.'.$type.'s') ])</small>
    </h1>
    <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
</section>

<!-- Main content -->
<section class="content">
    <input type="hidden" value="{{$type}}" id="contact_type">
    @component('components.widget', ['class' => 'box-primary', 'title' => __( 'contact.all_your_contact', ['contacts' => __('lang_v1.'.$type.'s') ])])
        @if(auth()->user()->can('supplier.create') || auth()->user()->can('customer.create') || auth()->user()->can('supplier.view_own') || auth()->user()->can('customer.view_own'))
            @slot('tool')
                <div class="box-tools">
                    <button type="button" class="btn btn-block btn-primary btn-modal"
                    data-href="{{action('ContactController@create', ['type' => $type])}}"
                    data-container=".contact_modal">
                    <i class="fa fa-plus"></i> @lang('messages.add')</button>
                </div>
            @endslot
        @endif
        @if(auth()->user()->can('supplier.view') || auth()->user()->can('customer.view') || auth()->user()->can('supplier.view_own') || auth()->user()->can('customer.view_own'))
            <table class="table table-bordered table-striped" id="contact_table">
                <thead>
                    <tr>
                        <th>@lang('messages.action')</th>
                        <th>@lang('lang_v1.contact_id')</th>
                        @if($type == 'supplier')
                            <th>@lang('business.business_name')</th>
                            <th>@lang('contact.name')</th>
                            <th>@lang('business.email')</th>
                            <th>@lang('contact.tax_no')</th>
                            <th>@lang('contact.pay_term')</th>
                            <th>@lang('account.opening_balance')</th>
                            <th>@lang('lang_v1.advance_balance')</th>
                            <th>@lang('lang_v1.added_on')</th>
                            <th>@lang('business.address')</th>
                            <th>@lang('contact.mobile')</th>
                            <th>@lang('contact.total_purchase_due')</th>
                            <th>@lang('lang_v1.total_purchase_return_due')</th>
                        @elseif( $type == 'customer')
                            <th>@lang('business.business_name')</th>
                            <th>@lang('user.name')</th>
                            <th>@lang('business.email')</th>
                            <th>@lang('contact.tax_no')</th>
                            <th>@lang('lang_v1.credit_limit')</th>
                            <th>@lang('contact.pay_term')</th>
                            <th>@lang('account.opening_balance')</th>
                            <th>@lang('lang_v1.advance_balance')</th>
                            <th>@lang('lang_v1.added_on')</th>
                            @if($reward_enabled)
                                <th id="rp_col">{{session('business.rp_name')}}</th>
                            @endif
                            <th>@lang('lang_v1.customer_group')</th>
                            <th>@lang('business.address')</th>
                            <th>@lang('contact.mobile')</th>
                            <th>@lang('contact.total_sale_due')</th>
                            <th>@lang('lang_v1.total_sell_return_due')</th>
                        @endif
                        @php
                            $custom_labels = json_decode(session('business.custom_labels'), true);
                        @endphp
                        <th>
                            {{ $custom_labels['contact']['custom_field_1'] ?? __('lang_v1.contact_custom_field1') }}
                        </th>
                        <th>
                            {{ $custom_labels['contact']['custom_field_2'] ?? __('lang_v1.contact_custom_field2') }}
                        </th>
                        <th>
                            {{ $custom_labels['contact']['custom_field_3'] ?? __('lang_v1.contact_custom_field3') }}
                        </th>
                        <th>
                            {{ $custom_labels['contact']['custom_field_4'] ?? __('lang_v1.contact_custom_field4') }}
                        </th>
                        <th>
                            {{ $custom_labels['contact']['custom_field_5'] ?? __('lang_v1.custom_field', ['number' => 5]) }}
                        </th>
                        <th>
                            {{ $custom_labels['contact']['custom_field_6'] ?? __('lang_v1.custom_field', ['number' => 6]) }}
                        </th>
                        <th>
                            {{ $custom_labels['contact']['custom_field_7'] ?? __('lang_v1.custom_field', ['number' => 7]) }}
                        </th>
                        <th>
                            {{ $custom_labels['contact']['custom_field_8'] ?? __('lang_v1.custom_field', ['number' => 8]) }}
                        </th>
                        <th>
                            {{ $custom_labels['contact']['custom_field_9'] ?? __('lang_v1.custom_field', ['number' => 9]) }}
                        </th>
                        <th>
                            {{ $custom_labels['contact']['custom_field_10'] ?? __('lang_v1.custom_field', ['number' => 10]) }}
                        </th>
                    </tr>
                </thead>
                <tfoot>
                    <tr class="bg-gray font-17 text-center footer-total">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td
                            @if($type == 'supplier')
                                colspan="6"
                            @elseif( $type == 'customer')
                                @if($reward_enabled)
                                    colspan="9"
                                @else
                                    colspan="8"
                                @endif
                            @endif>
                                <strong>
                                    @lang('sale.total'):
                                </strong>
                        </td>
                        <td id="footer_contact_due"></td>
                        <td id="footer_contact_return_due"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        @endif
    @endcomponent

    <div class="modal fade contact_modal" tabindex="-1" role="dialog"
    	aria-labelledby="gridSystemModalLabel">
    </div>
    <div class="modal fade pay_contact_due_modal" tabindex="-1" role="dialog"
        aria-labelledby="gridSystemModalLabel">
    </div>

</section>
<!-- /.content -->
@stop
@section('javascript')
    <script type="text/javascript">
        $(document).on('change','#parent_id,#sub_account_id',function(){
            $.ajax({
                url:"/chartofaccounts/getaccountcode/"+$('#parent_id').val(),
                method:'GET',
                success: function(result) {
                    $('#contact_id').val(result);
                }

            });

        });

        $(document).on('change','#routing_type',function (){
            var routing_type=$('#routing_type').val();
            if(routing_type==='main_account'){
                $('#main_account_dev').removeClass('hidden');
                $('#sub_account_dev').addClass('hidden');
            }else{
                $('#main_account_dev').addClass('hidden');
                $('#sub_account_dev').removeClass('hidden');
            }


        });

    </script>

@if(!empty($api_key))
<script>





  function initAutocomplete() {
    var map = new google.maps.Map(document.getElementById('map'), {
      center: {lat: -33.8688, lng: 151.2195},
      zoom: 10,
      mapTypeId: 'roadmap'
    });

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
            map.setCenter(initialLocation);
        });
    }


    // Create the search box and link it to the UI element.
    var input = document.getElementById('shipping_address');
    var searchBox = new google.maps.places.SearchBox(input);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    // Bias the SearchBox results towards current map's viewport.
    map.addListener('bounds_changed', function() {
      searchBox.setBounds(map.getBounds());
    });

    var markers = [];
    // Listen for the event fired when the user selects a prediction and retrieve
    // more details for that place.
    searchBox.addListener('places_changed', function() {
      var places = searchBox.getPlaces();

      if (places.length == 0) {
        return;
      }

      // Clear out the old markers.
      markers.forEach(function(marker) {
        marker.setMap(null);
      });
      markers = [];

      // For each place, get the icon, name and location.
      var bounds = new google.maps.LatLngBounds();
      places.forEach(function(place) {
        if (!place.geometry) {
          console.log("Returned place contains no geometry");
          return;
        }
        var icon = {
          url: place.icon,
          size: new google.maps.Size(71, 71),
          origin: new google.maps.Point(0, 0),
          anchor: new google.maps.Point(17, 34),
          scaledSize: new google.maps.Size(25, 25)
        };

        // Create a marker for each place.
        markers.push(new google.maps.Marker({
          map: map,
          icon: icon,
          title: place.name,
          position: place.geometry.location
        }));

        //set position field value
        var lat_long = [place.geometry.location.lat(), place.geometry.location.lng()]
        $('#position').val(lat_long);

        if (place.geometry.viewport) {
          // Only geocodes have viewport.
          bounds.union(place.geometry.viewport);
        } else {
          bounds.extend(place.geometry.location);
        }
      });
      map.fitBounds(bounds);
    });
  }

</script>

<script type="text/javascript">
    $(document).on('shown.bs.modal', '.contact_modal', function(e) {
        initAutocomplete();
    });


</script>
@endif
@endsection
