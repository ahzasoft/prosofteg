<?php $__env->startSection('title', __('account.account_book')); ?>

<?php $__env->startSection('content'); ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo app('translator')->get('account.account_book'); ?>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-sm-4 col-xs-6">
            <div class="box box-solid">
                <div class="box-body">
                    <table class="table">
                        <tr>
                            <th><?php echo app('translator')->get('account.account_name'); ?>: </th>
                            <td><?php echo e($account->name, false); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo app('translator')->get('lang_v1.account_type'); ?>:</th>
                            <td><?php if(!empty($account->account_type->parent_account)): ?> <?php echo e($account->account_type->parent_account->name, false); ?> - <?php endif; ?> <?php echo e($account->account_type->name ?? '', false); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo app('translator')->get('account.account_number'); ?>:</th>
                            <td><?php echo e($account->account_number, false); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo app('translator')->get('lang_v1.balance'); ?>:</th>
                            <td><span id="account_balance"></span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-8 col-xs-12">
            <div class="box box-solid">
                <div class="box-header">
                    <h3 class="box-title"> <i class="fa fa-filter" aria-hidden="true"></i> <?php echo app('translator')->get('report.filters'); ?>:</h3>
                </div>
                <div class="box-body">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <?php echo Form::label('transaction_date_range', __('report.date_range') . ':'); ?>

                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <?php echo Form::text('transaction_date_range', null, ['class' => 'form-control', 'readonly', 'placeholder' => __('report.date_range')]); ?>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <?php echo Form::label('transaction_type', __('account.transaction_type') . ':'); ?>

                            <div class="input-group">
                                <span class="input-group-addon"><i class="fas fa-exchange-alt"></i></span>
                                <?php echo Form::select('transaction_type', ['' => __('messages.all'),'debit' => __('account.debit'), 'credit' => __('account.credit')], '', ['class' => 'form-control']); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
        	<div class="box">
                <div class="box-body">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('account.access')): ?>
                        <div class="table-responsive">
                    	<table class="table table-bordered table-striped" id="account_book">
                    		<thead>
                    			<tr>
                                    <th><?php echo app('translator')->get( 'messages.date' ); ?></th>
                                    <th><?php echo app('translator')->get( 'lang_v1.description' ); ?></th>
                                    <th><?php echo app('translator')->get( 'lang_v1.payment_method' ); ?></th>
                                    <th><?php echo app('translator')->get( 'lang_v1.payment_details' ); ?></th>
                                    <th><?php echo app('translator')->get( 'brand.note' ); ?></th>
                                    <th><?php echo app('translator')->get( 'lang_v1.added_by' ); ?></th>
                                    <th><?php echo app('translator')->get('account.debit'); ?>(إيداع)</th>
                                    <th><?php echo app('translator')->get('account.credit'); ?>(سحب)</th>
                    				<th><?php echo app('translator')->get( 'lang_v1.balance' ); ?></th>
                                    <th><?php echo app('translator')->get( 'messages.action' ); ?></th>
                    			</tr>
                    		</thead>
                            <tfoot>
                            <tr class="bg-gray font-17 footer-total text-center">
                                <td colspan="6"><strong><?php echo app('translator')->get('sale.total'); ?>:</strong></td>
                                <td class="footer_total_debit"></td>
                                <td class="footer_total_credit"></td>
                                <td></td>
                                <td></td>
                            </tr>
                            </tfoot>
                    	</table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    

    <div class="modal fade account_model" tabindex="-1" role="dialog" 
    	aria-labelledby="gridSystemModalLabel">
    </div>
    <div class="modal fade account_model" tabindex="-1" role="dialog" 
        aria-labelledby="gridSystemModalLabel" id="edit_account_transaction">
    </div>

</section>
<!-- /.content -->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
<script>
    $(document).ready(function(){
        update_account_balance();

      /*  dateRangeSettings.startDate = moment().subtract(6, 'days');
        dateRangeSettings.endDate = moment();*/
        $('#transaction_date_range').daterangepicker(
            dateRangeSettings,
            function (start, end) {
                $('#transaction_date_range').val(start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format));
                
                account_book.ajax.reload();
            }
        );
        
        // Account Book
        account_book = $('#account_book').DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: {
                                url: '<?php echo e(action("AccountController@show",[$account->id]), false); ?>',
                                type:'POST',
                                data: function(d) {
                                    var start = '';
                                    var end = '';
                                    if($('#transaction_date_range').val()){
                                        start = $('input#transaction_date_range').data('daterangepicker').startDate.format('YYYY-MM-DD');
                                        end = $('input#transaction_date_range').data('daterangepicker').endDate.format('YYYY-MM-DD');
                                    }
                                    var transaction_type = $('select#transaction_type').val();
                                    d.start_date = start;
                                    d.end_date = end;
                                    d.type = transaction_type;
                                }
                            },
                            "ordering": false,
                            "searching": false,
                            columns: [
                                {data: 'operation_date', name: 'operation_date'},
                                {data: 'sub_type', name: 'sub_type'},
                                {data: 'method', name: 'TP.method'},
                                {data: 'payment_details', name: 'payment_details', searchable: false},
                                {data: 'note', name: 'note'},
                                {data: 'added_by', name: 'added_by'},
                                {data: 'credit', name: 'amount'},
                                {data: 'debit', name: 'amount'},
                                {data: 'balance', name: 'balance'},
                                {data: 'action', name: 'action'}
                            ],
                            "fnDrawCallback": function (oSettings) {
                                __currency_convert_recursively($('#account_book'));
                            },
                            "footerCallback": function ( row, data, start, end, display ) {
                                var footer_total_debit = 0;
                                var footer_total_credit = 0;

                                for (var r in data){
                                    footer_total_debit += $(data[r].credit).data('orig-value') ? parseFloat($(data[r].credit).data('orig-value')) : 0;
                                    footer_total_credit += $(data[r].debit).data('orig-value') ? parseFloat($(data[r].debit).data('orig-value')) : 0;
                                }

                                $('.footer_total_debit').html(__currency_trans_from_en(footer_total_debit));
                                $('.footer_total_credit').html(__currency_trans_from_en(footer_total_credit));
                            }
                        });

        $('#transaction_type').change( function(){
            account_book.ajax.reload();
        });
        $('#transaction_date_range').on('cancel.daterangepicker', function(ev, picker) {
            $('#transaction_date_range').val('');
            account_book.ajax.reload();
        });

        $('#edit_account_transaction').on('shown.bs.modal', function(e) {
            $('#edit_account_transaction_form').validate({
                submitHandler: function(form) {
                    e.preventDefault();
                    var data = $(form).serialize();
                    $.ajax({
                        method: 'POST',
                        url: $(form).attr('action'),
                        dataType: 'json',
                        data: data,
                        beforeSend: function(xhr) {
                            __disable_submit_button($(form).find('button[type="submit"]'));
                        },
                        success: function(result) {
                            if (result.success == true) {
                                $('#edit_account_transaction').modal('hide');
                                toastr.success(result.msg);

                                if (typeof(account_book) != 'undefined') {
                                    account_book.ajax.reload();
                                }
                                
                            } else {
                                toastr.error(result.msg);
                            }
                        },
                    });
                },
            });
        })

    });

    $(document).on('click', '.delete_account_transaction', function(e){
        e.preventDefault();
        swal({
          title: LANG.sure,
          icon: "warning",
          buttons: true,
          dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                var href = $(this).data('href');
                $.ajax({
                    url: href,
                    dataType: "json",
                    success: function(result){
                        if(result.success === true){
                            toastr.success(result.msg);
                            account_book.ajax.reload();
                            update_account_balance();
                        } else {
                            toastr.error(result.msg);
                        }
                    }
                });
            }
        });
    });

    function update_account_balance(argument) {
        $('span#account_balance').html('<i class="fas fa-sync fa-spin"></i>');
        $.ajax({
            url: '<?php echo e(action("AccountController@getAccountBalance", [$account->id]), false); ?>',
            dataType: "json",
            success: function(data){
                $('span#account_balance').text(__currency_trans_from_en(data.balance, true));
            }
        });
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\laragon\www\AZHA-ERP\resources\views/account/show.blade.php ENDPATH**/ ?>