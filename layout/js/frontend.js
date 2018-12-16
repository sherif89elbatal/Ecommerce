$(function(){

	'use strict';
	
	// Trigger The Selectboxit

	 $("select").selectBoxIt({

	 	autoWidth: false

	 	});

	// Switch Between login and signup	

	$('.login-page h1 span').click(function(){

		$(this).addClass('selected').siblings().removeClass('selected');

		$('.login-page form').hide();

		$('.' + $(this).data('class')).fadeIn(100);

	});

	//  Hide placeholder on form focus

	$('[placeholder]').focus(function(){

		$(this).attr('data-text', $(this).attr('placeholder'));
		$(this).attr('placeholder','');

	}).blur(function(){
		$(this).attr('placeholder',$(this).attr('data-text'));
	});
	
	// end
	
	// Add Asterisk on Required Field
 	
	$('input').each(function(){
		
		if($(this).attr('required') ===  "required" ){
			
			$(this).after('<span class="asterisk" > * </span>');
			
		}
		});
	
	// Confirmation Message On Buttton
	
	$('.confirm').click(function(){
		
		return confirm(" Are you sure ? ");
		
		});
	// to make the title in input  in newad page responsive whith the ad 

	$('.live').keyup(function(){

		$($(this).data('class')).text($(this).val());
	});

});