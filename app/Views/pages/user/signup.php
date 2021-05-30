<div class="container" style="height:90vh">
    <div class="row align-items-center justify-content-center h-100">

        <div class="col-lg-8">
            <!-- Divider Text -->
            <div class="form-group mx-auto d-flex align-items-center my-4">
                <div class="border-bottom w-100 ml-5"></div>
                <span class="px-2 small text-muted font-weight-bold text-muted">Signup</span>
                <div class="border-bottom w-100 mr-5"></div>
            </div>
            <form id="signup-form" action="/ajax/request/page" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <!-- Full Name -->
                        <div class="input-group mb-4">
                            <div class="input-group-prepend" style="height:38px">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa fa-user text-muted"></i>
                                </span>
                            </div>
                            <input id="firstName" type="text" name="full_name" placeholder="Full name *" class="form-control bg-white border-left-0 border-md" value="Administrator" required>
                        </div>

                        <!-- Username -->
                        <div class="input-group mb-4">
                            <div class="input-group-prepend" style="height:38px">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa fa-tags text-muted"></i>
                                </span>
                            </div>
                            <input id="username" type="text" name="username" placeholder="Username *" class="form-control bg-white border-left-0 border-md" value="admin" required>
                            <span id="usernameError" class="w-100 text-danger"></span>
                        </div>

                        <!-- Email Address -->
                        <div class="input-group mb-4">
                            <div class="input-group-prepend" style="height:38px">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa fa-envelope text-muted"></i>
                                </span>
                            </div>
                            <input id="email" type="email" name="email" placeholder="Email address *" class="form-control bg-white border-left-0 border-md" value="admin@admin.com" required>
                            <span id="emailError" class="w-100 text-danger"></span>
                        </div>
                    </div>

                    <div class="col-md-6">

                        <!-- Phone Number -->
                        <div class="input-group mb-4">
                            <div class="input-group-prepend" style="height:38px">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa fa-phone-square text-muted"></i>
                                </span>
                            </div>
                            <select id="countryCode" name="country" style="max-width: 80px" class="custom-select form-control bg-white border-left-0 border-md h-100">
                                <option value="">+852</option>
                            </select>
                            <input id="phone" type="tel" name="phone" placeholder="Phone number *" class="form-control bg-white border-md border-left-0 pl-3" value="12345678" required>
                            <span id="phoneError" class="w-100 text-danger"></span>
                        </div>

                        <!-- Password -->
                        <div class="input-group mb-4">
                            <div class="input-group-prepend" style="height:38px">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa fa-lock text-muted"></i>
                                </span>
                            </div>
                            <input id="password" type="password" name="password" placeholder="Password * (至少一大小字母和數字)" class="form-control bg-white border-left-0 border-md password_field" value="adminadmin" required>
                            <div class="input-group-append">
                                <span class="input-group-text password_reveal" id="basic-addon2"><i class="fa fa-eye-slash password_icon" aria-hidden="true"></i></span>
                            </div>
                            <span id="passwordError" class="w-100 text-danger"></span>
                        </div>

                        <!-- Password Confirmation -->
                        <div class="input-group mb-4">
                            <div class="input-group-prepend" style="height:38px">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa fa-lock text-muted"></i>
                                </span>
                            </div>
                            <input id="passwordConfirmation" type="password" name="passwordConfirmation" placeholder="Confirm password * (至少一大小字母和數字)" class="form-control bg-white border-left-0 border-md password_field" value="adminadmin1" required>
                            <div class="input-group-append">
                                <span class="input-group-text password_reveal" id="basic-addon2"><i class="fa fa-eye-slash password_icon" aria-hidden="true"></i></span>
                            </div>
                            <span id="passwordConfirmationError" class="w-100 text-danger"></span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="input-group mb-4">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1" checked required>
                                <label class="form-check-label" for="inlineCheckbox1">I have read the <a href="#" data-toggle="modal" data-target="#staticBackdrop">terms and conditions</a> and agreed to them when submitting the register form.</label>
                            </div>
                        </div>

                        <div class="form-group mx-auto mb-0">
                            <div id="status"></div>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group mx-auto mb-0">
                            <button class="btn btn-primary btn-block" type="submit" class="btnRegister" name="action">Signup</button>
                        </div>

                        <!-- Already Registered -->
                        <div class="text-center w-100 mt-3">
                            <p class="text-muted">Already have an account?<a href="/user/login" class="text-primary ml-2">Login</a></p>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>

<script>
    let messages = [];

    $('#signup-form').submit(e => onSubmit(e))
    const onSubmit = (e) => {
        e.preventDefault()
        console.log(e)

        ifIdentifierValid()
        ifPasswordValid()
        if (messages.length > 0) {
            e.preventDefault()
            addError('status', messages.join('<br>'))
        }
    }

    const chgError = (elID, msg) => {
        console.log($('#' + elID))
        $('#' + elID).html(msg);
    }

    const addError = (elID, msg) => {
        $('#' + elID).append("<br>" + msg);
    }

    const pushMsg = (msg) => {
        if (messages.indexOf(msg) == -1) {
            messages.push(msg);
        }
    }

    const getChecked = (name) => {
        return $('input[data-id^=' + name + ']:checked').map(function(id, el) {
            return $(el).val();
        }).get();
    }

    const ifUserExist = (username) => {
        return true
        $.ajax({
            url: '/user/ifUsernameExist/' + username,
            type: 'ajax',
            method: 'post',
            async: false,
            data: {},
            success: function(data) {
                return data
            }
        });
    }

    const ifEmailExist = (email) => {
        return true
        $.ajax({
            url: '/user/ifEmailExist/' + email,
            type: 'ajax',
            method: 'post',
            async: false,
            data: {},
            success: function(data) {
                return data
            }
        });
    }

    const ifPhoneExist = (phone) => {
        return true
        $.ajax({
            url: '/user/ifPhoneExist/' + phone,
            type: 'ajax',
            method: 'post',
            async: false,
            data: {},
            success: function(data) {
                return data
            }
        });
    }

    const ifIdentifierValid = () => {
        if (ifUserExist($('#username').value)) {
            pushMsg('Check your username');
            chgError('usernameError', '這個用戶名已經存在');
        } else {
            chgError('usernameError', '');
        }

        if (ifEmailExist($('#email').value)) {
            pushMsg('Check your email');
            chgError('emailError', '這個用戶名已經存在');
        } else {
            chgError('emailError', '');
        }

        if (ifPhoneExist($('#phone').value)) {
            pushMsg('Check your phone');
            chgError('phoneError', '這個電話已經存在');
        } else {
            chgError('phoneError', '');
        }
    }

    const ifPasswordValid = () => {
        if ($('#password').val().length <= 6) {
            pushMsg("Check your password");
            chgError("passwordError", "密碼必須超過6個字符");
        } else {
            chgError("passwordError", "");
        }
        if ($('#password').val() !== $('#passwordConfirmation').val()) {
            pushMsg("Check your confirmation password");
            chgError("passwordConfirmationError", "密碼不匹配");
        } else {
            chgError("passwordConfirmationError", "");
        }
        re = /[0-9]/;
        if (!re.test($('#password').val())) {
            pushMsg("Check your password");
            addError("passwordError", "密碼必須至少包含1個數字");
        }
        re = /[a-z]/;
        if (!re.test($('#password').val())) {
            pushMsg("Check your password");
            addError("passwordError", "密碼必須包含至少1個小寫字母");
        }
        re = /[A-Z]/;
        if (!re.test($('#password').val())) {
            pushMsg("Check your password");
            addError("passwordError", "密碼必須包含至少1個大寫字母");
        }
    }

    $('.password_reveal').click(function() {
        event.preventDefault();
        var password_field = $(".password_field");
        var password_icon = $(".password_icon");
        if (password_field.attr("type") == "text") {
            password_field.attr('type', 'password');
            password_icon.addClass("fa-eye-slash");
            password_icon.removeClass("fa-eye");
        } else if (password_field.attr("type") == "password") {
            password_field.attr('type', 'text');
            password_icon.removeClass("fa-eye-slash");
            password_icon.addClass("fa-eye");
        }
    })
</script>