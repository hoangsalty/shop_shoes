<!-- Js Config -->
<script type="text/javascript">
    var FRAMEWORK = FRAMEWORK || {};
    var CONFIG_BASE = '<?= $configBase ?>';
    var JS_AUTOPLAY = <?= ($_SERVER["SERVER_NAME"] != "localhost") ? 'true' : 'false' ?>;
    var ASSETS = '<?= ASSETS ?>';
    var TIMENOW = '<?= date("d/m/Y", time()) ?>';
</script>
<!-- Js Files -->
<script type="text/javascript" src="<?= $configBase ?>assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<?= $configBase ?>assets/js/lazyload.min.js"></script>
<script type="text/javascript" src="<?= $configBase ?>assets/js/jQuery.WCircleMenu-min.js"></script>
<script type="text/javascript" src="<?= $configBase ?>assets/js/functions.js"></script>
<script type="text/javascript" src="<?= $configBase ?>assets/js/apps.js"></script>
<script type="text/javascript" src="<?= $configBase ?>assets/bootstrap/bootstrap.js"></script>
<script type="text/javascript" src="<?= $configBase ?>assets/owlcarousel/owl.carousel.js"></script>
<script type="text/javascript" src="<?= $configBase ?>assets/holdon/HoldOn.js"></script>
<script type="text/javascript" src="<?= $configBase ?>assets/slick/slick.js"></script>
<script type="text/javascript" src="<?= $configBase ?>assets/magiczoomplus/magiczoomplus.js"></script>