<html>

<head>
    <title>:: Thông Báo ::</title>
    <base href="<?= $basehref ?>" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <link type="text/css" rel="stylesheet" href="<?= $configBase ?>assets/bootstrap/bootstrap.css" />
    <link rel="stylesheet" href="assets/transfer/transfer.css">
</head>

<body>
    <div id="alert">
        <i class="fas <?= ($numb) ? 'fa-check-circle fasuccess' : 'fa-exclamation-triangle fadanger' ?>"></i>
        <div class="title">Thông báo</div>
        <div class="message alert <?= ($numb) ? 'alert-success' : 'alert-danger' ?>"><?= @$showtext ?></div>
        <div class="rlink"><a href="<?= $page_transfer ?>">Quay lại</a></div>
    </div>
</body>

</html>