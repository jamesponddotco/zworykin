jQuery( document ).ready( function( $ ) {

	// Toggle navigation
	$( '.nav-toggle' ).on( 'click', function(){
		$( this ).add( '.site-nav' ).toggleClass( 'active' );
		$( 'body' ).toggleClass( 'lock-screen' );
	} );

	// Resize videos after their container
	var vidSelector = ".post iframe, .post object, .post video, .widget-content iframe, .widget-content object, .widget-content iframe";
	var resizeVideo = function(sSel) {
		$( sSel ).each(function() {
			var $video = $(this),
				$container = $video.parent(),
				iTargetWidth = $container.width();

			if ( !$video.attr("data-origwidth") ) {
				$video.attr("data-origwidth", $video.attr("width"));
				$video.attr("data-origheight", $video.attr("height"));
			}

			var ratio = iTargetWidth / $video.attr("data-origwidth");

			$video.css("width", iTargetWidth + "px");
			$video.css("height", ( $video.attr("data-origheight") * ratio ) + "px");
		});
	};

	resizeVideo( vidSelector );

	$( window ).resize( function() {
		resizeVideo( vidSelector );
	} );

});
