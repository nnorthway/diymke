function setActiveNavItem(){var a=["about","bands","submit","contact","index","venues","search","news","calendar"],b=$("#nav");for(i=[b.find("a[title='About']"),b.find("a[title='Bands']"),b.find("a[title='Submit']"),b.find("a[title='Contact']"),b.find("a[title='Home']"),b.find("a[title='Venues']"),b.find("a[title='Search']"),b.find("a[title='News']"),b.find("a[title='Calendar']")],n=0;n<=a.length;n++){var c=window.location.pathname.toString();c.indexOf(a[n])>0&&i[n].addClass("active")}}$(document).ready(function(){setActiveNavItem(),$("#menu-toggle").on("click",function(){$("#nav").toggleClass("active"),$("#nav").hasClass("active")?$(this).find(".material-icons").text("close"):$(this).find(".material-icons").text("menu")}),$(".form_submittable").hide(),$("#select_band").on("click",function(){$("#venue_form, #event_form").hide(500,function(){$("#band_form").show(500,function(){var a=$("#band_form").offset();$("body").animate({scrollTop:a.top},500)})})}),$("#select_venue").on("click",function(){$("#band_form, #event_form").hide(500,function(){$("#venue_form").show(500,function(){var a=$("#venue_form").offset();$("body").animate({scrollTop:a.top},500)})})}),$("#select_event").on("click",function(){$("#band_form, #venue_form").hide(500,function(){$("#event_form").show(500,function(){var a=$("#event_form").offset();$("body").animate({scrollTop:a.top},500)})})}),$(document).ready(function(){var a=$("#theList"),b=$("#view-grid"),c=$("#view-list");a.addClass("grid"),b.addClass("active"),b.on("click",function(){c.removeClass("active"),$(this).addClass("active"),a.removeClass("list"),a.addClass("grid")}),c.on("click",function(){b.removeClass("active"),$(this).addClass("active"),a.removeClass("grid"),a.addClass("list")})})});
