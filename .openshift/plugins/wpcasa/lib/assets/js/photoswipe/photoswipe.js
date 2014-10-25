jQuery(document).ready(function($) {	
	
	/**
	 * Photoswipe is a lightbox script
	 * that opens links with class .lightbox.
	 * Images linked to images will open in
	 * lightbox automatically.
	 *
	 * @since 1.1
	 */    
    function wpsight_photoswipe() {
    	
    	var thumbnails = 'a:has(img)[href$=".bmp"],a:has(img)[href$=".gif"],a:has(img)[href$=".jpg"],a:has(img)[href$=".jpeg"],a:has(img)[href$=".png"],a:has(img)[href$=".BMP"],a:has(img)[href$=".GIF"],a:has(img)[href$=".JPG"],a:has(img)[href$=".JPEG"],a:has(img)[href$=".PNG"]';
    	
    	if( !$(thumbnails).hasClass('dsidx_cboxElement') ) {
    		$(thumbnails).addClass('lightbox');
    	}
    	
    	var links = '.image-gallery a, .image-slider a, a.lightbox';
    	
    	// Remove Photoswipe when Jetpack carousel is active
    	$('.wpsight-jp-carousel .tiled-gallery a').removeClass('lightbox');
		
		if( $(links).length > 0 ){
			$(links).photoSwipe({
				imageScaleMethod: 'fitNoUpscale',
				captionAndToolbarFlipPosition: false,
				captionAndToolbarShowEmptyCaptions: false,
				captionAndToolbarAutoHideDelay: 5000
			});
		}

	}
	
	wpsight_photoswipe();
	
});