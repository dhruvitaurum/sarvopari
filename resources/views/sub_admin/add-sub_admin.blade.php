<!DOCTYPE html>
<html lang="en"> 
<head>
    <title>{{ __('Dashboard') }}</title>
    
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <meta name="description" content="Portal - Bootstrap 5 Admin Dashboard Template For Developers">
    <meta name="author" content="Xiaoying Riley at 3rd Wave Media">    
    <link rel="shortcut icon" href="favicon.ico"> 
    
    <!-- FontAwesome JS-->
    <script defer src="{{asset('assets/plugins/fontawesome/js/all.min.js')}}"></script>
    
    <!-- App CSS -->  
    <link id="theme-style" rel="stylesheet" href="{{asset('assets/css/portal.css')}}">

</head> 

<body class="app">   	
@extends('layouts/navigation')
<div class="app-wrapper">
	    
	    <div class="app-content pt-3 p-md-3 p-lg-4">
		    <div class="container-xl">
			<div class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration" role="alert">
				    <div class="inner">
					    <div class="app-card-body p-3 p-lg-4">

                   

			    <h1 class="app-page-title">Add  Sub Admin</h1>

    <form method="post" action="{{ route('sub_admin_store') }}"  class="mt-6 space-y-6">
        @csrf
        @method('patch')
        
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" class="form-control" ><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" class="form-control" ><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" class="form-control" ><br>

        <button type="submit" class="btn app-btn-primary" >{{ __('Save') }}</button>
    </form>
    </div><!--//app-card-body-->
                </div><!--//app-card-->  
 </div><!--//container-fluid-->
	    </div><!--//app-content-->
@extends('layouts/footer')
	    
        </div><!--//app-wrapper-->    					
    
     
        <!-- Javascript -->          
        <script src="{{asset('assets/plugins/popper.min.js')}}"></script>
        <script src="{{asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>  
    
        <!-- Charts JS -->
        <script src="{{asset('assets/plugins/chart.js/chart.min.js')}}"></script> 
        <script src="{{asset('assets/js/index-charts.js')}}"></script> 
        
        <!-- Page Specific JS -->
        <script src="{{asset('assets/js/app.js')}}"></script> 
    
    </body>
    </html> 
    
    
    