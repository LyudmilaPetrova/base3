(function ($) { $(document).ready(function() {    

/* $('.menu-line>ul.menu>li').mouseover(function(){
    $(this).addClass('hover');
  }); */

 $('ul.sf-menu').supersubs({ 
    minWidth:    12,   // minimum width of sub-menus in em units 
    maxWidth:    27,   // maximum width of sub-menus in em units 
    extraWidth:  1     // extra width can ensure lines don't sometimes turn over
    // due to slight rounding differences and font-family 
  }).superfish();
  
  //$('#mainMenu a.sf-with-ul').click(function(){return false;});
  
}); })(jQuery);

/*
(function ($) { $(document).ready(function() {
              
  $(".block-menu-block .menu .menu").hide();
  
  $(".block-menu-block .menu .expanded a").click(function() {
		if($(this).parent().hasClass('expanded')) {
			$(this).next().toggle();
			return false;
		};
  });
	
  $(".block-menu-block .menu .menu").find('.active-trail').parent().show();

  $('ul.sf-menu').supersubs({ 
    minWidth:    12,   // minimum width of sub-menus in em units 
    maxWidth:    27,   // maximum width of sub-menus in em units 
    extraWidth:  1     // extra width can ensure lines don't sometimes turn over
    // due to slight rounding differences and font-family 
  }).superfish();
  
  $('#mainMenu a.sf-with-ul').click(function(){return false;});
  
  
  $('#slider').slider();

  
}); })(jQuery); */

