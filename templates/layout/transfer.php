<html>

<head>
    <title>:: Thông Báo ::</title>
    <base href="<?= $basehref ?>" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="REFRESH" content="10; url=<?= $page_transfer ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <link type="text/css" rel="stylesheet" href="<?= $configBase ?>assets/bootstrap/bootstrap.css" />
    <link rel="stylesheet" href="assets/transfer/transfer.css">
</head>

<body>
    <div id="alert">
        <i class="fas <?= ($numb) ? 'fa-check-circle fasuccess' : 'fa-exclamation-triangle fadanger' ?>"></i>
        <div class="title">Thông báo</div>
        <div class="message alert <?= ($numb) ? 'alert-success' : 'alert-danger' ?>"><?= @$showtext ?></div>
        <div class="rlink">(<a href="<?= $page_transfer ?>">Click vào đây nếu không muốn đợi lâu</a>)</div>
        <div class="progress">
            <div id="process-bar" class="progress-bar progress-bar-striped progress-bar-<?= ($numb) ? 'success' : 'danger' ?> active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>
    <script type="text/javascript">
        var elem = document.getElementById("process-bar");
        var pos = 0;
        setInterval(function() {
            pos += 1;
            elem.style.width = pos + '%';
        }, 90);
    </script>
</body>

</html>