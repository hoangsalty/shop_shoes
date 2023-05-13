function isExist(ele) {
    return ele.length;
}

function isEmpty(o, t) {
    return "" == o && (void 0 !== t && alert(t), !0)
}

function notifyDialog(
    content = "",
    title = "Thông báo",
    icon = "fas fa-exclamation-triangle",
    type = "blue"
) {
    $.alert({
        title: title,
        icon: icon, // font awesome
        type: type, // red, green, orange, blue, purple, dark
        content: content, // html, text
        backgroundDismiss: true,
        animationSpeed: 600,
        animation: "zoom",
        closeAnimation: "scale",
        typeAnimated: true,
        animateFromElement: false,
        autoClose: "accept|3000",
        escapeKey: "accept",
        buttons: {
            accept: {
                text: "Đồng ý",
                btnClass: "btn-sm btn-primary",
            },
        },
    });
}

function confirmDialog(
    action,
    text,
    value,
    title = "Thông báo",
    icon = "fas fa-exclamation-triangle",
    type = "blue"
) {
    $.confirm({
        title: title,
        icon: icon, // font awesome
        type: type, // red, green, orange, blue, purple, dark
        content: text, // html, text
        backgroundDismiss: true,
        animationSpeed: 600,
        animation: "zoom",
        closeAnimation: "scale",
        typeAnimated: true,
        animateFromElement: false,
        autoClose: "cancel|5000",
        escapeKey: "cancel",
        buttons: {
            success: {
                text: "Đồng ý",
                btnClass: "btn-sm btn-primary",
                action: function () {
                    if (action == "delete-procart") deleteCart(value);
                },
            },
            cancel: {
                text: "Hủy",
                btnClass: "btn-sm btn-danger",
            },
        },
    });
}

function loadPaging(url = "", eShow = "") {
    if ($(eShow).length && url) {
        $.ajax({
            url: url,
            type: "GET",
            data: {
                eShow: eShow,
            },
            success: function (result) {
                $(eShow).html(result);
            },
        });
    }
}

function doEnter(event, obj) {
    if (event.keyCode == 13 || event.which == 13) onSearch(obj);
}

function onSearch(obj) {
    var keyword = $("#" + obj).val();

    if (keyword == "") {
        notifyDialog(LANG["no_keywords"]);
        return false;
    } else {
        location.href = "tim-kiem?keyword=" + encodeURI(keyword);
    }
}

function goToByScroll(id, minusTop) {
    minusTop = parseInt(minusTop) ? parseInt(minusTop) : 0;
    id = id.replace("#", "");
    $("html,body").animate(
        {
            scrollTop: $("#" + id).offset().top - minusTop,
        },
        "slow"
    );
}

function holdonOpen(
    theme = "sk-circle",
    text = "Loading...",
    backgroundColor = "rgba(0,0,0,0.8)",
    textColor = "white"
) {
    var options = {
        theme: theme,
        message: text,
        backgroundColor: backgroundColor,
        textColor: textColor,
    };

    HoldOn.open(options);
}

function holdonClose() {
    HoldOn.close();
}

function updateCart(id = 0, code = "", quantity = 1) {
    if (id) {
        $.ajax({
            type: "POST",
            url: "api/cart.php",
            dataType: "json",
            data: {
                cmd: "update-cart",
                id: id,
                code: code,
                quantity: quantity,
            },
            beforeSend: function () {
                holdonOpen();
            },
            success: function (result) {
                if (result) {
                    $(".form-cart").find(".load-price-" + code).html(result.regularPrice);
                    $(".form-cart").find(".load-price-new-" + code).html(result.salePrice);
                    $(".form-cart").find(".load-price-temp").html(result.tempText);
                    $(".form-cart").find(".load-price-total").html(result.totalText);
                }
                holdonClose();
            },
        });
    }
}

function deleteCart(obj) {
    var code = obj.data("code");
    var ward = $(".form-cart").find(".select-ward-cart").val();

    $.ajax({
        type: "POST",
        url: "api/cart.php",
        dataType: "json",
        data: {
            cmd: "delete-cart",
            code: code,
            ward: ward,
        },
        beforeSend: function () {
            holdonOpen();
        },
        success: function (result) {
            $(".count-cart").html(result.max);
            if (result.max) {
                $(".form-cart").find(".load-price-temp").html(result.tempText);
                $(".form-cart").find(".load-price-total").html(result.totalText);
                $(".form-cart").find(".procart-" + code).remove();
            } else {
                $(".wrap-cart").html(
                    '<a href="" class="empty-cart text-decoration-none"><i class="fas fa-cart-plus"></i><p>Không tồn tại sản phẩm trong giỏ hàng</p><span class="btn btn-warning">Về trang chủ</span></a>'
                );
            }
            holdonClose();
        },
    });
}

function loadDistrict(id = 0) {
    $.ajax({
        type: "post",
        url: "api/district.php",
        data: {
            id_city: id,
        },
        beforeSend: function () {
            holdonOpen();
        },
        success: function (result) {
            $(".select-district").html(result);
            holdonClose();
        },
    });
}

function loadWard(id = 0) {
    $.ajax({
        type: "post",
        url: "api/ward.php",
        data: {
            id_district: id,
        },
        beforeSend: function () {
            holdonOpen();
        },
        success: function (result) {
            $(".select-ward").html(result);
            holdonClose();
        },
    });
}