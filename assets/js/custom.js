$j=jQuery.noConflict();

$j(document).ready(function() {

	$j('#use-default-message').change(function () {
		if (this.checked) {
			$j('tr.toHide.defaultMessage').show();
			$j('tr.toHide.Android, tr.toHide.iOS').hide();
		}
		else {
			$j('tr.toHide.defaultMessage').hide();
			$j('tr.toHide.Android, tr.toHide.iOS').show();
		}
	});
	
	if($j('#use-default-message')) {
		if($j(!this.checked)) {
			$j('tr.toHide.Android, tr.toHide.iOS').show();
		} else {
			$j('tr.toHide.Android, tr.toHide.iOS').hide();
		}
	}

	if ($j('#use-default-message').attr("checked")) {
		$j('tr.toHide.defaultMessage').show();
		$j('tr.toHide.Android, tr.toHide.iOS').hide();
	}

	if($j('.welcome-message').data('cookie') == '' | $j('.welcome-message').data('cookie') == '') {
		var cookieExpiration = 20;
	} else {
		cookieExpiration = $j('.welcome-message').data('cookie');
	}

	$j('.welcome-message i.icon-cancel').click(function(){
		Cookies.set("wm_cookie", true, { expires: cookieExpiration, path: '/' });
		$j('.welcome-message').remove();
	});

	var messageDuration = $j('.welcome-message').data('duration');
	messageDuration2 = messageDuration * 1000;
	$j(".welcome-message").delay(messageDuration2).fadeOut("slow");
});