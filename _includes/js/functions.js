/* checks the visitor's browser for CSS GRID support. */
function checkGridSupport() {
	var result;

		try {
			result = CSS.supports("display", "grid");
		}
		catch(err) {
			/* browser cannot handle the CSS.supports command => assume this browser is ancient eldritch wizardry at this point. */
			result = false;
		}

	if(result == false) {
		/*Current browser does not support CSS grids. Let's make the internet a better place: */
		$('.grid').css('padding','15px').css('width','auto').css('height','100%').css('overflow','hidden').html('<h2><i class=\"fas fa-pause\"></i>&nbsp;Your current browser does not support grids.</h2><p>Several parts of this application depend on the use of modern techniques.<br/>Please switch to a newer browser to use the character creator, and make the internet a better place.</p><br/>');
		$('.grid').append('<h3><i class=\"fas fa-mobile-alt\"></i>&nbsp;If you are seeing this message on your smartphone/tablet, try updating your browser in the relevant app store - or install Chrome or Firefox.</h3>');

	} else {
		/* Grid support detected! This is a nice browser. It's allowed to stay.*/
	}
}

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

/* INIT ON LOAD */

$(document).ready(function(){

	/* print a HI FELLOW ROBOTS message for the curious monkeys. */
	console.log('%cHELLO CURIOUS COLONIST!', 'color:darkblue;font-size:20px;font-family:arial;font-style:italic;');
	console.log('Welcome to the Eos character creator. If you like breaking stuff, or just looking under the hood in general, feel free to contact Thijs/Maati at Eos IT.');
	console.log('%c____________________________', 'color:darkblue;');
	console.log('For now, enjoy the app. And be gentle.');



	/* remove Notransition:
	this css class prevents the entire grid from going full eldritch horror,
	if... the visitor's... browser.. is.. way.. too.. slow... */
	setTimeout(function(){
		$('body').removeClass('notransition');
	},200);

	checkGridSupport();
});
