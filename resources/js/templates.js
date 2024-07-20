document.addEventListener("DOMContentLoaded", (e) => {

    var $slideout = $('.slideout-menu');
    var $slideoutmask = $('.slideout-mask');
    var $subcat = $('.slideout-category > ul.sub-menu');

    $('#categories-slideout').click(function() {
        $slideout.addClass('block');
        $('body').css('overflow', 'hidden');
        //$slideoutmask.addClass('block');
        // $slideoutmask.removeClass('hidden');
        // $slideoutmask.addClass('opacity-100');
    });

   /* $('.slideout-category').click(function(event) {
        event.preventDefault();
      var category = event.target.parentNode;
      var subMenu = category.querySelector('.sub-menu');

      // Hide all other submenus
      var subMenus = document.querySelectorAll('.sub-menu');
      subMenus.forEach(function(menu) {
        menu.classList.remove('block');
      });

      // Show the selected submenu
      subMenu.classList.add('block');
      $('body').css('overflow', 'hidden');
      $slideout.css('overflow', 'hidden');
    });*/

    $('.browser').hover(function() {
        let phoneThumb = $(this).find('.phone-thumb');
        let style = phoneThumb.attr('data-style') || false;
        if (style) {
          phoneThumb.attr('style', style);
          phoneThumb.removeAttr('data-style');
        }
    });

    $('.slideout-category').on('click', function(event) {
    var target = $(event.target);
    if (!target.is('a')) {
      // Clicked element is not an anchor tag (a), so toggle the sub-menu visibility
      event.preventDefault();
      var subMenu = $(this).find('.sub-menu');
      if (subMenu.length) {
        $('.sub-menu').not(subMenu).removeClass('block');
        subMenu.toggleClass('block');
        //$('body').css('overflow', 'hidden');
        var categoryOffset = $(this).offset().top;
    var subMenuOffset = subMenu.offset().top;
    var scrollAmount = subMenuOffset - categoryOffset;

    // Scroll the page to adjust for the submenu position
    $('html, body').animate({
        scrollTop: '+=' + scrollAmount
    }, 500); // Adjust the animation speed as needed
    console.log(scrollAmount);
        
      }
    }
  });

    $('.back-subCat').click(function(){
        $subcat.removeClass('block');
    });

    $('.categories-close').click(function() {
        $slideout.removeClass('block');
        $('body').css('overflow', 'auto');
    });


    $('input[placeholder="Search"]').on('keyup', function(evt){
        if(evt.keyCode == 13) {
            searchTemplates(this.value);
        }
    });

    $(window).scroll(function() {
      if ($(this).scrollTop() > 220) {
          $('#template-nav2').addClass("hidden");
          $('#template-search').addClass("block");
          $('#template-search').removeClass("hidden");
      } else {
          $('#template-nav2').removeClass("hidden");
          $('#template-search').removeClass("block");
          $('#template-search').addClass("hidden");
      }
    });
});

function searchTemplates(keyword) {
    window.location.href = '/templates/search/'+keyword;
}


function openMenu() {
      var menuContainer = document.querySelector('.menu-container');
      menuContainer.style.transform = 'translateX(0)';
    }

    function closeMenu() {
      var menuContainer = document.querySelector('.menu-container');
      menuContainer.style.transform = 'translateX(100%)';
    }

    function toggleSubmenu(event) {
      event.preventDefault();
      var category = event.target.parentNode;
      var subMenu = category.querySelector('.sub-menu');

      // Hide all other submenus
      var subMenus = document.querySelectorAll('.sub-menu');
      subMenus.forEach(function(menu) {
        menu.classList.add('hide');
        menu.classList.remove('show');
      });

      // Show the selected submenu
      subMenu.classList.remove('hide');
      subMenu.classList.add('show');

      // Reset subcategories to initial state
        /*var subCategories = subMenu.querySelectorAll('li');
        subCategories.forEach(function(category) {
          category.style.opacity = '0';
          category.style.transform = 'translateX(100%)';
        });*/

      // Delay showing subcategories
      /*setTimeout(function() {
        var subCategories = subMenu.querySelectorAll('li');
        subCategories.forEach(function(category, index) {
          setTimeout(function() {
            category.style.opacity = '1';
            category.style.transform = 'translateX(0%)';
          }, index * 100);
        });
      }, 300);*/
    }