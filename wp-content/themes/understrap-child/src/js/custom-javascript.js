// Add your custom JS here.
jQuery(document).ready(function($) {
    // Gets the video src from the data-src on each button
    var $videoSrc;
    $('.video-btn').click(function() {
        $videoSrc = $(this).data( "src" );
    });

    // when the modal is opened autoplay it
    $('#exampleModal').on('shown.bs.modal', function (e) {

    // set the video src to autoplay and not to show related video. Youtube related video is like a box of chocolates... you never know what you're gonna get
        $("#video").attr('src',$videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0");

    })

    // stop playing the youtube video when I close the modal
    $('#exampleModal').on('hide.bs.modal', function (e) {
        // a poor man's stop video
        $("#video").attr('src',$videoSrc);
    })

    // Search form
    $('.search-form-trigger').on('click', function (e) {
        e.preventDefault();
        var searchFormElement = $('.search-form-element');
        var navbarNavDropdown = $('#navbarNavDropdown');
        searchFormElement.toggleClass('search-active');
        navbarNavDropdown.toggleClass('search-active');
    })

// document ready
});
