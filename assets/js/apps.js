FRAMEWORK.Random = function () {
  $('.birth-date').datetimepicker({
    timepicker: false,
    format: 'd/m/Y',
    formatDate: 'd/m/Y',
    maxDate: TIMENOW,
  });
}

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
  $(window).scroll(function () {
    if ($(window).width() > 991) {
      if (
        $(window).scrollTop() >=
        $(".header").height() + $(".slideshow").height()
      ) {
        $(".menu").addClass("fixed animate__fadeInDown animate__animated");
        $(".ul-menu").addClass("hidden-menu");
        $(".header").css({ "margin-bottom": $(".menu").height() });
      } else {
        $(".menu").removeClass("fixed animate__fadeInDown animate__animated");
        $(".header").css({ "margin-bottom": "" });
        if (isExist($(".wrap-home"))) {
          $(".ul-menu").removeClass("hidden-menu");
        }
      }
    } else {
      if ($(window).scrollTop() >= $(".header").height()) {
        $(".menu-res").addClass("fixed animate__fadeInDown animate__animated");

        $(".header").css({ "margin-bottom": $(".menu-res").height() });
      } else {
        $(".menu-res").removeClass(
          "fixed animate__fadeInDown animate__animated"
        );

        $(".header").css({ "margin-bottom": "" });
      }
    }
  });

  $(".menu-left .title").click(function () {
    if ($(".ul-menu").hasClass("hidden-menu")) {
      $(".ul-menu").removeClass("hidden-menu");
    } else {
      $(".ul-menu").addClass("hidden-menu");
    }
  });

  $(window).bind("load resize", function () {
    if (isExist($(".slideshow"))) {
      heigth = $(".slideshow").height();
    } else {
      heigth = 350;
    }

    $(".ul-menu").height(heigth);
  });
}

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
}

FRAMEWORK.Carousel = function () {
  $(".slideshow__slider").owlCarousel({
    loop: false,
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
    margin: 20,
    items: 4,
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

  $(".gallery__slider").owlCarousel({
    loop: true,
    margin: 10,
    items: 5,
    dots: false,
    nav: true,
    navText: [
      "<span class='fa fa-angle-left'><span/>",
      "<span class='fa fa-angle-right'><span/>",
    ],
    animateOut: "fadeOut",
    animateIn: "fadeIn",
    smartSpeed: 1200,
    autoHeight: true,
    autoplay: true,
    responsive: {
      0: {
        items: 1,
      },

      480: {
        items: 3,
      },

      768: {
        items: 4,
      },

      992: {
        items: 5,
      },
    },
  });
}

FRAMEWORK.Pagings = function () {
  loadPaging("api/product.php?perpage=8", ".paging-product-list", 0);
  $(".title-product-list .a-title-product").click(function () {
    $(".title-product-list .a-title-product").removeClass("active");
    $(this).addClass("active");
    var idList = $(this).data("list");
    loadPaging(
      "api/product.php?idList=" + idList + "&perpage=8",
      ".paging-product-list",
      0
    );
  });
}

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
}

FRAMEWORK.Cart = function () {
  /* Popup */
  $('body').on('click', '.popup_cart', function () {
    $.ajax({
      url: 'api/cart.php',
      type: 'POST',
      dataType: 'html',
      async: false,
      data: {
        cmd: 'popup-cart'
      },
      success: function (result) {
        $('#popup-cart .modal-body').html(result);
        $('#popup-cart').modal('show');
        holdonClose();
      }
    });
  });
  /* Add */
  $('body').on('click', '.btn-cart', function () {
    if (!IS_LOGIN) {
      confirmDialog('force-login', 'Vui lòng đăng nhập để sử dụng chức năng giỏ hàng');
      return false;
    }
  });
  $('body').on('click', '.addcart', function () {
    if (!IS_LOGIN) {
      confirmDialog('force-login', 'Vui lòng đăng nhập để sử dụng chức năng giỏ hàng');
      return false;
    }

    $this = $(this);
    $parents = $this.parents('.right-pro-detail');
    var id = $this.data('id');
    var action = $this.data('action');
    var quantity = $parents.find('.quantity-pro-detail').find('.qty-pro').val();
    quantity = quantity ? quantity : 1;

    /* size màu cơ bản*/
    var color = $parents.find('.color-block-pro-detail').find('.color-pro-detail input:checked').val();
    color = color ? color : 0;
    var size = $parents.find('.size-block-pro-detail').find('.size-pro-detail input:checked').val();
    size = size ? size : 0;

    if (id) {
      $.ajax({
        url: 'api/cart.php',
        type: 'POST',
        dataType: 'json',
        async: false,
        data: {
          cmd: 'add-cart',
          id: id,
          color: color,
          size: size,
          quantity: quantity,
        },
        beforeSend: function () {
          holdonOpen();
        },
        success: function (result) {
          if (action == 'addnow') {
            $('.count-cart').html(result.max);
            $.ajax({
              url: 'api/cart.php',
              type: 'POST',
              dataType: 'html',
              async: false,
              data: {
                cmd: 'popup-cart'
              },
              beforeSend: function () {
                HoldOn.open({
                  theme: "sk-bounce",
                  message: 'Vui lòng chờ tí ...'
                });
              },
              success: function (result) {
                $('#popup-cart .modal-body').html(result);
                $('#popup-cart').modal('show');
                $('#popup-quickview').modal('hide');
                holdonClose();
              }
            });
          } else if (action == 'buynow') {
            window.location = CONFIG_BASE + 'gio-hang';
          }
        }
      });
    }
  });
  /* Delete */
  $('body').on('click', '.del-procart', function () {
    confirmDialog('delete-procart', 'Bạn muốn xóa sản phẩm này khỏi giỏ hàng ?', $(this));
  });
  /* Counter */
  $('body').on('click', '.counter-procart', function () {
    var $button = $(this);
    var quantity = 1;
    var input = $button.parent().find('input');
    var id = input.data('pid');
    var code = input.data('code');
    var oldValue = $button.parent().find('input').val();
    if ($button.text() == '+') quantity = parseFloat(oldValue) + 1;
    else if (oldValue > 1) quantity = parseFloat(oldValue) - 1;
    $button.parent().find('input').val(quantity);
    updateCart(id, code, quantity);
  });
  /* City */
  if (isExist($('.select-city-cart'))) {
    $('.select-city-cart').change(function () {
      var id = $(this).val();
      loadDistrict(id);
    });
  }
  /* District */
  if (isExist($('.select-district-cart'))) {
    $('.select-district-cart').change(function () {
      var id = $(this).val();
      loadWard(id);
    });
  }
  /* Ward */
  if (isExist($('.select-ward-cart'))) {
    $('.select-ward-cart').change(function () {
      var id = $(this).val();
    });
  }
  /* Payments */
  if (isExist($('.payments-label'))) {
    $('.payments-label').click(function () {
      var payments = $(this).data('payments');
      $('.payments-cart .payments-label, .payments-info').removeClass('active');
      $(this).addClass('active');
      $('.payments-info-' + payments).addClass('active');
    });
  }
  /* Colors */
  if (isExist($('.color-pro-detail'))) {
    $('.color-pro-detail input').click(function () {
      $this = $(this).parents('label.color-pro-detail');
      $parents = $this.parents('.attr-pro-detail');
      $parents_detail = $this.parents('.grid-pro-detail');
      $parents.find('.color-block-pro-detail').find('.color-pro-detail').removeClass('active');
      $parents.find('.color-block-pro-detail').find('.color-pro-detail input').prop('checked', false);
      $this.addClass('active');
      $this.find('input').prop('checked', true);
    });
  }
  /* Sizes */
  if (isExist($('.size-pro-detail'))) {
    $('.size-pro-detail input').click(function () {
      $this = $(this).parents('label.size-pro-detail');
      $parents = $this.parents('.attr-pro-detail');
      $parents.find('.size-block-pro-detail').find('.size-pro-detail').removeClass('active');
      $parents.find('.size-block-pro-detail').find('.size-pro-detail input').prop('checked', false);
      $this.addClass('active');
      $this.find('input').prop('checked', true);
    });
  }
}

/* Ready */
$(document).ready(function () {
  FRAMEWORK.Menu();
  FRAMEWORK.Search();
  FRAMEWORK.Carousel();
  FRAMEWORK.Bootstrap();
  FRAMEWORK.Cart();
  FRAMEWORK.Pagings();
  FRAMEWORK.Random();
});