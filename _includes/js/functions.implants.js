/* cache those selectors to save calls. */
var activeImplantDiv = $('#activeImplants');
var implantFormDiv = $('#implantForm');

/* choose your implant type */
function IM_chooseType(char,sheet) {

  activeImplantDiv.fadeOut();

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

  var postdata = {
    "type" : type,
    "char" : char,
    "sheet": sheet
  };

  $.ajax({
    type: 'POST',
    url: '/eoschargen/handler/index.php',
    data: { createImplantForm : postdata }
  })
  .done(function(data){
    IM_animateFormDiv(data); /* show the response */
  })
  .fail(function() {
    IM_animateFormDiv("<h4><i class=\"fas fa-warning\"></i>&nbsp;Posting failed. [err 701]</h4>"); /* just in case posting your form failed */
  });

  /* prevent a refresh by returning false in the end. */
  return false;
}


/* help/info tab */
function IM_showHelp() {
  var printresult = "<h2><i class=\"fas fa-info-circle\"></i>&nbsp;Nice find. This message only shows, because you forced it to. You monster. [ERR 702]</h2>";
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

/* submit the implantform */
function IM_submitNewImplant() {

  var postdata = $(implantFormDiv).find('form').serialize();

  $.ajax({
    type: 'post',
    url: '/eoschargen/handler/index.php',
    data: postdata
  })
  .done(function(data){
    IM_animateFormDiv(data); /* show the response */
    setTimeout(function(){
      location.reload();
    },2500);
  })
  .fail(function() {
    IM_animateFormDiv("<h4><i class=\"fas fa-warning\"></i>&nbsp;Adding new augmentation failed. [ERR 703]</h4>"); /* just in case posting your form failed */
  });

}

function IM_removeImplant(sheetID,modifierID) {

  activeImplantDiv.fadeOut();

  var postdata = {
    "aug" : modifierID,
    "sheet": sheetID
  };

  $.ajax({
    type: 'POST',
    url: '/eoschargen/handler/index.php',
    data: { removeImplant : postdata }
  })
  .done(function(data){
    IM_animateFormDiv(data); /* show the response */
  })
  .fail(function() {
    IM_animateFormDiv("<h4><i class=\"fas fa-warning\"></i>&nbsp;Posting failed. [ERR 706]</h4>"); /* just in case posting your form failed */
  });

  /* prevent a refresh by returning false in the end. */
  return false;

}

function IM_removeImplantConfirmed(modifierID) {
  $.ajax({
    type: 'POST',
    url: '/eoschargen/handler/index.php',
    data: { deleteImplantConfirm : modifierID }
  })
  .done(function(data){
    IM_animateFormDiv(data); /* show the response */

    setTimeout(function(){
      location.reload();
    },3000);
  })
  .fail(function() {
    IM_animateFormDiv("<h4><i class=\"fas fa-warning\"></i>&nbsp;Posting failed. [ERR 707]</h4>"); /* just in case posting your form failed */
  });

  /* prevent a refresh by returning false in the end. */
  return false;
}


/* onload... */
$(document).ready(function(){

});
