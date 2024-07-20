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
<script type="text/javascript" src="https://cdn.secure.website/ws/1631048375/library/ripples.min.js"></script>
<script type="text/javascript" src="https://cdn.secure.website/ws/1631048375/library/material.min.js"></script>
<script type="text/javascript" src="https://cdn.secure.website/ws/1631048375/library/ui-common.min.js"></script>
<link href="{{ asset('css/app.css') }}" rel="stylesheet">

<script type="text/javascript">
	$(document).ready(function() {

		setTimeout(function(){
			$('.free-banner').addClass('animate');
		}, 10);
   });
</script>
</head>

<body class="bg-gray-100">
	<div class="free-banner bg-secondarycolor text-white py-2">
		<div class="container aligner">
			<div class="text">
				<div class="hidden md:block">
									This site is currently on a free plan. Upgrade now to add a domain name, custom email addresses, and have your site submitted to Google.
								</div>
				<div class="block md:hidden">
					Upgrade today and save 50%
				</div>
			</div>
		</div>
	</div>
	@include('fixed-header')
	<section id="pricing-page" class="bg-gray-100 pb-20">
		<div class="container aligner pt-8 flex-col">
			<h1 class="text-smheading font-semibold hidden md:block">Upgrade Your Site Now and Get 50% Off</h1>
			<h1 class="text-smheading font-semibold block md:hidden">Select A Plan</h1>
			<p class="text-body text-gray-500 font-medium hidden md:block">Get all the following and more when you choose a plan below...</p>			
		</div>

<div class="container pt-12">

<div class="aligner">
	<div class="2xl:w-4/5 xl:w-90 sm:w-90 md:block hidden">
		<div class="2xl:px-6 xl:px-4 sm:px-2 w-full flex">
	

		<div class="pricing-card-info w-23">
			<ul>
				<li>
					<span>Custom Domain Name</span>
					<i class="material-icons text-muted text-iconcolor align-middle" data-toggle="tooltip" data-placement="top" title="" tabindex="0">info</i>
				</li>
				<li>Search Engine Submission</li>
				<li>Free Advertising</li>
				<li>Social Integration</li>
				<li>Business Emails</li>
				<li>SEO Tools</li>
				<li>Available Pages</li>
				<li>Contact Forms</li>
				<li>Slideshows &amp; Galleries</li>
				<li>Cloud Storage</li>
				<li>Bandwidth</li>
				<li>Ads Shown</li>
				<li><span class="label label-primary">NEW</span> Notification Center</li>
				<li><span class="label label-primary">NEW</span> Live Chat</li>
				<li>Mobile Optimization</li>
				<li>HTML Access</li>
				<li>Membership Features</li>
				<li>Unlimited Styles &amp; Effects</li>
                <li>Online Store</li>
				<li>Lightning Fast CDN</li>
			</ul>
		</div>
	<div class="grid grid-cols-2 gap-3 w-4/5">
		
		<div class="pricing-card-container text-center">
			<div class="card shadow-none bg-white">
				<div class="pricing-header">
					<div>
						<a class="w-full btn btnprimary btn-trans btnmd" href="">Pro Plus</a>
						<p class="plan-sub lg:h-4em md:h-7em sm:h-8em">Perfect for clubs, organizations, teams, and non-profits.</p>
					</div>

					<hr class="hr">

					<p>Was <span class="strike">$14.32/mo</span></p>
					<p>Now only<br><span class="text-abouttitle span font-normal">$7.16/mo</span></p>

					<a class="btn btnprimary btnraised btn-trans" data-hasdomain="yes" data-plan="proplus" data-pcode="PROPLUS_11_1Y" href="/user/upgrade-account/plus">Select<span class="ml-1 hidden xl:block"> Plan</span></a>
				</div>

				<ul>
					<li>Yes</li>
					<li>&nbsp;<div class="se-bg google-only"></div></li>
					<li>$250</li>
					<li>
						
						<div class="icon-set">
							<i class="fa fa-facebook"></i>
							<i class="fa fa-twitter"></i>
							<i class="fa fa-instagram"></i>
							<i class="fa fa-pinterest"></i>
						</div>
					</li>
					<li>1 Email Address</li>
					<li>Yes</li>
					<li>Unlimited</li>
					<li>1,000 Contacts</li>
					<li>Unlimited</li>
					<li>10GB</li>
					<li>100GB/mo</li>
					<li>Ad Free</li>
					<li>&nbsp;<i class="material-icons checkmark">done</i></li>
					<li>&nbsp;<i class="material-icons checkmark">done</i></li>
					<li>&nbsp;<i class="material-icons checkmark">done</i></li>
					<li>&nbsp;<i class="material-icons checkmark">done</i></li>
					<li>&nbsp;<i class="material-icons checkmark">done</i></li>
					<li>&nbsp;<i class="material-icons">cross</i></li>
                    <li>&nbsp;<i class="material-icons">cross</i></li>
					<li>&nbsp;<i class="material-icons">cross</i></li>
				</ul>

				<div class="offer-footer">
					<a class="btn btnprimary btnraised btn-trans mb-20px" data-hasdomain="yes" data-plan="proplus" data-pcode="PROPLUS_11_1Y" href="/user/upgrade-account/plus">Select<span class="hidden xl:block ml-1"> Plan</span></a>
					<p>Only<br><span class="text-abouttitle span font-normal">$7.16/mo</span></p>

					<hr class="hr">

					<div>
						<p class="plan-sub lg:h-4em md:h-7em sm:h-8em">Perfect for clubs, organizations, teams, and non-profits.</p>
						<a class="w-full btn btnprimary btn-trans btnmd" href="">Pro Plus</a>

					</div>
				</div>
			</div>
		</div>

		<div class="pricing-card-container text-center">
			<div class="card shadow-none bg-white">
				<div class="pricing-header">
					<div>
						<a class="w-full btn btnsecondary btn-trans btnmd" href="">Business + Ecommerce
						<label class="label label-primary text-label ml-1 absolute right-2">BEST VALUE</label>
						</a>
						<p class="plan-sub lg:h-4em md:h-7em sm:h-8em">The right choice for businesses looking to expand.</p>
					</div>

					<hr class="hr">

					<p>Was <span class="strike">$39.98/mo</span></p>
					<p>Now only<br><span class="text-abouttitle span font-normal">$19.99/mo</span></p>

					<a class="btn btnsecondary btnraised btn-trans" data-hasdomain="yes" data-plan="business" data-pcode="PROPLUS_BUSINESS_PLUS_1Y" href="/user/upgrade-account/business">Select<span class="hidden xl:block ml-1"> Plan</span></a>
				</div>

				<ul>
					<li>Yes</li>
					<li>&nbsp;<div class="se-bg"></div></li>
					<li>$500</li>
					<li>
						<div class="icon-set">
							<i class="fa fa-facebook"></i>
							<i class="fa fa-twitter"></i>
							<i class="fa fa-instagram"></i>
							<i class="fa fa-pinterest"></i>
						</div>
					</li>
					<li>5 Email Addresses</li>
					<li>Yes</li>
					<li>Unlimited</li>
					<li>Unlimited</li>
					<li>Unlimited</li>
					<li>40GB</li>
					<li>Unlimited</li>
					<li>Ad Free</li>
					<li>&nbsp;<i class="material-icons checkmark">done</i></li>
					<li>&nbsp;<i class="material-icons checkmark">done</i></li>
					<li>&nbsp;<i class="material-icons checkmark">done</i></li>
					<li>&nbsp;<i class="material-icons checkmark">done</i></li>
					<li>&nbsp;<i class="material-icons checkmark">done</i></li>
					<li>&nbsp;<i class="material-icons checkmark">done</i></li>
                    <li>&nbsp;<i class="material-icons checkmark">done</i></li>
					<li>&nbsp;<i class="material-icons checkmark">done</i></li>
				</ul>

				<div class="offer-footer">
					<a class="btn btnsecondary btnraised btn-trans mb-20px" data-hasdomain="yes" data-plan="business" data-pcode="PROPLUS_BUSINESS_PLUS_1Y" href="/user/upgrade-account/business">Select<span class="hidden xl:block ml-1"> Plan</span></a>
					<p>Only<br><span class="text-abouttitle span font-normal">$19.99/mo</span></p>

					<hr class="hr">

					<div>
						<p class="plan-sub lg:h-4em md:h-7em sm:h-8em">The right choice for businesses looking to expand.</p>
						<a class="w-full btn btnsecondary btn-trans btnmd" href="">Business + Ecommerce
						<label class="label label-primary text-label ml-1 absolute right-2">BEST VALUE</label>
						</a>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
</div>
</div>

<!-- Phone View -->

	<div id="pricing-page-phone" class="w-full grid grid-cols-1 md:hidden sm:block">
		<ul class="nav nav-tabs tabs-2" role="tablist">
			<li class="nav-item active">
				<a class="nav-link text-title text-center" data-toggle="tab" href="#panel1" role="tab" aria-expanded="true"><h4>Pro Plus</h4><div class="ripple-container"></div></a>
			</li>
			<li class="nav-item">
				<a class="nav-link text-title text-center" data-toggle="tab" href="#panel2" role="tab" aria-expanded="false"><h4>Business</h4><div class="ripple-container"></div></a>
			</li>
		</ul>

		<div class="tab-content text-left">
			<div class="tab-pane fade active in" id="panel1" role="tabpanel">

				<div class="text-center my-2 text-gray-500">
					<span class="red-strike">Normally $14.32/mo</span>
				</div>

				<div class="price-div text-center my-4">
					<span class="sign align-top">$</span>
					<span class="amount">7.16</span>
					<span class="period align-bottom">/mo</span>
					<div class="annual text-lg">Billed annually</div>
				</div>

				<div class="text-center my-8">
					<a class="btn btnraised btnsecondary btnmd w-full" href="/buy.php?view=2&amp;medium=direct&amp;p=PROPLUS_11_1Y&amp;u=">Select Pro Plus Plan</a>
				</div>

				<ul class="key-features">
					<li>
						<i class="fa fa-check text-success"></i>
						<span>Free Domain Name</span>
						<i class="material-icons text-muted text-iconcolor align-middle" data-toggle="tooltip" data-placement="top">info</i>
					</li>
					<li><i class="fa fa-check text-success"></i>Matching Email Address</li>
					<li><i class="fa fa-check text-success"></i>Site Submitted To Google</li>
					<li><i class="fa fa-check text-success"></i>$250 Ad Vouchers</li>
					<li><i class="fa fa-check text-success"></i>Premium Apps</li>
				</ul>

			</div>
			<div class="tab-pane fade" id="panel2" role="tabpanel">

				<div class="text-center my-2 text-gray-500">
					<span class="red-strike">Normally $39.98/mo</span>
				</div>

				<div class="price-div text-center my-4">
					<span class="sign align-top">$</span>
					<span class="amount">19.99</span>
					<span class="period align-bottom">/mo</span>
					<div class="annual text-lg">Billed annually</div>
				</div>

				<div class="text-center my-8">
					<a class="btn btnraised btnsecondary btnmd w-full" href="/buy.php?view=2&amp;medium=direct&amp;p=PROPLUS_BUSINESS_PLUS_1Y&amp;u=">Select Business Plan</a>
				</div>

				<ul class="key-features">
					<li>
						<i class="fa fa-check text-success"></i>
						<span>Free Domain Name</span>
						<i class="material-icons text-muted text-iconcolor align-middle" data-toggle="tooltip" data-placement="top">info</i>
					</li>
					<li><i class="fa fa-check text-success"></i>5 Matching Email Addresses</li>
					<li><i class="fa fa-check text-success"></i>Site Submitted To Google, Yahoo and bing</li>
					<li><i class="fa fa-check text-success"></i>$500 Ad Vouchers</li>
					<li><i class="fa fa-check text-success"></i>Ecommerce Store</li>
					<li><i class="fa fa-check text-success"></i>Premium Apps</li>
					<li><i class="fa fa-check text-success"></i>Priority Support</li>
					<li><i class="fa fa-check text-success"></i>Unlimited Users</li>
				</ul>
			</div>
		</div>
		
			
	</div>
</div>
		
	</section>
</body>
@include('footer')