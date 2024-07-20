<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
<link type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,700" rel="stylesheet">
<link type="text/css" href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
<link type="text/css" href="https://cdn.secure.website/ws/1631048375/library/ripples.min.css" rel="stylesheet"> 
<script type="text/javascript" async="" src="https://ssl.google-analytics.com/ga.js"></script>
<script async="" src="//connect.facebook.net/en_US/fbds.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/arrive/2.4.1/arrive.min.js"></script>
<script type="text/javascript" src="https://cdn.secure.website/ws/1631048375/library/material.min.js"></script>
<script type="text/javascript" src="https://cdn.secure.website/ws/1631048375/library/ui-common.min.js"></script>

<link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
	<section id="offers-page">
  <div class="w-full grid grid-cols-1">
  	<div class="relative bg-white">
  		<div class="text-sm font-medium text-gray-700 bg-gray-100 header-shadow">
  			<div class="w-full mx-auto px-4 sm:px-6 navbar">
  				<div class="aligner border-b-2 border-gray-100 py-4">
  					<div class="absolute left-4">
            	<a href="#">
              	<span class="sr-only">Webstarts</span>
              	<img class="w-70" src="https://files.secure.website/wscfus/9927743/9046970/minimal-logo-source-png-w100-o.png" alt="webstarts logo">
            	</a>
     	     	</div>

		<ul class="nav nav-tabs tabs-3 lg:w-65 w-70 flex relative justify-end sm:justify-center space-x-4" role="tablist">
			<li class="flex items-center nav-item active">
				<span class="progress-count">1</span>
				<a class="progress-label nav-link flex" data-toggle="tab" href="#panel1" role="tab" aria-expanded="true"><h4>Select A Plan</h4>
				<div class="ripple-container"></div>
			</a>
			</li>
			<li class="flex items-center nav-item">
				<span class="progress-count">2</span>
				<a class="progress-label nav-link flex" data-toggle="tab" href="#panel2" role="tab" aria-expanded="false"><h4>Select A Billing Cycle</h4>
				<div class="ripple-container"></div>
			</a>
			</li>
			<li class="flex items-center nav-item">
				<span class="progress-count">3</span>
				<a class="progress-label nav-link flex" data-toggle="tab" href="#panel3" role="tab" aria-expanded="false"><h4>Complete Your Purchase</h4><div class="ripple-container"></div></a>
			</li>
		</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="tab-content text-left">
			<div class="tab-pane fade active in" id="panel1" role="tabpanel">
				@include('select-plan')
			</div>
			<div class="tab-pane fade" id="panel2" role="tabpanel">
				@include('select-billing')
			</div>
			<div class="tab-pane fade" id="panel3" role="tabpanel">
				@include('select-billing')
			</div>
		</div>
					
	</div>


	</section>

</body>