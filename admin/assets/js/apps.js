$(document).ready(function () {
    /* Validation form chung */
    validateForm('validation-form');
    /* Loader */
    if ($('.loader-wrapper').length) {
        setTimeout(function () {
            $('.loader-wrapper').fadeOut('medium');
        }, 300);
    }
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
    /* Slug */
    slugPress();
    if ($('#slugchange').length) {
        $('body').on('click', '#slugchange', function () {
            slugChange($(this));
        });
    }
    /* PhotoZone */
    if ($('#photo-zone').length) {
        photoZone('#photo-zone', '#file-zone', '#photoUpload-preview img');
    }
    /* Format price */
    if ($('.format-price').length) {
        $('.format-price').priceFormat({
            limit: 13,
            prefix: '',
            centsLimit: 0
        });
    }
    /* Ckeditor */
    if ($('.form-control-ckeditor').length) {
        $('.form-control-ckeditor').each(function () {
            var id = $(this).attr('id');
            CKEDITOR.replace(id);
        });
    }
    /* Check required form */
    if ($('.submit-check').length) {
        $('.submit-check').click(function () {
            var formCheck = $(this).parents('form.validation-form');

            /* Holdon */
            holdonOpen();

            /* Check slug */
            slugCheck();

            /* Elements */
            var flag = true;
            var slugs = '';
            var slugOffset = $('.card-slug');
            var slugsInValid = $('.card-slug :required:invalid');
            var slugsError = $('.card-slug .text-danger').not('.d-none');
            var cardOffset = 0;
            var elementsInValid = $('.card :required:invalid');

            /* Check if has slug vs name */
            if (slugsInValid.length || slugsError.length) {
                flag = false;
                slugs = slugsError.length ? slugsError : slugsInValid;

                /* Scroll to error */
                setTimeout(function () {
                    $('html,body').animate({ scrollTop: slugOffset.offset().top - 40 }, 'medium');
                }, 500);
            } else if (elementsInValid.length) {
                flag = false;

                /* Scroll to error */
                if (cardOffset) {
                    setTimeout(function () {
                        $('html,body').animate({ scrollTop: cardOffset.offset().top - 100 }, 'medium');
                    }, 500);
                }
            }

            /* Holdon close */
            holdonClose();

            /* Check form validated */
            if (!flag) {
                formCheck.addClass('was-validated');
            } else {
                formCheck.removeClass('was-validated');
            }

            return flag;
        });
    }
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
            var url = $(this).data('url');
            confirmDialog('delete-all', 'Bạn có chắc muốn xóa những mục này ?', url);
        });
    }
    /* Delete item */
    if ($('#delete-item').length) {
        $('body').on('click', '#delete-item', function () {
            var url = $(this).data('url');
            confirmDialog('delete-item', 'Bạn có chắc muốn xóa mục này ?', url);
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
    /* Change numb jax */
    if ($('input.update-numb').length) {
        $('body').on('change', 'input.update-numb', function () {
            var id = $(this).attr('data-id');
            var table = $(this).attr('data-table');
            var value = $(this).val();

            $.ajax({
                url: 'api/numb.php',
                type: 'POST',
                dataType: 'html',
                data: {
                    id: id,
                    table: table,
                    value: value
                }
            });

            return false;
        });
    }
    /* Filer */
    if ($('#filer-gallery').length) {
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
                },
                type: 'POST',
                enctype: 'multipart/form-data',
                dataType: 'json',
                async: false,
                beforeSend: function () {
                    holdonOpen();
                },
                success: function (data) {
                    data = JSON.parse(data);
                    if (data['success'] == true) {
                        holdonClose();
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

        confirmDialog('delete-filer', 'Bạn có chắc muốn xóa hình ảnh này ?', id, table);
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
        confirmDialog('delete-all-filer', 'Bạn có chắc muốn xóa các hình ảnh đã chọn ?', table);
    });
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
    $('.max-date').datetimepicker({
        timepicker: false,
        format: 'd/m/Y',
        formatDate: 'd/m/Y',
        maxDate: MAX_DATE,
    });



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

    /* Ajax place */
    /* City */
    if (isExist($('.select-place_city'))) {
        $('.select-place_city').change(function () {
            var id = $(this).val();
            loadDistrict(id);
        });
    }
    /* District */
    if (isExist($('.select-place_district'))) {
        $('.select-place_district').change(function () {
            var id = $(this).val();
            loadWard(id);
        });
    }
    /* Ward */
    if (isExist($('.select-place_ward'))) {
        $('.select-place_ward').change(function () {
            var id = $(this).val();
        });
    }
});