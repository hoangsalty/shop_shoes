/* Validation form */
function validateForm(ele) {
    window.addEventListener('load', function () {
        var forms = document.getElementsByClassName(ele);
        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            });
        });

        $('.' + ele).find('input[type=submit],button[type=submit]').removeAttr('disabled');
    });
}
/* Login */
function login() {
    var username = $('#username').val();
    var password = $('#password').val();

    if ($('.alert-login').hasClass('alert-danger') || $('.alert-login').hasClass('alert-success')) {
        $('.alert-login').removeClass('alert-danger alert-success');
        $('.alert-login').addClass('d-none');
        $('.alert-login').html('');
    }

    if ($('.show-password').hasClass('active')) {
        $('.show-password').removeClass('active');
        $('#password').attr('type', 'password');
        $('.show-password').find('span').toggleClass('fas fa-eye fas fa-eye-slash');
    }

    $('.show-password').addClass('disabled');
    $('.btn-login .sk-chase').removeClass('d-none');
    $('.btn-login span').addClass('d-none');
    $('.btn-login').attr('disabled', true);
    $('#username').attr('disabled', true);
    $('#password').attr('disabled', true);

    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: 'api/login.php',
        async: false,
        data: {
            username: username,
            password: password,
        },
        success: function (result) {
            if (result.success) {
                window.location = 'index.php';
            } else if (result.error) {
                $('.alert-login').removeClass('d-none');
                $('.show-password').removeClass('disabled');
                $('.btn-login .sk-chase').addClass('d-none');
                $('.btn-login span').removeClass('d-none');
                $('.btn-login').attr('disabled', false);
                $('#username').attr('disabled', false);
                $('#password').attr('disabled', false);
                $('.alert-login').removeClass('alert-success');
                $('.alert-login').addClass('alert-danger');
                $('.alert-login').html(result.error);
            }
        }
    });
}
/* HoldOn */
function holdonOpen(
    theme = 'sk-circle',
    text = 'Loading...',
    backgroundColor = 'rgba(0,0,0,0.8)',
    textColor = 'white'
) {
    var options = {
        theme: theme,
        message: text,
        backgroundColor: backgroundColor,
        textColor: textColor
    };

    HoldOn.open(options);
}
function holdonClose() {
    HoldOn.close();
}
/* Notify */
function notifyDialog(content = '', title = 'Thông báo', icon = 'fas fa-exclamation-triangle', type = 'blue') {
    $.alert({
        title: title,
        icon: icon, // font awesome
        type: type, // red, green, orange, blue, purple, dark
        content: content, // html, text
        backgroundDismiss: true,
        animationSpeed: 600,
        animation: 'zoom',
        closeAnimation: 'scale',
        typeAnimated: true,
        animateFromElement: false,
        autoClose: 'accept|3000',
        escapeKey: 'accept',
        buttons: {
            accept: {
                text: '<i class="fas fa-check align-middle mr-2"></i>Đồng ý',
                btnClass: 'btn-blue btn-sm bg-gradient-primary'
            }
        }
    });
}
/* Confirm */
function confirmDialog(action, text, value, table = '', title = 'Thông báo', icon = 'fas fa-exclamation-triangle', type = 'blue') {
    $.confirm({
        title: title,
        icon: icon, // font awesome
        type: type, // red, green, orange, blue, purple, dark
        content: text, // html, text
        backgroundDismiss: true,
        animationSpeed: 600,
        animation: 'zoom',
        closeAnimation: 'scale',
        typeAnimated: true,
        animateFromElement: false,
        autoClose: 'cancel|3000',
        escapeKey: 'cancel',
        buttons: {
            success: {
                text: '<i class="fas fa-check align-middle mr-2"></i>Đồng ý',
                btnClass: 'btn-blue btn-sm bg-gradient-primary',
                action: function () {
                    if (action == 'delete-item') deleteItem(value);
                    if (action == 'delete-all') deleteAll(value);
                    if (action == 'delete-filer') deleteFiler(value, table);
                    if (action == 'delete-all-filer') deleteAllFiler(value);
                }
            },
            cancel: {
                text: '<i class="fas fa-times align-middle mr-2"></i>Hủy',
                btnClass: 'btn-red btn-sm bg-gradient-danger'
            }
        }
    });
}
/* Delete item */
function deleteItem(url) {
    holdonOpen();
    document.location = url;
}
/* Delete all */
function deleteAll(url) {
    var listid = '';

    $('input.select-checkbox').each(function () {
        if (this.checked) {
            listid = listid + ',' + this.value;
        }
    });

    listid = listid.substring(1);

    if (listid == '') {
        notifyDialog('Bạn hãy chọn ít nhất 1 mục để xóa');
        return false;
    }

    holdonOpen();
    document.location = url + '&listid=' + listid;
}
/* Delete filer */
function deleteFiler(id, table) {
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
/* Delete all filer */
function deleteAllFiler(table) {
    var listid = '';
    $('input.filer-checkbox').each(function () {
        if (this.checked) listid = listid + ',' + this.value;
    });
    listid = listid.substring(1);
    if (listid == '') {
        notifyDialog('Bạn hãy chọn ít nhất 1 mục để xóa');
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
/* Slug */
function slugConvert(slug, focus = false) {
    slug = slug.toLowerCase();
    slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
    slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
    slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
    slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
    slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
    slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
    slug = slug.replace(/đ/gi, 'd');
    slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
    slug = slug.replace(/ /gi, '-');
    slug = slug.replace(/\-\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-/gi, '-');
    slug = slug.replace(/\-\-/gi, '-');

    if (!focus) {
        slug = '@' + slug + '@';
        slug = slug.replace(/\@\-|\-\@|\@/gi, '');
    }

    return slug;
}
function slugPreview(title, focus = false) {
    var slug = slugConvert(title, focus);

    $('#slug').val(slug);
    $('#slugurlpreview' + ' strong').html(slug);
}
function slugPress() {
    var inputArticle = $('input.for-seo');
    var id = $('.slug-id').val();

    inputArticle.each(function () {
        var name = $(this).attr('id');
        if ($('#' + name).length) {
            $('body').on('keyup', '#' + name, function (e) {
                var keyCode = e.keyCode || e.which;
                var title = $('#' + name).val();

                if (keyCode != 13) {
                    if ((!id || $('#slugchange').prop('checked'))) {
                        /* Slug preivew */
                        slugPreview(title);
                    }

                    /* slug Alert */
                    slugAlert(2);
                }
            });
        }

        if ($('#slug').length) {
            $('body').on('keyup', '#slug', function (e) {
                var keyCode = e.keyCode || e.which;
                var title = $('#slug').val();

                if (keyCode != 13) {
                    /* Slug preivew */
                    slugPreview(title, true);

                    /* slug Alert */
                    slugAlert(2);
                }
            });
        }
    });
}
function slugChange(obj) {
    if (obj.is(':checked')) {
        /* Load slug theo tiêu đề mới */
        slugStatus(1);
        $('.slug-input').attr('readonly', true);
    } else {
        /* Load slug theo tiêu đề cũ */
        slugStatus(0);
        $('.slug-input').attr('readonly', false);
    }
}
function slugStatus(status) {
    var inputArticle = $('.card-article input.for-seo');

    inputArticle.each(function (index) {
        var name = $(this).attr('id');
        var title = '';
        if (status == 1) {
            if ($('#' + name).length) {
                title = $('#' + name).val();

                /* Slug preivew */
                slugPreview(title);
            }
        } else if (status == 0) {
            if ($('#slug-default').length) {
                title = $('#slug-default').val();

                /* Slug preivew */
                slugPreview(title);
            }
        }
    });
}
function slugAlert(result) {
    if (result == 1) {
        $('#alert-slug-danger').addClass('d-none');
        $('#alert-slug-success').removeClass('d-none');
    } else if (result == 0) {
        $('#alert-slug-danger').removeClass('d-none');
        $('#alert-slug-success').addClass('d-none');
    } else if (result == 2) {
        $('#alert-slug-danger').addClass('d-none');
        $('#alert-slug-success').addClass('d-none');
    }
}
function slugCheck() {
    var slugInput = $('.slug-input');
    var id = $('.slug-id').val();

    slugInput.each(function (index) {
        var slug = $(this).val();
        if (slug) {
            $.ajax({
                url: 'api/slug.php',
                type: 'POST',
                dataType: 'html',
                async: false,
                data: {
                    slug: slug,
                    id: id,
                },
                success: function (result) {
                    slugAlert(result);
                }
            });
        }
    });
}
/* Reader image */
function readImage(inputFile, elementPhoto) {
    if (inputFile[0].files[0]) {
        if (inputFile[0].files[0].name.match(/.(jpg|jpeg|png|gif|svg)$/i)) {
            var size = parseInt(inputFile[0].files[0].size) / 1024;

            if (size <= 4096) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(elementPhoto).attr('src', e.target.result);
                };
                reader.readAsDataURL(inputFile[0].files[0]);
            } else {
                notifyDialog('Dung lượng hình ảnh lớn. Dung lượng cho phép <= 4MB ~ 4096KB');
                return false;
            }
        } else {
            $(elementPhoto).attr('src', '');
            notifyDialog('Định dạng hình ảnh không hợp lệ');
            return false;
        }
    } else {
        $(elementPhoto).attr('src', '');
        return false;
    }
}
/* Photo zone */
function photoZone(eDrag, iDrag, eLoad) {
    if ($(eDrag).length) {
        /* Drag over */
        $(eDrag).on('dragover', function () {
            $(this).addClass('drag-over');
            return false;
        });

        /* Drag leave */
        $(eDrag).on('dragleave', function () {
            $(this).removeClass('drag-over');
            return false;
        });

        /* Drop */
        $(eDrag).on('drop', function (e) {
            e.preventDefault();
            $(this).removeClass('drag-over');

            var lengthZone = e.originalEvent.dataTransfer.files.length;

            if (lengthZone == 1) {
                $(iDrag).prop('files', e.originalEvent.dataTransfer.files);
                readImage($(iDrag), eLoad);
            } else if (lengthZone > 1) {
                notifyDialog('Bạn chỉ được chọn 1 hình ảnh để upload');
                return false;
            } else {
                notifyDialog('Dữ liệu không hợp lệ');
                return false;
            }
        });

        /* File zone */
        $(iDrag).change(function () {
            readImage($(this), eLoad);
        });
    }
}
function onSearch(obj, url) {
    if (url == '') {
        notifyDialog('Đường dẫn không hợp lệ');
        return false;
    } else {
        var keyword = $('#' + obj).val();
        url = filterCategory(url);

        if (keyword) {
            url += '&keyword=' + encodeURI(keyword);
        }

        window.location = filterCategory(url);
    }
}
/* onChange Category */
function filterCategory(url) {
    if ($('.filter-category').length > 0 && url != '') {
        $('.filter-category').each(function () {
            var id = $(this).attr('id');
            if (id) {
                var value = parseInt($('#' + id).val());
                if (value) {
                    url += '&' + id + '=' + value;
                }
            }
        });
    }

    return url;
}
function onchangeCategory(obj) {
    var name = '';
    var keyword = $('#keyword').val();
    var url = LINK_FILTER;

    obj.parents('.form-group').nextAll().each(function () {
        name = $(this).find('.filter-category').attr('name');
        if ($(this) != obj) {
            $(this).find('.filter-category').val(0);
        }
    });

    url = filterCategory(url);

    if (keyword) {
        url += '&keyword=' + encodeURI(keyword);
    }

    return (window.location = url);
}
/* Youtube preview */
function youtubePreview(url, element) {
    var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
    var match = url.match(regExp);
    url = match && match[7].length == 11 ? match[7] : false;

    $(element).attr('src', '//www.youtube.com/embed/' + url).css({ width: '500', height: '300' });
}
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
        // minDate: '1950/01/01',
    });
});