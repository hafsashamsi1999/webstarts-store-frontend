<div class="font-body">
	<div class="relative bg-white">
		<div class="bg-white header-shadow">
			<div class="w-full mx-auto px-4 sm:px-6 navbar">
				<div class="flex flex-wrap justify-between items-center py-2 lg:justify-start">
					<div class="flex">
						<a href="/">
							<span class="sr-only">Webstarts</span>
							<picture>
								<source srcset="{{ asset('images/minimal-logo-source_w100.webp') }} 100w" type="image/webp">
								<source srcset="{{ asset('images/minimal-logo-source_w100.png') }} 100w" type="image/png">
								<img class="w-12 mr-5" src="{{ asset('images/minimal-logo-source_w100.png') }}" alt="webstarts logo">
							</picture>
						</a>
					</div>
					<div class="-mr-6 -my-2 lg:hidden">
						<button type="button" class="navbar-toggle sidebar-toggle" role="button" aria-pressed="false" aria-expanded="false" aria-label="Responsive Menu">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
					</div>
					<nav class="hidden lg:flex xl:hidden lg:flex-wrap md:justify-center space-x-8">
						<a href="/" class="header-li" aria-label="WebStarts Home">
							Home
						</a>
						<a href="/features" class="header-li" aria-label="WebStarts Features">
							Features
						</a>
						<a href="https://www.webstarts.com/templates/online-store" class="header-li" aria-label="WebStarts Apps">
							Designs
						</a>
					</nav>
					<nav class="hidden xl:flex lg:flex-wrap md:justify-center space-x-12">
						<a href="/" class="header-li" aria-label="WebStarts Home">
							Home
						</a>
						<a href="/features" class="header-li" aria-label="WebStarts Features">
							Features
						</a>
						<a href="https://www.webstarts.com/templates/online-store" class="header-li" aria-label="WebStarts Apps">
							Designs
						</a>
					</nav>
					<div class="hidden lg:flex justify-end relative lg:flex-1">
						<a href="https://www.webstarts.com/login" class="ml-0 btn btn-primary btn-raised" aria-label="WebStarts Login">
							Login
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="fixed top-0 -right-2 bottom-0 z-1035 bg-white hidden md:hidden navbar-sidebar h-full w-280px min-w-280px min-h-full shadow-sidebarshadow border-none">
		<div class="">
			<div class="bg-white header-shadow py-2 px-3">
				<div class="flex items-center justify-between">
					<a href="#" class="btn btn-default btn-secondary btn-raised btn-sm visible-xs pull-left py-2 px-6" aria-label="Signup">Get Started</a>
					<div class="-mr-2">
						<button type="button" class="pt-2 pr-2 inline-flex items-center justify-center text-gray-800 focus:outline-none">
							<span class="sr-only">Close menu</span>
							<svg class="h-7 w-7 sidebar-close" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
							</svg>
						</button>
					</div>
				</div>
			</div>
			<div class="pb-6">
				<div class="mt-6">
					<ul>
						<li class="hover:bg-gray-100"><a href="/" aria-label="WebStarts Home" aria-label="WebStarts Home">Home</a></li>
						<li class="hover:bg-gray-100"><a href="/features" aria-label="WebStarts Features">Features</a></li>
						<li class="hover:bg-gray-100"><a href="https://www.webstarts.com/templates/online-store" aria-label="Domain Search">Designs</a></li>
						<li class="hover:bg-gray-100">

						<li class="hover:bg-gray-100"><a href="https://www.webstarts.com/login" aria-label="WebStarts Login">Login</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="sidebar-overlay"></div>
</div>