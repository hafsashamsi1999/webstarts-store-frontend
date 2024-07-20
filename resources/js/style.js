function animateVisibleElements() {
  const elementsToAnimate = document.querySelectorAll('.reveal');
  elementsToAnimate.forEach((element) => {
    if (isElementVisible(element)) {
      element.classList.add('active');
    }
  });
}

function animateOnScroll() {
  const elementsToAnimate = document.querySelectorAll('.reveal:not(.active)');
  elementsToAnimate.forEach((element) => {
    if (isElementVisible(element)) {
      element.classList.add('active');
    }
  });
}

function isElementVisible(element) {
  const rect = element.getBoundingClientRect();
  const windowHeight = window.innerHeight || document.documentElement.clientHeight;
  return rect.top <= windowHeight && rect.bottom >= 0;
}

window.addEventListener('DOMContentLoaded', animateVisibleElements);
window.addEventListener('scroll', animateOnScroll);

/*window.addEventListener("load", () => {
  const intersectionObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("active");
        intersectionObserver.unobserve(entry.target);

        const image = entry.target.querySelector("img[data-src]");
        if (image) {
          const src = image.getAttribute("data-src");
          image.setAttribute("src", src);
          image.removeAttribute("data-src");
        }
      }
    });
  });

  const elementsToLazyLoad = document.querySelectorAll(".reveal");

  elementsToLazyLoad.forEach((element) => {
    intersectionObserver.observe(element);
  });
});
*/

/*function reveal() {
  var reveals = document.querySelectorAll(".reveal");

  for (var i = 0; i < reveals.length; i++) {
    var windowHeight = window.innerHeight;
    var elementTop = reveals[i].getBoundingClientRect().top;
    var elementVisible = 150;

    if (elementTop < windowHeight - elementVisible) {
      reveals[i].classList.add("active");
    } else {
      reveals[i].classList.remove("active");
    }
  }
	}

	window.addEventListener("scroll", reveal);
*/


/*****************FAQ********************/
document.addEventListener("DOMContentLoaded", (event) => {
    $('.faq_question').click(function() {
 
        if ($(this).parent().is('.open')){
            $(this).closest('.faq').find('.faq_answer_container').animate({'height':'0'},400);
            $(this).closest('.faq').removeClass('open');
            $(this).closest('.faq').find('.material-icons').toggleClass('rotate');
            $(this).find('.faq_classes').attr('aria-expanded', 'false');

        } else {
            var newHeight = $(this).closest('.faq').find('.faq_answer').height() +'px';
            $(this).closest('.faq').find('.faq_answer_container').animate({'height':newHeight},400);
            $(this).closest('.faq').addClass('open');
            $(this).closest('.faq').find('.material-icons').toggleClass('rotate');
            $(this).find('.faq_classes').attr('aria-expanded', 'true');
        }
    });

    $(".review p").text(function(index, currentText) {
      var maxLength = $(this).parent().attr('data-maxlength');
        if(currentText.length >= maxLength) {
        return currentText.substr(0, maxLength) + "...";
        } else {
      return currentText
      } 
    });

/*****************Sidebar********************/
  let $btn = $('.sidebar-toggle')
  ,   $navbar = $('.navbar')
  ,   $sidebar = $('.navbar-sidebar')
  ;

  $('.sidebar-toggle').click(function() {
    
    $sidebar.slideToggle("slow");
    $sidebar.addClass('open');
    $sidebar.removeClass('hidden');

    $btn.attr({"aria-pressed":"true", "aria-expanded":"true"});
  });

  $('.sidebar-close').click(function(){

    $sidebar.slideToggle("slow");
    $sidebar.removeClass('open');
    $sidebar.addClass('hidden');

    $btn.attr({"aria-pressed":"false", "aria-expanded":"false"});
  });

  $('.sidebar-overlay').click(function(){
    
    $sidebar.slideToggle("slow");
    $sidebar.removeClass('open');
    $sidebar.addClass('hidden');

    $btn.attr({"aria-pressed":"false", "aria-expanded":"false"});
  });

/*****************WSUI********************/

  //appends an "active" class to .popup and .popup-content when the "Open" button is clicked
  $(".open").on("click", function() {
    $(".popup-overlay, .popup-content").addClass("active");
  });

  //removes the "active" class to .popup and .popup-content when the "Close" button is clicked 
  $(".close, .popup-overlay").on("click", function() {
    $(".popup-overlay, .popup-content").removeClass("active");
  });

  $('.popup-btn').on('click', function(){
    $('.video-popup').fadeIn('slow');
    return false;
  });
  
  $('.popup-bg').on('click', function(){
    $('.video-popup').slideUp('slow');
    $(".video-popup iframe").attr("src", $(".video-popup iframe").attr("src"));

    return false;
  });
  
   $('.close-btn').on('click', function(){
     $('.video-popup').fadeOut('slow');
     $(".video-popup iframe").attr("src", $(".video-popup iframe").attr("src"));
      return false;
   });
  
});

function smoothScrollTo(targetId) {
  const targetElement = document.getElementById(targetId);
  if (targetElement) {
    window.scrollTo({
      top: targetElement.offsetTop,
      behavior: 'smooth' // Add smooth scrolling behavior
    });
  }
}

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function(e) {
    e.preventDefault(); // Prevent the default jump-scroll behavior

    const targetId = this.getAttribute('href').substring(1);
    smoothScrollTo(); // Call the smooth scrolling function
  });
});

function loadScript(src) {
	return new Promise(function (resolve, reject) {
		if ($("script[src='" + src + "']").length === 0) {
			var script = document.createElement('script');
			script.onload = function () {
				resolve();
			};
			script.onerror = function () {
				reject();
			};
			script.src = src;
			document.body.appendChild(script);
		} else {
			resolve();
		}
	});
}