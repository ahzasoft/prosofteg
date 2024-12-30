<?php if($receipt_details->show_qr_code ): ?>
    
    
   

    <img class="center-block mt-5" src="data:image/png;base64,<?php echo e(DNS2D::getBarcodePNG($receipt_details->qr_code_gen, 'QRCODE', 3, 3, [39, 48, 54]), false); ?>">

<?php endif; ?><?php /**PATH G:\laragon\www\AZHA-ERP\resources\views/sale_pos/partials/qr_code.blade.php ENDPATH**/ ?>