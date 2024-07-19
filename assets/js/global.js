document.addEventListener( 'DOMContentLoaded', function () {
	// Toggle navigation.
	const navToggle = document.querySelector( '.nav-toggle' );
	const siteNav = document.querySelector( '.site-nav' );
	const body = document.body;

	if ( navToggle ) {
		navToggle.addEventListener( 'click', function () {
			this.classList.toggle( 'active' );
			siteNav.classList.toggle( 'active' );
			body.classList.toggle( 'lock-screen' );
		} );
	}

	// Resize videos after their container.
	const vidSelector =
		'.post iframe, .post object, .post video, .widget-content iframe, .widget-content object, .widget-content iframe';

	function resizeVideo( selector ) {
		const videos = document.querySelectorAll( selector );

		for ( const video of videos ) {
			const container = video.parentElement;
			const targetWidth = container.offsetWidth;

			if ( ! Object.hasOwn( video.dataset, 'origwidth' ) ) {
				video.dataset.origwidth = video.width;
				video.dataset.origheight = video.height;
			}

			const ratio = targetWidth / video.dataset.origwidth;

			video.style.width = targetWidth + 'px';
			video.style.height = video.dataset.origheight * ratio + 'px';
		}
	}

	resizeVideo( vidSelector );

	window.addEventListener( 'resize', function () {
		resizeVideo( vidSelector );
	} );
} );
