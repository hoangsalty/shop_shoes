<?php
/* Order */
$orderNotify = $d->rawQuery("select id from table_order where order_status = 'moidat'");
/* Product */
$productNotify = $d->rawQuery("select id from table_product where find_in_set('hienthi',status)");
/* User */
$userNotify = $d->rawQuery("select id from table_user where permission=?", array('user'));
/* Comment */
$commentNotify = $d->rawQuery("select id from table_comment where find_in_set('new-admin',status)");
?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?= count($orderNotify) ?></h3>
                        <p>Đơn hàng mới</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <a href="index.php?com=order&act=list" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><?= count($productNotify) ?></h3>
                        <p>Sản phẩm</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-cog"></i>
                    </div>
                    <a href="index.php?com=product&act=list_list" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?= count($userNotify) ?></h3>
                        <p>Tài khoản thành viên</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <a href="index.php?com=user&act=list" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3><?= count($commentNotify) ?></h3>
                        <p>Đánh giá</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <a href="index.php?com=product&act=list&comment_status=new" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- ./col -->
        </div>
    </div>
</section>