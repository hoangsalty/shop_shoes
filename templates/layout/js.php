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
<script type="text/javascript" src="<?= $configBase ?>assets/select2/select2.min.js"></script>
<script type="text/javascript" src="<?= $configBase ?>assets/js/functions.js"></script>
<script type="text/javascript" src="<?= $configBase ?>assets/mmenu/mmenu.js"></script>
<script type="text/javascript" src="<?= $configBase ?>assets/js/jquery.pixelentity.shiner.min.js"></script>
<script type="text/javascript" src="<?= $configBase ?>assets/js/apps.js"></script>
<script type="text/javascript" src="<?= $configBase ?>assets/sweetalert/sweetalert.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        "use strict";
        var progressPath = document.querySelector('.progress-wrap path');
        var pathLength = progressPath.getTotalLength();
        progressPath.style.transition = progressPath.style.WebkitTransition = 'none';
        progressPath.style.strokeDasharray = pathLength + ' ' + pathLength;
        progressPath.style.strokeDashoffset = pathLength;
        progressPath.getBoundingClientRect();
        progressPath.style.transition = progressPath.style.WebkitTransition = 'stroke-dashoffset 10ms linear';
        var updateProgress = function() {
            var scroll = $(window).scrollTop();
            var height = $(document).height() - $(window).height();
            var progress = pathLength - (scroll * pathLength / height);
            progressPath.style.strokeDashoffset = progress;
        };
        updateProgress();
        $(window).scroll(updateProgress);
        var offset = 150;
        var duration = 550;
        $(window).on('scroll', function() {
            if ($(this).scrollTop() > offset) {
                $('.progress-wrap').addClass('active-progress');
            } else {
                $('.progress-wrap').removeClass('active-progress');
            }
        });
        $('.progress-wrap').on('click', function(event) {
            event.preventDefault();
            $('html, body').animate({
                scrollTop: 0
            }, duration);
            return false;
        });
    });
</script>

<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v17.0&appId=414625042805209&autoLogAppEvents=1" nonce="VfA41phC"></script>