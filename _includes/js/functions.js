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
		$('.logo').html('<p style="padding:8px">Your browser does not support CSS grids.</p>');

	} else {
		/* Grid support detected! This is a nice browser.*/

	}
}