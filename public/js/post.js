//ajax token setup
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(window).scroll(function() {

});

//show post image in new tab
$(document).on("click", ".post-img", function(event) {
    let src = $(this).attr('src');
    window.open(src, "_blank");
});
$(document).on("click", ".post-img-large", function(event) {
    let src = $(this).attr('src');
    window.open(src, "_blank");
});

//ajax like/dislike a post
$(document).on("click", ".ajax-post-like", function(event) {
    event.preventDefault();
    let like = 1;
    if( $(this).hasClass("dislike") ){
        like = 0;
    }
    let post_id = this.dataset['post_id'];

    $.ajax({
        method: "POST",
        url: '/p/like',
        data: {
            like: like,
            post_id: post_id
        },
        success: function(response) {
            $postlikecounter = $('#post-like-counter' + post_id);
            $score = response['score'];
            $postlikecounter.html($score);
        }
    });
});

//change like image
$(document).on("click", ".like", function(event) {
    let src = $(this).attr('src');

    if ( $(this).hasClass('ajax-post-like') ){
        let post_id = this.dataset['post_id'];
        if( src == "/svg/thumbsup_blank.svg") {
            src = "/svg/thumbsup.svg";
            $("#postDislike" + post_id).attr('src', "/svg/thumbsdown_blank.svg");
        }
        else {
            src = "/svg/thumbsup_blank.svg";
        }
        $(this).attr('src', src);
    }

    else if( $(this).hasClass('ajax-comment-like') ) {
        let comment_id = this.dataset['comment_id'];
        if( src == "/svg/thumbsup_blank.svg") {
            src = "/svg/thumbsup.svg";
            $("#commentDislike" + comment_id).attr('src', "/svg/thumbsdown_blank.svg");
        }
        else {
            src = "/svg/thumbsup_blank.svg";
        }
        $(this).attr('src', src);
    }
});

//change dislike image
$(document).on("click", ".dislike", function(event) {
    let src = $(this).attr('src');

    if ( $(this).hasClass('ajax-post-like') ){
        let post_id = this.dataset['post_id'];
        if( src == "/svg/thumbsdown_blank.svg") {
            src = "/svg/thumbsdown.svg";
            $("#postLike" + post_id).attr('src', "/svg/thumbsup_blank.svg");
        }
        else {
            src = "/svg/thumbsdown_blank.svg";
        }
        $(this).attr('src', src);
    }

    else if( $(this).hasClass('ajax-comment-like') ) {
        let comment_id = this.dataset['comment_id'];
        if( src == "/svg/thumbsdown_blank.svg") {
            src = "/svg/thumbsdown.svg";
            $("#commentLike" + comment_id).attr('src', "/svg/thumbsup_blank.svg");
        }
        else {
            src = "/svg/thumbsdown_blank.svg";
        }
        $(this).attr('src', src);
    }
});
