<!-- Js Config -->
<script type="text/javascript">
    var CONFIG_BASE = '<?= $configBase ?>';
    var ADMIN = '<?= ADMIN ?>';
    var MAX_DATE = '<?= date("Y/m/d", time()) ?>';
    var FRAMEWORK = FRAMEWORK || {};

    var CUR_PAGE = '<?= $curPage ?>';

    /* Get all paramters from website */
    var QUERY_STRING = '<?= ($_SERVER['QUERY_STRING']) ?>';

    /* Login */
    var LOGIN_PAGE = <?= (empty($_SESSION['account']['active'])) ? 'true' : 'false' ?>;

    /* Order */
    var ORDER_MIN_TOTAL = <?= (!empty($minTotal)) ? $minTotal : 1 ?>;
    var ORDER_MAX_TOTAL = <?= (!empty($maxTotal)) ? $maxTotal : 1 ?>;
    var ORDER_PRICE_FROM = <?= (!empty($price_from)) ? $price_from : 1 ?>;
    var ORDER_PRICE_TO = <?= (!empty($price_to)) ? $price_to : ((!empty($maxTotal)) ? $maxTotal : 1) ?>;
</script>

<!-- Js Files -->
<script src="assets/bootstrap/bootstrap.js"></script>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/holdon/HoldOn.js"></script>
<script src="assets/filer/jquery.filer.js"></script>
<script src="assets/daterangepicker/moment.min.js"></script>
<script src="assets/daterangepicker/daterangepicker.min.js"></script>
<script src="assets/datetimepicker/jquery.datetimepicker.min.js"></script>
<script src="assets/datetimepicker/jquery.mousewheel.js"></script>
<script src="assets/datetimepicker/php-date-formatter.min.js"></script>
<script src="assets/js/priceFormat.js"></script>
<script src="assets/ckeditor4/ckeditor.js"></script>
<script src="assets/sumoselect/jquery.sumoselect.js"></script>
<script src="assets/rangeSlider/ion.rangeSlider.js"></script>
<script src="assets/fancybox/fancybox.js"></script>
<script src="assets/js/functions.js"></script>
<script src="assets/js/apps.js"></script>
<script src="assets/js/adminlte.js"></script>
<script src="assets/sweetalert/sweetalert.min.js"></script>