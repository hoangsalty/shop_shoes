FRAMEWORK.Momo = function () {
  $("#thanhtoan").prop("disabled", true);
  $("#thanhtoan").addClass("disabled");

  if (isExist($(".form-cart"))) {
    $(".form-cart")[0].onchange = function () {
      if ($(".form-cart")[0].checkValidity() == true) {
        $("#thanhtoan").prop("disabled", false);
        $("#thanhtoan").removeClass("disabled");
      }
    };
  }
};

FRAMEWORK.DatePicker = function () {
  if (isExist($("#birthday"))) {
    $("#birthday").datetimepicker({
      timepicker: false,
      format: "d/m/Y",
      formatDate: "d/m/Y",
      minDate: "01/01/1950",
      maxDate: TIMENOW,
    });
  }
};

FRAMEWORK.UserInfo = function () {
  $(".container_load_info").hide();
  $(".container_load_info.load1").show();

  $(document).on("click", ".sty_list", function (event) {
    $(".sty_list").removeClass("act");

    var vitri = $(this).data("vitri");
    $(".container_load_info").hide();
    $(".load" + vitri).show();
    $(this).addClass("act");
  });

  /* Cancel order */
  $("body").on("click", "#cancel-order", function () {
    confirmDialog(
      "change-order-status",
      "Bạn muốn hủy đơn hàng này ?",
      $(this)
    );
  });
};

FRAMEWORK.Comments = function () {
  var wrapper = $("#form-comment");
  var wrapperLists = wrapper.find(".comment-lists");

  wrapper.on("click", "i.fa-star", function () {
    $this = $(this);

    var value = $this.data("value");
    $this.parents(".review-rating-star").find("input").attr("value", value);

    var onStar = parseInt($this.data("value"));
    var stars = $this.parent().children("i");

    for (i = 0; i < stars.length; i++) {
      $(stars[i]).removeClass("star-not-empty");
    }

    for (i = 0; i < onStar; i++) {
      $(stars[i]).addClass("star-not-empty");
    }

    return false;
  });

  if (isExist($("#review-file-photo"))) {
    $("#review-file-photo").getEvali({
      limit: 3,
      maxSize: 30,
      extensions: ["jpg", "png", "jpeg", "JPG", "PNG", "JPEG", "Png"],
      editor: false,
      addMore: true,
      enableApi: false,
      dragDrop: true,
      changeInput:
        '<div class="review-fileuploader">' +
        "<div class=review-fileuploader-caption><strong>${captions.feedback}</strong></div>" +
        '<div class="review-fileuploader-text mx-3">${captions.or}</div>' +
        '<div class="review-fileuploader-button btn btn-sm btn-primary text-capitalize font-weight-500 py-2 px-3">${captions.button}</div></div>',
      theme: "dragdrop",
      captions: {
        feedback: "(Kéo thả ảnh vào đây)",
        or: "-hoặc-",
        button: "Chọn ảnh",
      },
      thumbnails: {
        popup: false,
        canvasImage: false,
      },
      dialogs: {
        alert: function (e) {
          return notifyDialog(e);
        },
        confirm: function (e, t) {
          $.confirm({
            title: "Thông báo",
            icon: "fas fa-exclamation-triangle",
            type: "orange",
            content: e,
            backgroundDismiss: true,
            animationSpeed: 600,
            animation: "zoom",
            closeAnimation: "scale",
            typeAnimated: true,
            animateFromElement: false,
            autoClose: "cancel|3000",
            escapeKey: "cancel",
            buttons: {
              success: {
                text: "Đồng ý",
                btnClass: "btn-sm btn-warning",
                action: function () {
                  t();
                },
              },
              cancel: {
                text: "Hủy",
                btnClass: "btn-sm btn-danger",
              },
            },
          });
        },
      },
      afterSelect: function () { },
      onEmpty: function () { },
      onRemove: function () { },
    });
  }

  $(wrapper).submit(function (e) {
    e.preventDefault();
    $this = $(this);
    var form = $this;
    var formData = new FormData(form[0]);
    var responseEle = form.find(".response-review");

    var stars = $(this).find("#review-star");
    var content = $(this).find("#review-content");
    var amountError = 0;
    if (isEmpty(stars.val())) {
      responseEle.append(
        '<div class="alert alert-danger">Vui lòng chọn đánh giá</div>'
      );
      amountError += 1;
    }
    if (isEmpty(content.val())) {
      responseEle.append(
        '<div class="alert alert-danger">Vui lòng nhập nội dung đánh giá</div>'
      );
      amountError += 1;
    }

    if (amountError > 0) {
      return false;
    }
    $.ajax({
      url: "api/comment.php",
      method: "POST",
      enctype: "multipart/form-data",
      dataType: "json",
      data: formData,
      async: false,
      processData: false,
      contentType: false,
      cache: false,
      beforeSend: function (e) {
        holdonOpen();
        responseEle.html("");
      },
      error: function (e) {
        holdonClose();
        notifyDialog(
          "Hệ thống bị lỗi. Vui lòng thử lại sau.",
          "Thông báo",
          "fas fa-exclamation-triangle",
          "red"
        );
      },
      success: function (response) {
        form.trigger("reset");
        holdonClose();
        notifyDialog(
          "Bình luận sẽ được hiển thị sau khi được Bản Quản Trị kiểm duyệt",
          "Bình luận thành công",
          "fa-solid fa-check",
          "green"
        );

        setTimeout(function () {
          location.reload();
        }, 3000);
      },
    });
  });
};

FRAMEWORK.PopupLogin = function () {
  $("#form-user-login").submit(function (e) {
    e.preventDefault();

    var username = $(this).find("#username");
    var password = $(this).find("#password");
    if (isEmpty(username.val())) {
      $(".login_response").html(
        '<div class="alert alert-danger">Vui lòng nhập tài khoản</div>'
      );
      username.focus();
      return false;
    }
    if (isEmpty(password.val())) {
      $(".login_response").html(
        '<div class="alert alert-danger">Vui lòng nhập mật khẩu</div>'
      );
      password.focus();
      return false;
    }

    $.ajax({
      url: "api/login.php",
      type: "POST",
      dataType: "json",
      data: {
        username: username.val(),
        password: password.val(),
      },
      beforeSend: function () {
        holdonOpen();
        $("#popup-login").find(".modal-body").css("opacity", "0.5");
        $(this).find(".login-account").prop("disabled", true);
      },
      success: function (result) {
        $("#popup-login").find(".modal-body").css("opacity", "1");
        $(this).find(".login-account").prop("disabled", false);

        if (result.status == 200) {
          $("#form-user-login")[0].reset();
          $(".login_response").html(
            '<div class="alert alert-success">' + result.message + "</div>"
          );

          setTimeout(function () {
            location.reload();
          }, 1000);
        } else if (result.status == 404) {
          $(".login_response").html(
            '<div class="alert alert-danger">' + result.message + "</div>"
          );
        }
        holdonClose();
      },
    });
  });
};

FRAMEWORK.PopupRegister = function () {
  $("#form-user-register").submit(function (e) {
    e.preventDefault();

    var fullname = $(this).find("#fullname");
    var username = $(this).find("#username");
    var password = $(this).find("#password");
    var birthday = $(this).find("#birthday");
    var email = $(this).find("#email");
    var phone = $(this).find("#phone");
    var address = $(this).find("#address");

    if (isEmpty(fullname.val())) {
      $(".register_response").html(
        '<div class="alert alert-danger">Vui lòng nhập họ tên</div>'
      );
      fullname.focus();
      return false;
    }

    if (isEmpty(username.val())) {
      $(".register_response").html(
        '<div class="alert alert-danger">Vui lòng nhập tài khoản</div>'
      );
      username.focus();
      return false;
    }

    if (isEmpty(password.val())) {
      $(".register_response").html(
        '<div class="alert alert-danger">Vui lòng nhập mật khẩu</div>'
      );
      password.focus();
      return false;
    }

    if (isEmpty(birthday.val())) {
      $(".register_response").html(
        '<div class="alert alert-danger">Vui lòng chọn ngày sinh</div>'
      );
      birthday.focus();
      return false;
    }

    if (isEmpty(email.val())) {
      $(".register_response").html(
        '<div class="alert alert-danger">Vui lòng nhập email</div>'
      );
      email.focus();
      return false;
    }

    if (isEmpty(phone.val())) {
      $(".register_response").html(
        '<div class="alert alert-danger">Vui lòng nhập số điện thoại</div>'
      );
      phone.focus();
      return false;
    }

    if (isEmpty(address.val())) {
      $(".register_response").html(
        '<div class="alert alert-danger">Vui lòng nhập địa chỉ</div>'
      );
      address.focus();
      return false;
    }

    $.ajax({
      url: "api/register.php",
      type: "POST",
      dataType: "json",
      data: {
        fullname: fullname.val(),
        username: username.val(),
        password: password.val(),
        birthday: birthday.val(),
        email: email.val(),
        phone: phone.val(),
        address: address.val(),
      },
      beforeSend: function () {
        holdonOpen();
        $("#popup-register").find(".modal-body").css("opacity", "0.5");
        $(this).find(".register-account").prop("disabled", true);
      },
      success: function (result) {
        $("#popup-register").find(".modal-body").css("opacity", "1");
        $(this).find(".register-account").prop("disabled", false);

        if (result.status == 200) {
          $(".register_response").html(
            '<div class="alert alert-success">' + result.message + "</div>"
          );

          setTimeout(function () {
            $.ajax({
              url: "api/login.php",
              type: "POST",
              dataType: "json",
              data: {
                username: username.val(),
                password: password.val(),
              },
              success: function (result) {
                if (result.status == 200) {
                  location.reload();
                }
              },
            });
          }, 3000);
        } else if (result.status == 404) {
          $(".register_response").html(
            '<div class="alert alert-danger">' + result.message + "</div>"
          );
        }
        holdonClose();
      },
    });
  });
};

FRAMEWORK.Random = function () {
  $("#popup-order .input-select select").select2();

  $(".birth-date").datetimepicker({
    timepicker: false,
    format: "d/m/Y",
    formatDate: "d/m/Y",
    maxDate: TIMENOW,
  });
};

FRAMEWORK.Menu = function () {
  /* Menu remove empty ul */
  if (isExist($(".menu"))) {
    $(".menu ul li a").each(function () {
      $this = $(this);
      if (!isExist($this.next("ul").find("li"))) {
        $this.next("ul").remove();
        $this.removeClass("has-child");
      }
    });
  }

  /* Mmenu */
  if (isExist($("nav#menu"))) {
    $("nav#menu").mmenu({
      extensions: ["border-full", "position-left", "position-front"],
    });
  }

  /* Fixed menu */
  if (isExist($(".header"))) {
    $(window).scroll(function () {
      if ($(window).width() > 991) {
        if ($(window).scrollTop() >= $(".header").height()) {
          $(".header").height($(".header").height());
          $(".menu").addClass("fixed animate__fadeInDown animate__animated");
        } else {
          $(".header").height("");
          $(".menu").removeClass("fixed animate__fadeInDown animate__animated");
        }
      } else {
        if ($(window).scrollTop() >= $(".header").height()) {
          $(".header").height($(".header").height());
          $(".menu-res").addClass(
            "fixed animate__fadeInDown animate__animated"
          );
        } else {
          $(".header").height();
          $(".menu-res").removeClass(
            "fixed animate__fadeInDown animate__animated"
          );
        }
      }
    });
  }
};

FRAMEWORK.Search = function () {
  if (isExist($(".icon-search"))) {
    $(".icon-search").click(function () {
      if ($(this).hasClass("active")) {
        $(this).removeClass("active");
        $(".search-grid")
          .stop(true, true)
          .animate({ opacity: "0", width: "0px" }, 200);
      } else {
        $(this).addClass("active");
        $(".search-grid")
          .stop(true, true)
          .animate({ opacity: "1", width: "230px" }, 200);
      }
      document.getElementById($(this).next().find("input").attr("id")).focus();
      $(".icon-search i").toggleClass("fa fa-search fa fa-times");
    });
  }
};

FRAMEWORK.Carousel = function () {
  $(".slick_more_product .boxProduct").slick({
    lazyLoad: "progressive",
    infinite: true,
    accessibility: true,
    vertical: false,
    verticalSwiping: false,
    slidesToShow: 4,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 2000,
    speed: 1000,
    arrows: false,
    centerMode: false,
    dots: false,
    draggable: true,
    responsive: [],
  });

  $(".product__details__pic__left").slick({
    lazyLoad: "progressive",
    infinite: true,
    accessibility: true,
    vertical: true,
    verticalSwiping: true,
    slidesToShow: 4,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 2000,
    speed: 1000,
    arrows: false,
    asNavFor: ".product__details__pic__right",
    focusOnSelect: true,
    centerMode: false,
    dots: false,
    draggable: true,
    responsive: [],
  });

  $(".product__details__pic__right").slick({
    lazyLoad: "progressive",
    infinite: true,
    accessibility: true,
    vertical: false,
    verticalSwiping: false,
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: false,
    autoplaySpeed: 2000,
    speed: 1000,
    arrows: false,
    asNavFor: ".product__details__pic__left",
    centerMode: false,
    dots: false,
    draggable: true,
    responsive: [],
  });

  $(".slideshow__slider").owlCarousel({
    loop: true,
    margin: 10,
    items: 1,
    dots: false,
    nav: true,
    navText: [
      "<span class='fa fa-angle-left'><span/>",
      "<span class='fa fa-angle-right'><span/>",
    ],
    animateOut: "fadeOut",
    animateIn: "fadeIn",
    smartSpeed: 1200,
    autoHeight: false,
    autoplay: true,
  });

  $(".categories__slider").owlCarousel({
    loop: false,
    margin: 10,
    items: 2,
    dots: false,
    nav: true,
    navText: [
      "<span class='fa fa-angle-left'><span/>",
      "<span class='fa fa-angle-right'><span/>",
    ],
    animateOut: "fadeOut",
    animateIn: "fadeIn",
    smartSpeed: 1200,
    autoHeight: false,
    autoplay: true,
    responsive: {
      0: {
        items: 2,
      },

      480: {
        items: 3,
      },

      768: {
        items: 4,
      },

      992: {
        items: 6,
      },
    },
  });

  $(".product__slider").owlCarousel({
    loop: false,
    margin: 20,
    items: 2,
    dots: false,
    nav: true,
    navText: [
      "<span class='fa fa-angle-left'><span/>",
      "<span class='fa fa-angle-right'><span/>",
    ],
    animateOut: "fadeOut",
    animateIn: "fadeIn",
    smartSpeed: 1200,
    autoHeight: false,
    autoplay: true,
    responsive: {
      0: {
        items: 2,
      },

      480: {
        items: 2,
      },

      768: {
        items: 3,
      },

      992: {
        items: 4,
      },
    },
  });

  $(".newsnb__owl").owlCarousel({
    loop: false,
    margin: 30,
    items: 3,
    dots: false,
    nav: true,
    navText: [
      "<span class='fa fa-angle-left'><span/>",
      "<span class='fa fa-angle-right'><span/>",
    ],
    animateOut: "fadeOut",
    animateIn: "fadeIn",
    smartSpeed: 1200,
    autoHeight: false,
    autoplay: true,
    responsive: {
      0: {
        items: 1,
      },

      480: {
        items: 2,
      },

      768: {
        items: 3,
      },

      992: {
        items: 3,
      },
    },
  });
};

FRAMEWORK.Pagings = function () {
  /* Products */
  if (isExist($(".paging-product"))) {
    loadPaging("api/product.php?perpage=8", ".paging-product");
  }

  /* Categories */
  if (isExist($(".paging-product-category"))) {
    $(".paging-product-category").each(function () {
      var list = $(this).data("list");
      loadPaging(
        "api/product.php?perpage=8&idList=" + list,
        ".paging-product-category-" + list
      );
    });
  }
  if (isExist($(".page_splist"))) {
    loadPaging("api/product.php?perpage=8", ".page_splist", 0);
    $(".list_splist a").click(function () {
      $(".list_splist a").removeClass("active");
      $(this).addClass("active");
      var idList = $(this).data("list");
      loadPaging(
        "api/product.php?idList=" + idList + "&perpage=8",
        ".page_splist",
        0
      );
    });
  }
};

FRAMEWORK.Bootstrap = function () {
  if (isExist($("[data-margin]"))) {
    $("[data-margin]").each(function () {
      var $margin = $(this).data("margin");
      $(this).css({ "margin-bottom": $margin + "px" });
    });
  }

  if (isExist($("[data-padding]"))) {
    $("[data-padding]").each(function () {
      var $padding = $(this).data("padding");
      $(this).css({ "padding-top": $padding + "px" });
      $(this).css({ "padding-bottom": $padding + "px" });
    });
  }

  if (isExist($("[data-row]"))) {
    $("[data-row]").each(function () {
      var $padding = $(this).data("row");

      $this.children('[class*="col"]').css({
        paddingLeft: $padding + "px",
        paddingRight: $padding + "px",
      });

      $this.css({
        marginLeft: -$padding + "px",
        marginRight: -$padding + "px",
      });
    });
  }
};

FRAMEWORK.Cart = function () {
  /* Popup */
  $("body").on("click", ".popup_cart", function () {
    $.ajax({
      url: "api/cart.php",
      type: "POST",
      dataType: "html",
      data: {
        cmd: "popup-cart",
      },
      success: function (result) {
        $("#popup-cart .modal-body").html(result);
        $("#popup-cart").modal("show");
      },
    });
  });
  /* Add */
  $("body").on("click", ".btn-cart", function () {
    if (!IS_LOGIN) {
      confirmDialog("force-login", "Vui lòng đăng nhập");
      return false;
    }
  });
  $("body").on("click", ".addcart", function () {
    if (!IS_LOGIN) {
      confirmDialog("force-login", "Vui lòng đăng nhập");
      return false;
    }

    $this = $(this);
    $parents = $this.parents(".right-pro-detail");
    var id = $this.data("id");
    var action = $this.data("action");
    var quantity = $parents.find(".quantity-pro-detail").find(".qty-pro").val();
    quantity = quantity ? quantity : 1;

    /* size màu*/
    var color = $parents
      .find(".color-block-pro-detail")
      .find(".color-pro-detail input:checked")
      .val();
    color = color ? color : 0;
    var size = $parents
      .find(".size-block-pro-detail")
      .find(".size-pro-detail input:checked")
      .val();
    size = size ? size : 0;

    if (id) {
      $.ajax({
        url: "api/cart.php",
        type: "POST",
        dataType: "json",
        data: {
          cmd: "add-cart",
          id: id,
          color: color,
          size: size,
          quantity: quantity,
        },
        beforeSend: function () {
          holdonOpen();
        },
        success: function (result) {
          if (action == "addnow") {
            $(".count-cart").html(result.max);

            $.ajax({
              url: "api/cart.php",
              type: "POST",
              dataType: "html",
              data: {
                cmd: "popup-cart",
              },
              beforeSend: function () {
                holdonOpen();
              },
              success: function (result) {
                $("#popup-cart .modal-body").html(result);
                $("#popup-cart").modal("show");
                $("#popup-quickview").modal("hide");
                holdonClose();
              },
            });
          } else if (action == "buynow") {
            window.location = CONFIG_BASE + "gio-hang";
          }
        },
      });
    }
  });
  /* Delete */
  $("body").on("click", ".del-procart", function () {
    confirmDialog(
      "delete-procart",
      "Bạn muốn xóa sản phẩm này khỏi giỏ hàng ?",
      $(this)
    );
  });
  /* Counter */
  $("body").on("click", ".counter-procart", function () {
    var $button = $(this);
    var quantity = 1;
    var input = $button.parent().find("input");
    var id = input.data("pid");
    var code = input.data("code");
    var oldValue = $button.parent().find("input").val();
    if ($button.text() == "+") quantity = parseFloat(oldValue) + 1;
    else if (oldValue > 1) quantity = parseFloat(oldValue) - 1;
    $button.parent().find("input").val(quantity);
    updateCart(id, code, quantity);
  });
  /* City */
  if (isExist($(".select-city-cart"))) {
    $(".select-city-cart").change(function () {
      var id = $(this).val();
      loadDistrict(id);
    });
  }
  /* District */
  if (isExist($(".select-district-cart"))) {
    $(".select-district-cart").change(function () {
      var id = $(this).val();
      loadWard(id);
    });
  }
  /* Ward */
  if (isExist($(".select-ward-cart"))) {
    $(".select-ward-cart").change(function () {
      var id = $(this).val();
    });
  }
  /* Payments */
  if (isExist($(".payments-label"))) {
    $(".payments-label").click(function () {
      var payments = $(this).data("payments");
      $(".payments-cart .payments-label, .payments-info").removeClass("active");
      $(this).addClass("active");
      $(".payments-info-" + payments).addClass("active");
    });
  }
  /* Colors */
  if (isExist($(".color-pro-detail"))) {
    $(".color-pro-detail input").click(function () {
      $this = $(this).parents("label.color-pro-detail");
      $parents = $this.parents(".attr-pro-detail");
      $parents_detail = $this.parents(".grid-pro-detail");
      $parents
        .find(".color-block-pro-detail")
        .find(".color-pro-detail")
        .removeClass("active");
      $parents
        .find(".color-block-pro-detail")
        .find(".color-pro-detail input")
        .prop("checked", false);
      $this.addClass("active");
      $this.find("input").prop("checked", true);
    });
  }
  /* Sizes */
  if (isExist($(".size-pro-detail"))) {
    $(".size-pro-detail input").click(function () {
      $this = $(this).parents("label.size-pro-detail");
      $parents = $this.parents(".attr-pro-detail");
      $parents
        .find(".size-block-pro-detail")
        .find(".size-pro-detail")
        .removeClass("active");
      $parents
        .find(".size-block-pro-detail")
        .find(".size-pro-detail input")
        .prop("checked", false);
      $this.addClass("active");
      $this.find("input").prop("checked", true);
    });
  }
};

/* Photobox */
FRAMEWORK.Photobox = function () {
  if (isExist($(".album-gallery"))) {
    $(".album-gallery").photobox("a", { thumbs: true, loop: false });
  }
};

/* Ready */
$(document).ready(function () {
  FRAMEWORK.Menu();
  FRAMEWORK.Search();
  FRAMEWORK.Carousel();
  FRAMEWORK.Bootstrap();
  FRAMEWORK.Cart();
  FRAMEWORK.Pagings();
  FRAMEWORK.PopupLogin();
  FRAMEWORK.PopupRegister();
  FRAMEWORK.Comments();
  FRAMEWORK.UserInfo();
  FRAMEWORK.DatePicker();
  FRAMEWORK.Momo();
  FRAMEWORK.Photobox();
  FRAMEWORK.Random();
});
