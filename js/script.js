jQuery(document).ready(function ($) {

    $('textarea').autogrow();

    
    /**
     * Default ajax setup
     *//*
    $.ajaxSetup({
        type: "POST",
        url: inlinecomments.ajaxurl,
        dataType: "html"
    });*/
    
    /**
     * Allow Comment form to be submitted when the user
     * presses the "enter" key.
     */
    $(document).on('keypress', '#default_add_comment_form textarea, #default_add_comment_form input', function (event) {
        if (event.keyCode == '13') {
            event.preventDefault();
            $('#default_add_comment_form').submit();
        }
    });
    

    window.inline_comments_ajax_get_comments = function (params, ajax_global) {

        var request_in_process = false;

        params.action = 'inline_comments_get_comments';

        $.ajax({
            type: "POST",
            url: inlinecomments.ajaxurl,
            dataType: "html",
            data: params,
            cache: false,
            global: ajax_global,
            success: function (msg) {
                $(params.target_div).fadeOut(4000);
                $(params.target_div).html(msg).fadeIn(4000);
                request_in_process = false;
                $('.inline-comments-container').mCustomScrollbar("scrollTo", "bottom");
                if (typeof params.callback === "function") {
                    params.callback();
                }
            }
        });
    }

    /**
     * Submit new comment, note comments are loaded via ajax
     */
    $(document).on('submit', '#default_add_comment_form', function (event) {
        event.preventDefault();

        var $this = $(this);

        var data = {
            action: 'inline_comments_add_comment',
            post_id: $('#inline-comments-ajax-handle').attr('data-post_id'),
            user_name: $('#inline_comments_user_name').val(),
            user_email: $('#inline_comments_user_email').val(),
            user_url: $('#inline_comments_user_url').val(),
            comment: $( '#inline-comments-textarea' ).val(),
            add_comment_nonce: $('#inline_comments_form_nonce').val()
        };

        $.ajax({
            type: "POST",
            url: inlinecomments.ajaxurl,
            dataType: "html",
            data: data,
            timeout: 5000,
            global: false,
            success: function (msg) {
            	console.log(msg);
                inline_comments_ajax_get_comments({
                    "target_div": "#inline-comments-ajax-target",
                    //"template": $( '#inline_comments_ajax_handle' ).attr( 'data-template' ),
                    "post_id": $('#inline-comments-ajax-handle').attr('data-post_id'),
                    "get_comments_nonce": $('#inline_comments_nonce').val()
                }, false);
                $('textarea').val('');
                $('.inline-comments-container').mCustomScrollbar("update");// doesn't work
            },
            error: function () {
                $('#inline_comments_ajax_target').html('<p class="error"><strong>Oops!</strong> Try that again in a few moments.</p>');
                
            }
        });

    });


    /**
     * Retrieve existing comments when page is loaded or refreshed
     */
    $(window).load(function () {
    
        // We only run this if the comments template has been served ok
        if ($('#inline-comments-ajax-handle').length) {

            // Setup our Ajax POST variables
            var data = {
                action: 'inline_comments_get_comments',
                post_id: $('#inline-comments-ajax-handle').attr( 'data-post_id' ),
                get_comments_nonce: $('#inline_comments_nonce').val()
            };

            $.ajax({
                type: 'POST',
                url: inlinecomments.ajaxurl,
                dataType: "html",
                data: data,
                timeout: 5000,
                success: function (msg) {
                	// fade out loading icon
                    $('.inline-comments-loading-icon').hide();
                    // fade in the retrieved comments
                    $('#inline-comments-ajax-target').fadeIn().html(msg);
                    // fade in the comments form
                    $('#inline-comments-form').fadeIn();
                    // fade in the callout
                    // Conditional prevents callout displaying if server-side validation error occurs
                    if ($('#inline-comments-target').length) {
                    	$('.inline-comments-callout-container').fadeIn();
                    }
                    if ( location.hash ){
                    $('.inline-comments-container').mCustomScrollbar({
                    	scrollInertia: 100,
                    	theme: "dark-thick"
                    });
                    $('.inline-comments-container').mCustomScrollbar("scrollTo", "bottom");
                    /*if ( location.hash ){
                        $('html, body').animate({
                            scrollTop: $(location.hash).offset().top
                        });
                        $(location.hash).addClass('inline-comments-highlight');
                    }
                },
                error: function () {
                	// fade out the loading icon
                	$( '.inline-comments-loading-icon').hide();
                	// fade in the error message
                    $('#inline-comments-ajax-target').fadeIn().html('<p class="error"><strong>Oops!</strong> Refresh the page and try that again in a few moments.</p>');
                
                }
            });
            /*
            $( document ).on('click', '.inline-comments-time-handle', function( e ){
                $( '.inline-comments-content' ).removeClass('inline-comments-highlight')
                comment_id = '#comment-' + $( this ).attr('data-comment_id');
                $( comment_id ).addClass('inline-comments-highlight');
            });
            */
        }
    });
    

    $(document).on('click', '.inline-comments-more-handle', function (event) {
        event.preventDefault();
        if($(this).hasClass('inline-comments-more-open') ){
            $('a', this).html('more');
            $('#comment').css('height', '0');
        } else {
            $('a', this).html('less');
            $('#comment').css('height', '150');
        }
        $(this).toggleClass('inline-comments-more-open');
        $('.inline-comments-more-container').toggle();
    });
});