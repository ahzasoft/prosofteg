<?php $__env->startSection('title', __('superadmin::lang.superadmin') . ' | Business'); ?>

<?php $__env->startSection('content'); ?>

<!-- Main content -->
<section class="content">

	<div class="box box-solid">
        <div class="box-header">
        	<h3 class="box-title"><?php echo app('translator')->get( 'superadmin::lang.add_new_business' ); ?> <small>(<?php echo app('translator')->get( 'superadmin::lang.add_business_help' ); ?>)</small></h3>
        </div>

        <div class="box-body">
                <?php echo Form::open(['url' => action('\Modules\Superadmin\Http\Controllers\BusinessController@store'), 'method' => 'post', 'id' => 'business_register_form','files' => true ]); ?>

                    <?php echo $__env->make('business.partials.register_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <div class="clearfix"></div>
                    <div class="col-md-12"><hr></div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <?php echo Form::label('package_id', __( 'superadmin::lang.subscription_packages' ) . ':'); ?>

                            <?php echo Form::select('package_id', $packages, null, ['class' => 'form-control', 'placeholder' => __( 'messages.please_select' ) ]); ?>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <?php echo Form::label('paid_via', __( 'superadmin::lang.paid_via' ) . ':'); ?>

                            <?php echo Form::select('paid_via', $gateways, null, ['class' => 'form-control', 'placeholder' => __( 'messages.please_select' ) ]); ?>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <?php echo Form::label('payment_transaction_id', __( 'superadmin::lang.payment_transaction_id' ) . ':'); ?>

                            <?php echo Form::text('payment_transaction_id', null, ['class' => 'form-control', 'placeholder' => __( 'superadmin::lang.payment_transaction_id' ) ]); ?>

                         </div>
                    </div>

                    <?php echo Form::submit(__('messages.submit'), ['class' => 'btn btn-success pull-right']); ?>

                <?php echo Form::close(); ?>

        </div>
    </div>

    <div class="modal fade brands_modal" tabindex="-1" role="dialog" 
    	aria-labelledby="gridSystemModalLabel">
    </div>

</section>
<!-- /.content -->
<?php $__env->stopSection(); ?>


<?php $__env->startSection('javascript'); ?>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.select2_register').select2();
            $("form#business_register_form").validate({
                errorPlacement: function(error, element) {
                    if(element.parent('.input-group').length) {
                        error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                    }
                },
                rules: {
                    name: "required",
                    email: {
                        email: true,
                        remote: {
                            url: "/business/register/check-email",
                            type: "post",
                            data: {
                                email: function() {
                                    return $( "#email" ).val();
                                }
                            }
                        }
                    },
                    password: {
                        required: true,
                        minlength: 5
                    },
                    confirm_password: {
                        equalTo: "#password"
                    },
                    paid_via: {
                        required: function(element){
                                return $('#package_id').val() != '';
                            }
                    },
                    username: {
                        required: true,
                        minlength: 4,
                        remote: {
                            url: "/business/register/check-username",
                            type: "post",
                            data: {
                                username: function() {
                                    return $( "#username" ).val();
                                }
                            }
                        }
                    }
                },
                messages: {
                    name: LANG.specify_business_name,
                    password: {
                        minlength: LANG.password_min_length,
                    },
                    confirm_password: {
                        equalTo: LANG.password_mismatch
                    },
                    username: {
                        remote: LANG.invalid_username
                    },
                    email: {
                        remote: '<?php echo e(__("validation.unique", ["attribute" => __("business.email")]), false); ?>'
                    }
                }
            });

            $("#business_logo").fileinput({'showUpload':false, 'showPreview':false, 'browseLabel': LANG.file_browse_label, 'removeLabel': LANG.remove});
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\laragon\www\prosofteg\Modules\Superadmin\Providers/../Resources/views/business/create.blade.php ENDPATH**/ ?>