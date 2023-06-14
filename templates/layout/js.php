<!-- Js Config -->
<script type="text/javascript">
    var FRAMEWORK = FRAMEWORK || {};
    var CONFIG_BASE = '<?= $configBase ?>';
    var ASSETS = '<?= ASSETS ?>';
    var TIMENOW = '<?= date("d/m/Y", time()) ?>';
    /* Login */
    var IS_LOGIN = <?= (empty($_SESSION['account']['active'])) ? 'false' : 'true' ?>;
</script>
<!-- Js Files -->
<script type="text/javascript" src="<?= $configBase ?>assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<?= $configBase ?>assets/bootstrap/bootstrap.js"></script>

<script type="text/javascript" src="<?= $configBase ?>assets/js/jQuery.WCircleMenu-min.js"></script>
<script type="text/javascript" src="<?= $configBase ?>assets/owlcarousel/owl.carousel.js"></script>
<script type="text/javascript" src="<?= $configBase ?>assets/holdon/HoldOn.js"></script>
<script type="text/javascript" src="<?= $configBase ?>assets/slick/slick.js"></script>
<script type="text/javascript" src="<?= $configBase ?>assets/fotorama/fotorama.js"></script>
<script type="text/javascript" src="<?= $configBase ?>assets/confirm/confirm.js"></script>
<script type="text/javascript" src="<?= $configBase ?>assets/datetimepicker/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="<?= $configBase ?>assets/datetimepicker/jquery.datetimepicker.min.js"></script>
<script type="text/javascript" src="<?= $configBase ?>assets/datetimepicker/jquery.mousewheel.js"></script>
<script type="text/javascript" src="<?= $configBase ?>assets/datetimepicker/php-date-formatter.min.js"></script>
<script type="text/javascript" src="<?= $configBase ?>assets/js/jquery.nicescroll.min.js"></script>

<script type="text/javascript" src="<?= $configBase ?>assets/fileuploader/jquery.fileuploader.min.js"></script>

<script type="text/javascript" src="<?= $configBase ?>assets/fancybox/fancybox.js"></script>

<script type="text/javascript" src="<?= $configBase ?>assets/photobox/photobox.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript" src="<?= $configBase ?>assets/js/functions.js"></script>
<script type="text/javascript" src="<?= $configBase ?>assets/js/apps.js"></script>

<script>
    function inti_order_status(tab_class = '', tab_return = '', table_select = '') {
        if (tab_class != '') {
            if ($('.' + tab_class + ' a.active').length == 0) {
                $('.' + tab_class + ' a').eq(0).addClass('active');
            }
            var where_select = '' + $('.' + tab_class + ' a.active').data('id');
        }

        $.ajax({
            url: 'api/order.php',
            type: 'post',
            data: {
                cmd: "show-order-by-status",
                where_select: where_select,
            },
        }).done(function(result) {
            $('.' + tab_return).html(result);
        });
    }

    $(document).ready(function() {
        $(document).on('click', '.nav_status_order a', function(event) {
            event.preventDefault();
            $(this).parent('.nav_status_order').find('a').removeClass('active');
            $(this).addClass('active');
            inti_order_status('nav_status_order', 'status_order', 'table_order_detail');
        });
        inti_order_status('nav_status_order', 'status_order', 'table_order_detail');
    });
</script>