
<?php $__env->startSection('title', __('lang_v1.login')); ?>

<?php $__env->startSection('content'); ?>

            <div class="" style="background-color: white; padding: 10px 30px 30px 30px;border-radius: 10px;max-width: 350px;margin: auto; margin-top: 70px;">

                <div style="text-align: center;
                    color: #FFF;
                    background-color: #31313C;
                    margin: -30px -30px 30px -30px;
                    border-radius: 10px 10px 0px 0px;
                    padding-top: 1px;
                    padding-bottom: 15px;">

                    <h3 style="color: #FFFFFF"><?php echo e(env('APP_TITLE','AZHA-ERP'), false); ?></h3>

                </div>

               

                <form method="POST" action="<?php echo e(route('login'), false); ?>" id="login-form">
                    <?php echo e(csrf_field(), false); ?>


                    
                    <div class="form-group has-feedback <?php echo e($errors->has('username') ? ' has-error' : '', false); ?>" >
                        <?php
                            $username = old('username');
                            $password = null;
                            if(config('app.env') == 'demo'){
                                $username = 'admin';
                                $password = '123456';

                                $demo_types = array(
                                    'all_in_one' => 'admin',
                                    'super_market' => 'admin',
                                    'pharmacy' => 'admin-pharmacy',
                                    'electronics' => 'admin-electronics',
                                    'services' => 'admin-services',
                                    'restaurant' => 'admin-restaurant',
                                    'superadmin' => 'superadmin',
                                    'woocommerce' => 'woocommerce_user',
                                    'essentials' => 'admin-essentials',
                                    'manufacturing' => 'manufacturer-demo',
                                );

                                if( !empty($_GET['demo_type']) && array_key_exists($_GET['demo_type'], $demo_types) ){
                                    $username = $demo_types[$_GET['demo_type']];
                                }
                            }
                        ?>
                        <input id="username" type="text" class="form-control" name="username" value="<?php echo e($username, false); ?>" required autofocus placeholder="<?php echo app('translator')->get('lang_v1.username'); ?>">
                        <span class="fa fa-user form-control-feedback"></span>
                        <?php if($errors->has('username')): ?>
                            <span class="help-block">
                        <strong><?php echo e($errors->first('username'), false); ?></strong>
                    </span>
                        <?php endif; ?>
                    </div>

                    
                    <div class="form-group has-feedback <?php echo e($errors->has('password') ? ' has-error' : '', false); ?>">
                        <input id="password" type="password" class="form-control" name="password"
                               value="<?php echo e($password, false); ?>" required placeholder="<?php echo app('translator')->get('lang_v1.password'); ?>">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        <?php if($errors->has('password')): ?>
                            <span class="help-block">
                        <strong><?php echo e($errors->first('password'), false); ?></strong>
                    </span>
                        <?php endif; ?>
                    </div>


                    <div class="form-group">
                        <div class="checkbox icheck">
                            <label style="color: #0c0c0c">
                                <input type="checkbox" name="remember" <?php echo e(old('remember') ? 'checked' : '', false); ?>> <?php echo app('translator')->get('lang_v1.remember_me'); ?>
                            </label>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-flat btn-login" style="border-radius: 10px;height: 50px;font-size: 19px;"><?php echo app('translator')->get('lang_v1.login'); ?></button>

                   </div>
                    <div class="form-group" style="padding-bottom: 9px;">
                        <?php if(config('app.env') != 'demo'): ?>
                            <a href="<?php echo e(route('password.request'), false); ?>" class="pull-right" style="color: #0c0c0c">
                                <?php echo app('translator')->get('lang_v1.forgot_your_password'); ?>
                            </a>
                        <?php endif; ?>
                    </div>

                       </form>

            </div>


            <?php if(config('constants.allow_test')): ?>
           <div class="" style="text-align: center;background-color: white; padding: 6px 10px 15px 10px;border-radius: 10px;max-width: 350px;margin: auto; margin-top: 70px;">
             <h3>لتجربة البرنامج يمكنك الضغط هنا </h3>
               <button type="button" class="btn btn-danger btn-flat btn-login" style="border-radius: 10px;height: 50px;font-size: 19px;" id="test" >تجربة البرنامج </button>

           </div>
       <?php endif; ?>

<?php $__env->stopSection(); ?>



<?php $__env->startSection('javascript'); ?>
<script type="text/javascript">
   $(document).ready(function(){
       $('#change_lang').change( function(){
           window.location = "<?php echo e(route('login'), false); ?>?lang=" + $(this).val();
       });

       $('#test').click( function (e) {
          e.preventDefault();
          $('#username').val('demouser');
          $('#password').val("123456");
          $('form#login-form').submit();
       });
   })
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth2_old', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\laragon\www\AZHA-ERP\resources\views/auth/login.blade.php ENDPATH**/ ?>