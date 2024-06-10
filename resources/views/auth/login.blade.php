
<!doctype html>
<html class="no-js " lang="en">


<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="description" content="">
<title>{{ !empty(strtoupper($data['header']).' | '.strtoupper($data['title'])) ? strtoupper($data['header']).' | '.strtoupper($data['title']) : ''}}</title>

<!-- Favicon-->
<link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}">

<!-- Custom Css -->
<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/flash.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/color_skins.css') }}">
</head>
<body class="theme-black">
<div class="authentication">
    <div class="container">
        <div class="col-md-12 content-center">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="company_detail">
                        <h4 class="logo"><img src="assets/images/logo.svg" alt=""> Alpino</h4>
                        <h3>{{ strtoupper($data['title'])}}</h3>
                        <p>Welcome to Your Account</p>
                        <div class="footer">
                            <hr>
                            <ul  class="social_link list-unstyled">
                                <li><a href="../../../../thememakker.com/index.html" title="ThemeMakker"><i class="zmdi zmdi-globe"></i></a></li>
                                <li><a href="https://themeforest.net/user/thememakker" title="Themeforest"><i class="zmdi zmdi-shield-check"></i></a></li>
                                <li><a href="https://www.linkedin.com/company/thememakker/" title="LinkedIn"><i class="zmdi zmdi-linkedin"></i></a></li>
                                <li><a href="../../../../www.facebook.com/thememakkerteam.html" title="Facebook"><i class="zmdi zmdi-facebook"></i></a></li>
                                <li><a href="http://twitter.com/thememakker" title="Twitter"><i class="zmdi zmdi-twitter"></i></a></li>
                                <li><a href="http://plus.google.com/+thememakker" title="Google plus"><i class="zmdi zmdi-google-plus"></i></a></li>
                                <li><a href="../../../../www.behance.net/thememakker.html" title="Behance"><i class="zmdi zmdi-behance"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-12 offset-lg-1">
                    <div class="card-plain">
                        <div class="header">
                            <h5>{{ $data['header'] }}</h5>
                        </div>

                        <form id="form" class="form" >
                            @csrf
                            <div class="input-group mb-3">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" required>
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="zmdi zmdi-account-circle"></i></span>
                                </div>
                            </div>
                            <div class="input-group" id="show_hide_password">
                                <input type="password" class="form-control" name="password" id="password" placeholder="Enter password" required>
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="zmdi zmdi-lock"></i></span>
                                </div>
                            </div>
                            <div class="float-left mb-2">
                                <label for="">
                                    <input type="checkbox" name="checkbox" id="checkbox" class="mx-1">
                                    Show password
                                </label>
                            </div>
                            <div class="footer">
                                <input type="submit" value="Sign In" class="btn btn-primary btn-round btn-block">
                            </div>
                            <a href="{{ route('reset-password') }}" class="link">Forgot Password?</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Jquery Core Js -->
<script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    $(document).ready(function () {


        $("input[name=checkbox]").on('click', function (event) {
            event.preventDefault();
            if ($('#show_hide_password input').attr("type") == "text") {
                $('#show_hide_password input').attr('type', 'password');
            } else if ($('#show_hide_password input').attr("type") == "password") {
                $('#show_hide_password input').attr('type', 'text');
            }
        });


        $('form#form').submit(function (e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url: '{{ route("welcome") }}',
                type: 'POST',
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function(data) {

                    if (data.status == 200) {
                        showFlashMessage("success", data.message);
                        setTimeout(function() {
                            window.location.href = data.redirect_url;
                        }, 2000);
                    } else {
                        showFlashMessage("warning", data.message);
                    }

                },
                error: function(response) {
                    if (response.status === 422) {
                        var errors = response.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            $('#' + key).after('<span class="error">' + value[0] + '</span>');
                        });
                    } else {
                        alert('An error occurred. Please try again.');
                    }
                }
            });



        });


    });
</script>

<div id="forFlash"></div>
<script type="text/javascript">
    function showWarningToast(title, message) {
        Swal.fire({
            icon: 'warning',
            title: title,
            text: message,
            showConfirmButton: true,
            timer: 5000
        });
    }

    function showSuccessToast(title, message) {
        Swal.fire({
            icon: 'success',
            title: title,
            text: message,
            showConfirmButton: false,
            timer: 6000
        });
    }

    function showErrorToast(title, message) {
        Swal.fire({
            icon: 'error',
            title: title,
            text: message,
            showConfirmButton: true,
            timer: 10000
        });
    }

    function disableBtn(btn, access) {

        if (access) {
            $('#' + btn).prop("disabled", true);
            // add spinner to button
            $('#' + btn).html(
                `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...`
            );
        } else {
            $('#' + btn).prop("disabled", false);
            // add spinner to button
            $('#' + btn).html("Save")
        }

    }

    function removeSpecialCharacter(text) {
        var sanitizedValue = text.replace(/[!@#$%^&*()\-_=+\[\]{}|\\;:'",.<script>\/?]/g, "");
        return sanitizedValue
    }

    function showFlashMessage(indicator, message) {

        if (indicator == "danger") {
            $("#forFlash").html('<div id="flash-message"><span class="flashmessage"></span></div>')
            var flashMessage = document.getElementById('flash-message');
        }
        if (indicator == "success") {
            $("#forFlash").html('<div id="flash-message-success"><span class="flashmessage"></span></div>')
            var flashMessage = document.getElementById('flash-message-success');
        }
        if (indicator == "warning") {
            $("#forFlash").html('<div id="flash-message-warning"><span class="flashmessage"></span></div>')
            var flashMessage = document.getElementById('flash-message-warning');
        }

        var messageElement = flashMessage.querySelector('.flashmessage');

        messageElement.innerText = message;
        flashMessage.style.display = 'block';

        var secondsLeft = 10;
        var countdown = setInterval(function() {
            secondsLeft--;

            if (secondsLeft >= 0) {
                messageElement.innerText = message + ' (' + secondsLeft + 's)';
            } else {
                clearInterval(countdown);
                flashMessage.style.display = 'none';
                $("#forFlash").html('')
            }
        }, 1000);
    }

    function formatDate(dateString) {
        const date = new Date(dateString);

        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();

        const formattedDate = `${day}/${month}/${year}`;

        return formattedDate;
    }
</script>

</body>


</html>
