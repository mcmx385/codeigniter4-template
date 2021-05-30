<div class="container" style="height:90vh">
    <div class="row align-items-center justify-content-center h-100">

        <!-- Registeration Form -->
        <div class="col-md-7 col-lg-6 ml-auto">
            <form action="/user/auth" method="POST">

                <div class="row">
                    <!-- Divider Text -->
                    <div class="form-group col-lg-12 mx-auto d-flex align-items-center">
                        <div class="border-bottom w-100 ml-5"></div>
                        <span class="px-2 small text-muted font-weight-bold text-muted">Login</span>
                        <div class="border-bottom w-100 mr-5"></div>
                    </div>


                    <div class="col-12 py-2 text-center">
                        <?php echo $_GET["status"] ? $_GET["status"] : ''; ?>
                    </div>

                    <!-- Username -->
                    <div class="input-group col-lg-12 mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white px-4 border-md border-right-0">
                                <i class="fa fa-tags text-muted"></i>
                            </span>
                        </div>
                        <input id="lastName" type="text" name="username" placeholder="username / email / phone" class="form-control bg-white border-left-0 border-md" required <?php if ($_GET['status'] == "attempts used up") : echo "disabled";
                                                                                                                                                                                endif; ?>>
                    </div>

                    <!-- Password -->
                    <div class="input-group col-lg-12 mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white px-4 border-md border-right-0">
                                <i class="fa fa-lock text-muted"></i>
                            </span>
                        </div>
                        <input id="password" type="password" name="password" placeholder="password" class="form-control bg-white border-left-0 border-md" required <?php echo $_GET['status'] == "attempts used up" ?  "disabled" : ''; ?>>
                    </div>

                    <!--<div class="form-group col-6 mx-auto mb-4">
                        <input class="mr-2" type="checkbox" name="keep">Keep me logged in
                    </div>
                    <div class="form-group col-6 text-right">
                        <a href="/user/forgot_password">Forgot password?</a>
                    </div>-->

                    <!-- Submit Button -->
                    <div class="form-group col-lg-12 mx-auto mb-0">
                        <input type="hidden" name="target" value="<?php echo $_GET["target"] ? $_GET["target"] : $_SERVER["HTTP_REFERER"]; ?>">
                        <input type="submit" class="btn btn-danger btn-block py-2" value="Login">
                    </div>

                    <!-- Already Registered -->
                    <!--<div class="text-center w-100 mt-3">
                        <p>Not one of us? <a href="/user/signup" class="text-primary ml-2">Signup</a></p>
                    </div>-->

                </div>
            </form>
        </div>

        <div class="col-md-5 pr-lg-5 mb-5 mb-md-0">
            <img src="/svg/login<?php echo rand(1, 6); ?>.svg" alt="" class="img-fluid mb-3 d-none d-md-block">
        </div>
    </div>
</div>