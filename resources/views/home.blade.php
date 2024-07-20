<!DOCTYPE html>
<html lang="en-US">
<head>
{!! Meta::toHtml() !!}
</head>
<body class="bg-white">
	@include('fixed-header')
	<section id="store-home-page">
		<!-- Webstarts Store Home -->
		<div class="section-a main-section features-and-apps-section" loading="eager"><!--pink-and-blue-ribbon-section-->
			<div class="aligner">
				<div class="main-section-row">
					<div class="main-section-text-column z-index-1">
						<h1 class="main-section-heading reveal animate-left">
							Create A Free <br>Online Store
						</h1>
						<p class="main-section-paragraph reveal fade-left">Sell your products online. No trials. No transaction fees. No coding. No software to install.</p>
						<div class="main-section-button">
							<a href="https://www.webstarts.com/designs/online-store" class="m-0 w-210px block btn btn-lg btn-raised btn-secondary">Sign Up - It's Free</a>
						</div>
						<div class="py-4">
							<a href="#" class="popup-btn flex justify-center lg:justify-start">
								<span class="text-label font-semibold">Watch the demo video</span>
								<div class="pl-2 text-indextitle text-black cursor-pointer reveal fade-icon active">
									<img alt="play icon" style="width: 20px; height: 20px"  src="{{asset('images/svg/circle-play-regular.svg')}}">
								</div>
							</a>
						</div>
					</div>

					<div class="main-section-image-column-home reveal animate-right">
						<div class="image-align-bottom">
							<picture>
							<source srcset="{{ asset('images/Webp/store-cart-graphics_w1920.webp') }} 1920w, {{ asset('images/Webp/store-cart-graphics_w1500.webp') }} 1500w, {{ asset('images/Webp/store-cart-graphics_w1000.webp') }} 1000w, {{ asset('images/Webp/store-cart-graphics_w750.webp') }} 750w, {{ asset('images/Webp/store-cart-graphics_w500.webp') }} 500w" type="image/webp">
							<source srcset="{{ asset('images/Jpeg/store-cart-graphics_w1920.jpg') }} 1920w, {{ asset('images/Jpeg/store-cart-graphics_w1500.jpg') }} 1500w, {{ asset('images/Jpeg/store-cart-graphics_w1000.jpg') }} 1000w, {{ asset('images/Jpeg/store-cart-graphics_w750.jpg') }} 750w, {{ asset('images/Jpeg/store-cart-graphics_w500.jpg') }} 500w" type="image/jpeg">
							<img src="{{ asset('images/Jpeg/store-cart-graphics_w750.jpg') }}" alt="online store features">
						</picture>
						</div>
					</div>
				</div>
			</div>
			<div class="video-popup">
				<div class="popup-bg"></div>
				<div class="popup-content">
					<iframe loading="lazy" class="youtube-video h-230px sm:h-450px md:h-600px" width="1232" height="591" src="https://www.youtube.com/embed/e69B9NTER20?si=HK4p-BenyZWq9PBC" title="WebStarts Website Builder 2022" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</div>
			</div>
		</div>
		<!-- Webstarts Store Home -->

		<div class="section-c py-12">
			<div class="container aligner flex-col text-center px-5">
				<h1 class="index-heading reveal fade-right">
					<span class="hidden lg:block">So Easy Anyone Can Do It</span>
					<span class="lg:hidden block">So Easy Anyone<br>Can Do It</span>
				</h1>
				<p class="pt-4 reveal fade-left">With WebStarts there's no software to download or code to write.</p>
			</div>
			<div class="text-center mt-8">

				<div class="lg:pt-16 xl:px-12 aligner relative">
					<div class="grid lg:grid-cols-3 grid-cols-1 gap-x-16 2xl:gap-x-12 reveal fade-bottom w-full lg:w-90 2xl:w-85 relative">
						<div class="px-5 flex flex-col items-center">
							<div class="absolute top-16 left-12 w-70 h-5px bg-primarycolor reveal fade-icon mt-2 hidden lg:block"></div>
							<div class="relative reveal fade-icon aligner pb-6 lg:h-150px lg:w-150px w-120px h-120px">
								<i class="absolute num-icon">1</i>
								<svg class="w-full h-full" viewBox="0 0 110 110" xmlns="http://www.w3.org/2000/svg">
									<g></g>
									<circle cx="55" cy="55" r="50" stroke-width="10" stroke="#79d3fc" fill="#03a9f4"></circle>
								</svg>
							</div>
							<div class="flex flex-col mb-6">
								<h2 class="font-semibold text-indextitle leading-tight p-2">Choose A Theme</h2>
								<p class="text-body lg:w-300px max-w-400px">Choose from one of our great looking themes and customize it to make it your own.</p>
							</div>
						</div>
						<div class="px-5 flex flex-col items-center">
							<div class="relative reveal fade-icon aligner pb-6 lg:h-150px lg:w-150px w-120px h-120px">
								<i class="absolute num-icon">2</i>
								<svg class="w-full h-full" viewBox="0 0 110 110" xmlns="http://www.w3.org/2000/svg">
									<g></g>
									<circle cx="55" cy="55" r="50" stroke-width="10" stroke="#79d3fc" fill="#03a9f4"></circle>
								</svg>
							</div>
							<div class="flex flex-col mb-6">
								<h2 class="font-semibold text-indextitle leading-tight p-2">Create Your Products</h2>
								<p class="text-body lg:w-300px max-w-400px">Upload product images, add a description, and set your pricing.</p>
							</div>
						</div>
						<div class="px-5 flex flex-col items-center">
							<div class="relative reveal fade-icon aligner pb-6 lg:h-150px lg:w-150px w-120px h-120px">
								<i class="absolute num-icon">3</i>
								<svg class="w-full h-full" viewBox="0 0 110 110" xmlns="http://www.w3.org/2000/svg">
									<g></g>
									<circle cx="55" cy="55" r="50" stroke-width="10" stroke="#79d3fc" fill="#03a9f4"></circle>
								</svg>
							</div>
							<div class="flex flex-col mb-6">
								<h2 class="font-semibold text-indextitle leading-tight p-2">Accept Payments</h2>
								<p class="text-body lg:w-300px max-w-400px">Instantly begin accepting credit card payments directly from your website.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="section-e pb-40 lg:pb-0"><!--features-and-apps-section-->
			<div class="container aligner flex-col text-center pt-12 md:px-10">
				<h1 class="index-heading reveal fade-right hidden md:block">More Features And Apps</h1>
				<h1 class="index-heading reveal fade-right md:hidden block">More Features <br> And Apps</h1>
				<span class="pt-4 reveal fade-left">WebStarts is loaded with more features and apps than other website builders.</span>
			</div>


			<div class="aligner text-center px-2 sm:px-5 lg:px-0 pt-28 lg:pb-10 lg:pt-18 reveal fade-icon">
				<picture class="xl:w-70">
					<source srcset="{{ asset('images/Webp/apps-and-features_w1400.webp') }} 1400w, {{ asset('images/Webp/apps-and-features_w1000.webp') }} 1000w, {{ asset('images/Webp/apps-and-features_w750.webp') }} 750w, {{ asset('images/Webp/apps-and-features_w500.webp') }} 500w," type="image/webp">
					<source srcset="{{ asset('images/Jpeg/apps-and-features_w1400.jpg') }} 1400w, {{ asset('images/Jpeg/apps-and-features_w1000.jpg') }} 1000w, {{ asset('images/Jpeg/apps-and-features_w750.jpg') }} 750w, {{ asset('images/Jpeg/apps-and-features_w500.jpg') }} 500w" type="image/jpeg">
					<img src="{{ asset('images/Jpeg/apps-and-features_w750.jpg') }}" alt="WebStarts is loaded with more features and apps" loading="lazy">
				</picture>
			</div>
		</div>

		<div class="section-i">
			<div class="text-center sm:text-left aligner pt-10 md:pt-20">
				<div class="aligner px-4 sm:px-12 w-90 sm:w-80 lg:w-90 2xl:w-80">
					<div class="grid lg:grid-cols-2 grid-cols-1 gap-5 lg:gap-10">
						<div class="sm:flex sm:justify-center sm:items-start sm:px-5 my-5 max-w-600px">
							<div class="pt-6 pb-4 sm:pb-0 reveal fade-icon flex justify-center">
								<svg xmlns="http://www.w3.org/2000/svg" height="70px" viewBox="0 0 512 512"><path d="M64 64c0-17.7-14.3-32-32-32S0 46.3 0 64L0 400c0 44.2 35.8 80 80 80l400 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L80 416c-8.8 0-16-7.2-16-16L64 64zm406.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L320 210.7l-57.4-57.4c-12.5-12.5-32.8-12.5-45.3 0l-112 112c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L240 221.3l57.4 57.4c12.5 12.5 32.8 12.5 45.3 0l128-128z"/></svg>
							</div>
							<div class="sm:pl-8 sm:pt-8 w-full">
								<h4 class="font-semibold text-indextitle leading-tight reveal fade-icon">Sales Reporting</h4>
								<div class="h-2px bg-secondarycolor reveal fade-icon mt-2"></div>
								<p class="text-body mt-8 reveal fade-icon">Run sales reports to truly understand who's buying, what they're buying, and more.</p>
							</div>
						</div>

						<div class="sm:flex sm:justify-center sm:items-start sm:px-5 my-5 max-w-600px">
							<div class="pt-6 pb-4 sm:pb-0 reveal fade-icon flex justify-center">
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" height="70px"><path d="M144 144l0 48 160 0 0-48c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192l0-48C80 64.5 144.5 0 224 0s144 64.5 144 144l0 48 16 0c35.3 0 64 28.7 64 64l0 192c0 35.3-28.7 64-64 64L64 512c-35.3 0-64-28.7-64-64L0 256c0-35.3 28.7-64 64-64l16 0z"/></svg>
							</div>
							<div class="sm:pl-8 sm:pt-8 w-full">
								<h4 class="font-semibold text-indextitle leading-tight reveal fade-icon">Secure Transaction</h4>
								<div class="h-2px bg-primarycolor reveal fade-icon mt-2"></div>
								<p class="text-body mt-8 reveal fade-icon">All transactions are secured by SSL certificates.</p>
							</div>
						</div>

						<div class="sm:flex sm:justify-center sm:items-start sm:px-5 my-5 max-w-600px">
							<div class="pt-6 pb-4 sm:pb-0 reveal fade-icon flex justify-center">
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" height="70px"><path d="M64 64C28.7 64 0 92.7 0 128l0 64c0 8.8 7.4 15.7 15.7 18.6C34.5 217.1 48 235 48 256s-13.5 38.9-32.3 45.4C7.4 304.3 0 311.2 0 320l0 64c0 35.3 28.7 64 64 64l448 0c35.3 0 64-28.7 64-64l0-64c0-8.8-7.4-15.7-15.7-18.6C541.5 294.9 528 277 528 256s13.5-38.9 32.3-45.4c8.3-2.9 15.7-9.8 15.7-18.6l0-64c0-35.3-28.7-64-64-64L64 64zm64 112l0 160c0 8.8 7.2 16 16 16l288 0c8.8 0 16-7.2 16-16l0-160c0-8.8-7.2-16-16-16l-288 0c-8.8 0-16 7.2-16 16zM96 160c0-17.7 14.3-32 32-32l320 0c17.7 0 32 14.3 32 32l0 192c0 17.7-14.3 32-32 32l-320 0c-17.7 0-32-14.3-32-32l0-192z"/></svg>
							</div>
							<div class="sm:pl-8 sm:pt-8 w-full">
								<h4 class="font-semibold text-indextitle leading-tight reveal fade-icon">Coupon Codes</h4>
								<div class="h-2px bg-secondarycolor md:bg-primarycolor reveal fade-icon mt-2"></div>
								<p class="text-body mt-8 reveal fade-icon">Offer your customers coupon codes for discount by percentage or amount.</p>
							</div>
						</div>

						<div class="sm:flex sm:justify-center sm:items-start sm:px-5 my-5 max-w-600px">
							<div class="pt-6 pb-4 sm:pb-0 reveal fade-icon flex justify-center">
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" height="70px"><path d="M352 256c0 22.2-1.2 43.6-3.3 64l-185.3 0c-2.2-20.4-3.3-41.8-3.3-64s1.2-43.6 3.3-64l185.3 0c2.2 20.4 3.3 41.8 3.3 64zm28.8-64l123.1 0c5.3 20.5 8.1 41.9 8.1 64s-2.8 43.5-8.1 64l-123.1 0c2.1-20.6 3.2-42 3.2-64s-1.1-43.4-3.2-64zm112.6-32l-116.7 0c-10-63.9-29.8-117.4-55.3-151.6c78.3 20.7 142 77.5 171.9 151.6zm-149.1 0l-176.6 0c6.1-36.4 15.5-68.6 27-94.7c10.5-23.6 22.2-40.7 33.5-51.5C239.4 3.2 248.7 0 256 0s16.6 3.2 27.8 13.8c11.3 10.8 23 27.9 33.5 51.5c11.6 26 20.9 58.2 27 94.7zm-209 0L18.6 160C48.6 85.9 112.2 29.1 190.6 8.4C165.1 42.6 145.3 96.1 135.3 160zM8.1 192l123.1 0c-2.1 20.6-3.2 42-3.2 64s1.1 43.4 3.2 64L8.1 320C2.8 299.5 0 278.1 0 256s2.8-43.5 8.1-64zM194.7 446.6c-11.6-26-20.9-58.2-27-94.6l176.6 0c-6.1 36.4-15.5 68.6-27 94.6c-10.5 23.6-22.2 40.7-33.5 51.5C272.6 508.8 263.3 512 256 512s-16.6-3.2-27.8-13.8c-11.3-10.8-23-27.9-33.5-51.5zM135.3 352c10 63.9 29.8 117.4 55.3 151.6C112.2 482.9 48.6 426.1 18.6 352l116.7 0zm358.1 0c-30 74.1-93.6 130.9-171.9 151.6c25.5-34.2 45.2-87.7 55.3-151.6l116.7 0z"/></svg>
							</div>
							<div class="sm:pl-8 sm:pt-8 w-full">
								<h4 class="font-semibold text-indextitle leading-tight reveal fade-icon">Automatic Domain Setup</h4>
								<div class="h-2px bg-primarycolor md:bg-secondarycolor reveal fade-icon mt-2"></div>
								<p class="text-body mt-8 reveal fade-icon">Create your site, choose a new domain and it automatically begins working in less than a minute.</p>
							</div>
						</div>

						<div class="sm:flex sm:justify-center sm:items-start sm:px-5 my-5 max-w-600px">
							<div class="pt-6 pb-4 sm:pb-0 reveal fade-icon flex justify-center">
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" height="70px"><path d="M0 96C0 60.7 28.7 32 64 32l384 0c35.3 0 64 28.7 64 64l0 320c0 35.3-28.7 64-64 64L64 480c-35.3 0-64-28.7-64-64L0 96zM48 368l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16zm368-16c-8.8 0-16 7.2-16 16l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0zM48 240l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16zm368-16c-8.8 0-16 7.2-16 16l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0zM48 112l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16L64 96c-8.8 0-16 7.2-16 16zM416 96c-8.8 0-16 7.2-16 16l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0zM160 128l0 64c0 17.7 14.3 32 32 32l128 0c17.7 0 32-14.3 32-32l0-64c0-17.7-14.3-32-32-32L192 96c-17.7 0-32 14.3-32 32zm32 160c-17.7 0-32 14.3-32 32l0 64c0 17.7 14.3 32 32 32l128 0c17.7 0 32-14.3 32-32l0-64c0-17.7-14.3-32-32-32l-128 0z"/></svg>
							</div>
							<div class="sm:pl-8 sm:pt-8 w-full">
								<h4 class="font-semibold text-indextitle leading-tight reveal fade-icon">Product Videos</h4>
								<div class="h-2px bg-secondarycolor reveal fade-icon mt-2"></div>
								<p class="text-body mt-8 reveal fade-icon">Share product videos to go along with your photos.</p>
							</div>
						</div>

						<div class="sm:flex sm:justify-center sm:items-start sm:px-5 my-5 max-w-600px">
							<div class="pt-6 pb-4 sm:pb-0 reveal fade-icon flex justify-center">
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" height="70px">
									<path d="M470.7 9.4c3 3.1 5.3 6.6 6.9 10.3s2.4 7.8 2.4 12.2c0 0 0 .1 0 .1c0 0 0 0 0 0l0 96c0 17.7-14.3 32-32 32s-32-14.3-32-32l0-18.7L310.6 214.6c-11.8 11.8-30.8 12.6-43.5 1.7L176 138.1 84.8 216.3c-13.4 11.5-33.6 9.9-45.1-3.5s-9.9-33.6 3.5-45.1l112-96c12-10.3 29.7-10.3 41.7 0l89.5 76.7L370.7 64 352 64c-17.7 0-32-14.3-32-32s14.3-32 32-32l96 0s0 0 0 0c8.8 0 16.8 3.6 22.6 9.3l.1 .1zM0 304c0-26.5 21.5-48 48-48l416 0c26.5 0 48 21.5 48 48l0 160c0 26.5-21.5 48-48 48L48 512c-26.5 0-48-21.5-48-48L0 304zM48 416l0 48 48 0c0-26.5-21.5-48-48-48zM96 304l-48 0 0 48c26.5 0 48-21.5 48-48zM464 416c-26.5 0-48 21.5-48 48l48 0 0-48zM416 304c0 26.5 21.5 48 48 48l0-48-48 0zm-96 80a64 64 0 1 0 -128 0 64 64 0 1 0 128 0z"/>
								</svg>
							</div>
							<div class="sm:pl-8 sm:pt-8 w-full">
								<h4 class="font-semibold text-indextitle leading-tight reveal fade-icon">Payment Processors</h4>
								<div class="h-2px bg-primarycolor reveal fade-icon mt-2"></div>
								<p class="text-body mt-8 reveal fade-icon">WebStarts supports the most popular payment processors like Stripe, Authorize.net, and WePay.</p>
							</div>
						</div>

						<div class="sm:flex sm:justify-center sm:items-start sm:px-5 my-5 max-w-600px">
							<div class="pt-6 pb-4 sm:pb-0 reveal fade-icon flex justify-center">
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" height="70px">
									<path d="M208 80c0-26.5 21.5-48 48-48l64 0c26.5 0 48 21.5 48 48l0 64c0 26.5-21.5 48-48 48l-8 0 0 40 152 0c30.9 0 56 25.1 56 56l0 32 8 0c26.5 0 48 21.5 48 48l0 64c0 26.5-21.5 48-48 48l-64 0c-26.5 0-48-21.5-48-48l0-64c0-26.5 21.5-48 48-48l8 0 0-32c0-4.4-3.6-8-8-8l-152 0 0 40 8 0c26.5 0 48 21.5 48 48l0 64c0 26.5-21.5 48-48 48l-64 0c-26.5 0-48-21.5-48-48l0-64c0-26.5 21.5-48 48-48l8 0 0-40-152 0c-4.4 0-8 3.6-8 8l0 32 8 0c26.5 0 48 21.5 48 48l0 64c0 26.5-21.5 48-48 48l-64 0c-26.5 0-48-21.5-48-48l0-64c0-26.5 21.5-48 48-48l8 0 0-32c0-30.9 25.1-56 56-56l152 0 0-40-8 0c-26.5 0-48-21.5-48-48l0-64z"/>
								</svg>
							</div>
							<div class="sm:pl-8 sm:pt-8 w-full">
								<h4 class="font-semibold text-indextitle leading-tight reveal fade-icon">Site Map Support</h4>
								<div class="h-2px bg-primarycolor reveal fade-icon mt-2"></div>
								<p class="text-body mt-8 reveal fade-icon">Upload a site map and help search engines like Google find your content.</p>
							</div>
						</div>

						<div class="sm:flex sm:justify-center sm:items-start sm:px-5 my-5 max-w-600px">
							<div class="pt-6 pb-4 sm:pb-0 reveal fade-icon flex justify-center">
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" height="70px"><path d="M579.8 267.7c56.5-56.5 56.5-148 0-204.5c-50-50-128.8-56.5-186.3-15.4l-1.6 1.1c-14.4 10.3-17.7 30.3-7.4 44.6s30.3 17.7 44.6 7.4l1.6-1.1c32.1-22.9 76-19.3 103.8 8.6c31.5 31.5 31.5 82.5 0 114L422.3 334.8c-31.5 31.5-82.5 31.5-114 0c-27.9-27.9-31.5-71.8-8.6-103.8l1.1-1.6c10.3-14.4 6.9-34.4-7.4-44.6s-34.4-6.9-44.6 7.4l-1.1 1.6C206.5 251.2 213 330 263 380c56.5 56.5 148 56.5 204.5 0L579.8 267.7zM60.2 244.3c-56.5 56.5-56.5 148 0 204.5c50 50 128.8 56.5 186.3 15.4l1.6-1.1c14.4-10.3 17.7-30.3 7.4-44.6s-30.3-17.7-44.6-7.4l-1.6 1.1c-32.1 22.9-76 19.3-103.8-8.6C74 372 74 321 105.5 289.5L217.7 177.2c31.5-31.5 82.5-31.5 114 0c27.9 27.9 31.5 71.8 8.6 103.9l-1.1 1.6c-10.3 14.4-6.9 34.4 7.4 44.6s34.4 6.9 44.6-7.4l1.1-1.6C433.5 260.8 427 182 377 132c-56.5-56.5-148-56.5-204.5 0L60.2 244.3z"/></svg>
							</div>
							<div class="sm:pl-8 sm:pt-8 w-full">
								<h4 class="font-semibold text-indextitle leading-tight reveal fade-icon">Search Engine Friendly</h4>
								<div class="h-2px bg-secondarycolor reveal fade-icon mt-2"></div>
								<p class="text-body mt-8 reveal fade-icon">Create search engine friendly URLs for all your products so they get discovered on Google.</p>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>

		<div class="section-f lg:pb-0"> <!--blue-and-pink-ribbon-section-->
			<div class="container aligner flex-col text-center pt-36 pb-24 lg:pt-24 lg:pb-0 md:px-10">
				<h1 class="index-heading reveal fade-right">Expert support</h1>
				<p class="px-5 pt-4 reveal fade-left w-4/5">Live customer support from people who care.</p>
			</div>

			<div class="aligner text-center reveal fade-icon">
				<picture class="w-full lg:w-70" style="max-width:1024px">
					<source srcset="{{asset('images/team-new.webp')}} 1024w, {{asset('images/team-new_w1000.webp')}} 1000w, {{asset('images/team-new_w750.webp')}} 750w, {{asset('images/team-new_w500.webp')}} 500w" type="image/webp">
					<source srcset="{{asset('images/team-new.png')}} 1024w, {{asset('images/team-new_w1000.jpg')}} 1000w, {{asset('images/team-new_w750.jpg')}} 750w, {{asset('images/team-new_w500.jpg')}} 500w" type="image/jpeg">
					<img src="{{asset('images/team-new_w750.webp')}}" alt="webstarts support team employees" loading="lazy">
				</picture>
			</div>
		</div>

		<!-- Optimized For Mobile -->
		<!-- <div class="section-j">
			<div class="aligner pt-36 py-16 lg:py-20">
				<div class="features-column gap-5 lg:gap-20">
					<div class="pl-4 md:pl-16 pt-0 lg:pt-20 xl:pt-40 pr-20px lg:col-span-4">
						<h1 class="index-heading reveal animate-left">Optimized For Mobile</h1>
						<p class="text-body mt-8 reveal animate-left">Not only will you be able to create a version of your website that looks great on mobile but you'll be able to make edits while on the go directly from your phone.</p>
					</div>

					<div class="lg:col-span-3 lg:-mt-10 reveal animate-right">
						<div class="aligner text-center">
							<picture>
								<source srcset="{{asset('images/Webp/optimized-for-mobile-editor_w1500.webp')}} 1500w, {{asset('images/Webp/optimized-for-mobile-editor_w1000.webp')}} 1000w, {{asset('images/Webp/optimized-for-mobile-editor_w750.webp')}} 750w, {{asset('images/Webp/optimized-for-mobile-editor_w500.webp')}} 500w, {{asset('images/optimized-for-mobile-editor_w300.webp')}} 300w" type="image/webp">
								<source srcset="{{asset('images/Jpeg/optimized-for-mobile-editor_w750.jpg')}} 1500w, {{asset('images/Jpeg/optimized-for-mobile-editor_w750.jpg')}} 1000w, {{asset('images/Jpeg/optimized-for-mobile-editor_w750.jpg')}} 750w,{{asset('images/Jpeg/optimized-for-mobile-editor_w500.jpg')}} 500w, {{asset('images/Jpeg/optimized-for-mobile-editor_w300.jpg')}} 300w" type="image/jpeg">
								<img src="{{asset('images/Jpeg/optimized-for-mobile-editor_w750.jpg')}}" alt="apps mobile view" loading="lazy">
							</picture>
						</div>
					</div>
				</div>
			</div>
		</div> -->
		<!-- Optimized For Mobile -->


		<!-- Most Styles -->
		<div class="section-k bg-primarycolor">
			<div class="aligner py-12 lg:py-20">
				<div class="features-column">
					<div class="lg:pr-4 pl-4 lg:pl-16 lg:pt-0 pt-4 xl:pt-20 lg:col-span-3 lg:order-last order-first text-white">
						<h1 class="index-heading reveal animate-right">Sell Products</h1>
						<p class="text-body mt-8 reveal fade-right">Create your very own online store. Accept credit card payments. Sell both physical and digital products and a whole lot more.</p>
					</div>

					<div class="lg:col-span-4 reveal animate-left pt-10 lg:pt-4 order-last lg:order-first px-5 xl:px-10 2xl:px-16 lg:pt-0 active">
						<div class="aligner text-center xl:px-5">
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
		<!-- Most Styles -->

		{{-- Sell Digital Goods --}}
	<div class="section-e multicolor-ribbon-2-section">
		<div class="aligner pt-10 xl:pt-28">
			<div class="features-column">
				<div class="lg:pl-20 lg:pr-20px lg:pt-10 xl:pt-20 2xl:pt-40 pt-0 lg:col-span-4">
					<h1 class="index-heading reveal animate-left">
						Sell Digital Goods
					</h1>
					<p class="pt-4 reveal fade-left">Sell products like audio, video, media, software, and ebooks and deliver them digitally.</p>
					<img class="mt-6 xl:max-w-960px img-shadow rounded-sm-img hidden lg:block" src="{{asset('images/digital-delivery.png')}}" alt="digital delivery">
				</div>

				<div class="lg:col-span-3 reveal animate-right">
					<img class="hidden lg:block" src="{{asset('images/hispanic-woman.png')}}" loading="lazy" alt="sell digital items">
					<img class="lg:hidden block mt-20" src="{{asset('images/digital-delivery-graphics.png')}}" loading="lazy" alt="sell digital goods">
				</div>
			</div>
		</div>
	</div>
		{{-- Sell Digital Goods --}}


		<div class="section-p">
			<section id="faq_section" class="aligner px-8 lg:px-4rem py-12">
				<div class="faq_container">

					<div class="faq">
						<div class="faq_question" id="faqOne">
							<button class="faq_classes" data-parent="#faq_section" href="#answerOne" aria-expanded="false" aria-controls="answerOne">
								<h4>Why in the world does Webstarts offer completely free websites?</h4>
								<i class="material-icons">expand_more</i>
							</button>
						</div>

						<div id="answerOne" class="faq_answer_container" role="region" aria-labelledby="faqOne">
							<div class="faq_answer">
								<p> We give you a completely free website because we know when you see how easy it is to build powerful, professional looking websites with our tools you'll want to upgrade your site to unlock even more premium features. Get started building your very own free website at <a class="text-primarycolor" href="/">www.WebStarts.com.</a></p>
							</div>
						</div>
						<hr>
					</div>


					<div class="faq">
						<div class="faq_question" id="faqThree">
							<button class="faq_classes" data-parent="#faq_section" href="#answerThree" aria-expanded="false" aria-controls="answerThree">
								<h4>Can I add ecommerce and accept credit card payments on my Webstarts website?</h4>
								<i class="material-icons">expand_more</i>
							</button>
						</div>

						<div id="answerThree" class="faq_answer_container" role="region" aria-labelledby="faqThree">
							<div class="faq_answer">
								<p>Yes, you can add e-commerce to your WebStarts website and will be able to take payments from all major credit cards and even PayPal.</p>
							</div>
						</div>
						<hr>
					</div>

					<div class="faq">
						<div class="faq_question" id="faqFour">
							<button class="faq_classes" data-parent="#faq_section" href="#answerFour" aria-expanded="false" aria-controls="answerFour">
								<h4>How will the website I build with WebStarts look on a mobile phone?</h4>
								<i class="material-icons">expand_more</i>
							</button>
						</div>

						<div id="answerFour" class="faq_answer_container" role="region" aria-labelledby="faqFour">
							<div class="faq_answer">
								<p>Amazing! You will be able to create a version of your website specifically designed to look great on the smaller screens of a mobile device or set our mobile editor to automatically create it for you.</p>
							</div>
						</div>
						<hr>
					</div>

					<div class="faq">
						<div class="faq_question" id="faqFive">
							<button class="faq_classes" data-parent="#faq_section" href="#answerFive" aria-expanded="false" aria-controls="answerFive">
								<h4>Will my Webstarts website show up on Google, Yahoo, Bing, and other search engines?</h4>
								<i class="material-icons">expand_more</i>
							</button>
						</div>

						<div id="answerFive" class="faq_answer_container" role="region" aria-labelledby="faqFive">
							<div class="faq_answer">
								<p>Yes, your WebStarts website will show up on Google, Yahoo, Bing, and other search engines. When you upgrade your site to a paid subscription you get accesss to even more search engine optimization features.</p>
							</div>
						</div>
						<hr>
					</div>

					<div class="faq">
						<div class="faq_question" id="faqEight">
							<button class="faq_classes" data-parent="#faq_section" href="#answerEight" aria-expanded="false" aria-controls="answerEight">
								<h4>How can I create my store?</h4>
								<i class="material-icons">expand_more</i>
							</button>
						</div>

						<div id="answerEight" class="faq_answer_container" role="region" aria-labelledby="faqEight">
							<div class="faq_answer">
								<p>If you're looking to make a website to support your online store you can do that with WebStarts too. Just go to <a href="https://www.webstarts.com">WebStarts.com</a> and sign up for a free account. Webstarts is everything you need to create a website in the cloud. It's your hosting, domain name, and design tools all-in-one. You don't need to know how to code. Drag and drop elements where you want them to appear. It's that easy.</p>
								<div class="w-80 justify-center flex p-10">
								<iframe loading="lazy" class="youtube-video w-90 lg:w-70 p-5 md:p-12 h-230px sm:h-450px md:h-500px" src="https://www.youtube.com/embed/1m-lN41nmzM" title="Create A Free Online Store with WebStarts" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
								</div>
							</div>
						</div>
						<hr>
					</div>

				</div>
			</section>
		</div>

		<div id="stickyButton" class="justify-center sticky mt-8 bottom-20px z-9999 flex md:hidden reveal fade-bottom">
			<a href="https://www.webstarts.com/designs/online-store" class="m-0 w-90 block btn btn-lg btn-raised btn-secondary">Sign Up - It's Free</a>
		</div>

	</section>

@include('footer')
{!! Meta::footer()->toHtml() !!}
</body>
</html>