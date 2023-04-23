<div class="wrap-user">
    <div class="title-user">
        <span>Đăng nhập</span>
        <a href="account/quen-mat-khau" title="Quên mật khẩu ?">Quên mật khẩu ?</a>
    </div>
    <form class="form-user validation-user" novalidate method="post" action="account/dang-nhap"
        enctype="multipart/form-data">
        <?= $flash->getMessages("frontend") ?>
        <div class="input-group input-user">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-user"></i></div>
            </div>
            <input type="text" class="form-control text-sm" id="username" name="username" placeholder="Tài khoản"
                required>
            <div class="invalid-feedback">Vui lòng nhập tên tài khoản</div>
        </div>
        <div class="input-group input-user">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-lock"></i></div>
            </div>
            <input type="password" class="form-control text-sm" id="password" name="password" placeholder="Mật khẩu"
                required>
            <div class="invalid-feedback">Vui lòng nhập mật khẩu</div>
        </div>
        <div class="button-user">
            <input type="submit" class="btn btn-primary" name="login-account" value="Đăng nhập">
            <div class="checkbox-user custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="remember-user" id="remember-user" value="1">
                <label class="custom-control-label" for="remember-user">Nhớ mật khẩu</label>
            </div>
        </div>
        <div class="note-user">
            <span>Bạn chưa có tài khoản ? </span>
            <a href="account/dang-ky" title="Đăng ký ngay !">Đăng ký ngay !</a>
        </div>
    </form>
</div>