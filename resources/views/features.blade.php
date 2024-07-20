<!DOCTYPE html>
<html lang="en">
<head>
	{!! Meta::toHtml() !!}
</head>
<body class="bg-white font-body">
	@include('fixed-header')
	<section id="index-features-page">
		<!-- Webstarts Features -->
		<div class="section-a main-section top-section-height">
			<div class="aligner">
				<div class="main-section-row">
					<div class="main-section-text-column">
						<h1 class="main-section-heading reveal animate-left">
							Powerful Features For Professional Websites
						</h1>
						<p class="main-section-paragraph reveal fade-left">Everything you need to create a website, grow and manage your business online. WebStarts has more integrated features than other website builders.</p>
						<div class="main-section-button">
							<a href="/signup" class="m-0 w-210px block btn btn-lg btn-raised btn-secondary">Sign Up - It's Free</a>
						</div>
					</div>
					<div class="main-section-image-column-home reveal animate-right">
						<div class="image-align-bottom">
							<picture>
								<source srcset="{{ asset('images/man-working-on-his-phone_w1000.webp') }} 1000w, {{ asset('images/man-working-on-his-phone_w750.webp') }} 750w, {{ asset('images/man-working-on-his-phone_w500.webp') }} 500w" type="image/webp">
								<source srcset="{{ asset('images/man-working-on-his-phone_w1000.jpg') }} 1000w, {{ asset('images/man-working-on-his-phone_w750.png') }} 750w, {{ asset('images/man-working-on-his-phone_w500.png') }} 500w" type="image/png">
								<img class="w-auto -z-1" src="{{ asset('images/man-working-on-his-phone_w750.png') }}" alt="powerful features for websites">
							</picture>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Webstarts Features -->

		<!-- Drag And Drop -->
		<div class="section-b bg-graysection">
			<div class="aligner">
				<div class="features-column lg:grid-cols-7 py-24">
					<div class="features-left-image-column lg:col-span-3 lg:pr-16 pt-0 2xl:pt-20 lg:pl-0 lg:order-last order-first">
						<div class="text-left lg:text-right lg:max-w-650px">
							<h1 class="index-heading reveal animate-right">True Drag And Drop Editing</h1>
							<p class="pt-4 reveal fade-right">While others claim to be drag and drop they limit you to dragging elements into predetermined locations on the page. WebStarts is a true drag and drop, visual, page editor that allows you to place elements wherever you want them to appear, allowing you to create a truly unique design.</p>
						</div>
					</div>

					<div class="features-right-text-column lg:col-span-4 sm:pr-0 sm:pt-0 reveal animate-left">
						<div class="lg:px-5">
							<video class="rounded-sm-img" width="100%" autoplay loop muted playsinline>
								<source src="{{ asset('videos/drag-and-drop-gif.mp4') }}" type="video/mp4" />
								<img class="rounded-sm-img" src="{{ asset('images/drag-and-drop-gif_w750.gif') }}" srcset="{{ asset('images/drag-and-drop-gif.gif') }} 1785w, {{ asset('images/drag-and-drop-gif_w1024.gif') }} 1024w, {{ asset('images/drag-and-drop-gif_w500.gif') }} 750w, {{ asset('images/drag-drop_w500.gif') }} 500w" alt="drag and drop editing" loading="lazy">
							</video>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Drag And Drop -->

		<!-- Mobile Ready -->
		<div class="section-c">
			<div class="aligner pt-12">
				<div class="features-column lg:grid-cols-7">
					<div class="features-left-image-column lg:col-span-3 md:px-0 lg:pr-0 lg:pl-16 md:pt-0 lg:pt-40">
						<h1 class="index-heading reveal animate-left">
							Create Stunning Mobile Websites
						</h1>
						<p class="pt-4 reveal fade-left">Create a mobile version of your website in a few clicks from your phone using WebStarts AI or make a mobile version of your website using our mobile editor. Every aspect of WebStarts is made to make it easy for you to run your business from your mobile phone while you're on the go.</p>
					</div>
					<div class="lg:col-span-4 reveal animate-right">
						<div class="aligner max-w-600px mx-auto">
							<picture>
								<source srcset="{{ asset('images/stunning-mobile-site.webp') }} 1754w, {{ asset('images/stunning-mobile-site_w1500.webp') }} 1500w, {{ asset('images/stunning-mobile-site_w1000.webp') }} 1000w, {{ asset('images/stunning-mobile-site_w750.webp') }} 750w, , {{ asset('images/stunning-mobile-site_w500.webp') }} 500w" type="image/webp">
								<source srcset="{{ asset('images/stunning-mobile-site.png') }} 1754w, {{ asset('images/stunning-mobile-site_w1500.png') }} 1500w, {{ asset('images/stunning-mobile-site_w1000.png') }} 1000w, {{ asset('images/stunning-mobile-site_w750.png') }} 750w, {{ asset('images/stunning-mobile-site_w500.png') }} 500w" type="image/png">
								<img src="{{ asset('images/stunning-mobile-site_w1500.png') }}" alt="mobile ready website" loading="lazy">
							</picture>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Mobile Ready -->

		<!-- Domain Setup -->
		<div class="section-d pt-28 mt-28 primary-waves-section">
			<div class="aligner">
				<div class="features-column lg:grid-cols-7 py-24">
					<div class="features-left-image-column lg:col-span-3 lg:pr-16 pt-0 2xl:pt-20 lg:pl-0 lg:order-last order-first">
						<div class="text-white text-left lg:text-right lg:max-w-650px">
							<h1 class="index-heading reveal animate-right">Automatic Domain Setup</h1>
							<p class="pt-4 reveal fade-right">Normally registering and connecting a domain name to your website is painful. With WebStarts registering and connecting a domain name is as easy as finding a domain name you like and clicking continue. There's no painful process.</p>
						</div>
					</div>

					<div class="features-right-text-column lg:col-span-4 sm:pr-0 sm:pt-0 lg:px-5 2xl:px-12 reveal animate-left">
						<picture>
							<source srcset="{{ asset('images/Webp/domain-setup_w1750.webp') }} 1750w, {{ asset('images/Webp/domain-setup_w1500.webp') }} 1500w, {{ asset('images/Webp/domain-setup_w1000.webp') }} 1000w, {{ asset('images/Webp/domain-setup_w750.webp') }} 750w, {{ asset('images/Webp/domain-setup_w500.webp') }} 500w" type="image/webp">
							<source srcset="{{ asset('images/Jpeg/domain-setup_w1750.jpg') }} 1750w, {{ asset('images/Jpeg/domain-setup_w1500.jpg') }} 1500w, {{ asset('images/Jpeg/domain-setup_w1000.jpg') }} 1000w, {{ asset('images/Jpeg/domain-setup_w750.jpg') }} 750w, {{ asset('images/Jpeg/domain-setup_w500.jpg') }} 500w" type="image/jpeg">
							<img src="{{ asset('images/Jpeg/domain-setup_w750.jpg') }}" alt="domain setup" loading="lazy">
						</picture>
					</div>
				</div>
			</div>
		</div>
		<!-- Domain Setup -->

		<!-- Mailboxes -->
		<div class="section-h">
			<div class="aligner pt-10 lg:pt-12">
				<div class="features-column lg:grid-cols-7 gap-20 lg:gap-0">
					<div class="pl-4 lg:pl-16 md:px-0 pt-0 lg:pt-20 2xl:pt-40 lg:mb-10 lg:col-span-3">
						<h1 class="index-heading reveal animate-left">
							A Professional <br> Email Address
						</h1>
						<p class="pt-4 reveal fade-left">With WebStarts you can create a professional looking email address that matches your domain name. This lets your clients know you're serious about your business.</p>
					</div>
					<div class="lg:col-span-4 pt-10 lg:px-24 xl:px-36 lg:pt-0 self-end reveal animate-right">
						<div class="aligner items-end">
							<picture>
								<source srcset="{{asset('images/a-profesional-email-address.webp')}} 1151w, {{asset('images/a-profesional-email-address_w1000.webp')}} 1000w, {{asset('images/a-profesional-email-address_w750.webp')}} 750w, {{asset('images/a-profesional-email-address_w500.webp')}} 300w" type="image/webp">
								<source srcset="{{asset('images/a-profesional-email-address.png')}} 1151w, {{asset('images/a-profesional-email-address_w1000.png')}} 1000w, {{asset('images/a-profesional-email-address_w750.png')}} 750w, {{asset('images/a-profesional-email-address_w500.png')}} 300w" type="image/png">
								<img src="{{asset('images/a-profesional-email-address_w1000.png')}}" alt="professional email address" loading="lazy">
							</picture>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Mailboxes -->

		<!-- Escape the office -->
		<div class="section-e bg-darkgraysection">
			<div class="aligner pt-20 xl:pt-28 lg:px-0 md:px-20">
				<div class="flex flex-col lg:flex-row gap-10 lg:gap-20">

					<div class="self-center lg:w-4/9 reveal animate-right lg:order-last order-first">
						<div class="text-left lg:text-right lg:pr-16 px-10 pt-0 2xl:pt-20 lg:mb-10 text-white">
							<h1 class="index-heading">Escape The Office And Work On The Go</h1>
							<p class="pt-4 reveal fade-left">There's no software to install, no uploading and downloading of web pages. Simply login from any connected device and make edits to your site.</p>
						</div>
					</div>

					<div class="self-end xl:max-w-1000px lg:w-5/9 order-last lg:order-first">
						<div class="reveal animate-left">
							<picture>
								<source srcset="{{ asset('images/escape-from-the-office_w1000.webp') }} 1000w, {{ asset('images/escape-from-the-office_w750.webp') }} 750w, {{ asset('images/escape-from-the-office_w500.webp') }} 500w, {{ asset('images/escape-from-the-office_w300.webp') }} 300w, {{ asset('images/escape-from-the-office_w100.webp') }} 100w" type="image/webp">
								<source srcset="{{ asset('images/escape-from-the-office_w1000.png') }} 1835w, {{ asset('images/escape-from-the-office_w750.png') }} 750w, {{ asset('images/escape-from-the-office_w500.png') }} 500w, {{ asset('images/escape-from-the-office_w300.png') }} 300w, {{ asset('images/escape-from-the-office_w100.png') }} 100w" type="image/png">
								<img class="relative" src="{{ asset('images/escape-from-the-office_w1000.png') }}" alt="work on the go" loading="lazy">
							</picture>
						</div>
					</div>

				</div>
			</div>
		</div>
		<!-- Escape the office -->

		<!-- Powerful Forms -->
		<div class="section-f">
			<div class="aligner py-16 lg:py-12">
				<!-- <div class="flex flex-col xl:flex-row lg:flex-row w-full gap-y-8 justify-between flex-wrap">

					<div class="flex-1 relative self-center">
						<div class="pl-4 lg:pl-16 pr-20px lg:pt-10 md:pr-16">
							<h1 class="index-heading reveal animate-left">
								Capture Leads And Create Workflows
							</h1>
							<p class="pt-4 reveal fade-left">Add custom forms to your web pages to do everything from <br> capture leads to create custom workflows.</p>
						</div>
					</div>

					<div class="flex-1 md:shrink-0 self-end reveal animate-right">
						<picture>
							<source srcset="{{ asset('images/blue-chalk-explosion-forms-graphics.webp') }} 1024w, {{ asset('images/blue-chalk-explosion-forms-graphics_w1000.webp') }} 1000w, {{ asset('images/blue-chalk-explosion-forms-graphics_w750.webp') }} 750w, {{ asset('images/blue-chalk-explosion-forms-graphics_w500.webp') }} 500w" type="image/webp">
							<source srcset="{{ asset('images/blue-chalk-explosion-forms-graphics.png') }} 1024w, {{ asset('images/blue-chalk-explosion-forms-graphics_w1000.png') }} 1000w, {{ asset('images/blue-chalk-explosion-forms-graphics_w750.png') }} 750w, {{ asset('images/blue-chalk-explosion-forms-graphics_w500.png') }} 500w" type="image/png">
							<img src="{{ asset('images/blue-chalk-explosion-forms-graphics_w1000.png') }}" alt="Forms to capture leads & create workflows" loading="lazy">
						</picture>
					</div>
				</div> -->
				<div class="features-column lg:grid-cols-7 gap-20 lg:gap-0">
					<div class="pl-4 lg:pl-16 md:px-0 pt-0 lg:pt-10 xl:pt-20 xl:pr-36 lg:pr-20 lg:col-span-3">
						<h1 class="index-heading reveal animate-left">Capture Leads And Create Workflows</h1>
						<p class="pt-4 reveal fade-left">Add custom forms to your web pages to do everything from <br> capture leads to create custom workflows.</p>
					</div>
					<div class="lg:col-span-4 pt-10 lg:px-24 lg:pt-0 reveal animate-right">
						<div class="aligner">
							<picture>
								<source srcset="{{ asset('images/blue-chalk-explosion-forms-graphics.webp') }} 1024w, {{ asset('images/blue-chalk-explosion-forms-graphics_w1000.webp') }} 1000w, {{ asset('images/blue-chalk-explosion-forms-graphics_w750.webp') }} 750w, {{ asset('images/blue-chalk-explosion-forms-graphics_w500.webp') }} 500w" type="image/webp">
								<source srcset="{{ asset('images/blue-chalk-explosion-forms-graphics.png') }} 1024w, {{ asset('images/blue-chalk-explosion-forms-graphics_w1000.png') }} 1000w, {{ asset('images/blue-chalk-explosion-forms-graphics_w750.png') }} 750w, {{ asset('images/blue-chalk-explosion-forms-graphics_w500.png') }} 500w" type="image/png">
								<img src="{{ asset('images/blue-chalk-explosion-forms-graphics_w1000.png') }}" alt="Forms to capture leads & create workflows" loading="lazy">
							</picture>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Powerful Forms -->

		<!-- Eye Catching Effects -->
		<div class="section-g bg-graysection">
			<div class="aligner py-16 lg:py-12">
				<div class="grid features-column items-center">

					<div class="pl-4 lg:pl-16 pr-20px lg:pt-10 xl:pt-32 md:px-0 lg:col-span-3 lg:order-last order-first">
						<div class="text-left lg:text-right">
							<h1 class="index-heading reveal animate-right">Eye Catching Effects</h1>
							<p class="pt-4 reveal fade-right">Make your site pop with animations, hover-over, and parallax effects.</p>
						</div>
					</div>

					<div class="relative lg:col-span-4 reveal animate-left lg:pr-4 pt-10 lg:pt-0 order-last lg:order-first">
						<img src="{{asset('images/background-smoke.png')}}" alt="eye catching effects" loading="lazy">
						<div class="absolute top-20 xl:px-16 pt-5 sm:px-10 px-5">
							<video class="rounded-img" width="100%" autoplay loop muted playsinline>
								<source src="{{ asset('videos/meadow-effect.mp4') }}" type="video/mp4" />
								<img class="rounded-img" src="{{ asset('images/meadow-effect_w750.gif') }}" srcset="{{ asset('images/meadow-effect.gif') }} 1920w, {{ asset('images/meadow-effect_w1024.gif') }} 1024w, {{ asset('images/meadow-effect_w750.gif') }} 750w, {{ asset('images/meadow-effect_w500.gif') }} 500w" alt="effects" loading="lazy">
							</video>
						</div>
					</div>

				</div>
			</div>
		</div>
		<!-- Eye Catching Effects -->

		<!-- Slideshows -->
		<div class="section-i">
			<div class="aligner py-40 lg:py-36">
				<div class="features-column lg:grid-cols-7 gap-20 lg:gap-0">
					<div class="pl-4 lg:pl-16 md:px-0 pt-0 lg:pt-10 xl:pt-20 xl:pr-36 lg:pr-20 lg:col-span-3">
						<h1 class="index-heading reveal animate-left">Slideshows</h1>
						<p class="pt-4 reveal fade-left">Add interactivity to your website while displaying photos and images with a custom slideshow.</p>
					</div>
					<div class="lg:col-span-4 pt-10 lg:px-24 lg:pt-0 reveal animate-right">
						<div class="aligner">
							<picture>
								<source srcset="{{ asset('images/slideshow_w1920.webp') }} 1920w, {{ asset('images/slideshow_w1500.webp') }} 1500w, {{ asset('images/slideshow_w1000.webp') }} 1000w, {{ asset('images/slideshow_w750.webp') }} 750w, {{ asset('images/slideshow_w500.webp') }} 500w" type="image/webp">
								<source srcset="{{ asset('images/slideshow_w1920.png') }} 1920w, {{ asset('images/slideshow_w1500.png') }} 1500w, {{ asset('images/slideshow_w1000.png') }} 1000w, {{ asset('images/slideshow_w750.png') }} 750w, {{ asset('images/slideshow_w500.png') }} 500w" type="image/png">
								<img src="{{ asset('images/slideshow_w750.png') }}" alt="slideshow" loading="lazy">
							</picture>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Slideshows -->

		<!-- Photo Gallery -->
		<div class="section-j bg-primarycolor">
			<div class="aligner">
				<div class="features-column lg:grid-cols-7 py-24">
					<div class="features-left-image-column lg:col-span-3 lg:pr-16 pt-0 2xl:pt-20 lg:pl-0 lg:order-last order-first">
						<div class="text-white text-left lg:text-right lg:max-w-650px">
							<h1 class="index-heading reveal animate-right">Photo Galleries</h1>
							<p class="pt-4 reveal fade-right">Show off your work visually with a photo gallery. With WebStarts you can create a variety of styles as well as add titles and descriptions to each of your photos.</p>
						</div>
					</div>

					<div class="features-right-text-column lg:col-span-4 sm:pr-0 sm:pt-0 lg:px-24 reveal animate-left">
						<picture>
							<source srcset="{{ asset('images/photo-gallery.webp') }} 1920w, {{ asset('images/photo-gallery_w1024.webp') }} 1024w, {{ asset('images/photo-gallery_w1000.webp') }} 1000w, {{ asset('images/photo-gallery_w750.webp') }} 750w, {{ asset('images/photo-gallery_w500.webp') }} 500w" type="image/webp">
							<source srcset="{{ asset('images/photo-gallery.png') }} 1920w, {{ asset('images/photo-gallery_w1024.png') }} 1024w, {{ asset('images/photo-gallery_w1000.jpg') }} 1000w, {{ asset('images/photo-gallery_w750.jpg') }} 750w, {{ asset('images/photo-gallery_w500.jpg') }} 500w" type="image/png">
							<img src="{{ asset('images/photo-gallery_w1000.png') }}" alt="Photo Galleries" loading="lazy">
			  			</picture>
					</div>
				</div>
			</div>
		</div>
		<!-- Photo Gallery -->

		<!-- Animation Effect -->
		<div class="section-k">
			<div class="aligner py-12 pb-0">
				<div class="features-column">
					<div class="pl-4 lg:pl-16 md:px-0 pt-0 lg:pt-10 xl:pt-20 xl:pr-36 lg:pr-20 lg:col-span-3">
						<h1 class="index-heading reveal animate-left">Animation Effects</h1>
						<p class="pt-4 reveal fade-left">WebStarts helps you create visual interest by adding movement to your design elements. Choose from dozens of animations and effects.</p>
					</div>
					<div class="lg:col-span-4 reveal animate-right pt-10 lg:pt-0 md:px-20 lg:px-24">
						<video class="rounded-img" width="100%" autoplay loop muted playsinline>
							<source src="{{ asset('videos/animations-gif.mp4') }}" type="video/mp4" />
							<img src="{{ asset('images/animations-gif_w750.gif') }}" srcset="{{ asset('images/animations-gif.gif') }} 1326w, {{ asset('images/animations-gif_w1024.gif') }} 1024w, {{ asset('images/animations-gif_w750.gif') }} 750w, {{ asset('images/animations-gif_w500.gif') }} 500w" alt="animation effects" loading="lazy">
						</video>
					</div>
				</div>
			</div>
		</div>
		<!-- Animation Effect -->

		<!-- Calendars -->
		<div class="section-l bg-darkgraysection">
			<div class="aligner py-16">
				<div class="features-column lg:grid-cols-7 py-24">
					<div class="features-left-image-column lg:col-span-3 lg:pr-16 pt-0 2xl:pt-20 lg:pl-0 lg:order-last order-first">
						<div class="text-white text-left lg:text-right lg:max-w-650px">
							<h1 class="index-heading reveal animate-right">Calendars</h1>
							<p class="pt-4 reveal fade-right">Share events on your website with a public Calendar. <br>Customize it to display by day, week, or month.</p>
						</div>
					</div>
					<div class="features-right-text-column lg:col-span-4 sm:pr-0 sm:pt-0 lg:px-24 reveal animate-left">
						<picture>
							<source srcset="{{ asset('images/calendar-add-event.webp') }} 1361w, {{ asset('images/calendar-add-event_w1000.webp') }} 1000w, {{ asset('images/calendar-add-event_w750.webp') }} 750w, {{ asset('images/calendar-add-event_w500.webp') }} 500w" type="image/webp">
							<source srcset="{{ asset('images/calendar-add-event.png') }} 1361w, {{ asset('images/calendar-add-event_w1000.png') }} 1000w, {{ asset('images/calendar-add-event_w750.png') }} 750w, {{ asset('images/calendar-add-event_w500.jpg') }} 500w" type="image/png">
							<img src="{{ asset('images/calendar-add-event_w1000.png') }}" alt="calendars view" loading="lazy">
						</picture>
					</div>
				</div>
			</div>
		</div>
		<!-- Calendars -->

		<!-- Maps and Directions -->
		<div class="section-m py-16">
			<div class="aligner">
				<div class="features-column">
					<div class="pl-4 lg:pl-16 md:px-0 pt-0 lg:pt-10 xl:pt-20 xl:pr-36 lg:pr-20 lg:col-span-3">
						<h1 class="index-heading reveal animate-left">Maps And Directions</h1>
						<p class="pt-4 reveal fade-left">Help your customers find your location with direction maps. Customize your maps and display either map or satellite views.</p>
					</div>
					<div class="lg:col-span-4 pt-10 lg:pt-0 md:px-6 lg:px-10 reveal animate-right">
						<picture>
							<source srcset="{{ asset('images/maps-and-direction_w1500.webp') }} 1500w, {{ asset('images/maps-and-direction_w1000.webp') }} 1000w, {{ asset('images/maps-and-direction_w750.webp') }} 750w, {{ asset('images/maps-and-direction_w500.webp') }} 500w" type="image/webp">
							<source srcset="{{ asset('images/maps-and-direction_w1500.png') }} 1500w, {{ asset('images/maps-and-direction_w1000.png') }} 1000w, {{ asset('images/maps-and-direction_w750.png') }} 750w, {{ asset('images/maps-and-direction_w500.png') }} 500w" type="image/png">
							<img src="{{ asset('images/maps-and-direction_w750.png') }}" alt="Maps & direction" loading="lazy">
						</picture>
					</div>
				</div>
			</div>
		</div>
		<!-- Maps and Directions -->

		<!-- PDFs & Documents -->
		<div class="section-n bg-darkgraysection">
			<div class="aligner pt-20">
				<div class="features-column">
					<div class="lg:col-span-3 text-white lg:order-last order-first">
						<div class="text-left lg:text-right xl:pt-16 lg:pt-10 lg:pl-16 lg:pr-16">
							<h1 class="index-heading reveal animate-right">PDFs & Documents</h1>
							<p class="pt-4 reveal fade-right">Share documents with your clients directly from your website. WebStarts supports the most popular file types like PDFs, Word, Excel, Google Docs, and more.</p>
						</div>
					</div>

					<div class="self-end lg:col-span-4 pt-12 lg:pt-0 md:px-6 lg:px-18 order-last lg:order-first">
						<div class="reveal animate-left">
							<picture>
								<source srcset="{{ asset('images/a-man-holding-ipad-pdf.webp') }} 766w, {{ asset('images/a-man-holding-ipad-pdf_w750.webp') }} 750w, {{ asset('images/a-man-holding-ipad-pdf_w500.webp') }} 500w" type="image/webp">
								<source srcset="{{ asset('images/a-man-holding-ipad-pdf.png') }} 766w, {{ asset('images/a-man-holding-ipad-pdf_w750.png') }} 750w, {{ asset('images/a-man-holding-ipad-pdf_w500.png') }} 500w" type="image/webp">
								<img class="max-w-600px" src="{{ asset('images/a-man-holding-ipad-pdf.png') }}" alt="Documents & PDFs" loading="lazy">
							</picture>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- PDFs & Documents -->

		<!-- Chats -->
		<div class="section-o bg-graysection">
			<div class="aligner py-12">
				<div class="features-column lg:grid-cols-7">
					<div class="features-left-image-column lg:col-span-3 md:px-0 lg:pr-0 lg:pl-16 md:pt-0 lg:pt-40">
						<h1 class="index-heading reveal animate-left">Chat</h1>
						<p class="pt-4 reveal fade-left">Make it easy for your customers to get the help they want, when they want with online chat powered by WebStarts.</p>
					</div>
					<div class="lg:col-span-4 reveal animate-right">
						<div class="aligner max-w-600px mx-auto">
							<picture>
								<source srcset="{{ asset('images/smoke-chat-mobile.webp') }} 1454w, {{ asset('images/smoke-chat-mobile_w1000.webp') }} 1000w, {{ asset('images/smoke-chat-mobile_w750.webp') }} 750w, {{ asset('images/smoke-chat-mobile_w500.webp') }} 500w" type="image/webp">
								<source srcset="{{ asset('images/smoke-chat-mobile.png') }} 1454w, {{ asset('images/smoke-chat-mobile_w1000.png') }} 1000w, {{ asset('images/smoke-chat-mobile_w750.png') }} 750w, {{ asset('images/smoke-chat-mobile_w500.png') }} 500w" type="image/png">
								<img src="{{ asset('images/images/smoke-chat-mobile_w1000.png') }}" alt="Chat view on mobile" loading="lazy">
							</picture>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Chats -->

		<!-- Music Playlists & Store -->
		<!-- Mobile View -->
		<div class="section-p lg:hidden block" style="background:black;">
			<div class="aligner py-12 lg:pt-48">
				<div class="features-column">
					<div class="text-white pl-4 md:pl-16 pr-20px xl:pt-20 lg:col-span-4">
						<h1 class="index-heading reveal animate-left">
							Awesome Audio Players
						</h1>
						<p class="pt-4 reveal fade-left">Share a single audio file on your website or an entire playlist. You can even sell music and other audio files through your very own music store.</p>
						<picture>
							<source srcset="{{ asset('images/audio-player_w750.webp') }} 750w, {{ asset('images/audio-player_w500.webp') }} 500w, {{ asset('images/audio-player_w300.webp') }} 300w" type="image/webp">
							<source srcset="{{ asset('images/audio-player_w750.png') }} 750w, {{ asset('images/audio-player_w500.png') }} 500w, {{ asset('images/audio-player_w300.png') }} 300w" type="image/png">
							<img class="mt-8 img-shadow rounded-sm-img" src="{{ asset('images/audio-player_w750.png') }}" alt="Music player" loading="lazy">
						</picture>
					</div>

					<div class="aligner lg:col-span-4 reveal animate-right px-10 sm:px-20 lg:pt-0">
						<picture>
							<source srcset="{{ asset('images/audio-graphics_w734.webp') }} 734w, {{ asset('images/audio-graphics_w500.webp') }} 500w, {{ asset('images/audio-graphics_w300.webp') }} 300w" type="image/webp">
							<source srcset="{{ asset('images/audio-graphics_w734.png') }} 734w, {{ asset('images/audio-graphics_w500.png') }} 500w, {{ asset('images/audio-graphics_w300.png') }} 300w" type="image/png">
							<img src="{{ asset('images/audio-graphics_w734.png') }}" alt="Music graphics" loading="lazy">
						</picture>
					</div>
				</div>
			</div>
		</div>
		<!-- Desktop View -->
		<div class="section-p hidden lg:block bg-black">
			<div class="aligner py-12">
				<div class="features-column lg:grid-cols-8">
					<div class="relative aligner lg:col-span-4 lg:px-20 lg:pt-0">
						<div class="reveal animate-left">
							<picture>
								<source srcset="{{ asset('images/audio-graphics_w734.webp') }} 734w, {{ asset('images/audio-graphics_w500.webp') }} 500w, {{ asset('images/audio-graphics_w300.webp') }} 300w" type="image/webp">
								<source srcset="{{ asset('images/audio-graphics_w734.png') }} 734w, {{ asset('images/audio-graphics_w500.png') }} 500w, {{ asset('images/audio-graphics_w300.png') }} 300w" type="image/png">
								<img src="{{ asset('images/audio-graphics_w734.png') }}" alt="Music graphics" loading="lazy">
							</picture>
						</div>
					</div>

					<div class="text-white lg:col-span-4">
						<div class="pr-4 md:pr-16 pl-20px 2xl:pt-20">
							<h1 class="index-heading text-right reveal animate-right">Awesome Audio Players</h1>
							<p class="pt-4 text-right reveal fade-right">Share a single audio file on your website or an entire playlist. You can even sell music and other audio files through your very own music store.</p>
							<div class="lg:ml-auto mt-8 max-w-750px">
								<picture>
									<source srcset="{{ asset('images/audio-player_w750.webp') }} 750w, {{ asset('images/audio-player_w500.webp') }} 500w, {{ asset('images/audio-player_w300.webp') }} 300w" type="image/webp">
									<source srcset="{{ asset('images/audio-player_w750.png') }} 750w, {{ asset('images/audio-player_w500.png') }} 500w, {{ asset('images/audio-player_w300.png') }} 300w" type="image/png">
									<img class="img-shadow rounded-sm-img" src="{{ asset('images/audio-player_w750.png') }}" alt="Music player" loading="lazy">
								</picture>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Music Playlists & Store -->

		<!-- Videos -->
		<div class="section-q">
			<div class="aligner py-12">
				<div class="features-column lg:grid-cols-7">
					<div class="features-left-image-column lg:col-span-3 md:px-0 lg:pr-0 lg:pl-16 md:pt-0 lg:pt-28">
						<h1 class="index-heading reveal animate-left">Videos</h1>
						<p class="pt-4 reveal fade-left">Search the integrated video library, youtube, or upload your own videos directly to your website with WebStarts.</p>
					</div>
					<div class="lg:col-span-4 reveal animate-right">
						<div class="aligner lg:mx-16 xl:mx-12 mx-auto">
							<picture>
								<source srcset="{{ asset('images/video-graphics_w1920.webp') }} 1920w, {{ asset('images/video-graphics_w1500.webp') }} 1500w, {{ asset('images/video-graphics_w1000.webp') }} 1000w, {{ asset('images/video-graphics_w750.webp') }} 750w, {{ asset('images/video-graphics_w500.webp') }} 500w" type="image/webp">
								<source srcset="{{ asset('images/video-graphics_w1920.png') }} 1920w, {{ asset('images/video-graphics_w1500.png') }} 1500w, {{ asset('images/video-graphics_w1000.png') }} 1000w, {{ asset('images/video-graphics_w750.png') }} 750w, {{ asset('images/video-graphics_w500.png') }} 500w" type="image/jpeg">
								<img src="{{ asset('images/video-graphics_w750.png') }}" alt="Video library" loading="lazy">
							</picture>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Videos -->

		<!-- Accordions -->
		<div class="section-r bg-graysection">
			<div class="aligner py-16">
				<div class="features-column">
					<div class="lg:col-span-3 lg:order-last order-first">
						<div class="text-left lg:text-right xl:pt-16 lg:pt-10 lg:pl-16 lg:pr-16">
							<h1 class="index-heading reveal animate-right">Expandable Accordions</h1>
							<p class="pt-4 reveal fade-right">Create expandable content sections like FAQs and more.</p>
						</div>
					</div>

					<div class="self-end lg:col-span-4 pt-12 lg:pt-0 md:px-6 lg:px-18 order-last lg:order-first">
						<div class="reveal animate-left">
							<picture>
								<source srcset="{{ asset('images/accordions-phone-smoke_w750.webp') }} 750w, {{ asset('images/accordions-phone-smoke_w500.webp') }} 500w, {{ asset('images/accordions-phone-smoke_w300.webp') }} 300w" type="image/webp">
								<source srcset="{{ asset('images/accordions-phone-smoke_w750.png') }} 750w, {{ asset('images/accordions-phone-smoke_w500.png') }} 500w, {{ asset('images/accordions-phone-smoke_w300.png') }} 300w" type="image/png">
								<img class="max-w-600px" src="{{ asset('images/accordions-phone-smoke_w750.png') }}" alt="Accordions" loading="lazy">
							</picture>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Accordions -->

		<!-- Notifications -->
		<div class="section-s bg-black">
			<div class="aligner py-12">
				<div class="features-column lg:grid-cols-7">
					<div class="features-left-image-column lg:col-span-3 text-white md:px-0 lg:pr-0 lg:pl-16 md:pt-0 lg:pt-28">
						<h1 class="index-heading reveal animate-left">Notifications</h1>
						<p class="pt-4 reveal fade-left">Get notified when someone visits your site, <span class="inline lg:block">completes a form, places an order on your store, and more.</span></p>
					</div>
					<div class="lg:col-span-4 reveal animate-right">
						<div class="aligner lg:mx-24 xl:mx-48 mx-auto">
							<picture>
								<source srcset="{{ asset('images/notifications-panel_w750.webp') }} 750w, {{ asset('images/notifications-panel_w500.webp') }} 500w, {{ asset('images/notifications-panel_w300.webp') }} 300w" type="image/webp">
								<source srcset="{{ asset('images/notifications-panel_w750.png') }} 750w, {{ asset('images/notifications-panel_w500.png') }} 500w, {{ asset('images/notifications-panel_w300.png') }} 300w" type="image/png">
								<img class="lg:max-w-750" src="{{ asset('images/notifications-panel_w750.png') }}" alt="notifications-panel" loading="lazy">
							</picture>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Notifications -->
		<div id="stickyButton" class="justify-center sticky mt-8 bottom-20px z-9999 flex md:hidden reveal fade-bottom">
			<a href="/signup" class="m-0 w-90 block btn btn-lg btn-raised btn-secondary">Sign Up - It's Free</a>
		</div>
	</section>


	@include('footer')
	{!! Meta::footer()->toHtml() !!}
</body>
</html>