var formObject = {
	urlPost : '/mod/comment.php',
	urlRemove : '/mod/remove.php',
	idContainer : 'comments',
	classComment : 'comment',
	run : function() {
		formObject.submitClick($('.submit'));
		formObject.submitReturn($('.fields'));
		formObject.remove($('.remove'));
	},
	submitClick : function(obj) {
		obj.live('click', function() {
			formObject.submitForm($(this).closest('form'));
			return false;
		});
	},
	submitReturn : function(obj) {
		obj.live('keypress', function(event) {
			var thisKey = event.keyCode ? event.keyCode : event.which;
			if (thisKey === 13) {
				formObject.submitForm($(this).closest('form'));
				return false;
			}
		});
	},
	remove : function(obj) {
		obj.live('click', function() {
			var thisParent = $(this).parent('.comment');
			var thisId = $(this).attr('data-id');
			jQuery.post(formObject.urlRemove, { id : thisId }, function(data) {
				if (!data.error) {
					thisParent.fadeOut(200, function() {
						if (data.posts > 0) {
							$(this).remove();
						} else {
							$(this).replaceWith($('<p>There are currently no comments.</p>').hide().fadeIn(200));
						}
					});
				}
			}, 'json');
			return false;
		});
	},
	submitForm : function(form) {
		var thisArray = form.serializeArray();
		if (thisArray !== '') {
			jQuery.post(formObject.urlPost, thisArray, function(data) {
				if (!data.error) {
					if ($('.' + formObject.classComment).length > 0) {
						$('#' + formObject.idContainer).append($(data.comment).hide().fadeIn(200));
					} else {
						$('#' + formObject.idContainer).find('p').fadeOut(200, function() {
							$(this).replaceWith($(data.comment).hide().fadeIn(200));
						});
					}
				}
			}, 'json');
		}
	}
};
$(function() {
	
	formObject.run();
	
});







