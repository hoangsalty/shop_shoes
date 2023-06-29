<!-- Basehref -->
<base href="<?= $configBase ?>" />
<!-- UTF-8 -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Title, Keywords, Description -->
<title>Shoes Shop</title>
<meta name="keywords" content="Shoes Shop" />
<meta name="description" content="Shoes Shop" />
<!-- Viewport -->
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<?php if ($com == 'payment-vnpay') { ?>
    <meta http-equiv="REFRESH" content="10; url=<?= $configBase ?>account/thong-tin#order">
<?php } ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">