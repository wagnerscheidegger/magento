jQuery( document ).ready(function() 
	{


		// jQuery('ul.pagination li').click(function(){

		// 	jQuery.ajax({
		// 	  	url: "test.html",
		// 	  context: document.body
		// 	}).done(function() {
		// 	  	jQuery( this ).addClass( "done" );
		// 	});

		// });

		var options = {
	    	currentPage: 1, 
	        totalPages: 14,//obj_youtube_js.video_pages,
	        onPageClicked: function(e,originalEvent,type,page){
	                var data = {
								'action': 'youtube_video_feed',
								//'page_number': jQuery(this).attr('rel')
								'page_number': page
					   		  };

					// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
					jQuery.post('wp-admin/admin-ajax.php', data, function(response) 
					{
						//alert('Got this from the server: ' + response);
						jQuery('#main_toutube_div').html(response);
						jQuery('#main_toutube_div').removeClass('opacity_div');
						jQuery('#loading_div').hide();
						jQuery('.entry-content').removeClass('overlay_screen');
						
					});
	    }
            
        }


        jQuery('.pagination_div').bootstrapPaginator(options);

		jQuery('.fancybox-media')
						.attr('rel', 'media-gallery')
						.fancybox({
							openEffect : 'none',
							closeEffect : 'none',
							prevEffect : 'none',
							nextEffect : 'none',

							arrows : false,
							helpers : {
								media : {},
								buttons : {}
							}
						});

	
});
jQuery(document).ajaxStart(function(){
    jQuery('#main_toutube_div').addClass('opacity_div');
    jQuery('#loading_div').show();
    jQuery('.entry-content').addClass('overlay_screen');
}); 
