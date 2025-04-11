<?php $__env->startSection("body"); ?>
<div class="page-body">
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>List Coupons
                            <small>Multikart Admin panel</small>
                        </h3>
                    </div>
                </div>
                <div class="col-lg-6">
                    <ol class="breadcrumb pull-right">
                        <li class="breadcrumb-item">
                            <a href="index.html">
                                <i data-feather="home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">Coupons</li>
                        <li class="breadcrumb-item active">List Coupons</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <form class="form-inline search-form search-box">
                            <div class="form-group">
                                <input class="form-control-plaintext" type="search" placeholder="Search..">
                            </div>
                        </form>

                        <a href="coupon-create.html" class="btn btn-primary mt-md-0 mt-2">Add New Coupon</a>
                    </div>

                    <div class="card-body">
                        <div>
                            <div class="table-responsive table-desi">
                                <table class="all-package coupon-table table table-striped">
                                    <thead>
                                        <tr>
                                            <th>
                                                Thao tác
                                            </th>
                                            <th>Tên giảm giá</th>
                                            <th>Mô tả</th>
                                            <th>Tỷ lệ</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $promotions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promotion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td>
                                                    <a href="">Edit</a> | 
                                                    <a href="">Delete</a>
                                                </td>

                                                <td><?php echo e($promotion->name); ?></td>
                                                <td><?php echo e($promotion->description); ?></td>
                                                <td><?php echo e($promotion->discount_rate); ?></td>                                              

                                                <td class="order-warning">
                                                    <span>Waiting</span>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>
<?php $__env->stopSection(); ?>

    
<?php echo $__env->make("template.admin", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\e-commerce\e-commerce\resources\views/crud/coupon-list.blade.php ENDPATH**/ ?>