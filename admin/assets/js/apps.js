FRAMEWORK.DbSizeColor = function () {
    $('.modal').on('hidden.bs.modal', function (e) {
        $(this)
            .find("input,textarea,select")
            .val('')
            .end()
            .find("input[type=checkbox], input[type=radio]")
            .prop("checked", "")
            .end();
    });

    $("#form_product_size").submit(function (e) {
        e.preventDefault();

        id = $(this).find('#id').val();
        data = new FormData($(this)[0]);
        data.append('act', 'save_size');
        data.append('id', id);

        $.ajax({
            type: "POST",
            url: 'sources/product.php',
            processData: false,
            cache: false,
            contentType: false,
            dataType: "json",
            data: data,
            success: function (result) {
                if (result["status"] == 200) {
                    $('.modal').modal('hide');
                    $('.modal').on('hidden.bs.modal', function () {
                        Swal.fire({
                            icon: 'success',
                            title: 'Thông báo!',
                            text: result["messages"][0],
                            allowOutsideClick: false,
                        }).then((state) => {
                            if (state.isConfirmed) {
                                location.reload();
                            }
                        });
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Có lỗi phát sinh...',
                        text: result["messages"][0],
                        allowOutsideClick: false,
                    }).then((state) => {
                        if (state.isConfirmed) {
                            location.reload();
                        }
                    });
                }
            }
        });
    });

    if ($('#edit-size').length) {
        $('body').on('click', '#edit-size', function () {
            var id = $(this).data('id');

            $.ajax({
                type: "GET",
                url: 'sources/product.php',
                dataType: "json",
                data: {
                    act: 'edit_size',
                    id: id,
                },
                success: function (result) {
                    $("#form_product_size #id").val(result.id);
                    $("#form_product_size #name").val(result.name);
                    $('#popup_product_size').modal('show');
                }
            });
        });
    }

    $("#form_product_color").submit(function (e) {
        e.preventDefault();

        id = $(this).find('#id').val();
        data = new FormData($(this)[0]);
        data.append('act', 'save_color');
        data.append('id', id);

        $.ajax({
            type: "POST",
            url: 'sources/product.php',
            processData: false,
            cache: false,
            contentType: false,
            dataType: "json",
            data: data,
            success: function (result) {
                if (result["status"] == 200) {
                    $('.modal').modal('hide');
                    $('.modal').on('hidden.bs.modal', function () {
                        Swal.fire({
                            icon: 'success',
                            title: 'Thông báo!',
                            text: result["messages"][0],
                            allowOutsideClick: false,
                        }).then((state) => {
                            if (state.isConfirmed) {
                                location.reload();
                            }
                        });
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Có lỗi phát sinh...',
                        text: result["messages"][0],
                        allowOutsideClick: false,
                    }).then((state) => {
                        if (state.isConfirmed) {
                            location.reload();
                        }
                    });
                }
            }
        });
    });

    if ($('#edit-color').length) {
        $('body').on('click', '#edit-color', function () {
            var id = $(this).data('id');

            $.ajax({
                type: "GET",
                url: 'sources/product.php',
                dataType: "json",
                data: {
                    act: 'edit_color',
                    id: id,
                },
                success: function (result) {
                    $("#form_product_color #id").val(result.id);
                    $("#form_product_color #name").val(result.name);
                    $("#form_product_color #color").val(result.color);
                    $('#popup_product_color').modal('show');
                }
            });
        });
    }
};

FRAMEWORK.DbProduct = function () {
    $("#form_product").submit(function (e) {
        e.preventDefault();

        data = new FormData($(this)[0]);
        value = CKEDITOR.instances['content'].getData();
        data.set('data[content]', value);
        data.append('act', 'save');

        $.ajax({
            type: "POST",
            url: 'sources/product.php',
            processData: false,
            cache: false,
            contentType: false,
            dataType: "json",
            data: data,
            success: function (result) {
                if (result["status"] == 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thông báo!',
                        text: result["messages"][0],
                        allowOutsideClick: false,
                    }).then((state) => {
                        if (state.isConfirmed) {
                            location.href = result['link'];
                        }
                    });
                } else {
                    var myHTML = '';
                    result["messages"].forEach(e => {
                        myHTML += '<p class="mb-1">' + e + '</p>';
                    });

                    $('.box_response').html(
                        '<div class="card bg-gradient-red">' +
                        '<div class="card-header">' +
                        '<h3 class="card-title">Thông báo</h3>' +
                        '<div class="card-tools">' +
                        '<button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>' +
                        '<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>' +
                        '</div>' +
                        '</div>' +
                        '<div class="card-body">' +
                        myHTML +
                        '</div>' +
                        '</div>'
                    )
                }
            }
        });
    });
}

FRAMEWORK.DbProductList = function () {
    $("#form_product_list").submit(function (e) {
        e.preventDefault();

        data = new FormData($(this)[0]);
        data.append('act', 'save_list');

        $.ajax({
            type: "POST",
            url: 'sources/product.php',
            processData: false,
            cache: false,
            contentType: false,
            dataType: "json",
            data: data,
            success: function (result) {
                if (result["status"] == 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thông báo!',
                        text: result["messages"][0],
                        allowOutsideClick: false,
                    }).then((state) => {
                        if (state.isConfirmed) {
                            location.href = result['link'];
                        }
                    });
                } else {
                    var myHTML = '';
                    result["messages"].forEach(e => {
                        myHTML += '<p class="mb-1">' + e + '</p>';
                    });

                    $('.box_response').html(
                        '<div class="card bg-gradient-red">' +
                        '<div class="card-header">' +
                        '<h3 class="card-title">Thông báo</h3>' +
                        '<div class="card-tools">' +
                        '<button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>' +
                        '<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>' +
                        '</div>' +
                        '</div>' +
                        '<div class="card-body">' +
                        myHTML +
                        '</div>' +
                        '</div>'
                    )
                }
            }
        });
    });
}

FRAMEWORK.DbProductCat = function () {
    $("#form_product_cat").submit(function (e) {
        e.preventDefault();

        data = new FormData($(this)[0]);
        data.append('act', 'save_cat');

        $.ajax({
            type: "POST",
            url: 'sources/product.php',
            processData: false,
            cache: false,
            contentType: false,
            dataType: "json",
            data: data,
            success: function (result) {
                if (result["status"] == 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thông báo!',
                        text: result["messages"][0],
                        allowOutsideClick: false,
                    }).then((state) => {
                        if (state.isConfirmed) {
                            location.href = result['link'];
                        }
                    });
                } else {
                    var myHTML = '';
                    result["messages"].forEach(e => {
                        myHTML += '<p class="mb-1">' + e + '</p>';
                    });

                    $('.box_response').html(
                        '<div class="card bg-gradient-red">' +
                        '<div class="card-header">' +
                        '<h3 class="card-title">Thông báo</h3>' +
                        '<div class="card-tools">' +
                        '<button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>' +
                        '<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>' +
                        '</div>' +
                        '</div>' +
                        '<div class="card-body">' +
                        myHTML +
                        '</div>' +
                        '</div>'
                    )
                }
            }
        });
    });
}

FRAMEWORK.DbNews = function () {
    $("#form_news").submit(function (e) {
        e.preventDefault();

        type = $("#form_news #type").val();
        data = new FormData($(this)[0]);
        value = CKEDITOR.instances['content'].getData();
        data.set('data[content]', value);
        data.append('act', 'save');
        data.append('cur_Page', CUR_PAGE);
        data.append('cur_Type', type);

        $.ajax({
            type: "POST",
            url: 'sources/news.php',
            processData: false,
            cache: false,
            contentType: false,
            dataType: "json",
            data: data,
            success: function (result) {
                if (result["status"] == 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thông báo!',
                        text: result["messages"][0],
                        allowOutsideClick: false,
                    }).then((state) => {
                        if (state.isConfirmed) {
                            location.href = result['link'];
                        }
                    });
                } else {
                    var myHTML = '';
                    result["messages"].forEach(e => {
                        myHTML += '<p class="mb-1">' + e + '</p>';
                    });

                    $('.box_response').html(
                        '<div class="card bg-gradient-red">' +
                        '<div class="card-header">' +
                        '<h3 class="card-title">Thông báo</h3>' +
                        '<div class="card-tools">' +
                        '<button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>' +
                        '<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>' +
                        '</div>' +
                        '</div>' +
                        '<div class="card-body">' +
                        myHTML +
                        '</div>' +
                        '</div>'
                    )
                }
            }
        });
    });
}

FRAMEWORK.DbStatic = function () {
    $("#form_static").submit(function (e) {
        e.preventDefault();

        type = $("#form_static #type").val();
        data = new FormData($(this)[0]);
        value = CKEDITOR.instances['content'].getData();
        data.set('data[content]', value);
        data.append('act', 'save');
        data.append('cur_Type', type);

        $.ajax({
            type: "POST",
            url: 'sources/static.php',
            processData: false,
            cache: false,
            contentType: false,
            dataType: "json",
            data: data,
            success: function (result) {
                if (result["status"] == 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thông báo!',
                        text: result["messages"][0],
                        allowOutsideClick: false,
                    }).then((state) => {
                        if (state.isConfirmed) {
                            location.href = result['link'];
                        }
                    });
                } else {
                    var myHTML = '';
                    result["messages"].forEach(e => {
                        myHTML += '<p class="mb-1">' + e + '</p>';
                    });

                    $('.box_response').html(
                        '<div class="card bg-gradient-red">' +
                        '<div class="card-header">' +
                        '<h3 class="card-title">Thông báo</h3>' +
                        '<div class="card-tools">' +
                        '<button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>' +
                        '<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>' +
                        '</div>' +
                        '</div>' +
                        '<div class="card-body">' +
                        myHTML +
                        '</div>' +
                        '</div>'
                    )
                }
            }
        });
    });
}

FRAMEWORK.DbSetting = function () {
    $("#form_setting").submit(function (e) {
        e.preventDefault();

        data = new FormData($(this)[0]);
        data.append('act', 'save');

        $.ajax({
            type: "POST",
            url: 'sources/setting.php',
            processData: false,
            cache: false,
            contentType: false,
            dataType: "json",
            data: data,
            success: function (result) {
                if (result["status"] == 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thông báo!',
                        text: result["messages"][0],
                        allowOutsideClick: false,
                    }).then((state) => {
                        if (state.isConfirmed) {
                            location.href = result['link'];
                        }
                    });
                } else {
                    var myHTML = '';
                    result["messages"].forEach(e => {
                        myHTML += '<p class="mb-1">' + e + '</p>';
                    });

                    $('.box_response').html(
                        '<div class="card bg-gradient-red">' +
                        '<div class="card-header">' +
                        '<h3 class="card-title">Thông báo</h3>' +
                        '<div class="card-tools">' +
                        '<button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>' +
                        '<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>' +
                        '</div>' +
                        '</div>' +
                        '<div class="card-body">' +
                        myHTML +
                        '</div>' +
                        '</div>'
                    )
                }
            }
        });
    });
}

FRAMEWORK.DbStaticPhoto = function () {
    $("#form_static_photo").submit(function (e) {
        e.preventDefault();

        type = $("#form_static_photo #type").val();
        data = new FormData($(this)[0]);
        data.append('act', 'save_static');
        data.append('cur_Type', type);

        $.ajax({
            type: "POST",
            url: 'sources/photo.php',
            processData: false,
            cache: false,
            contentType: false,
            dataType: "json",
            data: data,
            success: function (result) {
                if (result["status"] == 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thông báo!',
                        text: result["messages"][0],
                        allowOutsideClick: false,
                    }).then((state) => {
                        if (state.isConfirmed) {
                            location.href = result['link'];
                        }
                    });
                } else {
                    var myHTML = '';
                    result["messages"].forEach(e => {
                        myHTML += '<p class="mb-1">' + e + '</p>';
                    });

                    $('.box_response').html(
                        '<div class="card bg-gradient-red">' +
                        '<div class="card-header">' +
                        '<h3 class="card-title">Thông báo</h3>' +
                        '<div class="card-tools">' +
                        '<button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>' +
                        '<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>' +
                        '</div>' +
                        '</div>' +
                        '<div class="card-body">' +
                        myHTML +
                        '</div>' +
                        '</div>'
                    )
                }
            }
        });
    });
}

FRAMEWORK.DbPhoto = function () {
    $("#form_photo").submit(function (e) {
        e.preventDefault();

        type = $("#form_photo #type").val();
        data = new FormData($(this)[0]);
        data.append('act', 'save_photo');
        data.append('cur_Page', CUR_PAGE);
        data.append('cur_Type', type);

        $.ajax({
            type: "POST",
            url: 'sources/photo.php',
            processData: false,
            cache: false,
            contentType: false,
            dataType: "json",
            data: data,
            success: function (result) {
                if (result["status"] == 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thông báo!',
                        text: result["messages"][0],
                        allowOutsideClick: false,
                    }).then((state) => {
                        if (state.isConfirmed) {
                            location.href = result['link'];
                        }
                    });
                } else {
                    var myHTML = '';
                    result["messages"].forEach(e => {
                        myHTML += '<p class="mb-1">' + e + '</p>';
                    });

                    $('.box_response').html(
                        '<div class="card bg-gradient-red">' +
                        '<div class="card-header">' +
                        '<h3 class="card-title">Thông báo</h3>' +
                        '<div class="card-tools">' +
                        '<button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>' +
                        '<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>' +
                        '</div>' +
                        '</div>' +
                        '<div class="card-body">' +
                        myHTML +
                        '</div>' +
                        '</div>'
                    )
                }
            }
        });
    });
}

FRAMEWORK.DbUser = function () {
    $("#form_user").submit(function (e) {
        e.preventDefault();

        data = new FormData($(this)[0]);
        data.append('act', 'save');
        data.append('cur_Page', CUR_PAGE);

        $.ajax({
            type: "POST",
            url: 'sources/user.php',
            processData: false,
            cache: false,
            contentType: false,
            dataType: "json",
            data: data,
            success: function (result) {
                if (result["status"] == 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thông báo!',
                        text: result["messages"][0],
                        allowOutsideClick: false,
                    }).then((state) => {
                        if (state.isConfirmed) {
                            location.href = result['link'];
                        }
                    });
                } else {
                    var myHTML = '';
                    result["messages"].forEach(e => {
                        myHTML += '<p class="mb-1">' + e + '</p>';
                    });

                    $('.box_response').html(
                        '<div class="card bg-gradient-red">' +
                        '<div class="card-header">' +
                        '<h3 class="card-title">Thông báo</h3>' +
                        '<div class="card-tools">' +
                        '<button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>' +
                        '<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>' +
                        '</div>' +
                        '</div>' +
                        '<div class="card-body">' +
                        myHTML +
                        '</div>' +
                        '</div>'
                    )
                }
            }
        });
    });
}

FRAMEWORK.DbOrder = function () {
    $("#form_order").submit(function (e) {
        e.preventDefault();

        data = new FormData($(this)[0]);
        data.append('act', 'save');

        $.ajax({
            type: "POST",
            url: 'sources/order.php',
            processData: false,
            cache: false,
            contentType: false,
            dataType: "json",
            data: data,
            success: function (result) {
                if (result["status"] == 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thông báo!',
                        text: result["messages"][0],
                        allowOutsideClick: false,
                    }).then((state) => {
                        if (state.isConfirmed) {
                            location.href = result['link'];
                        }
                    });
                } else {
                    var myHTML = '';
                    result["messages"].forEach(e => {
                        myHTML += '<p class="mb-1">' + e + '</p>';
                    });

                    $('.box_response').html(
                        '<div class="card bg-gradient-red">' +
                        '<div class="card-header">' +
                        '<h3 class="card-title">Thông báo</h3>' +
                        '<div class="card-tools">' +
                        '<button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>' +
                        '<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>' +
                        '</div>' +
                        '</div>' +
                        '<div class="card-body">' +
                        myHTML +
                        '</div>' +
                        '</div>'
                    )
                }
            }
        });
    });
}

FRAMEWORK.CustomSelect = function () {
    /* Sumoselect */
    if ($('.multiselect').length) {
        $('.multiselect').SumoSelect({
            placeholder: 'Chọn danh mục',
            selectAll: true,
            search: true,
            searchText: 'Tìm kiếm',
            locale: ['OK', 'Hủy', 'Chọn hết'],
            captionFormat: 'Đã chọn {0} mục',
            captionFormatAllSelected: 'Đã chọn tất cả {0} mục'
        });
    }

    /* Ajax category */
    if ($('.select-category')) {
        $('body').on('change', '.select-category', function () {
            var id = $(this).val();
            var child = $(this).data('child');
            var table = $(this).data('table');

            if ($('#' + child).length) {
                $.ajax({
                    url: 'api/category.php',
                    type: 'POST',
                    data: {
                        id: id,
                        table: table,
                    },
                    success: function (result) {
                        var op = "<option value='0'>Chọn danh mục</option>";

                        $('#id_cat').html(op);
                        $('#' + child).html(result);
                    }
                });

                return false;
            }
        });
    }
}

FRAMEWORK.Comments = function () {
    $('body').on('click', '.btn-status-comment', function (e) {
        e.preventDefault();
        $this = $(this);
        var id = $this.attr('data-id');
        var status = $this.attr('data-status');
        var newSibling = $this.attr('data-new-sibling');

        $.ajax({
            url: 'api/comment.php',
            method: 'POST',
            dataType: 'json',
            async: false,
            data: {
                type: 'status',
                id: id,
                status: status,
            },
            success: function (response) {
                if (response.errors) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Có lỗi phát sinh...',
                        text: response.errors,
                        allowOutsideClick: false,
                    }).then((state) => {
                        if (state.isConfirmed) {
                            location.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thông báo!',
                        text: 'Cập nhật trạng thái thành công',
                        allowOutsideClick: false,
                    }).then((state) => {
                        if (state.isConfirmed) {
                            location.reload();
                        }
                    });
                }
            }
        });
    });
    $('body').on('click', '.btn-delete-comment', function (e) {
        e.preventDefault();
        $this = $(this);
        $loadControl = $this.parents("." + $this.attr("data-parents")).find(".comment-load-more-control");
        var id = $this.attr('data-id');

        Swal.fire({
            title: 'Thông báo!',
            text: "Bạn muốn xóa bình luận này ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Chấp nhận xóa dữ liệu'
        }).then((state) => {
            if (state.isConfirmed) {
                $.ajax({
                    url: 'api/comment.php',
                    method: 'POST',
                    dataType: 'json',
                    async: false,
                    data: {
                        type: 'delete',
                        id: id
                    },
                    beforeSend: function () {
                        holdonOpen();
                    },
                    error: function (e) {
                        holdonClose();
                        console('API Comment Delete bị lỗi. Vui lòng thử lại sau.');
                    },
                    success: function (response) {
                        holdonClose();

                        if (response.errors) {
                            console('API Comment Delete ' + response.errors);
                        }
                        else {
                            $this.parents('.' + $this.data('class')).remove();
                        }
                    }
                });
            }
        });
    });
}

FRAMEWORK.AlbumFiler = function () {
    /* Filer */
    if ($('#filer-gallery').length) {
        var table = $("#gallery_table")[0].value;;

        $('#filer-gallery').filer({
            limit: null,
            maxSize: null,
            extensions: ['jpg', 'png', 'jpeg', 'JPG', 'PNG', 'JPEG', 'Png'],
            changeInput: '<div class="jFiler-input-dragDrop"><div class="jFiler-input-inner"><div class="jFiler-input-icon"><i class="icon-jfi-cloud-up-o"></i></div><div class="jFiler-input-text"><h3>Kéo và thả hình vào đây</h3> <span style="display:inline-block; margin: 15px 0">hoặc</span></div><a class="jFiler-input-choose-btn blue">Chọn hình</a></div></div>',
            theme: 'dragdropbox',
            showThumbs: false,
            addMore: true,
            allowDuplicates: false,
            clipBoardPaste: false,
            dragDrop: {
                dragEnter: null,
                dragLeave: null,
                drop: null,
                dragContainer: null
            },
            captions: {
                button: 'Thêm hình',
                feedback: 'Vui lòng chọn hình ảnh',
                feedback2: 'Những hình đã được chọn',
                drop: 'Kéo hình vào đây để upload',
                removeConfirmation: 'Bạn muốn loại bỏ hình ảnh này ?',
                errors: {
                    filesLimit: 'Chỉ được upload mỗi lần {{fi-limit}} hình ảnh',
                    filesType: 'Chỉ hỗ trợ tập tin là hình ảnh có định dạng: {{fi-extensions}}',
                    filesSize: 'Hình {{fi-name}} có kích thước quá lớn. Vui lòng upload hình ảnh có kích thước tối đa {{fi-maxSize}} MB.',
                    filesSizeAll: 'Những hình ảnh bạn chọn có kích thước quá lớn. Vui lòng chọn những hình ảnh có kích thước tối đa {{fi-maxSize}} MB.'
                }
            },
            uploadFile: {
                url: 'api/upload.php',
                data: {
                    'params': QUERY_STRING,
                    'album_table': table,
                },
                type: 'POST',
                enctype: 'multipart/form-data',
                dataType: 'json',
                async: false,
                success: function (data) {
                    data = JSON.parse(data);
                    if (data['success'] == true) {
                        location.reload();
                    } else {
                        alert(data['msg']);
                    }
                },
                error: function () {
                    alert('Error with filer');
                },
            },
        });
    }
    /* Delete filer */
    $('body').on('click', '.my-jFiler-item-trash', function () {
        var id = $(this).data('id');
        var table = $(this).data('table');

        Swal.fire({
            title: 'Bạn có chắc muốn xóa hình ảnh này ?',
            text: "Bạn sẽ không thể hoàn tác dữ liệu này!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Chấp nhận xóa ảnh này'
        }).then((state) => {
            if (state.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: 'api/gallery.php',
                    data: {
                        id: id,
                        cmd: 'delete',
                        table: table,
                    }
                });

                $('.my-jFiler-item-' + id).remove();
                if ($('.my-jFiler-items ul li').length == 0) {
                    $('.form-group-gallery').remove();
                }
            }
        });
    });
    /* Check all filer */
    $('body').on('click', '.check-all-filer', function () {
        var input = $('.my-jFiler-items .jFiler-items-list').find('input.filer-checkbox');
        var jFilerItems = $('#jFilerSortable').find('.my-jFiler-item');

        $(this).find('i').toggleClass('far fa-square fas fa-check-square');
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
            $('.sort-filer').removeClass('active');
            $('.sort-filer').attr('disabled', false);
            input.each(function () {
                $(this).prop('checked', false);
            });
        } else {
            $(this).addClass('active');
            $('.sort-filer').attr('disabled', true);
            $('.alert-sort-filer').hide();
            $('.my-jFiler-item-trash').show();
            input.each(function () {
                $(this).prop('checked', true);
            });
            jFilerItems.each(function () {
                $(this).find('input').attr('disabled', false);
            });
            jFilerItems.each(function () {
                $(this).removeClass('moved');
            });
        }
    });
    /* Delete all filer */
    $('body').on('click', '.delete-all-filer', function () {
        var table = $(this).data('table');

        Swal.fire({
            title: 'Bạn có chắc muốn xóa hình ảnh này ?',
            text: "Bạn sẽ không thể hoàn tác dữ liệu này!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Chấp nhận xóa ảnh này'
        }).then((state) => {
            if (state.isConfirmed) {
                var listid = '';
                $('input.filer-checkbox').each(function () {
                    if (this.checked) listid = listid + ',' + this.value;
                });
                listid = listid.substring(1);
                if (listid == '') {
                    Swal.fire({
                        icon: 'info',
                        title: 'Thông báo!',
                        text: 'Bạn hãy chọn ít nhất 1 mục để xóa',
                        allowOutsideClick: false,
                    });
                    return false;
                }

                $.ajax({
                    type: 'POST',
                    url: 'api/gallery.php',
                    data: {
                        listid: listid,
                        cmd: 'delete-all',
                        table: table,
                    },
                });

                listid = listid.split(',');
                for (var i = 0; i < listid.length; i++) {
                    $('.my-jFiler-item-' + listid[i]).remove();
                }

                if ($('.my-jFiler-items ul li').length == 0) {
                    $('.form-group-gallery').remove();
                }
            }
        });
    });
}

FRAMEWORK.Login = function () {
    /* Login */
    if (LOGIN_PAGE) {
        $('#username, #password').keypress(function (event) {
            if (event.keyCode == 13 || event.which == 13) {
                login();
            }
        });

        $('.btn-login').click(function () {
            login();
        });

        $('.show-password').click(function () {
            if ($('#password').val()) {
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                    $('#password').attr('type', 'password');
                } else {
                    $(this).addClass('active');
                    $('#password').attr('type', 'text');
                }
                $(this).find('span').toggleClass('fas fa-eye fas fa-eye-slash');
            }
        });
    }
}

FRAMEWORK.Order = function () {
    /* Order */
    /* Date range picker */
    $('#order_date').daterangepicker({
        callback: this.render,
        autoUpdateInput: false,
        timePicker: false,
        timePickerIncrement: 30,
        locale: {
            format: 'DD/MM/YYYY'
        }
    });
    $('#order_date').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
    });
    $('#order_date').on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
    });

    /* rangeSlider */
    $('#range_price').ionRangeSlider({
        skin: 'flat',
        min: ORDER_MIN_TOTAL,
        max: ORDER_MAX_TOTAL,
        from: ORDER_PRICE_FROM,
        to: ORDER_PRICE_TO,
        type: 'double',
        step: 1,
        postfix: ' đ',
        prettify: true,
        hasGrid: true
    });

    $('body').on('click', '.update-order', function (e) {
        var id = $(this).attr('data-id');
        var table = $(this).attr('data-table');
        var newstatus = $(this).attr('data-newstatus');
        $this = $(this);

        $.ajax({
            url: 'api/order_status.php',
            type: 'POST',
            data: {
                id: id,
                table: table,
                newstatus: newstatus
            },
            beforeSend: function () {
                holdonOpen();
            },
            success: function (result) {
                location.reload();
                holdonClose();
            },
        });
    });
}

FRAMEWORK.Slug = function () {
    slugPress();
    if ($('#slugchange').length) {
        $('body').on('click', '#slugchange', function () {
            slugChange($(this));
        });
    }
}

FRAMEWORK.PhotoZone = function () {
    if ($('#photo-zone').length) {
        photoZone('#photo-zone', '#file-zone', '#photoUpload-preview img');
    }
}

FRAMEWORK.FormatInput = function () {
    if ($('.format-price').length) {
        $('.format-price').priceFormat({
            limit: 13,
            prefix: '',
            centsLimit: 0
        });
    }

    $('.max-date').datetimepicker({
        timepicker: false,
        format: 'd/m/Y',
        formatDate: 'd/m/Y',
        maxDate: MAX_DATE,
    });
}

FRAMEWORK.CKeditor = function () {
    if ($('.form-control-ckeditor').length) {
        $('.form-control-ckeditor').each(function () {
            var id = $(this).attr('id');
            CKEDITOR.replace(id);
        });
    }
}

$(document).ready(function () {
    validateForm('validation-form');

    FRAMEWORK.DbProduct();
    FRAMEWORK.DbProductList();
    FRAMEWORK.DbProductCat();
    FRAMEWORK.DbSizeColor();
    FRAMEWORK.DbNews();
    FRAMEWORK.DbStatic();
    FRAMEWORK.DbSetting()
    FRAMEWORK.DbStaticPhoto();
    FRAMEWORK.DbPhoto();
    FRAMEWORK.DbUser();
    FRAMEWORK.DbOrder();

    FRAMEWORK.AlbumFiler();
    FRAMEWORK.Login();
    FRAMEWORK.Slug();
    FRAMEWORK.PhotoZone();
    FRAMEWORK.FormatInput();
    FRAMEWORK.CKeditor();

    /* Check all */
    if ($('#selectall-checkbox').length) {
        $('body').on('click', '#selectall-checkbox', function () {
            var parentTable = $(this).parents('table');
            var input = parentTable.find('input.select-checkbox');

            if ($(this).is(':checked')) {
                input.each(function () {
                    $(this).prop('checked', true);
                });
            } else {
                input.each(function () {
                    $(this).prop('checked', false);
                });
            }
        });
    }
    /* Delete all */
    if ($('#delete-all').length) {
        $('body').on('click', '#delete-all', function () {
            var listid = '';

            $('input.select-checkbox').each(function () {
                if (this.checked) {
                    listid = listid + ',' + this.value;
                }
            });

            listid = listid.substring(1);

            if (listid == '') {
                Swal.fire({
                    icon: 'info',
                    title: 'Hãy chọn ít nhất 1 mục để xóa',
                })
                return false;
            }

            url = $(this).data('url');
            act = $(this).data('act');
            type = $(this).data('type');

            Swal.fire({
                title: 'Bạn có chắc muốn xóa mục này ?',
                text: "Bạn sẽ không thể hoàn tác dữ liệu này!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Chấp nhận xóa dữ liệu'
            }).then((state) => {
                if (state.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: url,
                        dataType: "json",
                        data: {
                            cur_Type: type,
                            act: act,
                            listid: listid,
                            cur_Page: CUR_PAGE,
                        },
                        success: function (result) {
                            if (result["status"] == 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Thông báo!',
                                    text: result['messages'][0],
                                    allowOutsideClick: false,
                                }).then((state) => {
                                    if (state.isConfirmed) {
                                        location.href = result['link'];
                                    }
                                });
                            } else if (result["status"] == 404) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Có lỗi phát sinh...',
                                    text: result['messages'][0],
                                    allowOutsideClick: false,
                                }).then((state) => {
                                    if (state.isConfirmed) {
                                        location.href = result['link'];
                                    }
                                });
                            }
                        }
                    });
                }
            });
        });
    }
    /* Delete item */
    if ($('#delete-item').length) {
        $('body').on('click', '#delete-item', function () {
            id = $(this).data('id');
            url = $(this).data('url');
            act = $(this).data('act');
            type = $(this).data('type');

            Swal.fire({
                title: 'Bạn có chắc muốn xóa mục này ?',
                text: "Bạn sẽ không thể hoàn tác dữ liệu này!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Chấp nhận xóa dữ liệu'
            }).then((state) => {
                if (state.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: url,
                        dataType: "json",
                        data: {
                            cur_Type: type,
                            act: act,
                            id: id,
                            cur_Page: CUR_PAGE,
                        },
                        success: function (result) {
                            if (result["status"] == 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Thông báo!',
                                    text: result['messages'][0],
                                    allowOutsideClick: false,
                                }).then((state) => {
                                    if (state.isConfirmed) {
                                        location.href = result['link'];
                                    }
                                });
                            } else if (result["status"] == 404) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Có lỗi phát sinh...',
                                    text: result['messages'][0],
                                    allowOutsideClick: false,
                                }).then((state) => {
                                    if (state.isConfirmed) {
                                        location.href = result['link'];
                                    }
                                });
                            }
                        }
                    });
                }
            });
        });
    }
    /* Change status ajax */
    if ($('.show-checkbox').length) {
        $('body').on('click', '.show-checkbox', function () {
            var id = $(this).attr('data-id');
            var table = $(this).attr('data-table');
            var attr = $(this).attr('data-attr');
            var $this = $(this);

            $.ajax({
                url: 'api/status.php',
                type: 'POST',
                dataType: 'html',
                data: {
                    id: id,
                    table: table,
                    attr: attr
                },
                success: function () {
                    if ($this.is(':checked'))
                        $this.prop('checked', false);
                    else
                        $this.prop('checked', true);
                }
            });

            return false;
        });
    }

    FRAMEWORK.Order();
    FRAMEWORK.Comments();
    FRAMEWORK.CustomSelect();
});