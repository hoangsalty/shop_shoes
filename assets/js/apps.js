FRAMEWORK.DbUser = function () {
  $("#form_user").submit(function (e) {
    e.preventDefault();

    data = new FormData($(this)[0]);
    data.append("act", "luu-thong-tin");

    $.ajax({
      type: "POST",
      url: "sources/user.php",
      processData: false,
      cache: false,
      contentType: false,
      dataType: "json",
      data: data,
      success: function (result) {
        if (result["status"] == 200) {
          Swal.fire({
            icon: "success",
            title: "Thông báo!",
            text: result["messages"][0],
            allowOutsideClick: false,
          }).then((state) => {
            if (state.isConfirmed) {
              location.href = result["link"];
            }
          });
        } else {
          var myHTML = "";
          result["messages"].forEach((e) => {
            myHTML += '<p class="mb-1">' + e + "</p>";
          });

          $(".box_response").html(
            '<div class="alert alert-danger">' + myHTML + "</div>"
          );
        }
      },
    });
  });

  $("#form_forgotpassword").submit(function (e) {
    e.preventDefault();

    data = new FormData($(this)[0]);
    data.append("act", "quen-mat-khau");

    $.ajax({
      type: "POST",
      url: "sources/user.php",
      processData: false,
      cache: false,
      contentType: false,
      dataType: "json",
      data: data,
      beforeSend: function () {
        holdonOpen();
      },
      success: function (result) {
        holdonClose();
        if (result["status"] == 200) {
          Swal.fire({
            icon: "success",
            title: "Thông báo!",
            text: result["messages"][0],
            allowOutsideClick: false,
          }).then((state) => {
            if (state.isConfirmed) {
              $(".modal").modal("hide");
            }
          });
        } else {
          var myHTML = "";
          result["messages"].forEach((e) => {
            myHTML += '<p class="mb-1">' + e + "</p>";
          });

          $(".forgotpassword_response").html(
            '<div style="color:red">' + myHTML + "</div>"
          );
        }
      },
    });
  });

  $("#change_pass_user").click(function (e) {
    e.preventDefault();

    $(".modal").modal("hide");

    var id = $(this).data("id");
    $("#popup-changepassword").modal("show");
    $("#popup-changepassword").find("#id").val(id);
  });

  $("#form_changepassword").submit(function (e) {
    e.preventDefault();

    data = new FormData($(this)[0]);
    data.append("act", "luu-thong-tin");
    data.append("changepass", 1);

    $.ajax({
      type: "POST",
      url: "sources/user.php",
      processData: false,
      cache: false,
      contentType: false,
      dataType: "json",
      data: data,
      beforeSend: function () {
        holdonOpen();
      },
      success: function (result) {
        holdonClose();
        if (result["status"] == 200) {
          Swal.fire({
            icon: "success",
            title: "Thông báo!",
            text: result["messages"][0],
            allowOutsideClick: false,
          }).then((state) => {
            if (state.isConfirmed) {
              $(".modal").modal("hide");
              location.href = result["link"];
            }
          });
        } else {
          var myHTML = "";
          result["messages"].forEach((e) => {
            myHTML += '<p class="mb-1">' + e + "</p>";
          });

          $(".changepassword_response").html(
            '<div style="color:red">' + myHTML + "</div>"
          );
        }
      },
    });
  });
};

FRAMEWORK.Order = function () {
  function inti_order_status(
    tab_class = "",
    tab_return = "",
    table_select = ""
  ) {
    if (tab_class != "") {
      if ($("." + tab_class + " a.active").length == 0) {
        $("." + tab_class + " a")
          .eq(0)
          .addClass("active");
      }
      var where_select = "" + $("." + tab_class + " a.active").data("id");
    }

    $.ajax({
      url: "api/order.php",
      type: "post",
      data: {
        cmd: "show-order-by-status",
        where_select: where_select,
      },
    }).done(function (result) {
      $("." + tab_return).html(result);
    });
  }

  $(document).on("click", ".nav_status_order a", function (event) {
    event.preventDefault();
    $(this).parent(".nav_status_order").find("a").removeClass("active");
    $(this).addClass("active");
    inti_order_status("nav_status_order", "status_order", "table_order_detail");
  });
  inti_order_status("nav_status_order", "status_order", "table_order_detail");

  $("#form_cart").submit(function (e) {
    e.preventDefault();

    if (!IS_LOGIN) {
      Swal.fire({
        icon: "info",
        title: "Thông báo!",
        text: "Vui lòng đăng nhập để có thể thanh toán",
        allowOutsideClick: false,
      }).then((state) => {
        if (state.isConfirmed) {
          $("#popup-login").modal("show");
        }
      });
      return false;
    }

    data = new FormData($(this)[0]);
    data.append("thanhtoan", true);

    $.ajax({
      type: "POST",
      url: "sources/order.php",
      processData: false,
      cache: false,
      contentType: false,
      dataType: "json",
      data: data,
      success: function (result) {
        if (result["status"] == 201) {
          Swal.fire({
            icon: "success",
            title: "Thông báo!",
            text: result["messages"][0],
            allowOutsideClick: false,
            timer: 2000,
            timerProgressBar: true,
            didOpen: () => {
              Swal.showLoading();
            },
          }).then((state) => {
            if (state.dismiss === Swal.DismissReason.timer) {
              location.href = result["link"];
            }
          });
        } else if (result["status"] == 404) {
          var myHTML = "";
          result["messages"].forEach((e) => {
            myHTML += '<p class="mb-1">' + e + "</p>";
          });

          $(".content-debug").html(
            '<div class="alert alert-danger">' + myHTML + "</div>"
          );
        } else if (result["status"] == 200) {
          $.ajax({
            url: "api/order_status.php",
            type: "POST",
            dataType: "html",
            data: {
              currentOrder: result["currentOrder"],
              tempCart: result["tempCart"],
              messages: result["messages"][0],
              statusOrder: result["status"],
            },
            success: function (result2) {
              $("#order_holder").html(result2);
              window.setTimeout(function () {
                window.location.href = result["link"];
              }, 10000);
            },
          });
        }
      },
    });
  });
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
  $("#myTab a").click(function (e) {
    e.preventDefault();
    $(this).tab("show");
  });
  // store the currently selected tab in the hash value
  $("ul.nav-tabs > li > a").on("shown.bs.tab", function (e) {
    var id = $(e.target).attr("href").substr(1);
    window.location.hash = id;
  });
  // on load of the page: switch to the currently selected tab
  var hash = window.location.hash;
  $('#myTab a[href="' + hash + '"]').tab("show");

  /* Cancel order */
  $("body").on("click", "#cancel-order", function () {
    Swal.fire({
      icon: "warning",
      title: "Thông báo!",
      text: "Bạn muốn hủy đơn hàng này ?",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Chấp nhận",
    }).then((state) => {
      if (state.isConfirmed) {
        var id = $(this).data("id");
        var status = $(this).data("status");

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
    });
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
          return Swal.fire({
            icon: "error",
            title: "Có lỗi phát sinh...",
            text: e,
            allowOutsideClick: false,
          });
        },
        confirm: function (e, t) {
          Swal.fire({
            title: "Thông báo!",
            text: "Bạn có chắc muốn xóa ảnh này ?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Chấp nhận xóa ảnh này",
          }).then((state) => {
            if (state.isConfirmed) {
              t();
            }
          });

          /* $.confirm({
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
          }); */
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
        Swal.fire({
          icon: "error",
          title: "Có lỗi phát sinh...",
          text: "Hệ thống bị lỗi. Vui lòng thử lại sau.",
          allowOutsideClick: false,
        });
      },
      success: function (response) {
        form.trigger("reset");
        holdonClose();
        Swal.fire({
          icon: "success",
          title: "Thông báo!",
          text: "Bình luận sẽ được hiển thị sau khi được Bản Quản Trị kiểm duyệt",
          allowOutsideClick: false,
        });

        setTimeout(function () {
          location.reload();
        }, 3000);
      },
    });
  });
};

FRAMEWORK.PopupLogin = function () {
  $(".btn_signup").click(function (e) {
    e.preventDefault();

    $(".modal").modal("hide");
    $("#popup-register").modal("show");
  });

  $(".btn_forgot").click(function (e) {
    e.preventDefault();

    $(".modal").modal("hide");
    $("#popup-forgot").modal("show");
  });

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

    /* if (isEmpty(fullname.val())) {
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
    } */

    data = new FormData($(this)[0]);
    data.append("act", "luu-thong-tin");

    $.ajax({
      type: "POST",
      url: "sources/user.php",
      processData: false,
      cache: false,
      contentType: false,
      dataType: "json",
      data: data,
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
            '<div class="alert alert-success">' + result["messages"][0] + "</div>"
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
          var myHTML = "";
          result["messages"].forEach((e) => {
            myHTML += '<p class="mb-1">' + e + "</p>";
          });

          $(".register_response").html(
            '<div class="alert alert-danger">' + myHTML + "</div>"
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
        if ($(window).scrollTop() >= $(".menu").height()) {
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
    responsive: [
      {
        breakpoint: 769,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1,
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1
        }
      }
    ],
  });

  $(".product__details__pic__left").slick({
    lazyLoad: "progressive",
    infinite: true,
    accessibility: true,
    vertical: true,
    verticalSwiping: true,
    slidesToShow: 3,
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
    responsive: [
      {
        breakpoint: 769,
        settings: {
          slidesToShow: 4,
          slidesToScroll: 1,
          vertical: false
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1,
          vertical: false
        }
      }
    ],
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
        items: 2,
        margin: 10,
      },

      768: {
        items: 3,
        margin: 15,
      },

      992: {
        items: 4,
        margin: 20,
      },
    },
  });

  $(".newsnb__owl").owlCarousel({
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
    responsive: {
      0: {
        items: 1,
      },

      480: {
        items: 2,
        margin: 10,
      },

      768: {
        items: 3,
        margin: 15,
      },

      992: {
        items: 4,
        margin: 20,
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
  if (isExist($(".load-page-category"))) {
    $('.load-page-category').each(function (index) {
      var idList = $(this).data("rel");
      loadPaging("api/product.php?idList=" + idList + "&perpage=8", '.load-page-pronb' + idList);
      $(document).on('click', '.title-product-' + idList + ' .a-title-product', function () {
        $('.title-product-' + idList + ' .a-title-product').removeClass('active');
        $(this).addClass('active');
        var _list = $(this).data("list");
        var _cat = $(this).data("cat");
        loadPaging("api/product.php?idList=" + _list + "&idCat=" + _cat + "&perpage=8", '.load-page-pronb' + idList);
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
  $("body").on("click", ".addcart", function () {
    if (!IS_LOGIN && $(this).hasClass("btn_buynow")) {
      Swal.fire({
        icon: "info",
        title: "Thông báo!",
        text: "Vui lòng đăng nhập để có thể thanh toán",
        allowOutsideClick: false,
      }).then((state) => {
        if (state.isConfirmed) {
          $("#popup-login").modal("show");
        }
      });
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
          if (result["status"] == 200) {
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
          } else if (result["status"] == 404) {
            Swal.fire({
              icon: "warning",
              title: "Thông báo!",
              text: result["message"],
              allowOutsideClick: false,
            });
            holdonClose();
          }
        },
      });
    }
  });
  /* Delete */
  $("body").on("click", ".del-procart", function () {
    $this = $(this);

    Swal.fire({
      title: "Thông báo!",
      text: "Bạn muốn xóa sản phẩm này khỏi giỏ hàng ?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Chấp nhận",
    }).then((state) => {
      if (state.isConfirmed) {
        var code = $this.data("code");
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
    });
  });
  /* Counter */
  $("body").on("click", ".counter-procart", function () {
    var quantity = 1;
    var input = $(this).parent().find("input");
    var id = input.data("pid");
    var oldValue = $(this).parent().find("input").val();
    if ($(this).text() == "+") {
      $.ajax({
        url: "api/cart.php",
        type: "POST",
        dataType: "json",
        data: {
          cmd: "plus",
          oldValue: oldValue,
          id: id,
        },
        success: function (result) {
          input.val(result["quantity"]);
          updateCart(id, code, result["quantity"]);
        },
      });
    } else if (oldValue > 1) {
      $.ajax({
        url: "api/cart.php",
        type: "POST",
        dataType: "json",
        data: {
          cmd: "minus",
          oldValue: oldValue,
          id: id,
        },
        success: function (result) {
          input.val(result["quantity"]);
          updateCart(id, code, result["quantity"]);
        },
      });
    }
  });

  /* City */
  if (isExist($(".select-city-cart"))) {
    $(".select-city-cart").change(function () {
      var id = $(this).val().split("__")[1];
      loadDistrict(id);
    });
  }
  /* District */
  if (isExist($(".select-district-cart"))) {
    $(".select-district-cart").change(function () {
      var id = $(this).val().split("__")[1];
      loadWard(id);
    });
  }
  /* Ward */
  if (isExist($(".select-ward-cart"))) {
    $(".select-ward-cart").change(function () {
      var districtID = $(".select-district-cart").val().split("__")[1];
      var wardID = $(this).val().split("__")[1];
      loadShipPrice(districtID, wardID);
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

/* Load Sort */
FRAMEWORK.Sort = function () {
  $(".click-sort").click(function (e) {
    $(".sort-select-main").slideToggle();
  });
  $("body").on("click", ".sort-select-main p .check", function (event) {
    loadSort();
  });
};

/* Logo mã màu đặc biệt: monoHL, oceanHL, fireHL */
FRAMEWORK.ShinerLogo = function () {
  if (isExist($(".peShiner"))) {
    $(window).bind("load", function () {
      var api = $(".peShiner").peShiner({
        api: true,
        paused: true,
        reverse: true,
        repeat: 1,
        color: "oceanHL",
      });
      api.resume();
    });
  }
};

/* Ready */
$(document).ready(function () {
  validateForm("validation-form");
  FRAMEWORK.Menu();
  FRAMEWORK.Search();
  FRAMEWORK.Carousel();
  FRAMEWORK.Cart();
  FRAMEWORK.Pagings();
  FRAMEWORK.PopupLogin();
  FRAMEWORK.PopupRegister();
  FRAMEWORK.Comments();
  FRAMEWORK.UserInfo();
  FRAMEWORK.DatePicker();
  FRAMEWORK.Photobox();
  FRAMEWORK.Random();
  FRAMEWORK.Order();
  FRAMEWORK.DbUser();
  FRAMEWORK.Sort();
  FRAMEWORK.ShinerLogo();
});
