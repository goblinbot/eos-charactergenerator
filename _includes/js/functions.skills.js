/* toggleSkillBoxes: save the players several clicks by enabling/disabling all previous and next checkboxes when selecting a skill. */
function toggleSkillBoxes(e) {

  let skillData = $(e).data();

  if(e.checked == true) {

    /* set all PREVIOUS checkboxes to TRUE */
    $(e).prevAll().prop("checked", true);

    if(skillData['level'] == 5 && skillData['index']) {
      toggleSpecialties(skillData['index']);
    }

    if(skillData['level'] > 5 && skillData['parentid']) {
      /*let parentTarget = $('#sg_'+skillData['parentid']);*/
      $('#sg_'+skillData['parentid']).find('input').addClass('disabled').attr('readonly', true);
    }

  } else if(e.checked == false) {

    /* check if the NEXT checkbox is already set. If this is the case...*/
    let next = $(e).next();

    /* ...we set the clicked box to TRUE instead of disabling it as well. This feels more natural. */
    if(next[0] && next[0]['checked'] == true) {
      $(e).prop("checked", true);
    } else {

      if(skillData['level'] == 6 && skillData['parentid']) {
        /*let parentTarget = $('#sg_'+skillData['parentid']);*/
        $('#sg_'+skillData['parentid']).find('input').removeClass('disabled').attr('readonly', false);
      }

    }

    /* set all NEXT checkboxes to false. */
    $(e).nextAll().prop("checked", false);

  }

  /* finally: update the EXP used */
  updateExpUsed();
}
/* end of toggling skillboxes */


/* grab the specialty or hide the specialty, based on your skill level. */
function toggleSpecialties(index) {

  if($('#specialtycontainer').length > 0) {

    let target = $('#specialtycontainer');
    /*let checkforbeta = $('#charStatus').text();*/

    $.ajax({
      type: 'POST',
      url: '/eoschargen/handler/skills.php',
      data: { getSpecialtySkills : index }
    })
    .done(function(data){
      /*target.append(data);*/
      data = (JSON.parse(data));

      $.each(data, function(key,value) {

        if($('#sg_' + key).length > 0) {

          /* ALREADY EXISTS */
          return false;

        } else {

          /* doesn't exist? make the fields. */
          let printresult = "";

          for(let i = 1; i < 9; i++) {
            printresult += value[i];
          }

          target.append(printresult);

        }

      });

    })
    .fail(function() {
      /*target.html('<h2>Err: no skills found.</h2>');*/
    });

    /* finally: update the EXP used */
    updateExpUsed();
  }

  /* prevent a refresh by returning false in the end. */
  return false;

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

/* tooltip the skills.. */

  function previewSkill(groupid) {

    let target = $('#previewSkill');

    target.empty();

    $.ajax({
      type: 'POST',
      url: '/eoschargen/handler/skills.php',
      data: { previewSkill : groupid }
    })
    .done(function(data){
      target.html(data);
    })
    .fail(function() {
      target.html('<h2>Err: no skills found.</h2>');
    });

    /* prevent a refresh by returning false in the end. */
    return false;

  }
/* end tooltip */
/* tooltip navigation start */
function navPreview(direction) {

  let target = $('#previewSkill').find('.tab.active');

  if(direction == 'next') {
    $(target).hide().removeClass('active');
    $(target).next().show().addClass('active');

  } else if(direction == 'prev') {
    $(target).hide().removeClass('active');
    $(target).prev().show().addClass('active');

  }

}

function submitSkillsheet() {

  updateExpUsed();

  let expUsed = parseInt($('#expUsed').text());
  let expTotal = parseInt($('#expTotal').text());

  if(expUsed > expTotal) {
    let previewDiv = $('#previewSkill');

    previewDiv.empty().html('<br/><h3 class=\"text-center\" style=\"display:none;\"><i class=\"fa fa-times\"></i>&nbsp;Error: Character is using more points than available.</h3>');
    previewDiv.find('h3').fadeIn();

  } else {

    $('#skillsheet').submit();
  }



}

$(document).ready(function(){

  var lastCheckedSkill = 0;
  let specialtyDivs = $('.specialty');

  if(specialtyDivs.length > 0) {
    specialtyDivs.each(function(){
      let xData = $(this).data();
      if(lastCheckedSkill != xData['parentid']) {
        lastCheckedSkill = xData['parentid'];
        $('#sg_' + lastCheckedSkill).find('.skillcheck').addClass('disabled');
      }
    });
  }

});
/* end of functions.skills */
