<div class="modal-dialog" role="document">
  <div class="modal-content">

    <?php echo Form::open(['url' => action('\Modules\Essentials\Http\Controllers\EssentialsAllowanceAndDeductionController@store'), 'method' => 'post', 'id' => 'add_allowance_form' ]); ?>


    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title"><?php echo app('translator')->get( 'essentials::lang.add_allowance_and_deduction' ); ?></h4>
    </div>

    <div class="modal-body">
    	<div class="row">
    		<div class="form-group col-md-12">
	        	<?php echo Form::label('description', __( 'lang_v1.description' ) . ':*'); ?>

	          	<?php echo Form::text('description', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'lang_v1.description' ) ]); ?>

	      	</div>

	      	<div class="form-group col-md-12">
	        	<?php echo Form::label('type', __( 'lang_v1.type' ) . ':*'); ?>

	          	<?php echo Form::select('type', ['allowance' => __('essentials::lang.allowance'), 'deduction' => __('essentials::lang.deduction')], 'allowance', ['class' => 'form-control', 'required' ]); ?>

	      	</div>

	      	<div class="form-group col-md-12">
	        	<?php echo Form::label('employees', __('essentials::lang.employee') . ':*'); ?>

	          	<?php echo Form::select('employees[]', $users, null, ['class' => 'form-control select2', 'required', 'multiple' ]); ?>

	      	</div>

	      	<div class="form-group col-md-6">
	        	<?php echo Form::label('amount_type', __( 'essentials::lang.amount_type' ) . ':*'); ?>

	          	<?php echo Form::select('amount_type', ['fixed' => __('lang_v1.fixed'), 'percent' => __('lang_v1.percentage')], 'fixed', ['class' => 'form-control', 'required' ]); ?>

	      	</div>
	      	
	      	<div class="form-group col-md-6">
	        	<?php echo Form::label('amount', __( 'sale.amount' ) . ':*'); ?>

	          	<?php echo Form::text('amount', null, ['class' => 'form-control input_number', 'placeholder' => __( 'sale.amount' ), 'required' ]); ?>

	      	</div>

	      	<div class="form-group col-md-12">
	        	<?php echo Form::label('applicable_date', __( 'essentials::lang.applicable_date' ) . ':'); ?> <?php
                if(session('business.enable_tooltip')){
                    echo '<i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" 
                    data-container="body" data-toggle="popover" data-placement="auto bottom" 
                    data-content="' . __('essentials::lang.applicable_date_help') . '" data-html="true" data-trigger="hover"></i>';
                }
                ?>
	        	<div class="input-group data">
	        		<?php echo Form::text('applicable_date', null, ['class' => 'form-control', 'placeholder' => __( 'essentials::lang.applicable_date' ), 'readonly' ]); ?>

	        		<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
	        	</div>
	      	</div>
    	</div>
    </div>

    <div class="modal-footer">
      <button type="submit" class="btn btn-primary"><?php echo app('translator')->get( 'messages.save' ); ?></button>
      <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo app('translator')->get( 'messages.close' ); ?></button>
    </div>

    <?php echo Form::close(); ?>


  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog --><?php /**PATH G:\laragon\www\AZHA-ERP\Modules\Essentials\Providers/../Resources/views/allowance_deduction/create.blade.php ENDPATH**/ ?>