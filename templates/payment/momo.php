<?php
if ($m2signature == $partnerSignature) {
    if ($errorCode == '0') {
        $result = '<div class="alert alert-success"><strong>Payment status: </strong>Success</div>';
    } else {
        $result = '<div class="alert alert-danger"><strong>Payment status: </strong>' . $message . '/' . $localMessage . '</div>';
    }
} else {
    $result = '<div class="alert alert-danger">This transaction could be hacked, please check your signature and returned signature</div>';
}

echo $result;
