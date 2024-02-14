<!DOCTYPE html>
<html lang="en"> 
<head>
    <title>Login</title>
    
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <meta name="description" content="Login">
    <meta name="author" content="Xiaoying Riley at 3rd Wave Media">    
    <link rel="shortcut icon" href="favicon.ico"> 
    
    <!-- FontAwesome JS-->
    <script defer src="assets/plugins/fontawesome/js/all.min.js"></script>
    
    <!-- App CSS -->  
    <link id="theme-style" rel="stylesheet" href="assets/css/portal.css">

</head> 

<body class="app app-login p-0">    	
    <div class="row g-0 app-auth-wrapper">
	    <div class="col-12 col-md-7 col-lg-12 auth-main-col text-center p-5">
		    <div class="d-flex flex-column align-content-end">
			    <div class="app-auth-body mx-auto">	
				    <div class="app-auth-branding mb-4"><a class="app-logo" href="index.html"><img class="logo-icon me-2" src="assets/images/app-logo.svg" alt="logo"></a></div>
					<h2 class="auth-heading text-center mb-5">Log in to Sarvopari</h2>
			        <div class="auth-form-container text-start">
                    <x-auth-session-status class="mb-4" :status="session('status')" />
						<form class="auth-form login-form"  method="POST" action="{{ route('login') }}">   
                        @csrf      
							<div class="email mb-3">
								<label class="sr-only" for="email">Email</label>
								<input id="email" name="email" :value="old('email')" type="email" class="form-control email" placeholder="Email address" required="required">
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div><!--//form-group-->
							<div class="password mb-3">
								<label class="sr-only" for="password">Password</label>
								<input id="password" name="password" type="password" class="form-control signin-password" placeholder="Password" required autocomplete="current-password">
								<x-input-error :messages="$errors->get('password')" class="mt-2" />
                                <div class="extra mt-3 row justify-content-between">
									<div class="col-6">
										<div class="form-check">
											<input class="form-check-input" type="checkbox" value="" id="remember_me" name="remember">
											<label class="form-check-label" for="remember_me">
											Remember me
											</label>
										</div>
									</div><!--//col-6-->
									<div class="col-6">
										<div class="forgot-password text-end">
                                        @if (Route::has('password.request'))
											<a  href="{{ route('password.request') }}">Forgot password?</a>
                                            @endif    
										</div>
									</div><!--//col-6-->
								</div><!--//extra-->
							</div><!--//form-group-->
							<div class="text-center">
								<button type="submit" class="btn app-btn-primary w-100 theme-btn mx-auto">Log In</button>
							</div>
						</form>
						
						<!--<div class="auth-option text-center pt-5">No Account? Sign up <a class="text-link" href="signup.html" >here</a>.</div>-->
					</div><!--//auth-form-container-->	

			    </div><!--//auth-body-->
                @extends('layouts/footer')
		    </div><!--//flex-column-->   
	    </div><!--//auth-main-col-->
	    
    </div><!--//row-->


</body>
</html> 

