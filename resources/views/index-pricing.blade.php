<!DOCTYPE html>
<html lang="en-US">
<head>
{!! Meta::toHtml() !!}
<script type="text/javascript">
	document.addEventListener('DOMContentLoaded', function() {
	
		$(window).scroll(function() {
			if ($(this).scrollTop()>200)
			{
				$('.plan-sub').slideUp(500);
				$("hr").slideUp(500);
			}
			else
			{
				$('.plan-sub').slideDown(500);
				$("hr").slideDown(500);
			}
		});

		$('button[data-plan]').click(function() {
			let plan = $(this).data('plan')
			,	$form = $('form[name="plan-select"]')
			;
			
			$form.find('input[name="plan"]').val(plan);
			$form[0].submit();
		});
	});
</script>
</head>
<body>
	@include('index-header')
	<section id="pricing-page" class="bg-white pb-20">
		<div class="main-section-text-column">
			<div class="py-9">
			<h1 class="main-section-heading text-center lg:text-left">Plans & Pricing</h1>	
			<p class="main-section-paragraph">Explore WebStarts plans and pricing to start your online journey today.</p>
			</div>
			<!-- <div class="main-section-button">
          	<a href="/templates" class="m-0 w-210px block btn btn-lg btn-raised btn-secondary">Sign Up - It's Free</a>   
      	</div> -->		
		</div>

<div class="">

<div class="aligner">
	<div class="px-16 lg:block hidden">
		<div>
	<div class="grid index-pricing-grid">

		<div class="top-left-border-radius index-pricing-header">
			
		</div>

		<div class="index-pricing-header">
			<div>
				<h3 class="plan-name">Free</h3>
				<p class="plan-sub lg:h-4em md:h-7em sm:h-8em">Kick the tires and take it for a spin.</p>
			</div>

				<hr class="hr w-full">

				<p>Sign Up It's Free.</p>
				<p>Takes less than 30 seconds.<br class="hidden xl:block"><span class="text-abouttitle span">&nbsp;</span></p>

				<button data-plan="free" class="m-0 block btn btn-raised btn-trans btn-default md:px-20">Continue</button>
				
		</div>

		<div class="index-pricing-header">
			<div>
				<h3 class="plan-name">Pro Plus</h3>
				<p class="plan-sub lg:h-4em md:h-7em sm:h-8em">Perfect for clubs, organizations, teams, and non-profits.</p>
			</div>

				<hr class="hr w-full">

				<p>Was <span class="strike">{{ $symbol.$proplus_price_before }}/mo</span></p>
				<p>Now only<br><span class="text-abouttitle span font-normal">{{ $symbol.$proplus_price_major.'.'.$proplus_price_minor }}/mo</span></p>

				<button data-plan="plus" class="m-0 block btn btn-raised btn-trans btn-secondary md:px-20">Continue</button>
				
		</div>

		<div class="index-pricing-header top-right-border-radius">
			<div>
				<h3 class="plan-name">Business</h3>
				<p class="plan-sub lg:h-4em md:h-7em sm:h-8em">The right choice for businesses looking to expand.</p>
			</div>

				<hr class="hr w-full">

				<p>Was <span class="strike">{{ $symbol.$business_price_before }}/mo</span></p>
				<p>Now only<br><span class="text-abouttitle span font-normal">{{ $symbol.$business_price_major.'.'.$business_price_minor }}/mo</span></p>

				<button data-plan="business" class="m-0 block btn btn-raised btn-trans btn-secondary md:px-20">Continue</button>
				
		</div>

		<div class="index-pricing-info">
			<span>Custom Domain Name</span>
		</div>

		<div class="index-pricing-details">
			<span>No</span>
		</div>

		<div class="index-pricing-details">
			<span>Yes</span>
		</div>

		<div class="index-pricing-details">
			<span>Yes</span>
		</div>

		<div class="index-pricing-info">
			<span>Search Engine Submission</span>
		</div>

		<div class="index-pricing-details">
			<span>No</span>
		</div>

		<div class="index-pricing-details relative">
			<div class="se-bg google-only"></div>
		</div>

		<div class="index-pricing-details relative">
			<div class="se-bg"></div>
		</div>

		<div class="index-pricing-info">
			<span>Free Advertising</span>
		</div>

		<div class="index-pricing-details">
			<span>$0</span>
		</div>

		<div class="index-pricing-details">
			<span>$250</span>
		</div>

		<div class="index-pricing-details">
			<span>$500</span>
		</div>

		<div class="index-pricing-info">
			<span>Social Integration</span>
		</div>

		<div class="index-pricing-details">
			<span>No</span>
		</div>

		<div class="index-pricing-details">
			<div class="icon-set flex">
				<i class="fb-logo">
					<svg xmlns="http://www.w3.org/2000/svg" height="24px" width="24px" fill="#3b5998" viewBox="0 0 448 512"><path d="M400 32H48A48 48 0 0 0 0 80v352a48 48 0 0 0 48 48h137.25V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.27c-30.81 0-40.42 19.12-40.42 38.73V256h68.78l-11 71.69h-57.78V480H400a48 48 0 0 0 48-48V80a48 48 0 0 0-48-48z"/></svg>
				</i>
				<!-- <i class="fa fa-facebook"></i> -->
				<i class="twitter-logo">
					<svg xmlns="http://www.w3.org/2000/svg" height="24px" width="24px" fill="1DA1F2" viewBox="0 0 448 512"><path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm297.1 84L257.3 234.6 379.4 396H283.8L209 298.1 123.3 396H75.8l111-126.9L69.7 116h98l67.7 89.5L313.6 116h47.5zM323.3 367.6L153.4 142.9H125.1L296.9 367.6h26.3z"/></svg>
				</i>

				<i class="instagram-logo">
					<svg xmlns="http://www.w3.org/2000/svg" height="24px" width="24px" fill="#E4405F" viewBox="0 0 448 512">
						<radialGradient id="instagramGradient" r="150%" cx="30%" cy="107%">
    					<stop stop-color="#fdf497" offset="0" />
    					<stop stop-color="#fdf497" offset="0.05" />
    					<stop stop-color="#fd5949" offset="0.45" />
    					<stop stop-color="#d6249f" offset="0.6" />
    					<stop stop-color="#285AEB" offset="0.9" />
  						</radialGradient>
						<path d="M224,202.66A53.34,53.34,0,1,0,277.36,256,53.38,53.38,0,0,0,224,202.66Zm124.71-41a54,54,0,0,0-30.41-30.41c-21-8.29-71-6.43-94.3-6.43s-73.25-1.93-94.31,6.43a54,54,0,0,0-30.41,30.41c-8.28,21-6.43,71.05-6.43,94.33S91,329.26,99.32,350.33a54,54,0,0,0,30.41,30.41c21,8.29,71,6.43,94.31,6.43s73.24,1.93,94.3-6.43a54,54,0,0,0,30.41-30.41c8.35-21,6.43-71.05,6.43-94.33S357.1,182.74,348.75,161.67ZM224,338a82,82,0,1,1,82-82A81.9,81.9,0,0,1,224,338Zm85.38-148.3a19.14,19.14,0,1,1,19.13-19.14A19.1,19.1,0,0,1,309.42,189.74ZM400,32H48A48,48,0,0,0,0,80V432a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48V80A48,48,0,0,0,400,32ZM382.88,322c-1.29,25.63-7.14,48.34-25.85,67s-41.4,24.63-67,25.85c-26.41,1.49-105.59,1.49-132,0-25.63-1.29-48.26-7.15-67-25.85s-24.63-41.42-25.85-67c-1.49-26.42-1.49-105.61,0-132,1.29-25.63,7.07-48.34,25.85-67s41.47-24.56,67-25.78c26.41-1.49,105.59-1.49,132,0,25.63,1.29,48.33,7.15,67,25.85s24.63,41.42,25.85,67.05C384.37,216.44,384.37,295.56,382.88,322Z"/></svg>
				</i>
				<i class="pinterest-logo">
					<svg xmlns="http://www.w3.org/2000/svg" height="24px" width="24px" fill="#E60023" viewBox="0 0 448 512"><path d="M448 80v352c0 26.5-21.5 48-48 48H154.4c9.8-16.4 22.4-40 27.4-59.3 3-11.5 15.3-58.4 15.3-58.4 8 15.3 31.4 28.2 56.3 28.2 74.1 0 127.4-68.1 127.4-152.7 0-81.1-66.2-141.8-151.4-141.8-106 0-162.2 71.1-162.2 148.6 0 36 19.2 80.8 49.8 95.1 4.7 2.2 7.1 1.2 8.2-3.3.8-3.4 5-20.1 6.8-27.8.6-2.5.3-4.6-1.7-7-10.1-12.3-18.3-34.9-18.3-56 0-54.2 41-106.6 110.9-106.6 60.3 0 102.6 41.1 102.6 99.9 0 66.4-33.5 112.4-77.2 112.4-24.1 0-42.1-19.9-36.4-44.4 6.9-29.2 20.3-60.7 20.3-81.8 0-53-75.5-45.7-75.5 25 0 21.7 7.3 36.5 7.3 36.5-31.4 132.8-36.1 134.5-29.6 192.6l2.2.8H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h352c26.5 0 48 21.5 48 48z"/></svg>
				</i>
			</div>
		</div>

		<div class="index-pricing-details">
			<div class="icon-set flex">
				<i class="fb-logo">
					<svg xmlns="http://www.w3.org/2000/svg" height="24px" width="24px" fill="#3b5998" viewBox="0 0 448 512"><path d="M400 32H48A48 48 0 0 0 0 80v352a48 48 0 0 0 48 48h137.25V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.27c-30.81 0-40.42 19.12-40.42 38.73V256h68.78l-11 71.69h-57.78V480H400a48 48 0 0 0 48-48V80a48 48 0 0 0-48-48z"/></svg>
				</i>
				<!-- <i class="fa fa-facebook"></i> -->
				<i class="twitter-logo">
					<svg xmlns="http://www.w3.org/2000/svg" height="24px" width="24px" fill="1DA1F2" viewBox="0 0 448 512"><path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm297.1 84L257.3 234.6 379.4 396H283.8L209 298.1 123.3 396H75.8l111-126.9L69.7 116h98l67.7 89.5L313.6 116h47.5zM323.3 367.6L153.4 142.9H125.1L296.9 367.6h26.3z"/></svg>
				</i>
				<i class="instagram-logo">
					<svg xmlns="http://www.w3.org/2000/svg" height="24px" width="24px" fill="#E4405F" viewBox="0 0 448 512" >
						<radialGradient id="instagramGradient" r="150%" cx="30%" cy="107%">
    					<stop stop-color="#fdf497" offset="0" />
    					<stop stop-color="#fdf497" offset="0.05" />
    					<stop stop-color="#fd5949" offset="0.45" />
    					<stop stop-color="#d6249f" offset="0.6" />
    					<stop stop-color="#285AEB" offset="0.9" />
  						</radialGradient>
						<path d="M224,202.66A53.34,53.34,0,1,0,277.36,256,53.38,53.38,0,0,0,224,202.66Zm124.71-41a54,54,0,0,0-30.41-30.41c-21-8.29-71-6.43-94.3-6.43s-73.25-1.93-94.31,6.43a54,54,0,0,0-30.41,30.41c-8.28,21-6.43,71.05-6.43,94.33S91,329.26,99.32,350.33a54,54,0,0,0,30.41,30.41c21,8.29,71,6.43,94.31,6.43s73.24,1.93,94.3-6.43a54,54,0,0,0,30.41-30.41c8.35-21,6.43-71.05,6.43-94.33S357.1,182.74,348.75,161.67ZM224,338a82,82,0,1,1,82-82A81.9,81.9,0,0,1,224,338Zm85.38-148.3a19.14,19.14,0,1,1,19.13-19.14A19.1,19.1,0,0,1,309.42,189.74ZM400,32H48A48,48,0,0,0,0,80V432a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48V80A48,48,0,0,0,400,32ZM382.88,322c-1.29,25.63-7.14,48.34-25.85,67s-41.4,24.63-67,25.85c-26.41,1.49-105.59,1.49-132,0-25.63-1.29-48.26-7.15-67-25.85s-24.63-41.42-25.85-67c-1.49-26.42-1.49-105.61,0-132,1.29-25.63,7.07-48.34,25.85-67s41.47-24.56,67-25.78c26.41-1.49,105.59-1.49,132,0,25.63,1.29,48.33,7.15,67,25.85s24.63,41.42,25.85,67.05C384.37,216.44,384.37,295.56,382.88,322Z"/></svg>
				</i>
				<i class="pinterest-logo">
					<svg xmlns="http://www.w3.org/2000/svg" height="24px" width="24px" fill="#E60023" viewBox="0 0 448 512"><path d="M448 80v352c0 26.5-21.5 48-48 48H154.4c9.8-16.4 22.4-40 27.4-59.3 3-11.5 15.3-58.4 15.3-58.4 8 15.3 31.4 28.2 56.3 28.2 74.1 0 127.4-68.1 127.4-152.7 0-81.1-66.2-141.8-151.4-141.8-106 0-162.2 71.1-162.2 148.6 0 36 19.2 80.8 49.8 95.1 4.7 2.2 7.1 1.2 8.2-3.3.8-3.4 5-20.1 6.8-27.8.6-2.5.3-4.6-1.7-7-10.1-12.3-18.3-34.9-18.3-56 0-54.2 41-106.6 110.9-106.6 60.3 0 102.6 41.1 102.6 99.9 0 66.4-33.5 112.4-77.2 112.4-24.1 0-42.1-19.9-36.4-44.4 6.9-29.2 20.3-60.7 20.3-81.8 0-53-75.5-45.7-75.5 25 0 21.7 7.3 36.5 7.3 36.5-31.4 132.8-36.1 134.5-29.6 192.6l2.2.8H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h352c26.5 0 48 21.5 48 48z"/></svg>
				</i>
			</div>
		</div>

		<div class="index-pricing-info">
			<span>Business Emails</span>
		</div>

		<div class="index-pricing-details">
			<span>None</span>
		</div>

		<div class="index-pricing-details">
			<span>1 Email Address</span>
		</div>

		<div class="index-pricing-details">
			<span>5 Email Address</span>
		</div>

		<div class="index-pricing-info">
			<span>SEO Tools</span>
		</div>

		<div class="index-pricing-details">
			<span>No</span>
		</div>

		<div class="index-pricing-details">
			<span>Yes</span>
		</div>

		<div class="index-pricing-details">
			<span>Yes</span>
		</div>

		<div class="index-pricing-info">
			<span>Available Pages</span>
		</div>

		<div class="index-pricing-details">
			<span>Unlimited</span>
		</div>

		<div class="index-pricing-details">
			<span>Unlimited</span>
		</div>

		<div class="index-pricing-details">
			<span>Unlimited</span>
		</div>

		<div class="index-pricing-info">
			<span>Contact Forms</span>
		</div>

		<div class="index-pricing-details">
			<span>None</span>
		</div>

		<div class="index-pricing-details">
			<span>1,000 Contacts</span>
		</div>

		<div class="index-pricing-details">
			<span>Unlimited</span>
		</div>

		<div class="index-pricing-info">
			<span>Slideshows & Galleries</span>
		</div>

		<div class="index-pricing-details">
			<span>None</span>
		</div>

		<div class="index-pricing-details">
			<span>Unlimited</span>
		</div>

		<div class="index-pricing-details">
			<span>Unlimited</span>
		</div>

		<div class="index-pricing-info">
			<span>Cloud Storage</span>
		</div>

		<div class="index-pricing-details">
			<span>1GB</span>
		</div>

		<div class="index-pricing-details">
			<span>10GB</span>
		</div>

		<div class="index-pricing-details">
			<span>40GB</span>
		</div>

		<div class="index-pricing-info">
			<span>Bandwidth</span>
		</div>

		<div class="index-pricing-details">
			<span>1GB/mo</span>
		</div>

		<div class="index-pricing-details">
			<span>100GB/mo</span>
		</div>

		<div class="index-pricing-details">
			<span>Unlimited</span>
		</div>

		<div class="index-pricing-info">
			<span>Ads Shown</span>
		</div>

		<div class="index-pricing-details">
			<span>On All Pages</span>
		</div>

		<div class="index-pricing-details">
			<span>Ad Free</span>
		</div>

		<div class="index-pricing-details">
			<span>Ad Free</span>
		</div>

		<div class="index-pricing-info justify-start">
			<span class="label label-primary mr-2">NEW</span>
			<span>Notification Center</span>
		</div>

		<div class="index-pricing-details">
			<i class="material-icons checkmark">done</i>
		</div>

		<div class="index-pricing-details">
			<i class="material-icons checkmark">done</i>
		</div>

		<div class="index-pricing-details">
			<i class="material-icons checkmark">done</i>
		</div>

		<div class="index-pricing-info justify-start">
			<span class="label label-primary mr-2">NEW</span>
			<span>Live Chat</span>
		</div>

		<div class="index-pricing-details">
			<i class="material-icons checkmark">done</i>
		</div>

		<div class="index-pricing-details">
			<i class="material-icons checkmark">done</i>
		</div>

		<div class="index-pricing-details">
			<i class="material-icons checkmark">done</i>
		</div>

		<div class="index-pricing-info justify-start">
			<span>Mobile Optimization</span>
		</div>

		<div class="index-pricing-details">
			
		</div>

		<div class="index-pricing-details">
			<i class="material-icons checkmark">done</i>
		</div>

		<div class="index-pricing-details">
			<i class="material-icons checkmark">done</i>
		</div>

		<div class="index-pricing-info justify-start">
			<span>HTML Access</span>
		</div>

		<div class="index-pricing-details">
			
		</div>

		<div class="index-pricing-details">
			<i class="material-icons checkmark">done</i>
		</div>

		<div class="index-pricing-details">
			<i class="material-icons checkmark">done</i>
		</div>

		<div class="index-pricing-info justify-start">
			<span>Membership Features</span>
		</div>

		<div class="index-pricing-details">
			
		</div>

		<div class="index-pricing-details">
			<i class="material-icons checkmark">done</i>
		</div>

		<div class="index-pricing-details">
			<i class="material-icons checkmark">done</i>
		</div>

		<div class="index-pricing-info justify-start">
			<span>Unlimited Styles & Effects</span>
		</div>

		<div class="index-pricing-details">
			
		</div>

		<div class="index-pricing-details">

		</div>

		<div class="index-pricing-details">
			<i class="material-icons checkmark">done</i>
		</div>

		<div class="index-pricing-info justify-start">
			<span>Online Store</span>
		</div>

		<div class="index-pricing-details">
			
		</div>

		<div class="index-pricing-details">
			
		</div>

		<div class="index-pricing-details">
			<i class="material-icons checkmark">done</i>
		</div>

		<div class="index-pricing-info justify-start bottom-left-border-radius">
			<span>Lightning Fast CDN</span>
		</div>

		<div class="index-pricing-details">			
		</div>

		<div class="index-pricing-details">			
		</div>

		<div class="index-pricing-details bottom-right-border-radius">
			<i class="material-icons checkmark">done</i>
		</div>

	</div>
</div>
</div>
</div>

<!-- Phone View -->

	<div id="pricing-page-phone" class="w-full grid grid-cols-1 lg:hidden px-8">
		<div class="mb-10">
			<div class="pricing-card-container text-center">
				<div class="border border-gray-300 border-default-radius bg-white shadow-none">
					<div class="index-pricing-header top-right-border-radius top-left-border-radius border-none bg-white">
						<div>
							<h3 class="plan-name">Pro Plus</h3>
							<p class="plan-sub h-4em">Perfect for clubs, organizations, teams, and non-profits.</p>
						</div>

						<hr class="hr w-full">

						<p>Was <span class="strike">{{ $symbol.$proplus_price_before }}/mo</span></p>
						<p>Now only<br><span class="text-abouttitle span font-normal">{{ $symbol.$proplus_price_major.'.'.$proplus_price_minor }}/mo</span></p>

						<button data-plan="plus" class="m-0 block btn btn-raised btn-trans btn-secondary md:px-20">Continue</button>
						
					</div>

					<ul>
						<li>
							<h3 class="">Custom Domain Name</h3>&nbsp;
							<i class="p-2 material-icons checkmark">done</i>
						</li>
						<li>
							<div>Search Engine Submission</div>&nbsp;
							<div class="mt-2 p-2 se-bg google-only"></div>
						</li>
						<li>
							<h3>$250 Free Advertising</h3>&nbsp;
							<i class="p-2 material-icons checkmark">done</i>
						</li>
						<li>
							<div>Social Integration</div>
							<div class="icon-set mt-2 flex justify-center">
				<i class="fb-logo">
					<svg xmlns="http://www.w3.org/2000/svg" height="24px" width="24px" fill="#3b5998" viewBox="0 0 448 512"><path d="M400 32H48A48 48 0 0 0 0 80v352a48 48 0 0 0 48 48h137.25V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.27c-30.81 0-40.42 19.12-40.42 38.73V256h68.78l-11 71.69h-57.78V480H400a48 48 0 0 0 48-48V80a48 48 0 0 0-48-48z"/></svg>
				</i>
				<!-- <i class="fa fa-facebook"></i> -->
				<i class="twitter-logo">
					<svg xmlns="http://www.w3.org/2000/svg" height="24px" width="24px" fill="1DA1F2" viewBox="0 0 448 512"><path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm297.1 84L257.3 234.6 379.4 396H283.8L209 298.1 123.3 396H75.8l111-126.9L69.7 116h98l67.7 89.5L313.6 116h47.5zM323.3 367.6L153.4 142.9H125.1L296.9 367.6h26.3z"/></svg>
				</i>
				<i class="instagram-logo-phone">
					<svg xmlns="http://www.w3.org/2000/svg" height="24px" width="24px" fill="#E4405F" viewBox="0 0 448 512">
						<radialGradient id="instaGradient" r="150%" cx="30%" cy="107%">
    					<stop stop-color="#fdf497" offset="0" />
    					<stop stop-color="#fdf497" offset="0.05" />
    					<stop stop-color="#fd5949" offset="0.45" />
    					<stop stop-color="#d6249f" offset="0.6" />
    					<stop stop-color="#285AEB" offset="0.9" />
  						</radialGradient>
						<path d="M224,202.66A53.34,53.34,0,1,0,277.36,256,53.38,53.38,0,0,0,224,202.66Zm124.71-41a54,54,0,0,0-30.41-30.41c-21-8.29-71-6.43-94.3-6.43s-73.25-1.93-94.31,6.43a54,54,0,0,0-30.41,30.41c-8.28,21-6.43,71.05-6.43,94.33S91,329.26,99.32,350.33a54,54,0,0,0,30.41,30.41c21,8.29,71,6.43,94.31,6.43s73.24,1.93,94.3-6.43a54,54,0,0,0,30.41-30.41c8.35-21,6.43-71.05,6.43-94.33S357.1,182.74,348.75,161.67ZM224,338a82,82,0,1,1,82-82A81.9,81.9,0,0,1,224,338Zm85.38-148.3a19.14,19.14,0,1,1,19.13-19.14A19.1,19.1,0,0,1,309.42,189.74ZM400,32H48A48,48,0,0,0,0,80V432a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48V80A48,48,0,0,0,400,32ZM382.88,322c-1.29,25.63-7.14,48.34-25.85,67s-41.4,24.63-67,25.85c-26.41,1.49-105.59,1.49-132,0-25.63-1.29-48.26-7.15-67-25.85s-24.63-41.42-25.85-67c-1.49-26.42-1.49-105.61,0-132,1.29-25.63,7.07-48.34,25.85-67s41.47-24.56,67-25.78c26.41-1.49,105.59-1.49,132,0,25.63,1.29,48.33,7.15,67,25.85s24.63,41.42,25.85,67.05C384.37,216.44,384.37,295.56,382.88,322Z"/></svg>
				</i>
				<i class="pinterest-logo">
					<svg xmlns="http://www.w3.org/2000/svg" height="24px" width="24px" fill="#E60023" viewBox="0 0 448 512"><path d="M448 80v352c0 26.5-21.5 48-48 48H154.4c9.8-16.4 22.4-40 27.4-59.3 3-11.5 15.3-58.4 15.3-58.4 8 15.3 31.4 28.2 56.3 28.2 74.1 0 127.4-68.1 127.4-152.7 0-81.1-66.2-141.8-151.4-141.8-106 0-162.2 71.1-162.2 148.6 0 36 19.2 80.8 49.8 95.1 4.7 2.2 7.1 1.2 8.2-3.3.8-3.4 5-20.1 6.8-27.8.6-2.5.3-4.6-1.7-7-10.1-12.3-18.3-34.9-18.3-56 0-54.2 41-106.6 110.9-106.6 60.3 0 102.6 41.1 102.6 99.9 0 66.4-33.5 112.4-77.2 112.4-24.1 0-42.1-19.9-36.4-44.4 6.9-29.2 20.3-60.7 20.3-81.8 0-53-75.5-45.7-75.5 25 0 21.7 7.3 36.5 7.3 36.5-31.4 132.8-36.1 134.5-29.6 192.6l2.2.8H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h352c26.5 0 48 21.5 48 48z"/></svg>
				</i>
			</div>
						</li>
						<li><h3>1 Business Email Address</h3>&nbsp;
							<i class="p-2 material-icons checkmark">done</i>
						</li>
						<li><h3>SEO Tools</h3>&nbsp;
							<i class="p-2 material-icons checkmark">done</i>
						</li>
						<li><h3>Unlimited Pages</h3>&nbsp;
							<i class="p-2 material-icons checkmark">done</i>
						</li>
						<li><h3>1,000 Contact Forms</h3>&nbsp;
							<i class="p-2 material-icons checkmark">done</i>
						</li>
						<li><h3>Unlimited Slideshows &amp; Galleries</h3>&nbsp;
							<i class="p-2 material-icons checkmark">done</i>
						</li>
						<li>10GB Cloud Storage</li>
						<li>100GB/mo Bandwidth</li>
						<li><h3>Ad Free</h3>&nbsp;
							<i class="p-2 material-icons checkmark">done</i>
						</li>
						<li>
							<div class="flex items-center justify-center">
							<span class="primary-label">NEW</span> 
							<h3>Notification Center</h3>
							</div>
							&nbsp;
							<i class="p-2 material-icons checkmark">done</i></li>
						<li>
							<div class="flex items-center justify-center">
							<span class="primary-label">NEW</span>
							<h3> Live Chat</h3>&nbsp;
							</div>
							<i class="p-2 material-icons checkmark">done</i>
						</li>
						<li>
							<h3>Mobile Optimized</h3>&nbsp;
							<i class="p-2 material-icons checkmark">done</i>
						</li>
						<li><h3>HTML Access</h3>&nbsp;
							<i class="p-2 material-icons checkmark">done</i></li>
						<li><h3>Membership Features</h3>&nbsp;
							<i class="p-2 material-icons checkmark">done</i></li>
						<li><h3>Unlimited Styles &amp; Effects</h3>&nbsp;
							<i class="p-2 material-icons checkmark">close</i></li>
						<li><h3>Online Store</h3>&nbsp;
							<i class="p-2 material-icons checkmark">close</i></li>
						<li><h3>Lightning Fast CDN</h3>&nbsp;
							<i class="p-2 material-icons checkmark">close</i></li>
					</ul>
				</div>
			</div>
		</div>

		<div class="mb-10">
			<div class="pricing-card-container text-center">
				<div class="border border-gray-300 border-default-radius bg-white shadow-none">
					<div class="index-pricing-header top-right-border-radius top-left-border-radius border-none bg-white">
						<div>
							<h3 class="plan-name">Business</h3>
							<p class="plan-sub h-4em">The right choice for businesses looking to expand.</p>
						</div>

						<hr class="hr w-full">

						<p>Was <span class="strike">{{ $symbol.$business_price_before }}/mo</span></p>
						<p>Now only<br><span class="text-abouttitle span font-normal">{{ $symbol.$business_price_major.'.'.$business_price_minor }}/mo</span></p>

						<button data-plan="business" class="m-0 block btn btn-raised btn-trans btn-secondary md:px-20">Continue</button>
						
					</div>

					<ul>
						<li><h3>Custom Domain Name</h3>&nbsp;
							<i class="p-2 material-icons checkmark">done</i></li>
						<li>
							<div>Search Engine Submission</div>&nbsp;
							<div class="mt-2 p-2 se-bg"></div>
						</li>
						<li><h3>$500 Free Advertising</h3>&nbsp;
							<i class="p-2 material-icons checkmark">done</i>
						</li>
						<li>
							<div>Social Integration</div>
							<div class="icon-set flex justify-center mt-2">
				<i class="fb-logo">
					<svg xmlns="http://www.w3.org/2000/svg" height="24px" width="24px" fill="#3b5998" viewBox="0 0 448 512"><path d="M400 32H48A48 48 0 0 0 0 80v352a48 48 0 0 0 48 48h137.25V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.27c-30.81 0-40.42 19.12-40.42 38.73V256h68.78l-11 71.69h-57.78V480H400a48 48 0 0 0 48-48V80a48 48 0 0 0-48-48z"/></svg>
				</i>
				<!-- <i class="fa fa-facebook"></i> -->
				<i class="twitter-logo">
					<svg xmlns="http://www.w3.org/2000/svg" height="24px" width="24px" fill="1DA1F2" viewBox="0 0 448 512"><path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm297.1 84L257.3 234.6 379.4 396H283.8L209 298.1 123.3 396H75.8l111-126.9L69.7 116h98l67.7 89.5L313.6 116h47.5zM323.3 367.6L153.4 142.9H125.1L296.9 367.6h26.3z"/></svg>
				</i>
				<i class="instagram-logo-phone">
					<svg xmlns="http://www.w3.org/2000/svg" height="24px" width="24px" fill="#E4405F" viewBox="0 0 448 512">
						<radialGradient id="instaGradient" r="150%" cx="30%" cy="107%">
    					<stop stop-color="#fdf497" offset="0" />
    					<stop stop-color="#fdf497" offset="0.05" />
    					<stop stop-color="#fd5949" offset="0.45" />
    					<stop stop-color="#d6249f" offset="0.6" />
    					<stop stop-color="#285AEB" offset="0.9" />
  						</radialGradient>
						<path d="M224,202.66A53.34,53.34,0,1,0,277.36,256,53.38,53.38,0,0,0,224,202.66Zm124.71-41a54,54,0,0,0-30.41-30.41c-21-8.29-71-6.43-94.3-6.43s-73.25-1.93-94.31,6.43a54,54,0,0,0-30.41,30.41c-8.28,21-6.43,71.05-6.43,94.33S91,329.26,99.32,350.33a54,54,0,0,0,30.41,30.41c21,8.29,71,6.43,94.31,6.43s73.24,1.93,94.3-6.43a54,54,0,0,0,30.41-30.41c8.35-21,6.43-71.05,6.43-94.33S357.1,182.74,348.75,161.67ZM224,338a82,82,0,1,1,82-82A81.9,81.9,0,0,1,224,338Zm85.38-148.3a19.14,19.14,0,1,1,19.13-19.14A19.1,19.1,0,0,1,309.42,189.74ZM400,32H48A48,48,0,0,0,0,80V432a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48V80A48,48,0,0,0,400,32ZM382.88,322c-1.29,25.63-7.14,48.34-25.85,67s-41.4,24.63-67,25.85c-26.41,1.49-105.59,1.49-132,0-25.63-1.29-48.26-7.15-67-25.85s-24.63-41.42-25.85-67c-1.49-26.42-1.49-105.61,0-132,1.29-25.63,7.07-48.34,25.85-67s41.47-24.56,67-25.78c26.41-1.49,105.59-1.49,132,0,25.63,1.29,48.33,7.15,67,25.85s24.63,41.42,25.85,67.05C384.37,216.44,384.37,295.56,382.88,322Z"/></svg>
				</i>
				<i class="pinterest-logo">
					<svg xmlns="http://www.w3.org/2000/svg" height="24px" width="24px" fill="#E60023" viewBox="0 0 448 512"><path d="M448 80v352c0 26.5-21.5 48-48 48H154.4c9.8-16.4 22.4-40 27.4-59.3 3-11.5 15.3-58.4 15.3-58.4 8 15.3 31.4 28.2 56.3 28.2 74.1 0 127.4-68.1 127.4-152.7 0-81.1-66.2-141.8-151.4-141.8-106 0-162.2 71.1-162.2 148.6 0 36 19.2 80.8 49.8 95.1 4.7 2.2 7.1 1.2 8.2-3.3.8-3.4 5-20.1 6.8-27.8.6-2.5.3-4.6-1.7-7-10.1-12.3-18.3-34.9-18.3-56 0-54.2 41-106.6 110.9-106.6 60.3 0 102.6 41.1 102.6 99.9 0 66.4-33.5 112.4-77.2 112.4-24.1 0-42.1-19.9-36.4-44.4 6.9-29.2 20.3-60.7 20.3-81.8 0-53-75.5-45.7-75.5 25 0 21.7 7.3 36.5 7.3 36.5-31.4 132.8-36.1 134.5-29.6 192.6l2.2.8H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h352c26.5 0 48 21.5 48 48z"/></svg>
				</i>
			</div>
						</li>
						<li><h3>5 Business Email Addresses</h3>&nbsp;
							<i class="p-2 material-icons checkmark">done</i></li>
						<li><h3>SEO Tools</h3>&nbsp;
							<i class="p-2 material-icons checkmark">done</i></li>
						<li><h3>Unlimited Pages</h3>&nbsp;
							<i class="p-2 material-icons checkmark">done</i></li>
						<li><h3>Unlimited Contact Forms</h3>&nbsp;
							<i class="p-2 material-icons checkmark">done</i></li>
						<li><h3>Unlimited Slideshows &amp; Galleries</h3>&nbsp;
							<i class="p-2 material-icons checkmark">done</i></li>
						<li>40GB Cloud Storage</li>
						<li><h3>Unlimited Bandwidth</h3>&nbsp;
							<i class="p-2 material-icons checkmark">done</i></li>
						<li><h3>Ad Free</h3>&nbsp;
							<i class="p-2 material-icons checkmark">done</i></li>
						<li>
							<div class="flex items-center justify-center">
							<span class="primary-label">NEW</span>
							<h3> Notification Center</h3>&nbsp;
							</div>
							<i class="p-2 material-icons checkmark">done</i></li>
						<li>
							<div class="flex items-center justify-center">
							<span class="primary-label">NEW</span>
							<h3> Live Chat</h3>&nbsp;
							</div>
							<i class="p-2 material-icons checkmark">done</i></li>
						<li><h3>Mobile Optimized</h3>&nbsp;
							<i class="p-2 material-icons checkmark">done</i></li>
						<li><h3>HTML Access</h3>&nbsp;
							<i class="p-2 material-icons checkmark">done</i></li>
						<li><h3>Membership Features</h3>&nbsp;
							<i class="p-2 material-icons checkmark">done</i></li>
						<li><h3>Unlimited Styles &amp; Effects</h3>&nbsp;
							<i class="p-2 material-icons checkmark">done</i></li>
						<li><h3>Online Store</h3>&nbsp;
							<i class="p-2 material-icons checkmark">done</i></li>
						<li><h3>Lightning Fast CDN</h3>&nbsp;
							<i class="p-2 material-icons checkmark">done</i></li>
					</ul>
				</div>
			</div>
		</div>

		<div class="">
			<div class="pricing-card-container text-center">
				<div class="border border-gray-300 border-default-radius bg-white shadow-none">
					<div class="top-left-border-radius top-right-border-radius border-none index-pricing-header bg-white">
						<div>
							<h3 class="plan-name">Free</h3>
							<p class="plan-sub h-4em">Kick the tires and take it for a spin.</p>
						</div>

						<hr class="hr w-full">

						<p>Sign Up It's Free.</p>
						<p>Takes less than 30 seconds.<br class="visible-lg"><span class="h3">&nbsp;</span></p>

						<button data-plan="free" class="m-0 block btn btn-raised btn-trans btn-default md:px-20">Continue</button>
					</div>

					<ul>
						<li><h3>Custom Domain Name</h3>&nbsp;
							<i class="p-2 material-icons checkmark">close</i></li>
						<li><h3>Search Engine Submission</h3>&nbsp;
							<i class="p-2 material-icons checkmark">close</i></li>
						<li><h3>Free Advertising</h3>&nbsp;
							<i class="p-2 material-icons checkmark">close</i></li>
						<li><h3>Social Integration</h3>&nbsp;
							<i class="p-2 material-icons checkmark">close</i></li>
						<li><h3>Business Emails</h3>&nbsp;
							<i class="p-2 material-icons checkmark">close</i></li>
						<li><h3>SEO Tools</h3>&nbsp;
							<i class="p-2 material-icons checkmark">close</i></li>
						<li><h3>Unlimited Pages</h3>&nbsp;
							<i class="p-2 material-icons checkmark">done</i></li>
						<li><h3>Contact Forms</h3>&nbsp;
							<i class="p-2 material-icons checkmark">close</i></li>
						<li><h3>Slideshows &amp; Galleries</h3>&nbsp;
							<i class="p-2 material-icons checkmark">close</i></li>
						<li>1GB Cloud Storage</li>
						<li>1GB/mo Bandwidth</li>
						<li><h3>Ad Free</h3>&nbsp;
							<i class="p-2 material-icons checkmark">close</i></li>
						<li>
							<div class="flex items-center justify-center">
							<span class="primary-label">NEW</span>
							 <h3>Notification Center</h3>&nbsp;
							 </div>
							 <i class="p-2 material-icons checkmark">done</i></li>
						<li>
							<div class="flex items-center justify-center">
							<span class="primary-label">NEW</span>
						 	<h3>Live Chat</h3>&nbsp;
						 	</div>
							<i class="p-2 material-icons checkmark">done</i></li>
						<li><h3>Mobile Optimized</h3>&nbsp;
							<i class="p-2 material-icons checkmark">close</i></li>
						<li><h3>HTML Access</h3>&nbsp;
							<i class="p-2 material-icons checkmark">close</i></li>
						<li><h3>Membership Features</h3>&nbsp;
							<i class="p-2 material-icons checkmark">close</i></li>
						<li><h3>Unlimited Styles &amp; Effects</h3>&nbsp;
							<i class="p-2 material-icons checkmark">close</i></li>
						<li><h3>Online Store</h3>&nbsp;
							<i class="p-2 material-icons checkmark">close</i></li>
						<li><h3>Lightning Fast CDN</h3>&nbsp;
							<i class="p-2 material-icons checkmark">close</i></li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="aligner mt-24">
		
			<h4 class="text-center text-paragraph font-semibold" >
				Need more room to grow? <a href="https://help.webstarts.com/" class="text-primarycolor hover:underline">Contact us</a> about business development and enterprise solutions.
			</h4>
		
	</div>
</div>
	<form name="plan-select" method="POST" action="/plan-select">
		@csrf
		<input type="hidden" name="plan" />
	</form>
	</section>
	@include('footer')
{!! Meta::footer()->toHtml() !!}
</body>
</html>