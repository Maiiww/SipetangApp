<?php if($paginator->hasPages()): ?>
    <div style="display: flex; justify-content: center; align-items: center; gap: 8px; margin-top: 20px;">
        
        <?php if($paginator->onFirstPage()): ?>
            <button disabled
                style="width: 32px; height: 32px; border: 1px solid #e0e0e0; background: #f5f5f5; border-radius: 4px; cursor: not-allowed; opacity: 0.5; color: #999; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                <i class="fas fa-chevron-left" style="font-size: 12px;"></i>
            </button>
        <?php else: ?>
            <a href="<?php echo e($paginator->previousPageUrl()); ?>"
                style="width: 32px; height: 32px; border: 1px solid #e0e0e0; background: white; border-radius: 4px; cursor: pointer; color: #1a4d7d; display: flex; align-items: center; justify-content: center; font-size: 12px; text-decoration: none; transition: all 0.3s;">
                <i class="fas fa-chevron-left" style="font-size: 12px;"></i>
            </a>
        <?php endif; ?>

        
        <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            
            <?php if(is_string($element)): ?>
                <span style="padding: 0 4px; color: #999; font-size: 12px;"><?php echo e($element); ?></span>
            <?php endif; ?>

            
            <?php if(is_array($element)): ?>
                <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($page == $paginator->currentPage()): ?>
                        <button disabled
                            style="width: 32px; height: 32px; border: 1px solid #0d2640; background: #0d2640; border-radius: 4px; cursor: default; color: white; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 600;">
                            <?php echo e($page); ?>

                        </button>
                    <?php else: ?>
                        <a href="<?php echo e($url); ?>"
                            style="width: 32px; height: 32px; border: 1px solid #e0e0e0; background: white; border-radius: 4px; cursor: pointer; color: #1a4d7d; display: flex; align-items: center; justify-content: center; font-size: 13px; text-decoration: none; transition: all 0.3s; font-weight: 600;">
                            <?php echo e($page); ?>

                        </a>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        
        <?php if($paginator->hasMorePages()): ?>
            <a href="<?php echo e($paginator->nextPageUrl()); ?>"
                style="width: 32px; height: 32px; border: 1px solid #e0e0e0; background: white; border-radius: 4px; cursor: pointer; color: #1a4d7d; display: flex; align-items: center; justify-content: center; font-size: 12px; text-decoration: none; transition: all 0.3s;">
                <i class="fas fa-chevron-right" style="font-size: 12px;"></i>
            </a>
        <?php else: ?>
            <button disabled
                style="width: 32px; height: 32px; border: 1px solid #e0e0e0; background: #f5f5f5; border-radius: 4px; cursor: not-allowed; opacity: 0.5; color: #999; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                <i class="fas fa-chevron-right" style="font-size: 12px;"></i>
            </button>
        <?php endif; ?>

        
        <span style="font-size: 12px; color: #999; margin-left: 10px;">
            Halaman <?php echo e($paginator->currentPage()); ?> dan <?php echo e($paginator->lastPage()); ?>

        </span>
    </div>
<?php endif; ?>
<?php /**PATH C:\laragon\www\SipetangApp\web-laravel\resources\views/pagination/custom.blade.php ENDPATH**/ ?>