<div class="container d-flex" style="height:75vh">
    <div class="align-self-center col-lg-6 col-md-12 text-center p-5 mx-auto">
        <h3><i class="fa fa-wrench fa-4x" aria-hidden="true"></i></h3>
        <h2 class="text-center font-weight-bold">重設密碼</h2>
        <p class="text-center">
            <?php if (isset($status)) : echo $status . "<br>";
            endif;
            if ($allow_reset) :
            ?>
                重設<?php if (isset($_SESSION['username'])) {
                        echo $_SESSION['username'];
                    } ?>的密碼<br>
                您的密碼不能與您的用戶名相同。<br>
                <?php if (isset($error_message)) {
                    echo $error_message;
                } ?></p>
        <form action="/ajax/user/page" method="post">
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
            <input type="hidden" name="prev_url" value="<?php echo $_SERVER["REQUEST_URI"]; ?>">
            <button type="submit" class="btn btn-lg btn-primary btn-block" data-loading-text="Changing Password..." name="action" value="<?php echo $reset_password_token; ?>">更新密碼</button>
        </form>
    <?php
            else :
    ?>
        </p>
        <a href="/user/forgot_password" class="btn btn-lg btn-primary btn-block">忘記密碼</a>
    <?php
            endif;
    ?>
    </div>
</div>