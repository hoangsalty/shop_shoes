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
<script type="text/javascript" src="<?= $configBase ?>assets/js/jQuery.WCircleMenu-min.js"></script>
<script type="text/javascript" src="<?= $configBase ?>assets/bootstrap/bootstrap.js"></script>
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


<script type="text/javascript" src="<?= $configBase ?>assets/js/functions.js"></script>
<script type="text/javascript" src="<?= $configBase ?>assets/js/apps.js"></script>