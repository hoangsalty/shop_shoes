function isExist(ele) {
    return ele.length;
}
/* Validation form */
function validateForm(e) {
    window.addEventListener('load', function () {
        var forms = document.getElementsByClassName(e);
        Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            });
        });
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
function holdonOpen(theme = 'sk-circle', text = 'Loading...', backgroundColor = 'rgba(0,0,0,0.8)', textColor = 'white') {
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
    var inputArticle = $('input.for-slug');
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
    var inputArticle = $('input.for-slug');

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
        if (inputFile[0].files[0].name.match(/.(jpg|jpeg|png)$/i)) {
            var size = parseInt(inputFile[0].files[0].size) / 1024;

            if (size <= 4096) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(elementPhoto).attr('src', e.target.result);
                };
                reader.readAsDataURL(inputFile[0].files[0]);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Có lỗi phát sinh...',
                    text: 'Dung lượng hình ảnh lớn. Dung lượng cho phép <= 4MB ~ 4096KB',
                    allowOutsideClick: false,
                });

                return false;
            }
        } else {
            $(elementPhoto).attr('src', '');
            Swal.fire({
                icon: 'error',
                title: 'Có lỗi phát sinh...',
                text: 'Định dạng hình ảnh không hợp lệ',
                allowOutsideClick: false,
            });
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
                Swal.fire({
                    icon: 'info',
                    title: 'Nhắc nhở !',
                    text: 'Bạn chỉ được chọn 1 hình ảnh để upload',
                    allowOutsideClick: false,
                });
                return false;
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Có lỗi phát sinh...',
                    text: 'Dữ liệu không hợp lệ',
                    allowOutsideClick: false,
                });
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
        Swal.fire({
            icon: 'error',
            title: 'Có lỗi phát sinh...',
            text: 'Đường dẫn không hợp lệ',
            allowOutsideClick: false,
        });
        return false;
    } else {
        var keyword = $('#' + obj).val();
        if (keyword) {
            url += '&keyword=' + encodeURI(keyword);
        }

        window.location = url;
    }
}
/* Youtube preview */
function youtubePreview(url, element) {
    var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
    var match = url.match(regExp);
    url = match && match[7].length == 11 ? match[7] : false;

    $(element).attr('src', '//www.youtube.com/embed/' + url).css({ width: '500', height: '300' });
}

/* Search order */
function actionOrder(url) {
    var order_status = $('#order_status').val();
    var order_payment = $('#order_payment').val();
    var order_date = $('#order_date').val();
    var keyword = $('#keyword').val();

    if (order_status) url += '&order_status=' + order_status;
    if (order_payment) url += '&order_payment=' + order_payment;
    if (order_date) url += '&order_date=' + order_date;
    if (keyword) url += '&keyword=' + encodeURI(keyword);

    window.location = url;
}