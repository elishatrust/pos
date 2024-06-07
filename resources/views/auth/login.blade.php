
<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ !empty(strtoupper($data['header']).' | '.strtoupper($data['title'])) ? strtoupper($data['header']).' | '.strtoupper($data['title']) : ''}}</title>

	<!--favicon-->
	<link rel="icon" href="{{ asset('assets/images/favicon-32x32.png" type="image/png') }}" />
	<!--plugins-->
	<link href="{{ asset('assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
	<link href="{{ asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
	<link href="{{ asset('assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
	<!-- loader-->
	<link href="{{ asset('assets/css/pace.min.css') }}" rel="stylesheet" />
	<script src="{{ asset('assets/js/pace.min.js') }}"></script>
	<!-- Bootstrap CSS -->
	<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/bootstrap-extended.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
	<link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">
</head>

<body class="">
	<!--wrapper-->
	<div class="wrapper">
		<div class="section-authentication-cover">
			<div class="">
				<div class="row g-0">

					<div class="col-12 col-xl-7 col-xxl-8 auth-cover-left align-items-center justify-content-center d-none d-xl-flex">

                        <div class="card shadow-none bg-transparent shadow-none rounded-0 mb-0">
							<div class="card-body">
                                 <img src="{{ asset('assets/images/login-images/login-cover.svg') }}" class="img-fluid auth-img-cover-login" width="650" alt=""/>
							</div>
						</div>

					</div>

					<div class="col-12 col-xl-5 col-xxl-4 auth-cover-right align-items-center justify-content-center">
						<div class="card rounded-0 m-3 shadow-none bg-transparent mb-0">
							<div class="card-body p-sm-5">
								<div class="">
									<div class="mb-3 text-center">
										<a href="{{ route('login') }}">
                                            <img src="{{ asset('assets/images/logo-icon.png') }}" width="60" alt="">
                                        </a>
									</div>
									<div class="text-center mb-4">
										<h4 class="">{{ strtoupper($data['title'])}}</h4>
										<p class="my-3">Login to Your Account</p>
									</div>
									<div class="form-body">

                                        <div class="alert-message ms-3"></div>

										<form class="row g-3" id="login">
                                            @csrf
											<div class="col-12">
												<label for="email" class="form-label">Email <span class="text-danger">*</span></label>
												<input type="email" class="form-control" id="email" name="email" placeholder="hsamia@email.com" required>
											</div>
											<div class="col-12">
												<label for="password" class="form-label">Password <span class="text-danger">*</span></label>
												<div class="input-group" id="show_hide_password">
													<input type="password" class="form-control border-end-0" id="password" name="password" placeholder="*******" required>
                                                    <a href="javascript:;" class="input-group-text bg-transparent"><i class="bx bx-hide"></i></a>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-check form-switch">
													<input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked">
													<label class="form-check-label" for="flexSwitchCheckChecked">Remember Me</label>
												</div>
											</div>
											<div class="col-md-6 text-end">
                                                <a href="auth-cover-forgot-password.html">Forgot Password ?</a>
                                            </div>
											<div class="col-12">
												<div class="d-grid">
													<button type="submit" class="btn btn-primary">Login</button>
												</div>
											</div>
										</form>

									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
				<!--end row-->
			</div>
		</div>
	</div>
	<!--end wrapper-->

	<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ asset('assets/js/jquery.min.js') }}"></script>


	{{-- <script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script> --}}
	{{-- <script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script> --}}
	{{-- <script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script> --}}
	<!--Password show & hide js -->
	<script>
		$(document).ready(function () {


			$("#show_hide_password a").on('click', function (event) {
				event.preventDefault();
				if ($('#show_hide_password input').attr("type") == "text") {
					$('#show_hide_password input').attr('type', 'password');
					$('#show_hide_password i').addClass("bx-hide");
					$('#show_hide_password i').removeClass("bx-show");
				} else if ($('#show_hide_password input').attr("type") == "password") {
					$('#show_hide_password input').attr('type', 'text');
					$('#show_hide_password i').removeClass("bx-hide");
					$('#show_hide_password i').addClass("bx-show");
				}
			});


            $('form#login').submit(function (e) {
                e.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    url: '{{ route("welcome") }}',
                    type: 'POST',
                    data: formData,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            $('.alert-message').html(`<h5 class="mb-3 text-success text-center">${response.message}</h5>`).show();

                            setTimeout(function() {
                                window.location.href = response.redirect_url;
                            }, 2000);

                        } else {
                            $('.alert-message').html(`<h5 class="mb-3 text-danger text-center">${response.message}</h5>`).show();
                            setTimeout(function() {
                                $('.alert-message').fadeOut('slow');
                            }, 4000);
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
	<!--app JS-->
	{{-- <script src="{{ asset('assets/js/app.js') }}"></script> --}}
</body>

</html>
