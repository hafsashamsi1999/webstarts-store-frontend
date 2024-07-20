<!DOCTYPE html>
<html lang="en-US">
<head>
{!! Meta::toHtml() !!}
<script type="text/javascript">
    // Pass the database $plans array to a JavaScript variable
    const allplans = @json($plans);
    var categorizedArray = {
            YEARLY: [],
            YEARLY_TRIAL: [],
            MONTHLY: [],
            MONTHLY_TRIAL: []
        }
    ;

    function generatePlansHtml(plans) {
        let html = '';

        for (let i = 0; i < plans.length; i++) {
            const plan = plans[i]
            ,   plan_recursion = (plan.recursion == 3) ?'yearly' :'monthly'
            ,   trial_days = (plan_recursion == 'yearly') ?categorizedArray.YEARLY_TRIAL[i].trial_days :categorizedArray.MONTHLY_TRIAL[i].trial_days
            ,   trial_pcode = (plan_recursion == 'yearly') ?categorizedArray.YEARLY_TRIAL[i].pcode :categorizedArray.MONTHLY_TRIAL[i].pcode
            ;

            if(plan.key_features)
                plan.key_features = (typeof plan.key_features === 'string') ?JSON.parse(plan.key_features) :plan.key_features;
            else 
                plan.key_features = [];

            // format number to US dollar
            let USDollar = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD',
            });
            const frequency = (plan_recursion == 'yearly') ?'year' :'month';
            const renews_at = USDollar.format(plan.price) + "/" + frequency;
            const renews_at_permonth = (plan_recursion == 'yearly') ?USDollar.format(plan.price/12) + "/month" :USDollar.format(plan.price) + "/month";

            html += `
            <div id="plan_${plan.pcode}" class="flex justify-between flex-col md:w-2/4 top-right-border-radius top-left-border-radius bg-white" style="border-color:rgba(209,213,219,var(--tw-border-opacity)); border-width:1px; padding:20px">
                <div class="flex flex-col">
                    <div class="flex flex-col justify-between">
                        <div class="text-center">
                            <h1 class="font-semibold mt-5" style="font-size:24px">${plan.simple_name}</h1>
                            <h3 class="mt-2 mb-20">${renews_at_permonth}</h3>
                        </div>
                        <p>${plan.description}</p>
                    </div>
                    <div class="d-flex flex-grow">
                        <ul>
                            ${plan.key_features.map(f => `<li>${f}</li>`).join('')}
                        </ul>
                    </div>
                </div>
                    <div>
                    <div class="text-center mt-20 mb-5">
                        <button id="${trial_pcode}" class="btn btn-raised btn-primary trial-plan-selected">Start Free Trial</button>
                        <p>${trial_days} days free trial. Renews at ${renews_at}</p>
                    </div>
                    </div>
            </div>
            `;
        }
        $('#plans-container').html(html);
    }

	document.addEventListener('DOMContentLoaded', function() {
	
		/* $(window).scroll(function() {
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
		}); */

		/* $('button[data-plan]').click(function() {
			let plan = $(this).data('plan')
			,	$form = $('form[name="plan-select"]')
			;
			
			$form.find('input[name="plan"]').val(plan);
			$form[0].submit();
		}); */

        allplans.forEach(item => {
            if (item.pcode.includes('YEARLY')) {
                if (item.pcode.includes('TRIAL')) {
                    categorizedArray.YEARLY_TRIAL.push(item);
                } else {
                    categorizedArray.YEARLY.push(item);
                }
            } else if (item.pcode.includes('MONTHLY')) {
                if (item.pcode.includes('TRIAL')) {
                    categorizedArray.MONTHLY_TRIAL.push(item);
                } else {
                    categorizedArray.MONTHLY.push(item);
                }
            }
        });

        console.log(categorizedArray);
        generatePlansHtml(categorizedArray.YEARLY);

        $('#frequency li').click(function(){
            $('#frequency li').removeClass('active');
            $(this).addClass('active');
            let freq = $(this).text().toLowerCase();
            let plans_array = categorizedArray[freq.toUpperCase()];
            generatePlansHtml(plans_array);
        });

        $('.trial-plan-selected').click(function(){
            let plan_id = $(this).attr('id')
			,	$form = $('form[name="plan-select"]')
			;
			
			$form.find('input[name="planid"]').val(plan_id);
			$form[0].submit();
            //console.log(plan_id);
            //creditCardPopup({plan: plan_id}, function(){});
        });
	});
</script>
</head>
<body>
	@include('index-header')
	<section id="pricing-page" class="bg-white pb-5">
		<div class="main-section-text-column">
			<div class="py-9">
			<h1 class="main-section-heading text-center lg:text-left">Plans & Pricing</h1>	
			<p class="main-section-paragraph">Explore WebStarts plans and pricing to start your online journey today.</p>
			</div>		
		</div>


        <div class="">
            <div class="aligner">
                <div class="container mx-auto">
                    <div class="flex justify-center mt-0">
                        <div class="">Save 50% with yearly</div>
                    </div>
                    <div class="flex justify-center mb-0">
                        <div class="my-2">
                            <ul id="frequency" class="flex justify-between">
                                <li class="active"><a href="#" class="px-4 py-2">Yearly</a></li>
                                <li><a href="#" class="px-4 py-2">Monthly</a></li>
                            </ul>
                        </div>
                    </div>
                    <div id="plans-container" class="flex gap-5 flex-wrap md:flex-nowrap justify-evenly"></div>
                </div>

            </div>
        </div>




        <form name="plan-select" method="POST" action="/plan-select-trial">
            @csrf
            <input type="hidden" name="planid" />
        </form>
	</section>
	@include('footer')
{!! Meta::footer()->toHtml() !!}
</body>
</html>