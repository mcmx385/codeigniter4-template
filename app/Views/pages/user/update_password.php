<div class="container d-flex" style="height:90vh">
    <div class="align-self-center col-lg-6 col-md-12 text-center p-5 mx-auto">
        <h3><i class="fa fa-wrench fa-4x" aria-hidden="true"></i></h3>
        <h2 class="text-center font-weight-bold">更新密碼</h2>
        <p class="text-center">更改<?php if (isset($_SESSION['username'])) {
                                        echo $_SESSION['username'];
                                    } ?>的密碼<br>您的密碼不能與您的用戶名相同。</p>
        <p><?php if (isset($error_message)) {
                echo $error_message;
            } ?></p>
        <form action="/ajax/user/page" method="post" id="passwordForm">
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fa fa-key" aria-hidden="true"></i>
                    </div>
                </div>
                <input type="password" class="input-lg form-control" name="new_password" id="password1" placeholder="新密碼" autocomplete="off">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fa fa-key" aria-hidden="true"></i>
                    </div>
                </div>
                <input type="password" class="input-lg form-control" name="repeat_password" id="password2" placeholder="重複輸入密碼" autocomplete="off">
            </div>
            <button type="submit" class="btn btn-lg btn-primary btn-block" data-loading-text="Changing Password..." name="action" value="<?php echo $update_token; ?>">更新密碼</button>
        </form>
    </div>
</div>