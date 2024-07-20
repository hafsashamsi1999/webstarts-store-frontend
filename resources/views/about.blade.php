<!DOCTYPE html>
<html lang="en-US">
<head>
{!! Meta::toHtml() !!}
</head>
<body>
  @include('fixed-header')
  <section id="about-page" class="bg-white pb-20">
	<div class="section-a main-section">
		<div class="aligner">
			<div class="main-section-row">
				<div class="main-section-text-column lg:col-span-4">
					<h1 class="main-section-heading w-auto">
						About WebStarts
					</h1>
				</div>
			</div>
		</div>
	</div>

	<div class=" pt-12">
		<div class="flex justify-center lg:justify-start pl-0 lg:pl-16">
			<div class="w-90">

				<div class="bg-white">
					<div class="">
						<h3 class="about-title">Our Story</h3>
						<img width="156" height="180" src="https://www.webstarts.com/images/adamPic.jpg" class="pull-left mr-5">
						<p class="mb-8">Frustrated with the high cost and long wait times of hiring professional designers to maintain my website, I went in search for a do it yourself website builder. I soon realized do-it-yourself website builders didn't provide the flexibility to create a unique website that reflected my products and services. Stifled by these limitations I set out to create a new way to build websites. A way where everyday people could create unique pages without knowing any code and without the harsh limitations of other website builders.</p>
						<div class="flex">
							<img class="h-100px" src="https://www.webstarts.com/images/sig.jpg">
							<div class="hidden md:block">
								<div class="pb-8">
									<div><a target="_blank" href="https://www.facebook.com/WebStarts" class="btn mt-0 facebook hover:bg-gray-100 text-body"><i class="fa fa-facebook mr-2"></i><span class="text-sm">Become a fan of WebStarts</span></a></div>
									<div class="my-4"><a target="_blank" href="https://twitter.com/webstarts" class="btn mt-0 twitter hover:bg-gray-100"><i class="fa fa-twitter mr-2"></i><span class="text-sm">Follow us on Twitter</span></a></div>
									<div><a target="_blank" href="https://www.youtube.com/profile?user=webstarts" class="btn mt-0 youtube hover:bg-gray-100"><i class="fa fa-youtube mr-2"></i><span class="text-sm">Subscribe to our YouTube channel</span></a></div>
								</div>
							</div>
						</div>

						<hr>

						<div class="py-5">
							<h3 class="about-title">Our Vision</h3>
							<p>At WebStarts our vision is to provide everything you need to build and maintain your very own website. Not just any website, but websites that you can quickly edit and change, allowing you to keep your content fresh and original.</p>
						</div>
						<hr>

						<div class="py-5">
							<h3 class="about-title">How We're Different</h3>
							<p>Unlike other website builders WebStarts doesn't limit your creative ability modifying a few lines of text on the same boring template being used by hundreds of other people on the web. Instead WebStarts gives you the creative freedom to change virtually every element of your page. With WebStarts you can easily upload photos and images from your own computer then place them exactly where you want them to appear on your page. In addition WebStarts doesn't limit you to just text. You can add audio, video, forms, slideshows, widgets, and just about anything else.</p>
							<p>At WebStarts we know if you mean business you'll want to get your very own domain name (example: YourWebSite.com). Normally this process is tedious, requiring you to search for an available domain name with a registrar then configuring that domain to work with your web hosting, and finally your site. But with WebStarts this process is automatic. You simply click on the add domain icon in your account, choose the domain you want, and the it's made live on the web in minutes.</p>
							<p>Once you've designed your website, we know you'll want to get found. For most of us that means we want to show up high in the search engine rankings when people perform searches for keywords and phrases that have to do with our site. WebStarts is the first website builder to be designed with this specifically in mind and provides you with the tools you need to obtain top these results.</p>
						</div>
						<hr>

						<div class="py-5">
							<h3 class="about-title">Our Commitment To Our Customers</h3>
							<p class="pb-4">Companies and customers alike, need to trust the people with whom they do business. We know as a customer you expect honest, straightforward interactions where your voice is heard. As a company we work to inspire brand loyalty and deliver satisfaction while trying to understand you better.</p>
							<p class="pb-4">Along with open, authentic communication comes the mutual responsibility to make it work. By adopting these five practical measures, we can together realize the benefits of our business relationship.</p>
							<p>
							<ol class="ml-5 pb-4 list-decimal list-inside">
								<li>As a company we promise to be human, avoid scripts, canned answers, and corporate doublespeak. As a customer we ask that you be understanding and show the same respect and kindness to our company reps that you would like shown to you.</li>
								<li>As a company our employees use their real names and express a personal touch. As a customer we ask that you too use your real identity, and work to build a positive long-term reputation with our company.</li>
								<li>As a company we anticipate that problems will occur and set clear, public expectations in advance for how we will correct them. As a customer we ask you recognize that problems will occur, and give companies the information and time required to fix them. </li>
								<li>As a company we will cultivate a public dialog with our customers so they feel they are being heard and to demonstrate our accountability. As a customer we ask you share issues directly with our company and give us the opportunity to respond, so we can work with you to resolve problems.</li>
								<li>As a company we promise to demonstrate good intentions by speaking plainly, earnestly, and candidly with you about problems that may arise. As a customer we ask you give our company the benefit of the doubt, and be open to what we have to say.</li>
							</ol>
							</p>
							<p>Our hope is by working together in these ways we can build long-term relationships filled with trust and communication. We believe if we help you succeed you will help us succeed.</p>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
	<div class="text-center py-8 aligner">
		<a class="m-0 w-90 md:w-210px block btn btn-lg btn-secondary btn-raised" href="/templates">Sign up. It's free.</a>
	</div>
</section>
@include('footer')
{!! Meta::footer()->toHtml() !!}
</body>
</html>