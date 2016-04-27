/**
 * @package     Joomla.Site
 * @subpackage  Templates.beez3
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @since       3.2
 */

(function($)
{
	$(document).ready(function()
	{	
		$(".prog-content img").hover(function() {
			$(this).prev().show();
		});
		
		$(".prog-content .hover-prog").hover(function() {
			$(this).show();
		}, function() {
			$(this).hide();
		});

		$(".prog-content h2").click(function() {
			var h2=$(this);
			var baseText = $(this).text();
			var firstLetter = baseText.substr(0, 1);
			if(firstLetter=='-'){
				h2.text('+'+baseText.substr(1));
				h2.addClass('untoggled');
			}else{
				h2.removeClass();
				h2.text('-'+baseText.substr(1));
			}
			$(this).next().slideToggle( "slow", function(){

			});
		});
	})
})(jQuery);
