<div class="modal-dialog" role="document">
    <div class="modal-content">

        <?php echo Form::open(['url' => action('\Modules\ChartOfAccounts\Http\Controllers\ChartOfAccountsController@saveacount'), 'method' => 'post','id' => 'add_chart_account' ]); ?>

        <input type="hidden" value="<?php echo e($account->id, false); ?>" class="form-control" name="account_id">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>

            <?php if(!empty($account->id)): ?>
                <h4 class="modal-title"><?php echo app('translator')->get( 'chartofaccounts::lang.edit_account' ); ?> : <span style="color: #6F1212ED;"><?php echo e($account->account_code, false); ?> - <?php echo e($account->name, false); ?></span></h4>
            <?php else: ?>
                <h4 class="modal-title"><?php echo app('translator')->get( 'chartofaccounts::lang.add_account' ); ?></h4>
            <?php endif; ?>

        </div>

        <div class="modal-body">

            <div class="row">

                <?php
                $disabled='';
               if($account->parent_id==0 && $account->id){
                   $disabled='disabled';
                   $account->parent_id=$account->id;
               }

               ?>
                <div class="col-md-6">
                    <div class="form-group">
                        <?php echo Form::label('parent_id', __('chartofaccounts::lang.themain_account') ); ?>

                        <?php echo Form::select('parent_id', $accounts,$account->parent_id, ['class' => 'form-control select2', 'style' => 'width:100%', 'id' => 'parent_id',$disabled ]); ?>


                    </div>
                </div>


                <div class="col-md-6">
                    <div class="form-group">
                        <?php echo Form::label('name', __( 'chartofaccounts::lang.account_name' ) . ':*'); ?>

                        <?php echo Form::text('name', $account->name, ['class' => 'form-control', 'required' ]); ?>

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <?php echo Form::label('account_code', __( 'chartofaccounts::lang.account_code' ) . ':'); ?>

                        <input type="text" value="<?php echo e($account->account_code, false); ?>" name="account_code" id="account_code"
                               class="form-control" style="max-width:200px">

                    </div>
                </div>


                <div class="col-md-6">
                    <div class="form-group">
                        <?php echo Form::label('account_nature', __( 'chartofaccounts::lang.journal_cat' ) ); ?>

                        <select name="account_nature" id="account_nature " class="form-control">
                            <option value="-1" <?php if($account->account_nature==-1): ?> selected <?php endif; ?>><?php echo app('translator')->get('chartofaccounts::lang.journal_debt'); ?></option>
                            <option value="1" <?php if($account->account_nature==1): ?> selected <?php endif; ?>><?php echo app('translator')->get('chartofaccounts::lang.journal_cridet'); ?></option>
                        </select>
                    </div>

                </div>
                <div class="col-md-6">
                                   <div class="form-group">
                                       <?php echo Form::label('account_type', __( 'chartofaccounts::lang.account_type' ) ); ?>

                                       <?php echo Form::select('account_type', $account_type, $account->account_type, ['class' => 'form-control select2', 'style' => 'width:100%', 'id' => 'account_type','require',$disabled ]); ?>


                                   </div>
                               </div>

                    <div class="col-lg-12 mt-15">
                        <?php echo Form::label('notes','ملاحظات: '); ?>

                        <input type="text" name="notes" value="" id="notes" class="form-control">

                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"><?php echo app('translator')->get( 'messages.save' ); ?></button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo app('translator')->get( 'messages.close' ); ?></button>
            </div>

            <?php echo Form::close(); ?>


        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog --><?php /**PATH G:\laragon\www\prosofteg\Modules/ChartOfAccounts\Resources/views/accounts/create.blade.php ENDPATH**/ ?>