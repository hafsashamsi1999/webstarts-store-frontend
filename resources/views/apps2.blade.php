<!DOCTYPE html>
<html lang="en-US">
<head>
{!! Meta::toHtml() !!}
</head>
<body class="bg-white">
@include('fixed-header')
<section id="apps-page">
	<!-- Apps -->
	<div class="section-a main-section top-section-height"><!--apps-main-section-->
		<div class="aligner">
			<div class="main-section-row sm:gap-1.5">
				<div class="main-section-text-column z-index-1 relative">
					<h1 class="main-section-heading reveal animate-left">
						Apps To Run Your Business In The Office Or On The Go
					</h1>
					<p class="main-section-paragraph reveal animate-left">
						WebStarts has powerful apps to create dynamic websites and grow your business online.
					</p>
					<div class="main-section-button">
						<a href="/signup" class="m-0 w-210px block btn btn-lg btn-raised btn-secondary">Sign Up - It's Free</a>
					</div>
				</div>
				<div class="main-section-image-column-home reveal animate-right">
					<div class="image-align-bottom relative">
						<picture class="fade-icon reveal z-1">
							<source srcset="{{ asset('images/blue-shirt-guy-sized.webp') }} 858w, {{ asset('images/blue-shirt-guy-sized_w750.webp') }} 750w, {{ asset('images/blue-shirt-guy-sized_w500.webp') }} 500w" type="image/webp">
							<source srcset="{{ asset('images/blue-shirt-guy-sized.png') }} 858w, {{ asset('images/blue-shirt-guy-sized_w750.png') }} 750w, {{ asset('images/blue-shirt-guy-sized_w500.png') }} 500w" type="image/png">
							<img class="lg:w-680px w-full" src="{{ asset('images/blue-shirt-guy-sized_w750.png') }}" alt="online ecommerce store" style="aspect-ratio:750/842">
						</picture>

						<div class="">
							<picture>
								<source srcset="{{ asset('images/email-marketing-panel_w500.webp') }} 500w, {{ asset('images/email-marketing-panel_w300.webp') }} 300w, {{ asset('images/email-marketing-panel_w100.webp') }} 100w" type="image/webp">
								<source srcset="{{ asset('images/email-marketing-panel_w500.png') }} 500w, {{ asset('images/email-marketing-panel_w300.png') }} 300w, {{ asset('images/email-marketing-panel_w100.png') }} 100w" type="image/png">
								<img class="fade-right reveal absolute app-email-marketing-panel" src="{{ asset('images/email-marketing-panel_w500.png') }}" alt="Email Marketing App">
							</picture>
							<picture>
								<source srcset="{{ asset('images/store-panel_w500.webp') }} 500w, {{ asset('images/store-panel_w300.webp') }} 300w, {{ asset('images/store-panel_w100.webp') }} 100w" type="image/webp">
								<source srcset="{{ asset('images/store-panel_w500.png') }} 500w, {{ asset('images/store-panel_w300.png') }} 300w, {{ asset('images/store-panel_w100.png') }} 100w" type="image/png">
								<img class="fade-left reveal absolute app-store-panel" src="{{asset('images/store-panel_w500.png')}}" alt="Store Manager">
							</picture>
							<picture>
								<source srcset="{{ asset('images/files-panel_w500.webp') }} 500w, {{ asset('images/files-panel_w300.webp') }} 300w, {{ asset('images/files-panel_w100.webp') }} 100w" type="image/webp">
								<source srcset="{{ asset('images/files-panel_w500.png') }} 500w, {{ asset('images/files-panel_w300.png') }} 300w, {{ asset('images/files-panel_w100.png') }} 100w" type="image/png">
								<img class="fade-top reveal absolute app-files-panel" src="{{ asset('images/files-panel_w500.png') }}" alt="File Manager">
							</picture>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Apps -->

	<!-- Sell Products -->
	<!-- Mobile View -->
	<div id="store" class="section-b lg:hidden block bg-primarycolor">
		<div class="aligner py-24 lg:pt-48">
			<div class="features-column">
				<div class="text-white pl-4 lg:pl-20 pt-0 2xl:pt-20 lg:col-span-3 reveal animate-left">
					<h1 class="index-heading">
						Sell Products
					</h1>
					<p class="py-6 md:pr-24">
						Create your very own online store. Accept credit card payments. Sell both physical and digital products and a whole lot more.
					</p>
					<div class="flex justify-start">
						<a href="/store-features" class="m-0 w-full md:w-210px block btn btn-lg btn-raised btn-primary" style="color: #000000; background-color: #ffffff;">Explore More</a>
					</div>
				</div>
				<div class="relative lg:col-span-4 reveal animate-right lg:pt-0 pl-0 lg:pl-6">
					<picture>
						<source srcset="{{ asset('images/Webp/sell-product_w1500.webp') }} 1500w, {{ asset('images/Webp/sell-product_w1000.webp') }} 1000w, {{ asset('images/Webp/sell-product_w750.webp') }} 750w, {{ asset('images/Webp/sell-product_w500.webp') }} 500w" type="image/webp">
						<source srcset="{{ asset('images/Jpeg/sell-product_w1500.jpg') }} 1500w, {{ asset('images/Jpeg/sell-product_w1000.jpg') }} 1000w, {{ asset('images/Jpeg/sell-product_w750.jpg') }} 750w, {{ asset('images/Jpeg/sell-product_w500.jpg') }} 500w" type="image/jpeg">
						<img src="{{ asset('images/Jpeg/sell-product_w750.jpg') }}" alt="Sell products" loading="lazy" style="aspect-ratio:750/538">
					</picture>
				</div>
			</div>
		</div>
	</div>
	</div>
	<!-- Desktop View -->
	<div id="store-features" class="section-b hidden lg:block bg-primarycolor">
		<div class="aligner py-28">
			<div class="app-column">
				<div class="relative lg:col-span-4 reveal animate-left px-5 xl:px-10 2xl:px-20 lg:pt-0">
					<picture>
						<source srcset="{{ asset('images/Webp/sell-product_w1500.webp') }} 1500w, {{ asset('images/Webp/sell-product_w1000.webp') }} 1000w, {{ asset('images/Webp/sell-product_w750.webp') }} 750w, {{ asset('images/Webp/sell-product_w500.webp') }} 500w" type="image/webp">
						<source srcset="{{ asset('images/Jpeg/sell-product_w1500.jpg') }} 1500w, {{ asset('images/Jpeg/sell-product_w1000.jpg') }} 1000w, {{ asset('images/Jpeg/sell-product_w750.jpg') }} 750w, {{ asset('images/Jpeg/sell-product_w500.jpg') }} 500w" type="image/jpeg">

						<img src="{{ asset('images/Jpeg/sell-product_w750.jpg') }}" alt="Sell products" loading="lazy" style="aspect-ratio:750/538">
					</picture>
				</div>

				<div class="text-white pt-10 xl:pt-20 pr-4 md:pr-16 lg:col-span-3 text-right reveal animate-right">
					<h1 class="index-heading">
						Sell Products
					</h1>
					<p class="py-6 pl-20">
						Create your very own online store. Accept credit card payments. Sell both physical and digital products and a whole lot more.
					</p>
					<div class="flex justify-end">
						<a href="/store-features" class="m-0 w-full md:w-210px block btn btn-lg btn-raised btn-white">Explore More</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Sell Products -->

	<!-- Blog -->
	<div class="section-c bg-graysection">
		<div class="aligner py-24 lg:py-28">
			<div class="features-column">
				<div class="pl-4 lg:pl-16 pt-0 xl:pt-20 lg:col-span-3 reveal animate-left">
					<h1 class="index-heading">
						Blog</h1>
					<p class="py-6 lg:pr-24">
						Write blog posts, save them as drafts, and schedule them to be published later. Format text, create links, and optimize your posts to get found on search engines.
					</p>
					<div class="flex justify-start">
						<a href="/blog-features" class="m-0 w-full md:w-210px block btn btn-lg btn-raised btn-primary">Explore More</a>
					</div>
				</div>

				<div class="lg:col-span-4 reveal animate-right lg:pt-0 px-5 lg:pl-6">
					<picture>
						<source srcset="{{ asset('images/Webp/blog-graphics_w1920.webp') }} 1920w, {{ asset('images/Webp/blog-graphics_w1500.webp') }} 1500w, {{ asset('images/Webp/blog-graphics_w1000.webp') }} 1000w, {{ asset('images/Webp/blog-graphics_w750.webp') }} 750w, {{ asset('images/Webp/blog-graphics_w500.webp') }} 500w" type="image/webp">
						<source srcset="{{ asset('images/Jpeg/blog-graphics_w1920.jpg') }} 1920w, {{ asset('images/Jpeg/blog-graphics_w1500.jpg') }} 1500w, {{ asset('images/Jpeg/blog-graphics_w1000.jpg') }} 1000w, {{ asset('images/Jpeg/blog-graphics_w750.jpg') }} 750w, {{ asset('images/Jpeg/blog-graphics_w500.jpg') }} 500w" type="image/jpeg">

						<img src="{{ asset('images/Jpeg/blog-graphics_w750.jpg') }}" alt="blog view" loading="lazy" style="aspect-ratio:750/508">
					</picture>
				</div>
			</div>
		</div>
	</div>
	<!-- Blog -->

	<!-- Email Marketing -->
	<!-- Mobile View -->
	<div class="section-d lg:hidden block">
		<div class="aligner py-12">
			<div class="features-column">
				<div class="pl-4 lg:pl-16 pt-0 xl:pt-20 lg:col-span-3 reveal animate-left">
					<h1 class="index-heading">
						Email Marketing
					</h1>
					<p class="py-6 lg:pr-24">
						Create email marketing campaigns. Send both broadcast emails as well as schedule follow up emails. Put leads directly into your marketing lists from the forms on your website to create your own sales funnels.
					</p>
					<div class="flex justify-start">
						<a href="/email-marketing-features" class="m-0 w-full md:w-210px block btn btn-lg btn-raised btn-primary">Explore More</a>
					</div>
				</div>
				<div class="lg:col-span-4 reveal animate-right lg:pt-0 lg:pl-6">
					<div class="relative aligner text-center">

						<picture>
							<source srcset="{{ asset('images/Webp/email-marketing-graphics_w1920.webp') }} 1920w, {{ asset('images/Webp/email-marketing-graphics_w1500.webp') }} 1500w, {{ asset('images/Webp/email-marketing-graphics_w1000.webp') }} 1000w, {{ asset('images/Webp/email-marketing-graphics_w750.webp') }} 750w, {{ asset('images/Webp/email-marketing-graphics_w500.webp') }} 500w" type="image/webp">
							<source srcset="{{ asset('images/Jpeg/email-marketing-graphics_w1920.jpg') }} 1920w, {{ asset('images/Jpeg/email-marketing-graphics_w1500.jpg') }} 1500w, {{ asset('images/Jpeg/email-marketing-graphics_w1000.jpg') }} 1000w, {{ asset('images/Jpeg/blog-graphics_w750.jpg') }} 750w, {{ asset('images/Jpeg/email-marketing-graphics_w500.jpg') }} 500w" type="image/jpeg">

							<img src="{{ asset('images/Jpeg/email-marketing-graphics_w750.jpg') }}" alt="Email marketing view" loading="lazy" style="aspect-ratio:750/667">
						</picture>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Desktop View -->
	<div class="section-d hidden lg:block">
		<div class="aligner py-12">
			<div class="features-column">
				<div class="lg:col-span-4 reveal animate-left lg:pt-0 px-10">
					<div class="relative aligner text-center">
						<picture>
							<source srcset="{{ asset('images/Webp/email-marketing-graphics_w1920.webp') }} 1920w, {{ asset('images/Webp/email-marketing-graphics_w1500.webp') }} 1500w, {{ asset('images/Webp/email-marketing-graphics_w1000.webp') }} 1000w, {{ asset('images/Webp/email-marketing-graphics_w750.webp') }} 750w, {{ asset('images/Webp/email-marketing-graphics_w500.webp') }} 500w" type="image/webp">
							<source srcset="{{ asset('images/Jpeg/email-marketing-graphics_w1920.jpg') }} 1920w, {{ asset('images/Jpeg/email-marketing-graphics_w1500.jpg') }} 1500w, {{ asset('images/Jpeg/email-marketing-graphics_w1000.jpg') }} 1000w, {{ asset('images/Jpeg/blog-graphics_w750.jpg') }} 750w, {{ asset('images/Jpeg/email-marketing-graphics_w500.jpg') }} 500w" type="image/jpeg">

							<img src="{{ asset('images/Jpeg/email-marketing-graphics_w750.jpg') }}" alt="Email marketing view" loading="lazy" style="aspect-ratio:750/667">
						</picture>
					</div>

				</div>

				<div class="pr-4 md:pr-16 pt-20 2xl:pt-40 lg:col-span-3 text-right reveal animate-right">
					<h1 class="index-heading">
						Email Marketing
					</h1>
					<p class="py-6 pl-20">
						Create email marketing campaigns. Send both broadcast emails as well as schedule follow up emails. Put leads directly into your marketing lists from the forms on your website to create your own sales funnels.
					</p>
					<div class="flex justify-end">
						<a href="/email-marketing-features" class="m-0 w-full md:w-210px block btn btn-lg btn-raised btn-primary">Explore More</a>
					</div>
				</div>


			</div>
		</div>
	</div>
	<!-- Email Marketing -->

	<!-- Appointment -->
	<div class="section-e bg-darkgraysection" style="margin-bottom: -100px">
		<div class="aligner py-24 lg:py-28">
			<div class="features-column">
				<div class="pl-4 lg:pl-16 pt-0 xl:pt-20 lg:col-span-3 text-white reveal animate-left">
					<h1 class="index-heading">Appointment Booking</h1>
					<p class="py-6 lg:pr-24">Book appointments directly from your website, schedule your availability, manage multiple services, send reminders, and more.</p>
					<div class="flex justify-start">
						<a href="/appointment-features" class="m-0 w-full md:w-210px block btn btn-lg btn-raised btn-white">Explore More</a>
					</div>
				</div>

				<div class="lg:col-span-4 reveal animate-right lg:pt-0 px-5 lg:pl-6 pb-6">
					<picture>
						<source srcset="{{ asset('images/appointment-availibility.webp') }} 1834w, {{ asset('images/appointment-availibility_w1500.webp') }} 1500w, {{ asset('images/appointment-availibility_w1000.webp') }} 1000w, {{ asset('images/appointment-availibility_w750.webp') }} 750w, {{ asset('images/appointment-availibility_w500.webp') }} 500w" type="image/webp">
						<source srcset="{{ asset('images/appointment-availibility.png') }} 1834w, {{ asset('images/appointment-availibility_w1500.png') }} 1500w, {{ asset('images/appointment-availibility_w1000.png') }} 1000w, {{ asset('images/appointment-availibility_w750.png') }} 750w, {{ asset('images/appointment-availibility_w500.png') }} 500w" type="image/png">
						<img src="{{ asset('images/appointment-availibility_w750.png') }}" alt="appointment features" loading="lazy" style="aspect-ratio:750/582">
					</picture>
				</div>
			</div>
		</div>
	</div>
	<!-- Appointment -->

	<!-- Members Only Pages -->
	<div class="section-f primary-waves-section bg-darkgraysection pt-28">
		<div class="aligner pt-8 pb-12 lg:py-12 bg-primarycolor">
			<div class="features-column">

				<div class="text-white pl-4 lg:pl-16 pt-0 xl:pt-10 lg:col-span-3 reveal animate-right">
					<h1 class="index-heading">
						Members Only Pages</h1>
					<p class="py-6 lg:pr-24">
						Make your pages accessible by members only. Add a sign up and login to any page. Auto approve or manually approve your members.
					</p>
					<div class="flex justify-start">
						<a href="/membership-features" class="m-0 w-full md:w-210px block btn btn-lg btn-raised btn-white">Explore More</a>
					</div>
				</div>

				<div class="lg:col-span-4 reveal animate-left lg:pt-0 px-5 lg:px-10 2xl:px-20 lg:pl-6 sm:order-first">
					<picture>
						<source srcset="{{ asset('images/Webp/login-signup_w1500.webp') }} 1500w, {{ asset('images/Webp/login-signup_w1000.webp') }} 1000w, {{ asset('images/Webp/login-signup_w750.webp') }} 750w, {{ asset('images/Webp/login-signup_w500.webp') }} 500w" type="image/webp">
						<source srcset="{{ asset('images/Jpeg/login-signup_w1500.jpg') }} 1500w, {{ asset('images/Jpeg/login-signup_w1000.jpg') }} 1000w, {{ asset('images/Jpeg/login-signup_w750.jpg') }} 750w, {{ asset('images/Jpeg/login-signup_w500.jpg') }} 500w" type="image/jpeg">

						<img src="{{ asset('images/Jpeg/login-signup_w750.jpg') }}" alt="login and signup view" loading="lazy" style="aspect-ratio:750/503">
					</picture>
				</div>

			</div>
		</div>
	</div>

	<!-- Members Only Pages -->

	<!-- Web Analytics -->
	<!-- <div class="section-c">
		<div class="aligner pb-48 lg:py-48">
			<div class="app-column">
				<div class="pl-4 lg:pl-20 pt-0 xl:pt-20 lg:col-span-3">
					<h1 class="index-heading reveal animate-left">
					Web Analytics</h1>
					<p class="mt-4 reveal animate-left lg:pr-24">
					Create email marketing campaigns. Send both broadcast emails as well as schedule follow up emails. Put leads directly into your marketing list from the forms on your website to create your own sales funnels.				
					</p>
				<div class="mt-12 w-full sm:w-4/5 lg:w-full xl:w-4/5 reveal animate-left">
					<a href="/web-analytics" class="w-full  btn apps-btn btnraised btnprimary btn-trans text-base">
					Explore Web Analytics Features
					<div class="ripple-container"></div></a>
					</div>
				</div>

				<div class="lg:col-span-4 reveal animate-right pt-24 lg:pt-0 pl-6">
					<img class="" src="{{ asset('images/blog-graphics.png') }}">			
				</div>					
			</div>
		</div>
		</div>			
	</div> -->
	<!-- Web Analytics -->
	@include('login-signup-sticky-button-for-mobile')
</section>
@include('footer')
<link href="{{ asset('css/index-app.css') }}" rel="stylesheet">
{!! Meta::footer()->toHtml() !!}
</body>
</html>