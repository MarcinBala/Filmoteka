//ajax token setup
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

//ajax like/dislike a post
$(document).on("click", ".ajax-news-like", function(event) {
    event.preventDefault();
    let like = 1;
    if( $(this).hasClass("dislike") ){
        like = 0;
    }
    let news_id = this.dataset['news_id'];

    $.ajax({
        method: "POST",
        url: '/news/like',
        data: {
            like: like,
            news_id: news_id
        },
        success: function(response) {
            let counter = $('#news-like-counter' + news_id);
            let score = response['score'];
            counter.html(score);
        }
    });
});

//change like image
$(document).on("click", ".like", function(event) {
    let src = $(this).attr('src');

    if ( $(this).hasClass('ajax-news-like') ){
        let news_id = this.dataset['news_id'];
        if( src == "/svg/thumbsup_blank.svg") {
            src = "/svg/thumbsup.svg";
            $("#newsDislike" + news_id).attr('src', "/svg/thumbsdown_blank.svg");
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

    if ( $(this).hasClass('ajax-news-like') ){
        let news_id = this.dataset['news_id'];
        if( src == "/svg/thumbsdown_blank.svg") {
            src = "/svg/thumbsdown.svg";
            $("#newsLike" + news_id).attr('src', "/svg/thumbsup_blank.svg");
        }
        else {
            src = "/svg/thumbsdown_blank.svg";
        }
        $(this).attr('src', src);
    }
});
