/* toggleSkillBoxes: save the players several clicks by enabling/disabling all previous and next checkboxes when selecting a skill. */
function toggleSkillBoxes(e) {

  let skillData = $(e).data();

  if(e.checked == true) {

    /* set all PREVIOUS checkboxes to TRUE */
    $(e).prevAll().prop("checked", true);

  } else if(e.checked == false) {

    /* check if the NEXT checkbox is already set. If this is the case...*/
    let next = $(e).next();

    /* ...we set the clicked box to TRUE instead of disabling it as well. This feels more natural. */
    if(next[0] && next[0]['checked'] == true) {
      $(e).prop("checked", true);
    }

    /* set all NEXT checkboxes to false. */
    $(e).nextAll().prop("checked", false);

  }

  /* finally: update the EXP used */
  updateExpUsed();
}
/* end of toggling skillboxes */


/* grab the specialty or hide the specialty, based on your skill level. */
function toggleSpecialties(e) {



  /* finally: update the EXP used */
  updateExpUsed();
}
/* end of toggleSpecialties */


/* update the 'EXP USED X / Y' html field */
function updateExpUsed() {

  let expUsedCont = $('#expUsed');
  let expUsed = expUsedCont.text();
  let expTotal = $('#expTotal').text();

  if(expTotal && expUsed) {

    let activeSkillBoxes = $('input.skillcheck:checked');

    if(activeSkillBoxes) {
      var newExpUsed = 0;

      $(activeSkillBoxes).each(function(arr){

        /* cache the current block, grab the data-attrs */
        let current = activeSkillBoxes[arr];
        let divdata = $(current).data();

        /* add and extract exp based on data-attr's */
        if(divdata) {
          if(divdata.expmodifier) {
            newExpUsed = (newExpUsed + divdata.expmodifier);
          }
          if(divdata.level) {
            newExpUsed = (newExpUsed + divdata.level);
          }
        }

      });

      expUsedCont.html(newExpUsed);
      if(newExpUsed > expTotal) {
        expUsedCont.addClass('tomato');
      } else {
        if(expUsedCont.hasClass('tomato')) {
          expUsedCont.removeClass('tomato');
        }
      }

    } else {
      return false;
    }
  }
}
/* end of update EXP used */

/* tooltip the skills when mouseover happens AND the timer runs out.. */

  function skillTooltip(e) {

    let skilldata = $(e).data();


  }



/* end tooltip */
