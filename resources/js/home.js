/* document.addEventListener("DOMContentLoaded", (event) => {
    setTimeout(function() {
        ready();
    }, 5000);
}); */

window.onload = function(){
    setTimeout(function() {
        ready();
    }, 3000);
};

function ready() {
    showGoogleReviews3();
    console.log('Done');
}

function showGoogleReviews3() {

    var $reviews = $('#customer-testimonials3 .review-container'),
        $wrapper = $reviews.find('.wrapper'),
        $indicators = $reviews.find('.indicators'),
        $slidesbtn = $reviews.find('.indicators-button'),
        googleLogo = 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KPHN2ZyB2aWV3Qm94PSIwIDAgMjQgMjQiIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICA8ZyB0cmFuc2Zvcm09Im1hdHJpeCgxLCAwLCAwLCAxLCAyNy4wMDkwMDEsIC0zOS4yMzg5OTgpIj4KICAgIDxwYXRoIGZpbGw9IiM0Mjg1RjQiIGQ9Ik0gLTMuMjY0IDUxLjUwOSBDIC0zLjI2NCA1MC43MTkgLTMuMzM0IDQ5Ljk2OSAtMy40NTQgNDkuMjM5IEwgLTE0Ljc1NCA0OS4yMzkgTCAtMTQuNzU0IDUzLjc0OSBMIC04LjI4NCA1My43NDkgQyAtOC41NzQgNTUuMjI5IC05LjQyNCA1Ni40NzkgLTEwLjY4NCA1Ny4zMjkgTCAtMTAuNjg0IDYwLjMyOSBMIC02LjgyNCA2MC4zMjkgQyAtNC41NjQgNTguMjM5IC0zLjI2NCA1NS4xNTkgLTMuMjY0IDUxLjUwOSBaIi8+CiAgICA8cGF0aCBmaWxsPSIjMzRBODUzIiBkPSJNIC0xNC43NTQgNjMuMjM5IEMgLTExLjUxNCA2My4yMzkgLTguODA0IDYyLjE1OSAtNi44MjQgNjAuMzI5IEwgLTEwLjY4NCA1Ny4zMjkgQyAtMTEuNzY0IDU4LjA0OSAtMTMuMTM0IDU4LjQ4OSAtMTQuNzU0IDU4LjQ4OSBDIC0xNy44ODQgNTguNDg5IC0yMC41MzQgNTYuMzc5IC0yMS40ODQgNTMuNTI5IEwgLTI1LjQ2NCA1My41MjkgTCAtMjUuNDY0IDU2LjYxOSBDIC0yMy40OTQgNjAuNTM5IC0xOS40NDQgNjMuMjM5IC0xNC43NTQgNjMuMjM5IFoiLz4KICAgIDxwYXRoIGZpbGw9IiNGQkJDMDUiIGQ9Ik0gLTIxLjQ4NCA1My41MjkgQyAtMjEuNzM0IDUyLjgwOSAtMjEuODY0IDUyLjAzOSAtMjEuODY0IDUxLjIzOSBDIC0yMS44NjQgNTAuNDM5IC0yMS43MjQgNDkuNjY5IC0yMS40ODQgNDguOTQ5IEwgLTIxLjQ4NCA0NS44NTkgTCAtMjUuNDY0IDQ1Ljg1OSBDIC0yNi4yODQgNDcuNDc5IC0yNi43NTQgNDkuMjk5IC0yNi43NTQgNTEuMjM5IEMgLTI2Ljc1NCA1My4xNzkgLTI2LjI4NCA1NC45OTkgLTI1LjQ2NCA1Ni42MTkgTCAtMjEuNDg0IDUzLjUyOSBaIi8+CiAgICA8cGF0aCBmaWxsPSIjRUE0MzM1IiBkPSJNIC0xNC43NTQgNDMuOTg5IEMgLTEyLjk4NCA0My45ODkgLTExLjQwNCA0NC41OTkgLTEwLjE1NCA0NS43ODkgTCAtNi43MzQgNDIuMzY5IEMgLTguODA0IDQwLjQyOSAtMTEuNTE0IDM5LjIzOSAtMTQuNzU0IDM5LjIzOSBDIC0xOS40NDQgMzkuMjM5IC0yMy40OTQgNDEuOTM5IC0yNS40NjQgNDUuODU5IEwgLTIxLjQ4NCA0OC45NDkgQyAtMjAuNTM0IDQ2LjA5OSAtMTcuODg0IDQzLjk4OSAtMTQuNzU0IDQzLjk4OSBaIi8+CiAgPC9nPgo8L3N2Zz4=';;


    $.get('/google_reviews').done(function(response) {
        if (response.data) {

            var timer
            ,	loading = false
            ;

            response.data.forEach(function(review, index) {
                var active = index === 0 ? true : false,
                    $slide = $('<div class="card-main" />').appendTo($wrapper),
                    $button = $('<button />').appendTo($indicators);

                $slide.append(
                    '<div class="card-review">' +
                    '<div class="card-thumb mx-auto">' +
                    '<div class="client-info">' +
                    '<img class="client-img" data-src="' + review.reviewer_picture_url + '" alt="' + review.reviewer_name + '">' +
                    '</div>' +
                    '</div>' +
                    '<div class="card-body">' +
                    '<div class="title-name" data-maxlength="16">' +
                    '<h1 class="name">' + review.reviewer_name + '</h1>' +
                    '<div class="aligner mt-4">' +
                    '<a href="' + review.url + '" target="_review">' +
                    '<img class="g-logo" src="' + googleLogo + '" loading="lazy" alt="google review">' +
                    '</a>' +
                    '<div class="text-label">' + getTime(review.published_at) + '</div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="review" data-maxlength="150">' +
                    '<p>"' + review.text + '"</p>' +
                    '</div>' +
                    '<div class="rating">' + getStars(review.rating) + '</div>' +
                    '</div>' +
                    '</div>'
                );

                if (active) {
                    $slide.addClass('active');
                    $button.addClass('active');
                    loadImage($slide);
                }

                $(".review p").text(function(index, currentText) {
                    var maxLength = $(this).parent().attr('data-maxlength');
                    if (currentText.length >= maxLength) {
                        return currentText.substr(0, maxLength) + "....";
                    } else {
                        return currentText
                    }
                });

                $(".card-body .title-name h1").text(function(index, currentText) {
                    var maxLength = $(this).parent().attr('data-maxlength');
                    if (currentText.length >= maxLength) {
                        return currentText.substr(0, maxLength) + "....";
                    } else {
                        return currentText
                    }
                });
            });

            /* auto rotate */
            function changeSlide() {

                if ($wrapper.hasClass('pause') || !isInViewport($wrapper) || loading === true) {
                    return;
                }

                var $slides = $wrapper.find('.card-main'),
                    $buttons = $indicators.find('button'),
                    $active = $slides.filter('.active'),
                    $btnactive = $buttons.filter('.active'),
                    currentSlide = $slides.index($active),
                    lastSlide = $slides.length - 1;

                function removeClass() {
                    $slides.removeClass('active');
                    $buttons.removeClass('active');
                }

                if (currentSlide == lastSlide) {
                    removeClass();
                    $slides.first().addClass('active');
                    $buttons.first().addClass('active');
                } else {
                    var $next = $active.next();
                    loading = true;
                    loadImage($next, function() {
                        loading = false;
                        removeClass();
                        $next.addClass('active');
                        $btnactive.next().addClass('active');
                    });
                }
            }

            timer = setInterval(changeSlide, 5000);
            /* auto rotate */

            /* events */

            //prev
            $slidesbtn.find('.prev').click(function() {
                var $slides = $wrapper.find('.card-main'),
                    $activeSlide = $wrapper.find('.card-main.active'),
                    currentSlide = $slides.index($activeSlide);


                $slides.removeClass('active');

                if (currentSlide == 0) {
                    $slides.last().addClass('active');

                } else {
                    $activeSlide.prev().addClass('active');
                }
            });

            //next
            $slidesbtn.find('.next').click(function() {
                var $slides = $wrapper.find('.card-main'),
                    $activeSlide = $wrapper.find('.card-main.active'),
                    currentSlide = $slides.index($activeSlide),
                    lastSlide = $slides.length - 1;


                $slides.removeClass('active');

                if (currentSlide == lastSlide) {
                    $slides.first().addClass('active');

                } else {
                    $activeSlide.next().addClass('active');
                }
            });

            //buttons
            /*$indicators.find('button').click(function() {
                var $slides = $wrapper.find('.card-main')
                ,	$buttons = $indicators.find('button')
                ,	index = $buttons.index(this)
                ;

                $slides.removeClass('active');
                $buttons.removeClass('active');

                $($slides.get(index)).addClass('active');
                $($buttons.get(index)).addClass('active');
            });*/

            $wrapper.on('mouseenter', function() {
                $(this).addClass('pause');
            }).on('mouseleave', function() {
                $(this).removeClass('pause');
            });
            /* events */


        }
    });
}

function loadImage($slide, callback) {
    var $img = $slide.find('.client-img')
    ,	src = $img.attr('data-src') || false
    ;

    callback = callback || function() {};

    if (src) {
        $img.removeAttr('data-src');
        $img.on('load', function(){callback(true)});
        $img.attr('src', src);
        return true;
    }

    callback(false);
}

function isInViewport(el) {
    var _top = $(el).offset().top,
        _bottom = _top + $(el).outerHeight(),
        vpTop = $(window).scrollTop(),
        vpBottom = vpTop + $(window).height();

    return _bottom > vpTop && _top < vpBottom;
}

function getStars(length) {
    var str = '';
    for (var i = 1; i <= length; i++) {
        str += '<span class="material-icons">star</span>';
    }
    return str;
}

function getTime(time) {
    var currentTime = new Date().getTime() / 1000;
    var timeDifference = currentTime - time;
    var seconds = Math.floor(timeDifference);

    if (seconds < 60) {
        return seconds + " seconds ago";
    }

    var minutes = Math.floor(timeDifference / 60);
    if (minutes < 60) {
        return minutes + " minutes ago";
    }

    var hours = Math.floor(timeDifference / 3600);
    if (hours < 24) {
        return hours + " hours ago";
    }

    var days = Math.floor(timeDifference / 86400);
    if (days < 30) {
        return days + " days ago";
    }

    var months = Math.floor(timeDifference / 2592000);
    if (months < 12) {
        return months + " months ago";
    }

    var years = Math.floor(timeDifference / 31536000);
    return years + " years ago";
}