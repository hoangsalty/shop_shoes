<div class="payment-content redirect-info">
    <div>
        <div class="item-info">
            <div class="<?= $vnp_ResponseCode == '00' ? 'icon-success' : 'icon-fail' ?>">
                <?php if ($vnp_ResponseCode == '00') { ?>
                    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
                    <lottie-player src="https://assets6.lottiefiles.com/packages/lf20_hfevst90.json" background="transparent" speed="1" style="width: 120px; height: 120px;" loop autoplay></lottie-player>
                <?php } ?>
            </div>
        </div>

        <div>
            <div class="item-info">
                <h3>Thanh toán <?= $vnp_ResponseCode != '00' ? 'không' : '' ?> thành công</h3>
            </div>
        </div>
    </div>

    <div class="item-info error">
        <span style="color: #000000;">Thông tin: </span>
        <span style="color: <?= $vnp_ResponseCode == '00' ? '#63C000' : '#f5222d' ?>;"><?= $message ?></span>
    </div>

    <div class="item-box">
        <div class="box-info col-lg-1 col-offset-6 centered item-info">
            <span class="m-1"><?= $vnp_OrderInfo ?></span>
        </div>
    </div>

    <div class="item-info">
        <a class="hover-momo-color hover-none-decoration" href="<?= $configBase ?>">Quay về</a>
    </div>
</div>