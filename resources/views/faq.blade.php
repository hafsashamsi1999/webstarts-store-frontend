<!DOCTYPE html>
<html lang="en-US">
<head>
{!! Meta::toHtml() !!}
</head>
<body class="bg-white">
@include('fixed-header')
<div>
	<div class="section-a main-section">
		<div class="aligner">
			<div class="main-section-row">
				<div class="main-section-text-column lg:col-span-4">
					<h1 class="main-section-heading w-auto">
						Frequently Asked Questions
					</h1>
				</div>
			</div>
		</div>
	</div>

	<section id="faq_section" class="aligner px-8 lg:px-4rem pt-8">
		<div class="faq_conatiner">

			<div class="faq">
				<div class="faq_question" role="tab" id="faqOne">
					<button class="faq_classes" data-parent="#faq_section" href="#answerOne" aria-expanded="false" aria-controls="answerOne">
						<h3>How do I get a hold of someone at WebStarts?</h3>
						<i class="material-icons">expand_more</i>
					</button>
				</div>

				<div id="answerOne" class="faq_answer_container" role="tabpanel" aria-labelledby="faqOne">
					<div class="faq_answer">
						<p> Visit the WebStarts Knowledge Base to contact our support team here: <a href="https://help.webstarts.com/">help.webstarts.com</a></p>
					</div>
				</div>
				<hr>
			</div>

			<div class="faq">
				<div class="faq_question" role="tab" id="faqTwo">
					<button class="faq_classes" data-parent="#faq_section" href="#answerTwo" aria-expanded="false" aria-controls="answerTwo">
						<h3>Why in the world does Webstarts offer completely free websites?</h3>
						<i class="material-icons">expand_more</i>
					</button>
				</div>

				<div id="answerTwo" class="faq_answer_container" role="tabpanel" aria-labelledby="faqTwo">
					<div class="faq_answer">
						<p>We give you a completely free website because we know when you see how easy it is to build powerful, professional looking websites with our tools you'll want to upgrade your site to unlock even more premium features. Get started building your very own free website at <a href="/">www.WebStarts.com</a>.</p>
					</div>
				</div>
				<hr>
			</div>

			<div class="faq">
				<div class="faq_question" role="tab" id="faqThree">
					<button class="faq_classes" data-parent="#faq_section" href="#answerThree" aria-expanded="false" aria-controls="answerThree">
						<h3>What do I get with a Premium WebStarts Account?</h3>
						<i class="material-icons">expand_more</i>
					</button>
				</div>

				<div id="answerThree" class="faq_answer_container" role="tabpanel" aria-labelledby="faqThree">
					<div class="faq_answer">
						<p>In short, you get everything you need to have a professional presence online. You can see a complete list by <a href="/pricing" class="text-primarycolor">clicking here</a> to view our pricing page.</p>
					</div>
				</div>
				<hr>
			</div>

			<div class="faq">
				<div class="faq_question" role="tab" id="faqFour">
					<button class="faq_classes" data-parent="#faq_section" href="#answerFour" aria-expanded="false" aria-controls="answerFour">
						<h3>What is the total cost for a Pro Plus subscription?</h3>
						<i class="material-icons">expand_more</i>
					</button>
				</div>

				<div id="answerFour" class="faq_answer_container" role="tabpanel" aria-labelledby="faqFour">
					<div class="faq_answer">
						<p>The total cost for a Pro Plus subscription is $14 per month but we do require you to pay 12 months in advance for that rate. If we charged your card $14 each month, we'd lose money to credit card company fees and would not be able to charge such an affordable price for our product.</p>
					</div>
				</div>
				<hr>
			</div>

			<div class="faq">
				<div class="faq_question" role="tab" id="faqFive">
					<button class="faq_classes" data-parent="#faq_section" href="#answerFive" aria-expanded="false" aria-controls="answerFive">
						<h3>Do payments include tax?</h3>
						<i class="material-icons">expand_more</i>
					</button>
				</div>

				<div id="answerFive" class="faq_answer_container" role="tabpanel" aria-labelledby="faqFive">
					<div class="faq_answer">
						<p>Yes, all payments include tax so there are additional taxes and fees added at checkout.</p>
					</div>
				</div>
				<hr>
			</div>

			<div class="faq">
				<div class="faq_question" role="tab" id="faqSix">
					<button class="faq_classes" data-parent="#faq_section" href="#answerSix" aria-expanded="false" aria-controls="answerSix">
						<h3>Can I pay per month or do I have to pay for the whole year up front?</h3>
						<i class="material-icons">expand_more</i>
					</button>
				</div>

				<div id="answerSix" class="faq_answer_container" role="tabpanel" aria-labelledby="faqSix">
					<div class="faq_answer">
						<p>You can opt to pay monthly or yearly, but the rate is much cheaper when paying yearly. We have to charge more money for monthly plans to cover the fees we're charged by the credit card processing companies.</p>
					</div>
				</div>
				<hr>
			</div>

			<div class="faq">
				<div class="faq_question" role="tab" id="faqSeven">
					<button class="faq_classes" data-parent="#faq_section" href="#answerSeven" aria-expanded="false" aria-controls="answerSeven">
						<h3>Are there any hidden costs or fees?</h3>
						<i class="material-icons">expand_more</i>
					</button>
				</div>

				<div id="answerSeven" class="faq_answer_container" role="tabpanel" aria-labelledby="faqSeven">
					<div class="faq_answer">
						<p>No. WebStarts doesn't charge any hidden costs or fees.</p>
					</div>
				</div>
				<hr>
			</div>

			<div class="faq">
				<div class="faq_question" role="tab" id="faqEight">
					<button class="faq_classes" data-parent="#faq_section" href="#answerEight" aria-expanded="false" aria-controls="answerEight">
						<h3>Can I register a professional looking custom domain name (example: MyWebsite.com) with my Webstarts website?</h3>
						<i class="material-icons">expand_more</i>
					</button>
				</div>

				<div id="answerEight" class="faq_answer_container" role="tabpanel" aria-labelledby="faqEight">
					<div class="faq_answer">
						<p>Yes, you can register a custom domain name with your Webstarts website. Simply pick a domain, upgrade to a Pro Plus or Business Plan, and your domain name will be working with your website within minutes.</p>
					</div>
				</div>
				<hr>
			</div>

			<div class="faq">
				<div class="faq_question" role="tab" id="faqNine">
					<button class="faq_classes" data-parent="#faq_section" href="#answerNine" aria-expanded="false" aria-controls="answerNine">
						<h3>I already have a domain which I registered elsewhere. Can I use that domain name with my Webstarts website?</h3>
						<i class="material-icons">expand_more</i>
					</button>
				</div>

				<div id="answerNine" class="faq_answer_container" role="tabpanel" aria-labelledby="faqNine">
					<div class="faq_answer">
						<p>Yes, no matter where you registered your domain you can use it with your Webstarts website but you'll need to upgrade to a Pro Plus account to do so.</p>
					</div>
				</div>
				<hr>
			</div>

			<div class="faq">
				<div class="faq_question" role="tab" id="faqTen">
					<button class="faq_classes" data-parent="#faq_section" href="#answerTen" aria-expanded="false" aria-controls="answerTen">
						<h3>Do I own the domain name I register with a Pro Plus account?</h3>
						<i class="material-icons">expand_more</i>
					</button>
				</div>

				<div id="answerTen" class="faq_answer_container" role="tabpanel" aria-labelledby="faqTen">
					<div class="faq_answer">
						<p>Yes. When you register a domain name with WebStarts you own and can take it anywhere you choose.</p>
					</div>
				</div>
				<hr>
			</div>

			<div class="faq">
				<div class="faq_question" role="tab" id="faq11">
					<button class="faq_classes" data-parent="#faq_section" href="#answer11" aria-expanded="false" aria-controls="answer11">
						<h3>Can I register a domain name with Webstarts and later decide to have it registered elsewhere?</h3>
						<i class="material-icons">expand_more</i>
					</button>
				</div>

				<div id="answer11" class="faq_answer_container" role="tabpanel" aria-labelledby="faq11">
					<div class="faq_answer">
						<p>Yes, you can register a domain with Webstarts and if you later decide to use a different company to host your website or manage your domain you can. There is absolutely no risk involved when registering a domain name with Webstarts.</p>
					</div>
				</div>
				<hr>
			</div>

			<div class="faq">
				<div class="faq_question" role="tab" id="faq12">
					<button class="faq_classes" data-parent="#faq_section" href="#answer12" aria-expanded="false" aria-controls="answer12">
						<h3>Can I have a professional looking email address that matches my website domain name? (myname@MyWebsite.com)</h3>
						<i class="material-icons">expand_more</i>
					</button>
				</div>

				<div id="answer12" class="faq_answer_container" role="tabpanel" aria-labelledby="faq12">
					<div class="faq_answer">
						<p>Yes, when you choose a domain name for your website you will be able to purchase email addresses that match your domain name.</p>
					</div>
				</div>
				<hr>
			</div>

			<div class="faq">
				<div class="faq_question" role="tab" id="faq13">
					<button class="faq_classes" data-parent="#faq_section" href="#answer13" aria-expanded="false" aria-controls="answer13">
						<h3>How will the website I build with WebStarts look on my mobile Phone?</h3>
						<i class="material-icons">expand_more</i>
					</button>
				</div>

				<div id="answer13" class="faq_answer_container" role="tabpanel" aria-labelledby="faq13">
					<div class="faq_answer">
						<p>Amazing! You will be able to create a version of your website specifically designed to look great on the smaller screens of a mobile device.</p>
					</div>
				</div>
				<hr>
			</div>

			<div class="faq">
				<div class="faq_question" role="tab" id="faq14">
					<button class="faq_classes" data-parent="#faq_section" href="#answer14" aria-expanded="false" aria-controls="answer14">
						<h3>If I close my Account, will I lose my domain name?</h3>
						<i class="material-icons">expand_more</i>
					</button>
				</div>

				<div id="answer14" class="faq_answer_container" role="tabpanel" aria-labelledby="faq14">
					<div class="faq_answer">
						<p>No. If you close your account you will be able to use your domain name elsewhere should you decide to do so.</p>
					</div>
				</div>
				<hr>
			</div>

			<div class="faq">
				<div class="faq_question" role="tab" id="faq15">
					<button class="faq_classes" data-parent="#faq_section" href="#answer15" aria-expanded="false" aria-controls="answer15">
						<h3>Can I move my website to another web host in the future?</h3>
						<i class="material-icons">expand_more</i>
					</button>
				</div>

				<div id="answer15" class="faq_answer_container" role="tabpanel" aria-labelledby="faq15">
					<div class="faq_answer">
						<p>Yes. You can take your entire website to any other web host but we don't recommend it :D</p>
					</div>
				</div>
				<hr>
			</div>

			<div class="faq">
				<div class="faq_question" role="tab" id="faq16">
					<button class="faq_classes" data-parent="#faq_section" href="#answer16" aria-expanded="false" aria-controls="answer16">
						<h3>What are the Google Adwords Credits?</h3>
						<i class="material-icons">expand_more</i>
					</button>
				</div>

				<div id="answer16" class="faq_answer_container" role="tabpanel" aria-labelledby="faq16">
					<div class="faq_answer">
						<p>The Google Adwords Credit is up to $100 worth of free ads that will show your site on top of Google search results when people search for keywords and phrases that have to do with your business or website.</p>
					</div>
				</div>
				<hr>
			</div>

			<div class="faq">
				<div class="faq_question" role="tab" id="faq17">
					<button class="faq_classes" data-parent="#faq_section" href="#answer17" aria-expanded="false" aria-controls="answer17">
						<h3>What type of technical support do I get with a Pro Plus Account?</h3>
						<i class="material-icons">expand_more</i>
					</button>
				</div>

				<div id="answer17" class="faq_answer_container" role="tabpanel" aria-labelledby="faq17">
					<div class="faq_answer">
						<p>With a Pro Plus subscription you get telephone support from 11:00am to 7:30pm EST Monday thru Friday and email support around the clock. We know our hours are somewhat limited but rest assured that you will be working with a WebStarts expert and not a difficult to understand, outsourced minion reading questions and answers off a computer screen.</p>
					</div>
				</div>
				<hr>
			</div>

			<div class="faq">
				<div class="faq_question" role="tab" id="faq18">
					<button class="faq_classes" data-parent="#faq_section" href="#answer18" aria-expanded="false" aria-controls="answer18">
						<h3>Where can I find instructions on how to use a particular feature?</h3>
						<i class="material-icons">expand_more</i>
					</button>
				</div>

				<div id="answer18" class="faq_answer_container" role="tabpanel" aria-labelledby="faq18">
					<div class="faq_answer">
						<p>We provide extensive support documentation at <a href="https://help.webstarts.com/">help.webstarts.com</a>. Just type in a keyword and click search.</p>
					</div>
				</div>
				<hr>
			</div>

			<div class="faq">
				<div class="faq_question" role="tab" id="faq19">
					<button class="faq_classes" data-parent="#faq_section" href="#answer19" aria-expanded="false" aria-controls="answer19">
						<h3>What is the typical response time to technical questions.</h3>
						<i class="material-icons">expand_more</i>
					</button>
				</div>

				<div id="answer19" class="faq_answer_container" role="tabpanel" aria-labelledby="faq19">
					<div class="faq_answer">
						<p>We typically respond to support emails within one hour during office hours (11:00am to 7:30pm EST Monday thru Friday). We are also available by phone during those times. We do check our email frequently over the weekend and after hours so response times may be more than one hour.</p>
					</div>
				</div>
				<hr>
			</div>

			<div class="faq">
				<div class="faq_question" role="tab" id="faq20">
					<button class="faq_classes" data-parent="#faq_section" href="#answer20" aria-expanded="false" aria-controls="answer20">
						<h3>Why would I want more than one domain name?</h3>
						<i class="material-icons">expand_more</i>
					</button>
				</div>

				<div id="answer20" class="faq_answer_container" role="tabpanel" aria-labelledby="faq20">
					<div class="faq_answer">
						<p>Adding multiple domain names to your website will help get your site more easily found on the search engines and found under more keywords.</p>
					</div>
				</div>
				<hr>
			</div>

			<div class="faq">
				<div class="faq_question" role="tab" id="faq21">
					<button class="faq_classes" data-parent="#faq_section" href="#answer21" aria-expanded="false" aria-controls="answer21">
						<h3>Can I build my website with Webstarts and later decide to have it hosted elsewhere?</h3>
						<i class="material-icons">expand_more</i>
					</button>
				</div>

				<div id="answer21" class="faq_answer_container" role="tabpanel" aria-labelledby="faq21">
					<div class="faq_answer">
						<p>Yes, you can build your website with Webstarts and if you later decide to take your website elsewhere you can. There is absolutely no risk involved when building a website with Webstarts.</p>
					</div>
				</div>
				<hr>
			</div>

			<div class="faq">
				<div class="faq_question" role="tab" id="faq22">
					<button class="faq_classes" data-parent="#faq_section" href="#answer22" aria-expanded="false" aria-controls="answer22">
						<h3>Will my email address and account information be kept private?</h3>
						<i class="material-icons">expand_more</i>
					</button>
				</div>

				<div id="answer22" class="faq_answer_container" role="tabpanel" aria-labelledby="faq22">
					<div class="faq_answer">
						<p>Yes, Webstarts will never share your email address or other account information with anybody...</p>
					</div>
				</div>
				<hr>
			</div>

			<div class="faq">
				<div class="faq_question" role="tab" id="faq23">
					<button class="faq_classes" data-parent="#faq_section" href="#answer23" aria-expanded="false" aria-controls="answer23">
						<h3>Will my WebStarts website show up on Google, Yahoo, Bing, and other search engines?</h3>
						<i class="material-icons">expand_more</i>
					</button>
				</div>

				<div id="answer23" class="faq_answer_container" role="tabpanel" aria-labelledby="faq23">
					<div class="faq_answer">
						<p>Yes, your WebStarts website will show up on Google, Yahoo, Bing, and other search engines. To increase your ranking however you'll want to upgrade to a WebStarts Pro Plus Plan.</p>
					</div>
				</div>
				<hr>
			</div>

			<div class="faq">
				<div class="faq_question" role="tab" id="faq24">
					<button class="faq_classes" data-parent="#faq_section" href="#answer24" aria-expanded="false" aria-controls="answer24">
						<h3>Can I add a contact form to my Webstarts website?</h3>
						<i class="material-icons">expand_more</i>
					</button>
				</div>

				<div id="answer24" class="faq_answer_container" role="tabpanel" aria-labelledby="faq24">
					<div class="faq_answer">
						<p>Yes, you can create and add custom forms to your Webstarts website.</p>
					</div>
				</div>
				<hr>
			</div>

			<div class="faq">
				<div class="faq_question" role="tab" id="faq25">
					<button class="faq_classes" data-parent="#faq_section" href="#answer25" aria-expanded="false" aria-controls="answer25">
						<h3>Can I add ecommerce and accept credit card payments on my Webstarts website?</h3>
						<i class="material-icons">expand_more</i>
					</button>
				</div>

				<div id="answer25" class="faq_answer_container" role="tabpanel" aria-labelledby="faq25">
					<div class="faq_answer">
						<p>Yes, you can add ecommerce to your Webstarts website and will be able to take payments from all major credit cards and even PayPal.</p>
					</div>
				</div>
				<hr>
			</div>

			<div class="faq">
				<div class="faq_question" role="tab" id="faq26">
					<button class="faq_classes" data-parent="#faq_section" href="#answer26" aria-expanded="false" aria-controls="answer26">
						<h3>Can I close my account at any time? Are there any cancellation fees?</h3>
						<i class="material-icons">expand_more</i>
					</button>
				</div>

				<div id="answer26" class="faq_answer_container" role="tabpanel" aria-labelledby="faq26">
					<div class="faq_answer">
						<p>Yes. You can close your account at any time. There are no fees or penalties for doing so.</p>
					</div>
				</div>
				<hr>
			</div>
		</div>
	</section>

	<div class="text-center py-8 aligner">
		<a class="m-0 w-90 md:w-210px block btn btn-lg btn-secondary btn-raised" href="/templates">Sign up. It's free.</a>
	</div>
</div>
@include('footer')
<link href="{{ asset('css/faq.css') }}" rel="stylesheet" defer async>
{!! Meta::footer()->toHtml() !!}
</body>
</html>