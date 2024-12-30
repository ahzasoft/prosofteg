<?php $__env->startSection('title', __('essentials::lang.allowance_and_deduction')); ?>

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('essentials::layouts.nav_hrm', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<section class="content-header">
    <h1><?php echo app('translator')->get('essentials::lang.allowance_and_deduction'); ?>
    </h1>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?php $__env->startComponent('components.widget', ['class' => 'box-solid']); ?>
                <?php $__env->slot('tool'); ?>
                    <div class="box-tools">
                        <button type="button" class="btn btn-block btn-primary btn-modal" data-href="<?php echo e(action('\Modules\Essentials\Http\Controllers\EssentialsAllowanceAndDeductionController@create'), false); ?>" data-container="#add_allowance_deduction_modal">
                            <i class="fa fa-plus"></i> <?php echo app('translator')->get( 'messages.add' ); ?></button>
                    </div>
                <?php $__env->endSlot(); ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="ad_table">
                        <thead>
                            <tr>
                                <th><?php echo app('translator')->get( 'lang_v1.description' ); ?></th>
                                <th><?php echo app('translator')->get( 'lang_v1.type' ); ?></th>
                                <th><?php echo app('translator')->get( 'sale.amount' ); ?></th>
                                <th><?php echo app('translator')->get( 'essentials::lang.applicable_date' ); ?></th>
                                <th><?php echo app('translator')->get( 'essentials::lang.employee' ); ?></th>
                                <th><?php echo app('translator')->get( 'messages.action' ); ?></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            <?php echo $__env->renderComponent(); ?>
        </div>
    </div>
    <div class="row" id="user_leave_summary"></div>
</section>
<!-- /.content -->
<div class="modal fade" id="add_allowance_deduction_modal" tabindex="-1" role="dialog"
 aria-labelledby="gridSystemModalLabel"></div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
    <script type="text/javascript">
        $('#add_allowance_deduction_modal').on('shown.bs.modal', function(e) {
            var $p = $(this);
            $('#add_allowance_deduction_modal .select2').select2({dropdownParent:$p});
            $('#add_allowance_deduction_modal #applicable_date').datepicker();
            
        });

        $(document).on('submit', 'form#add_allowance_form', function(e) {
            e.preventDefault();
            $(this).find('button[type="submit"]').attr('disabled', true);
            var data = $(this).serialize();

            $.ajax({
                method: $(this).attr('method'),
                url: $(this).attr('action'),
                dataType: 'json',
                data: data,
                success: function(result) {
                    if (result.success == true) {
                        $('div#add_allowance_deduction_modal').modal('hide');
                        toastr.success(result.msg);
                        ad_table.ajax.reload();
                    } else {
                        toastr.error(result.msg);
                    }
                },
            });
        });

        $(document).ready(function() {
            ad_table = $('#ad_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "<?php echo e(action('\Modules\Essentials\Http\Controllers\EssentialsAllowanceAndDeductionController@index'), false); ?>",
                columns: [
                    { data: 'description', name: 'description' },
                    { data: 'type', name: 'type' },
                    { data: 'amount', name: 'amount' },
                    { data: 'applicable_date', name: 'applicable_date' },
                    { data: 'employees', searchable: false, orderable: false },
                    { data: 'action', name: 'action' }
                ],
                fnDrawCallback: function(oSettings) {
                    __currency_convert_recursively($('#ad_table'));
                },
            });
        });

        $(document).on('click', '.delete-allowance', function(e) {
            e.preventDefault();
            swal({
                title: LANG.sure,
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            }).then(willDelete => {
                if (willDelete) {
                    var href = $(this).data('href');
                    var data = $(this).serialize();

                    $.ajax({
                        method: 'DELETE',
                        url: href,
                        dataType: 'json',
                        data: data,
                        success: function(result) {
                            if (result.success == true) {
                                toastr.success(result.msg);
                                ad_table.ajax.reload();
                            } else {
                                toastr.error(result.msg);
                            }
                        },
                    });
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\laragon\www\AZHA-ERP\Modules\Essentials\Providers/../Resources/views/allowance_deduction/index.blade.php ENDPATH**/ ?>