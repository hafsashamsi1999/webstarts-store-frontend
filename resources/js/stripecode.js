function stripeToken(key, _callback) {
    var stripe = Stripe(key)
    ,	elements = stripe.elements({fonts: [{cssSrc: 'https://fonts.googleapis.com/css?family=Open+Sans:300'}]})
    ,	style = {
            base: {
                color: "#000",
                fontFamily: '"Open Sans", Helvetica, Arial, sans-serif',
                fontWeight: '300',
                fontSmoothing: "antialiased",
                fontSize: "17px"
            },
            invalid: {
                color: "#f44336",
                iconColor: "#f44336"
            }
        }
    ,	card = elements.create('card', {style: style})
    ,   callback = _callback
    ;

    card.mount('#card-element');

    card.addEventListener('change', function(event) {

        if (event.error) {
            $("#card-error").html(
                '<div class="alert alert-danger"><div class="alert-icon"><i class="material-icons">error_outline</i></div><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i class="material-icons">clear</i></span></button>' + event.error.message + '</div>'
            ).show();
        } else {
            $("#card-error").empty().hide();
        }
    });

    $('#add-card-element').click(function(){

        $('#add-card-element').addClass('disabled');

        //var $loader = setLoading();
        stripe.createToken(card).then(function(result) {
            $('#add-card-element').removeClass('disabled');
            //$loader.remove();

            if (result.error) {
                $("#card-error").html(
                    '<div class="alert alert-danger"><div class="alert-icon"><i class="material-icons">error_outline</i></div><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i class="material-icons">clear</i></span></button>' + result.error.message + '</div>'
                ).show();
            } else {
                $("#card-error").empty().hide();

                var data = {stripeToken: result.token};

                //callback = callback || function(resp){};
                //user_cards.addCardFromToken(userid, data, callback);
                //console.log(result.token);
            }
        });
    });
}

/* function setLoading() {
    var $loader = $('<div />').addClass('load-inplace').append(WSUI.generateLoader({center: true}));
    $('.card-content:last').css({position: 'relative'}).append($loader);
    return $loader;
} */

/* function stripeIntent(key) {
    var stripe = Stripe(key, {apiVersion: "2020-08-27"})
    ,	styles = {
        layout: {
            type: 'accordion'
        },
    }
    ,	appearance = {
        theme: 'stripe',
        labels: 'floating',
        variables: {
            colorPrimary: '#03a9f4',
            colorBackground: '#ffffff',
            colorText: '#333333',
            colorDanger: '#f44336',
            fontFamily: 'Open Sans, system-ui, sans-serif',
            borderRadius: '8px',
            fontSmooth: 'always',
            // See all possible variables below
        },
        rules: {
            '.Input': {
                backgroundColor: 'rgba(0,0,0,.04)',
                border: 0,
                outline: 0,
                borderBottomLeftRadius: 0,
                borderBottomRightRadius: 0,
                boxShadow: 'none',
            },
            '.Input:focus': {
                boxShadow: '0px 2px 0px 0px rgba(3,169,244,0.75)'
            }
        }
    }
    ,   options = {
            mode: 'setup',
            currency: 'usd',
            appearance: appearance
        }
    ,   elements = stripe.elements(options)
    ;

    const paymentElement = elements.create("payment", styles);
    paymentElement.mount("#payment-element");

    const handleSubmit = async (event) => {
        event.preventDefault();
      
        if (!stripe) {
          // Stripe.js hasn't yet loaded.
          // Make sure to disable form submission until Stripe.js has loaded.
          return;
        }
      
        var $loader = setLoading(true);
        $('#add-card-element').addClass('disabled');
      
        // Trigger form validation and wallet collection
        const {error: submitError} = await elements.submit();
        if (submitError) {
          handleError(submitError);
          return;
        }
      
        // Create the SetupIntent and obtain clientSecret
        const res = await fetch("/library/services/stripe-setup-intent-create.php", {
          method: "POST",
          headers: {"Content-Type": "application/json"},
        });
      
        const {client_secret: clientSecret} = await res.json();

        const baseDomain = window.location.origin || window.location.protocol + '//' + window.location.host;
        // Use the clientSecret and Elements instance to confirm the setup
        const {error} = await stripe.confirmSetup({
          elements,
          clientSecret,
          confirmParams: {
            return_url: baseDomain + '/cadmin/dashboard/billing',
          },
          // Uncomment below if you only want redirect for redirect-based payments
          redirect: "if_required",
        });

        $loader.remove();
        $('#add-card-element').removeClass('disabled');
      
        if (error) {
            $("#card-error").html(
                '<div class="alert alert-danger"><div class="alert-icon"><i class="material-icons">error_outline</i></div><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i class="material-icons">clear</i></span></button>' + error.message + '</div>'
            ).show();
        } else {
            // The setup has succeeded. Display a success message.
            $("#card-error").html(
                '<div class="alert alert-success alert-dismissible show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i class="material-icons">close</i></span></button><div class="alert-icon"><i class="material-icons">info_outline</i></div><span>Payment method added successfully</span></div>'
            ).show();

            user_cards.get_cards(userid,show_cards);
            ajax_loading($('#table-wrapper'));
        }
    };

    $('#add-card-element').click(function(e){
        handleSubmit(e);
    });
} */