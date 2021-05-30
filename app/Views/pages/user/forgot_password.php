<div class="container d-flex" style="height:75vh">
    <div class="align-self-center col-lg-6 col-md-12 text-center p-5 mx-auto">
        <form action="/ajax/user/page" method="post">
            <h3><i class="fa fa-lock fa-4x"></i></h3>
            <h2 class="text-center font-weight-bold">忘記密碼？</h2>
            <p>
                <?php
                if (isset($status) && !empty($status)) :
                    echo $status . "<br>";
                endif;
                ?>
                你可以在這裡重設密碼。
            </p>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-envelope"></i></span>
                </div>
                <input type="email" class="form-control" name="email" placeholder="輸入您的電子郵件" aria-label="Email" aria-describedby="basic-addon1" required>
            </div>
            <div class="form-group">
                <input type="hidden" name="prev_url" value="<?php echo $_SERVER["REQUEST_URI"]; ?>">
                <button class="btn btn-lg btn-primary btn-block" name="action" value="<?php echo $forgot_password_token; ?>" type="submit">重設密碼</button>
            </div>
        </form>
    </div>
</div>