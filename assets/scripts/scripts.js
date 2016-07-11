$(document).ready(function() {
  setActiveNavItem();

  $("#menu-toggle").on('click', function() {
    $("#nav").toggleClass('active');
    if ($("#nav").hasClass("active")) {
      $(this).find('.material-icons').text('close');
    } else {
      $(this).find('.material-icons').text('menu');
    }
  })

  $("#band_form").hide();
  $("#venue_form").hide();

  $("#select_band").on('click', function() {
    $("#venue_form").hide(500, function() {
      $("#band_form").show(500, function() {
        var $off = $("#band_form").offset();
        $("body").animate({scrollTop:$off.top}, 500);
      });
    })
  })

  $("#select_venue").on('click', function() {
    $("#band_form").hide(500, function() {
      $("#venue_form").show(500, function() {
        var $off = $("#venue_form").offset();
        $("body").animate({scrollTop:$off.top}, 500);
      });
    })
  })


})

function setActiveNavItem() {
  var $pages = [
    'about', 'bands', 'submit', 'contact', 'index', 'venues', 'search'
  ];

  var $nav = $("#nav");

  var $obj = [
    $nav.find("a[title='About']"),
    $nav.find("a[title='Bands']"),
    $nav.find("a[title='Submit']"),
    $nav.find("a[title='Contact']"),
    $nav.find("a[title='Home']"),
    $nav.find("a[title='Venues']"),
    $nav.find("a[title='Search']")
  ];

  for (var $i = 0; $i <= $pages.length; $i++) {
    var $location = window.location.pathname.toString();

    if ($location.indexOf($pages[$i]) > 0) {
      $obj[$i].addClass('active');
    }
  }
}
