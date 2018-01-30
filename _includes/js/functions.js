/* checks the visitor's browser for CSS GRID support. */
function checkGridSupport() {
	var result;

		try {
			result = CSS.supports("display", "grid");
		}
		catch(err) {
			/* browser cannot handle the CSS.supports command => assume this browser is ancient eldritch wizardry at this point. */
		}

	if(result == false) {
		/*Current browser does not support CSS grids, but DOES understand the CSS.supports command. There may be hope yet. */
		$('#topcell').html('<p style="padding:8px">Your browser does not support CSS grids.</p>');

	} else {
		/* Grid support detected! This is a nice browser.*/
	}
}

$(document).ready(function(){

	var maincell = $('.main');

	if(maincell && $(window).width() > 768) {

		function scrollMain() {

			var offsetTop = maincell.scrollTop();
			var offsetBottom = maincell.scrollTop() + maincell.height();

			if(offsetTop > 2) {
				maincell.addClass('offsetTop');
			} else {
				maincell.removeClass('offsetTop');
			}

		}

		/* adds the scroll function to the MAIN div. */
		maincell.scroll(function() {
		    scrollMain();
		});

		/* run the function at start incase of refresh. */
		scrollMain();

	}

	/* init */
	setTimeout(function(){
		$('body').removeClass('notransition');
	},400);

	checkGridSupport();
});
