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
		$('#maincell').prepend('<p style="padding:8px">Your browser does not support CSS grids.</p>');

	} else {
		/* Grid support detected! This is a nice browser.*/
	}
}

$(document).ready(function(){

	/* init */
	setTimeout(function(){
		$('body').removeClass('notransition');
	},200);

	checkGridSupport();
});


/* toggledisable a button onclick. Use this by adding ((  onclick="disableButton(this);" )) to a button." */
function disableButton(e) {

	$(e).addClass('disabled');

	setTimeout(function(){
		$(e).removeClass('disabled');
	},1000);
}

/* or, disable all the buttons in the same div... */
function disableButtonGroup(e, levels) {

	if(e) {

		/* levels: how many parent divs are we going to search through? */
		if(!levels || levels < 1) {
			levels = 1;
		}

		/* this previously clicked button */
		var target = $(e);

		/* for every level, go one div upwards. */
		for(i = 0; i < levels; i++) {
			target = target.parent();
		}

		/* find all the buttons inside the current target. */
		target = target.find('.button');

		/* apply the hide/display */
		$(target).addClass('disabled');

		setTimeout(function(){
			$(target).removeClass('disabled');
		},1000);

	} else {
		/* if 'this' is not declared.. */
		return false;
	}
	
}


/* ********************************************** *//* ********************************************** */
/* Internet's single most stolen cookie functions *//* ********************************************** */
/* ********************************************** *//* ********************************************** */

function ecc_setCookie(cname, cvalue, exdays) {
  var d = new Date();
  	d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
  var expires = "expires="+d.toUTCString();
  	document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function ecc_getCookie(cname) {
  var name = cname + "=";
  var ca = document.cookie.split(';');

  for(var i = 0; i < ca.length; i++) {

		var c = ca[i];

    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}
