/* Validation form */
function validateForm(e) {
  window.addEventListener("load", function () {
    var forms = document.getElementsByClassName(e);
    Array.prototype.filter.call(forms, function (form) {
      form.addEventListener("submit", function (event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add("was-validated");
      });
    });
  });
}

function isExist(ele) {
  return ele.length;
}

function isEmpty(o, t) {
  return "" == o && (void 0 !== t && alert(t), !0);
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
    Swal.fire({
      icon: "error",
      title: "Có lỗi phát sinh...",
      text: "Đường dẫn không hợp lệ",
      allowOutsideClick: false,
    });
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
          $(".form-cart")
            .find(".load-price-" + code)
            .html(result.regularPrice);
          $(".form-cart")
            .find(".load-price-new-" + code)
            .html(result.salePrice);
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
        $(".form-cart")
          .find(".procart-" + code)
          .remove();
      } else {
        location.reload();
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
      province_id: id,
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
      district_id: id,
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

function loadShipPrice(districtID = 0, wardID = 0) {
  const formatter = new Intl.NumberFormat("vi-VN", {
    style: "currency",
    currency: "VND",
  });

  $.ajax({
    type: "post",
    url: "api/ship_price.php",
    data: {
      district_id: districtID,
      ward_id: wardID,
    },
    beforeSend: function () {
      holdonOpen();
    },
    success: function (result) {
      $("#price-ship").html(formatter.format(result));

      $.ajax({
        type: "POST",
        url: "api/cart.php",
        dataType: "json",
        data: {
          cmd: "update-ship-total",
          ship_price: result,
        },
        beforeSend: function () {
          holdonOpen();
        },
        success: function (result) {
          if (result) {
            $(".form-cart").find("#ship_price").val(result.shipPrice);
            $(".form-cart").find("#temp_price").val(result.tempPrice);
            $(".form-cart").find("#total_price").val(result.totalPrice);
            $(".form-cart").find(".load-price-temp").html(result.tempText);
            $(".form-cart").find(".load-price-total").html(result.totalText);
          }
          holdonClose();
        },
      });

      holdonClose();
    },
  });
}

function changeOrderStatus(obj) {
  var id = obj.data("id");
  var status = obj.data("status");

  $.ajax({
    type: "POST",
    url: "api/order.php",
    data: {
      cmd: "change-status",
      id: id,
      status: status,
    },
    beforeSend: function () {
      holdonOpen();
    },
    success: function (result) {
      location.reload();
      holdonClose();
    },
  });
}
