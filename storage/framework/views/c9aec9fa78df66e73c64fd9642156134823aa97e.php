<?php $__env->startSection('title', __('home.home')); ?>

<?php $__env->startSection('content'); ?>

<!-- Content Header (Page header) -->
<section class="content-header content-header-custom">
    <h1><?php echo e(__('home.welcome_message', ['name' => Session::get('user.first_name')]), false); ?>

    </h1>
</section>
<!-- Main content -->
<section class="content content-custom no-print">
	<style>
       		canvas {
			-moz-user-select: none;
			-webkit-user-select: none;
			-ms-user-select: none;
		}
        .box-body{
            padding: 3px!important;
        }
        .btn-danger {
            background: #1e7f89;
            border-color: #f41e4800;
        }
        .col-custom{
            padding-left: 15px;
            padding-right: 15px;
        }

        .info-box-content {
            padding-top: 6px !important;
            padding-right: 10px !important;
            padding-bottom: 6px!important;
            padding-left: 12px!important;
            margin-left: 64px !important;
        }
.row-custom{
    padding-top: 3px;
}
	</style>
  <br>
    <?php if(auth()->user()->can('dashboard.data')): ?>




        <?php if(!empty($widgets['after_sale_purchase_totals'])): ?>
            <?php $__currentLoopData = $widgets['after_sale_purchase_totals']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $widget): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $widget; ?>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>

    <!-- sales chart start -->

          	<div class="row">
				<div class="col-md-5" style="padding-right: 3px; padding-left: 3px">
					<?php $__env->startComponent('components.widget', ['class' => 'box-primary', 'title' =>'المصروفات عن السنة الحالية']); ?>
     				<div id="canvas-holder" >
						<canvas id="canvas_expnacess" ></canvas>
					</div>
					<?php echo $__env->renderComponent(); ?>
				</div>

                <div class="col-md-5" style="padding-right: 3px; padding-left: 3px">
                    <?php $__env->startComponent('components.widget', ['class' => 'box-primary', 'title' =>'المبيعات خلال العام']); ?>
                        <div  >
                            <canvas id="sells" ></canvas>
                        </div>
                    <?php echo $__env->renderComponent(); ?>
                </div>

                <div class="col-md-2" style="padding-right: 3px; padding-left: 3px">
                    <?php $__env->startComponent('components.widget', ['class' => 'box-primary', 'title' =>'إضافات']); ?>

                        <button type="button" class="btn btn-block btn-danger btn-modal" style="margin-top: 15px;margin-bottom:15px;"
                                data-href="<?php echo e(action('ContactController@create', ['type' => 'customer']), false); ?>"
                                data-container=".contact_modal">
                           </i> إضافة عميل</button>

                        <button type="button" class="btn btn-block btn-danger btn-modal" style="margin-top: 15px;margin-bottom:15px;"
                                data-href="<?php echo e(action('ContactController@create', ['type' => 'supplier']), false); ?>"
                                data-container=".contact_modal">
                             إضافة مورد</button>
                        <a href="<?php echo e(action('ManageUserController@create'), false); ?>" class="btn btn-danger btn-block" style="margin-bottom:15px;"  > إضافة مستخدم</a>
                        <a href="<?php echo e(action('ProductController@create'), false); ?>" class="btn btn-danger btn-block" style="margin-bottom:15px;" >إضافة منتج</a>
                       <a href="<?php echo e(action('ExpenseController@create'), false); ?>" class="btn btn-danger btn-block" style="margin-bottom:15px;" >     إضافة مصروفات</a>
                      
                    <?php echo $__env->renderComponent(); ?>
                </div>
            </div>

        <?php $__env->startComponent('components.widget', ['class' => 'box-primary', 'title' =>'']); ?>
          <div class="row" style=" margin-right: 1px!important;margin-left: 1px!important;">
            <br>
              <div class="row">
                  <div class="col-md-4 col-xs-12">
                      <?php if(count($all_locations) > 1): ?>
                          <?php echo Form::select('dashboard_location', $all_locations, null, ['class' => 'form-control select2', 'placeholder' => __('lang_v1.select_location'), 'id' => 'dashboard_location']); ?>

                      <?php endif; ?>
                  </div>
                  <div class="col-md-8 col-xs-12">
                      <div class="btn-group pull-right" data-toggle="buttons">
                          <label class="btn btn-info active">
                              <input type="radio" name="date-filter"
                                     data-start="<?php echo e(date('Y-m-d'), false); ?>"
                                     data-end="<?php echo e(date('Y-m-d'), false); ?>"
                                     checked> <?php echo e(__('home.today'), false); ?>

                          </label>
                          <label class="btn btn-info">
                              <input type="radio" name="date-filter"
                                     data-start="<?php echo e($date_filters['this_week']['start'], false); ?>"
                                     data-end="<?php echo e($date_filters['this_week']['end'], false); ?>"
                              > <?php echo e(__('home.this_week'), false); ?>

                          </label>
                          <label class="btn btn-info">
                              <input type="radio" name="date-filter"
                                     data-start="<?php echo e($date_filters['this_month']['start'], false); ?>"
                                     data-end="<?php echo e($date_filters['this_month']['end'], false); ?>"
                              > <?php echo e(__('home.this_month'), false); ?>

                          </label>
                          <label class="btn btn-info">
                              <input type="radio" name="date-filter"
                                     data-start="<?php echo e($date_filters['this_fy']['start'], false); ?>"
                                     data-end="<?php echo e($date_filters['this_fy']['end'], false); ?>"
                              > <?php echo e(__('home.this_fy'), false); ?>

                          </label>
                      </div>
                  </div>
              </div>
              <br>
            <div class="row row-custom">
            <div class="col-md-3 col-sm-6 col-xs-12 col-custom">
                <div class="info-box info-box-new-style">
                    <span class="info-box-icon bg-aqua"><i class="ion ion-cash"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text"><?php echo e(__('home.total_purchase'), false); ?></span>
                        <span class="info-box-number total_purchase"><i class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12 col-custom">
                <div class="info-box info-box-new-style">
                    <span class="info-box-icon bg-aqua"><i class="ion ion-ios-cart-outline"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text"><?php echo e(__('home.total_sell'), false); ?></span>
                        <span class="info-box-number total_sell"><i class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12 col-custom">
                <div class="info-box info-box-new-style">
    	        <span class="info-box-icon bg-yellow">
    	        	<i class="ion ion-ios-paper-outline"></i>
    	        	<i class="fa fa-exclamation"></i>
    	        </span>

                    <div class="info-box-content">
                        <span class="info-box-text"><?php echo e(__('home.invoice_due'), false); ?></span>
                        <span class="info-box-number invoice_due"><i class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12 col-custom">
                <div class="info-box info-box-new-style">
                <span class="info-box-icon bg-red">
                  <i class="fas fa-minus-circle"></i>
                </span>

                    <div class="info-box-content">
                  <span class="info-box-text">
                    <?php echo e(__('lang_v1.expense'), false); ?>

                  </span>
                        <span class="info-box-number total_expense"><i class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
        </div>
    </div>
        <?php echo $__env->renderComponent(); ?>

    <div class="row">
               <div class="col-lg-10" style="padding-right: 3px; padding-left: 3px">
                        <?php $__env->startComponent('components.widget', ['class' => 'box-primary', 'title' =>'أحدث الفواتير']); ?>
                        <table class="table mytable">
                            <thead>
                            <tr>
                                <th>رقم الفاتورة</th>
                                <th>تاريخ الفاتورة</th>
                                <th>إجمالي قبل الضريبة</th>
                                <th>الخصم</th>
                                <th>الإجمالي</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $sells_transaction; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($row->invoice_no, false); ?></td>
                                    <td><?php echo e($row->transaction_date, false); ?></td>
                                    <td><?php echo e(number_format($row->total_before_tax,2,'.',''), false); ?></td>
                                    <td><?php echo e(number_format($row->discount_amount,2,'.',''), false); ?></td>
                                    <td><?php echo e(number_format($row->final_total,2,'.',''), false); ?></td>

                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <?php echo $__env->renderComponent(); ?>
                    </div>
                <div class="col-md-2" style="padding-right: 3px; padding-left: 3px">
                    <?php $__env->startComponent('components.widget', ['class' => 'box-primary', 'title' =>'إضافات']); ?>
                        <a href="<?php echo e(action('SellController@create'), false); ?>" class="btn btn-danger btn-block" style="margin-bottom:15px; margin-bottom:15px;" >فاتتورة بيع</a>
                        <a href="<?php echo e(action('PurchaseController@create'), false); ?>" class="btn btn-danger btn-block" style="margin-bottom:15px;" >فاتورة شراء </a>
                        <a href="<?php echo e(action('SellReturnController@index'), false); ?>" class="btn btn-danger btn-block" style="margin-bottom:15px;" >مرتجع مبيعات</a>
                        <a href="<?php echo e(action('PurchaseReturnController@index'), false); ?>" class="btn btn-danger btn-block" style="margin-bottom:15px;" >مرتجع مشتريات</a>
                        <a href="<?php echo e(action('ReportController@getproductSellReport'), false); ?>" class="btn btn-danger btn-block" style="margin-bottom:15px;" >تقرير مبيعات المنتجات</a>
                        <a href="<?php echo e(action('ReportController@getproductPurchaseReport'), false); ?>" class="btn btn-danger btn-block" style="margin-bottom:15px;" >تقرير مشتريات المنتجات</a>

                               <?php echo $__env->renderComponent(); ?>
                </div>

                <div class="col-md-12 col-sm-12">
                    <?php $__env->startComponent('components.widget', ['class' => 'box-primary', 'title' => __('home.sells_last_30_days')]); ?>
                        <?php echo $sells_chart_1->container(); ?>

                    <?php echo $__env->renderComponent(); ?>
                </div>



               


            </div>


       
  	<!-- sales chart end -->






      	<!-- products less than alert quntity -->
      
        <div class="row">
            <div class="<?php if((session('business.enable_product_expiry') != 1) && auth()->user()->can('stock_report.view')): ?> col-sm-12 <?php else: ?> col-sm-6 <?php endif; ?>">
                <?php $__env->startComponent('components.widget', ['class' => 'box-warning']); ?>
                  <?php $__env->slot('icon'); ?>
                    <i class="fa fa-exclamation-triangle text-yellow" aria-hidden="true"></i>
                  <?php $__env->endSlot(); ?>
                  <?php $__env->slot('title'); ?>
                    <?php echo e(__('home.product_stock_alert'), false); ?> <?php
                if(session('business.enable_tooltip')){
                    echo '<i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" 
                    data-container="body" data-toggle="popover" data-placement="auto bottom" 
                    data-content="' . __('tooltip.product_stock_alert') . '" data-html="true" data-trigger="hover"></i>';
                }
                ?>
                  <?php $__env->endSlot(); ?>
                  <table class="table table-bordered table-striped" id="stock_alert_table" style="width: 100%;">
                    <thead>
                      <tr>
                        <th><?php echo app('translator')->get( 'sale.product' ); ?></th>
                        <th><?php echo app('translator')->get( 'business.location' ); ?></th>
                        <th><?php echo app('translator')->get( 'report.current_stock' ); ?></th>
                      </tr>
                    </thead>
                  </table>
                <?php echo $__env->renderComponent(); ?>
            </div>

            
      	</div>

       
    <?php endif; ?>
</section>
<!-- /.content -->
<div class="modal fade payment_modal" tabindex="-1" role="dialog" 
    aria-labelledby="gridSystemModalLabel">
</div>

<div class="modal fade edit_payment_modal" tabindex="-1" role="dialog" 
    aria-labelledby="gridSystemModalLabel">
</div>
<div class="modal fade contact_modal" tabindex="-1" role="dialog"
     aria-labelledby="gridSystemModalLabel">
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('javascript'); ?>
    <script src="<?php echo e(asset('js/home.js?v=' . $asset_v), false); ?>"></script>
    <script src="<?php echo e(asset('js/payment.js?v=' . $asset_v), false); ?>"></script>
    <script src="<?php echo e(asset('js/chart.min.js'), false); ?>"></script>
    <script src="<?php echo e(asset('js/utils.js'), false); ?>"></script>


	<?php if(!empty($all_locations)): ?>
        <?php echo $sells_chart_1->script(); ?>

     <?php endif; ?>
	<script>
        var randomScalingFactor = function() {
            return Math.round(Math.random() * 100);
        };

/* type:pie,line,bar,doughnut*/
        var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        var config = {
            type: 'bar',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                datasets: [{
                            label: 'المصروفات',
                            data: [<?php echo $expnacess; ?>],
                            backgroundColor: [
                        '#4843ea',
                        '#d23041',
                        '#95ae38',
                        '#6b6b6b',
                        '#469049',
                        '#ea781c',
                        '#cdc6ea',
                        '#eae42d',
                        '#ea2084',
                        '#b3ea1f',
                        '#6fea48',
                        '#ea2634',
                        '#3f38ea',
                    ],
                            fill: false,
                            }]
                     },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'المصروفات'
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    x: {
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Month'
                        }
                    },
                    y: {
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Value'
                        }
                    }
                }
            }
        };




        /* type:pie,line,bar,doughnut*/
        var config2 = {
            type: 'bar',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                datasets: [{
                    label: 'المبيعات',
                    backgroundColor: window.chartColors.blue,
                    borderColor: window.chartColors.red,
                    data: [<?php echo $sells; ?>],
                    backgroundColor: [
                                   '#0c6cea',
                                   '#d23041',
                                   '#95ae38',
                                   '#6b6b6b',
                                   '#469049',
                                   '#ea781c',
                                   '#cdc6ea',
                                   '#eae42d',
                                   '#ea2084',
                                   '#b3ea1f',
                                   '#6fea48',
                                   '#ea2634',
                                   '#3f38ea',
                                         ],
                    fill: false,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'المبيعات'
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    x: {
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Month'
                        }
                    },
                    y: {
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Value'
                        }
                    }
                }
            }
        };

        window.onload = function() {
            var ctx = document.getElementById('canvas_expnacess').getContext('2d');
            window.myLine = new Chart(ctx, config);

            var ctx2 = document.getElementById('sells').getContext('2d');
            window.myLine = new Chart(ctx2, config2);



        };




	</script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\laragon\www\AZHA-ERP\resources\views/home/index_old.blade.php ENDPATH**/ ?>