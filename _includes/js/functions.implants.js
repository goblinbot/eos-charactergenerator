/* cache those selectors to save calls. */
var activeImplantDiv = $('#activeImplants');
var implantFormDiv = $('#implantForm');

/* choose your implant type */
function IM_chooseType(char,sheet) {

  var printresult = "<h2>Choose a type of augmentation</h2><hr/><br/>"
  + "<div class=\"row flexcolumn\">"
    + "<button class=\"button no-bg\" style=\"font-size: 1.6rem; margin-bottom: 1.8rem;\" onclick=\"IM_creationForm('cybernetic','"+char+"','"+sheet+"');return false;\"><i class=\"fas fa-microchip cyan\"></i>&nbsp;Skill-based&nbsp;Cybernetic</button>"
    + "<button class=\"button no-bg\" style=\"font-size: 1.6rem; margin-bottom: 1.8rem;\" onclick=\"IM_creationForm('symbiont','"+char+"','"+sheet+"');return false;\"><i class=\"fas fa-bug green\"></i>&nbsp;Skill-based&nbsp;Symbiont</button>"
    + "<button class=\"button no-bg\" style=\"font-size: 1.6rem; margin-bottom: 1.8rem;\" onclick=\"IM_creationForm('flavour','"+char+"','"+sheet+"');return false;\"><i class=\"fas fa-cogs\"></i>&nbsp;Flavour/non-skill augmentation</button>"
  + "</div>"

  IM_animateFormDiv(printresult);
  printresult = "";

}

/* create an implant: form. */
function IM_creationForm(type,char,sheet) {

  var postArr = {type,char,sheet};

  $.ajax({
      type: 'POST',
      url: '/eoschargen/handler/index.php',
      data: postArr
  })
  .done(function(data){

      /* show the response */
      IM_animateFormDiv(data);

  })
  .fail(function() {
    /* just in case posting your form failed */
    IM_animateFormDiv("<h4><i class=\"fas fa-warning\"></i>&nbsp;Posting failed.</h4>");
  });

  return false;

  // if(type) {
  //
  //   var printresult = "<button class=\"button cyan no-bg\" onclick=\"IM_chooseType();return false;\"><i class=\"fas fa-arrow-left\"></i>&nbsp;Choose another type</button><br/><br/>";
  //
  //   /* open form */
  //   printresult += "<form method=\"post\" action=\"implants.php?viewChar="+ char +"&viewSheet="+ sheet +"\">"
  //   + "<input type=\"hidden\" style=\"display: none;\" name=\"implant[sheet]\" value=\""+ sheet +"\"/>"
  //   + "<input type=\"hidden\" style=\"display: none;\" name=\"implant[type]\" value=\""+ type +"\"/>";
  //
  //   printresult += "<label><h3>Add "+type+" augment.</h3></label>";
  //
  //   if(type == 'cybernetic' || type == 'symbiont') {
  //
  //     printresult += "<div class=\"formitem\">"
  //       + "<input type=\"text\" name=\"implant[skillindex]\" "
  //     + "</div>";
  //
  //   } else if (type == 'flavour') {
  //
  //
  //
  //   } else {
  //     /* invalid typing */
  //     return false;
  //   }
  //
  //   printresult += "<div class=\"formitem\">"
  //     + "<label>Description</label><br/>"
  //     + "<textarea name=\"implant[description]\" placeholder=\"A name, or description. Optional, ofcourse.\"></textarea>"
  //   + "</div>";
  //
  //   /* close form */
  //   printresult += "</form>";
  //
  //   IM_animateFormDiv(printresult);
  //   printresult = "";
  //
  // } else {
  //   return false;
  // }

}


/* help/info tab */
function IM_showHelp() {

  var printresult = "<h2><i class=\"fas fa-info-circle\"></i>&nbsp;WIP</h2>";

  IM_animateFormDiv(printresult);
  printresult = "";

}


/* function to animate the form div, just so I don't have to repeat myself three times. */
function IM_animateFormDiv(printresult) {

  /* loading 'spinner' */
  implantFormDiv.empty().html('<br/><p class=\"text-center\"><i style=\"font-size:5rem;\" class=\"fas fa-cog fa-spin\"></i></p>').fadeOut();

  setTimeout(function(){

    implantFormDiv.empty().html(printresult).fadeIn();
    return true;

  },750);
}


/* onload... */
$(document).ready(function(){

  /* force loading spinner followed by a green checkmark. */
  /*setTimeout(function(){
    IM_animateFormDiv('<br/><p class=\"text-center\"><i style=\"font-size:5rem;\" class=\"fas fa-check green\"></i></p>');

    setTimeout(function(){
      implantFormDiv.fadeOut();
    },1500);
  },250);*/

});
