jQuery(function($) {

  /**
   * Activate rating in form
   *
   * @type {*|jQuery|HTMLElement}
   */
  var formStars = $('form ul.star li .material-icons');

  formStars.click(function() {
    var star = $(this);
    var holder = star.closest('ul.star');
    holder.find('i').removeClass('active');
    var list = holder.find('li');
    var x = 0;
    for (var i = 0; i < 5; i++) {
      var _star = list.eq(i).children()[0];
      $(_star).addClass('active');
      x++;
      if (_star === this) {
        break;
      }
    }
    holder.find('[name=rating]').val(x);
  });

  /**
   * Initiate ratings
   *
   * @type {*|jQuery|HTMLElement}
   */
  var allStarContainers = $('ul.star');
  for (var i = 0; i < allStarContainers.length; i++) {
    var container = allStarContainers.eq(i);
    var value = container.attr('value');
    if (value) {
      var stars = container.find('li i.material-icons');
      for (var x = 0; x < value; x++) {
        stars.eq(x).addClass('active');
      }
    }
  }
});

/**
 * Make sure user submits ratings
 *
 * @param form
 * @returns {boolean}
 */
function validateCommentForm(form) {
  if (jQuery(form).find('[name=rating]').val() == '') {
    alert('You need to give a rating');
    return false;
  }
  else {
    return true;
  }
}