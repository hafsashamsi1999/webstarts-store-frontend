<!DOCTYPE html>
<html lang="en-US">
<head>
{!! Meta::toHtml() !!}
</head>
<body class="bg-white font-body">
@include('fixed-header')
<section id="store-features-page">
{{-- Store Features --}}
	<div class="section-a main-section features-and-apps-section top-section-height">
		<div class="aligner">
			<div class="main-section-row">
				<div class="main-section-text-column">
					<h1 class="main-section-heading active animate-left">
						Online Store Features
					</h1>
					<p class="main-section-paragraph reveal fade-left active">Create a fully featured online store. Accept credit card payments and sell both physical and digital products. Everything you need for your own e-commerce business in one place.</p>
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
	</div>
{{-- Store Features --}}
{{-- Product Variants --}}
	<div class="section-b block bg-graysection">
		<div class="aligner features-section py-12">
			<div class="features-column lg:grid-cols-7 gap-0">
				<div class="features-left-image-column lg:col-span-3 lg:pt-10 2xl:pt-20 lg:order-last order-first">
					<div class="text-left lg:text-right">
						<h1 class="index-heading reveal animate-right">
							Product Variants
						</h1>
						<p class="pt-4 reveal fade-right">Sell products with variants like size, color, material, and more.</p>
					</div>
				</div>
				<div class="features-right-text-column lg:col-span-4 md:pr-0 sm:pr-0 lg:pl-5 reveal animate-left">
					<picture>
						<source srcset="{{ asset('images/Webp/product-variants_w1920.webp') }} 1920w, {{ asset('images/Webp/product-variants_w1500.webp') }} 1500w, {{ asset('images/Webp/product-variants_w1000.webp') }} 1000w, {{ asset('images/Webp/product-variants_w750.webp') }} 750w, {{ asset('images/Webp/product-variants_w500.webp') }} 500w" type="image/webp">
						<source srcset="{{ asset('images/Jpeg/product-variants_w1920.jpg') }} 1920w, {{ asset('images/Jpeg/product-variants_w1500.jpg') }} 1500w, {{ asset('images/Jpeg/product-variants_w1000.jpg') }} 1000w, {{ asset('images/Jpeg/product-variants_w750.jpg') }} 750w, {{ asset('images/Jpeg/product-variants_w500.jpg') }} 500w" type="image/jpeg">
						<img src="{{ asset('images/Jpeg/product-variants_w750.jpg') }}" alt="product variants" loading="lazy">
					</picture>
				</div>
			</div>
		</div>
	</div>
{{-- Product Variants --}}
{{-- Mobile E-Commerce --}}
	<div class="section-c relative bg-grey-white">
		<div class="mobile-e-commerce-section">
			<div class="aligner features-section py-32 md:pt-40">
				<div class="features-column">
					<div class="lg:col-span-3 text-white lg:pl-20 pt-0 lg:pt-28 2xl:pt-40 lg:pr-20px">
						<div class="text-left mt-40 lg:mt-0">
							<h1 class="index-heading reveal animate-left">Mobile E-Commerce</h1>
							<p class="pt-4 reveal fade-left">Your store is mobile ready and mobile friendly. That means you can manage your customers, orders, and products while on the go and your customers can shop when they're on the go too.</p>
						</div>
					</div>

					<div class="lg:col-span-4 md:pr-0 sm:pr-0 reveal animate-right">
						<div class="aligner lg:pt-10 pt-0">
							<picture>
								<source srcset="{{ asset('images/Webp/mobile-store-view_w1000.webp') }} 1000w, {{ asset('images/Webp/mobile-store-view_w750.webp') }} 750w, {{ asset('images/Webp/mobile-store-view_w500.webp') }} 500w, {{ asset('images/Webp/mobile-store-view_w300.webp') }} 300w" type="image/webp">
								<source srcset="{{ asset('images/Jpeg/mobile-store-view_w1000.jpg') }} 1000w, {{ asset('images/Jpeg/mobile-store-view_w750.jpg') }} 750w, {{ asset('images/Jpeg/mobile-store-view_w500.jpg') }} 500w, {{ asset('images/Jpeg/mobile-store-view_w300.jpg') }} 300w" type="image/jpeg">
								<img class="max-h-550px lg:max-h-600px xl:max-h-700px" src="{{ asset('images/Jpeg/mobile-store-view_w500.jpg') }}" alt="inventory management view" loading="lazy">
							</picture>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
{{-- Mobile E-Commerce --}}
{{-- Custom Shipping Rules --}}
	<div class="section-d bg-primarycolor">
		<div class="aligner features-section py-32">
			<div class="features-column lg:grid-cols-7 gap-0">
				<div class="features-left-image-column lg:col-span-3 lg:pt-10 2xl:pt-20 lg:order-last order-first">
					<div class="text-white text-left lg:text-right">
						<h1 class="index-heading reveal animate-right">
							Custom Shipping Rules
						</h1>
						<p class="pt-4 reveal fade-right">Create custom shipping rules for any and every market you service around the world.</p>
					</div>
				</div>
				<div class="features-right-text-column lg:col-span-4 md:pr-0 sm:pr-0 lg:pl-5 reveal animate-left">
					<div class="aligner flex flex-col">
						<img class="img-shadow" src="{{asset('images/shipping-rules.png')}}" loading="lazy" alt="custom shipping rules">
						<img class="pt-12 w-70" src="{{asset('images/shipping-logos-white.png')}}" loading="lazy" alt="shipping methods">
					</div>
				</div>
			</div>
		</div>
	</div>
{{-- Custom Shipping Rules --}}
{{-- Sell Digital Goods --}}
	<div class="section-e multicolor-ribbon-2-section">
		<div class="aligner pt-10 lg:pt-36 xl:pt-24">
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
{{-- Returning Customer Login --}}
		<div class="section-f bg-darkgraysection">
			<div class="aligner features-section py-12">
				<div class="features-column lg:grid-cols-7 gap-0">
					<div class="features-left-image-column lg:col-span-3 lg:pt-10 2xl:pt-20 lg:order-last order-first">
						<div class="text-white text-left lg:text-right">
							<h1 class="index-heading reveal animate-right">Returning Customer Login</h1>
							<p class="pt-4 reveal fade-right">Boost your sales by allowing your customers to save payment and shipping information so it's easy to place orders their second order and beyond.</p>
						</div>
					</div>
					<div class="lg:col-span-4 reveal animate-left">
						<div class="aligner">
							<img class="max-h-550px lg:max-h-600px xl:max-h-700px" src="{{asset('images/returning-customer-login.png')}}" loading="lazy" alt="custom shipping rules">
						</div>
					</div>
				</div>
			</div>
		</div>
{{-- Returning Customer Login --}}
{{-- Manage Products --}}
	<div class="section-g">
		<div class="aligner py-20 lg:pt-10 lg:pb-0">
			<div class="features-column lg:grid-cols-7 gap-20 lg:gap-0">
		    	<div class="lg:pl-16 pr-20px lg:pt-40 lg:col-span-3">
				<h1 class="index-heading reveal animate-left">Manage Products</h1>
				<p class="pt-4 reveal fade-left">Add products to your store manually or import them from a spreadsheet. Edit and arrange and more.</p>
				</div>
				<div class="lg:col-span-4 reveal animate-right 2xl:mx-16 xl:mx-12 lg:mx-8">
					<div class="aligner">
						<img src="{{asset('images/product-management-graphics.png')}}" loading="lazy" alt="manage products">
					</div>
				</div>
			</div>
		</div>
	</div>
{{-- Manage Products --}}
{{-- Manage Customers --}}
	<div class="section-h">
		<div class="aligner features-section py-12">
			<div class="features-column lg:grid-cols-7 gap-0">
				<div class="features-left-image-column lg:col-span-3 pt-0 lg:pt-20 2xl:pt-40 lg:order-last order-first">
					<div class="text-left lg:text-right">
						<h1 class="index-heading reveal animate-right">Manage Customers</h1>
						<p class="pt-4 reveal fade-right">Build your customer base, look up their orders, and more.</p>
					</div>
				</div>
				<div class="lg:col-span-4 reveal animate-left 2xl:mx-16 xl:mx-12 lg:mx-8">
					<div class="aligner">
						<img src="{{asset('images/manage-customer.png')}}" loading="lazy" alt="Customer management">
					</div>
				</div>
			</div>
		</div>
	</div>
{{-- Manage Customers --}}
{{-- Manage Orders --}}
		<div class="section-c">
			<div class="aligner pt-12 pb-20">
				<div class="features-column">
		    		<div class="lg:pl-20 pt-0 lg:pt-20 2xl:pt-40 lg:pr-20px lg:col-span-3">
						<h1 class="index-heading reveal animate-left">Manage Orders</h1>
						<p class="pt-4 reveal fade-left">Enter tracking numbers and keep your customers updated about the status of their order.</p>
					</div>
					<div class="lg:col-span-4 reveal animate-right 2xl:mx-16 xl:mx-12 lg:mx-8">
		       			<div class="aligner text-center">
							<img src="{{asset('images/manage-orders-graphics.png')}}" loading="lazy" alt="Manage Orders">
		       			</div>					
					</div>
				</div>
			</div>
		</div>
{{-- Manage Orders --}}
</section>
@include('footer')
{!! Meta::footer()->toHtml() !!}
</body>
</html>