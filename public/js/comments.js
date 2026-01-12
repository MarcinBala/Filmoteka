//ajax token setup
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

//show or hide 'show more' button
function updateShowMoreButtons() {
    $('.content-toggle').each(function() {
        let comment_id = this.dataset['comment_id'];
        let text = $(".comment-text[data-comment_id='" + comment_id +"']");

        text.removeClass('max-lines-4');

        let height = text.height();
        let lineHeight = parseInt(text.css('line-height'), 10);
        let lineCount = Math.round(height / lineHeight);

        let btn = $(".content-toggle[data-comment_id='" + comment_id +"']");

        if(lineCount < 5) {
            btn.addClass('hide');
        }
        else {
            btn.removeClass('hide');
        }
    });
    $('.comment-text').each(function() {
        $(this).addClass('max-lines-4');
    });
}

//show more text or less text
$(document).on("click", ".content-toggle", function(event) {
    let comment_id = this.dataset['comment_id'];
    let text = $(".comment-text[data-comment_id='" + comment_id +"']");

    if(text.hasClass('max-lines-4')) {
        text.removeClass('max-lines-4');
        $(this).html('Pokaż mniej');
    }
    else {
        text.addClass('max-lines-4');
        $(this).html('Pokaż więcej');
    }
});

//load comments
$(document).ready(function() {
    let post_id = $('#post').data('post_id');
    $.ajax({
        method: "GET",
        url: '/comment/view',
        data: {
            post_id: post_id,
        },
        success: function(response) {
            $('#commentSection').html(response);
            updateShowMoreButtons();
        }
    });
    $('.comment-replies').addClass('show');
});

//disable send button if textarea is empty
$(document).on("keyup", ".comment-textarea", function() {
    let id = null;
    if(this.dataset['comment_id']) {
        id = this.dataset['comment_id'];
    }

    if (id) {
        var elem = $(".comment-btn[data-comment_id='" + id +"']");
    }
    else {
        var elem = $('#postCommentBtn');
    }

    if( $(this).val().trim()) {
        elem.prop( "disabled", false );
    }
    else {
        elem.prop( "disabled", true );
    }
});

//ajax create a comment
$(document).on("click", ".ajax-comment", function(event) {
    event.preventDefault();

    let post_id = this.dataset['post_id'];
    let reply_to_id = null;
    if (this.dataset['reply_to_id']) {
        reply_to_id = this.dataset['reply_to_id'];
    }
    if (reply_to_id) {
        let comment_id = this.dataset['comment_id'];
        var textarea = $(".comment-textarea[data-comment_id='" + comment_id +"']");
        var content = textarea.val();
    }
    else {
        var textarea = $('#postCommentTextarea');
        var content = textarea.val();
    }

    if (!content.trim()) {
        return null;
    }
    if (content.length > 500) {
        alert('Maksymalna długość komentarza to 500 znaków.');
        return null;
    }

    $.ajax({
        method: "POST",
        url: '/comment',
        data: {
            post_id: post_id,
            reply_to_id: reply_to_id,
            content: content
        },
        success: function(response) {
            textarea.val('');
            $('#commentSection').html(response);
            if( $(".comment-replies[data-comment_id='" + reply_to_id +"']") ) {
                $(".comment-replies[data-comment_id='" + reply_to_id +"']").css('display', 'block');
            }
            updateShowMoreButtons();
        }
    });
});

//ajax edit a comment
$(document).on("click", ".ajax-edit-comment", function(event) {
    event.preventDefault();

    let comment_id = this.dataset['comment_id'];
    let textarea = $(".comment-edit-textarea[data-comment_id='" + comment_id +"']");
    let content = textarea.val();

    let reply_to_id = null;
    if (this.dataset['reply_to_id']) {
        reply_to_id = this.dataset['reply_to_id'];
    }

    if (!content.trim()) {
        return null;
    }
    if (content.length > 500) {
        alert('Maksymalna długość komentarza to 500 znaków.');
        return null;
    }

    $.ajax({
        method: "POST",
        url: '/comment/edit',
        data: {
            comment_id: comment_id,
            content: content
        },
        success: function(response) {
            let expand = false;
            if($(".comment-replies[data-comment_id='" + comment_id +"']").first().css('display') == 'block') {
                expand = true;
            }
            $('#commentSection').html(response);
            if(reply_to_id) {
                $(".comment-replies[data-comment_id='" + reply_to_id +"']").css('display', 'block');
            }
            if(expand) {
                $(".comment-replies[data-comment_id='" + comment_id +"']").css('display', 'block');
            }
            updateShowMoreButtons();
        }
    });
});

//ajax delete a comment
$(document).on("click", ".comment-delete-dropdown", function(event) {
    event.preventDefault();

    let comment_id = this.dataset['comment_id'];
    let reply_to_id = null;
    if (this.dataset['reply_to_id']) {
        reply_to_id = this.dataset['reply_to_id'];
    }

    $.ajax({
        method: "DELETE",
        url: '/comment',
        data: {
            comment_id: comment_id
        },
        success: function(response) {
            $('#commentSection').html(response);
            if( $(".comment-replies[data-comment_id='" + reply_to_id +"']") ) {
                $(".comment-replies[data-comment_id='" + reply_to_id +"']").css('display', 'block');
            }
            updateShowMoreButtons();
        }
    });
});


//toggle comment form display
$(document).on("click", ".comment-reply-btn", function(event) {
    let comment_id = this.dataset['comment_id'];
    let reply_to_user = null;
    if (this.dataset['reply_to_user']) {
        reply_to_user = this.dataset['reply_to_user'];
    }

    if( $(".comment-reply[data-comment_id='" + comment_id +"']").css('display') == 'none' ) {
        $('.comment-reply').css('display', 'none');
        $(".comment-reply[data-comment_id='" + comment_id +"']").css('display', 'block');

        if(reply_to_user) {
            $(".comment-textarea[data-comment_id='" + comment_id +"']").val('@' + reply_to_user + ' ').focus();
        }
        else {
            $(".comment-textarea[data-comment_id='" + comment_id +"']").val('').focus();
        }
    }
    else {
        $('.comment-reply').css('display', 'none');
    }
});

//ajax like/dislike a comment
$(document).on("click", ".ajax-comment-like", function(event) {
    event.preventDefault();
    let like = 1;
    if( $(this).hasClass("dislike") ){
        like = 0;
    }
    let comment_id = this.dataset['comment_id'];

    $.ajax({
        method: "POST",
        url: '/comment/like',
        data: {
            like: like,
            comment_id: comment_id
        },
        success: function(response) {
            $commentlikecounter = $('#comment-like-counter' + comment_id);
            $score = response['score'];
            $commentlikecounter.html($score);
        }
    });
});

//comment cancel
$(document).on("click", ".comment-cancel-btn", function(event) {
    let comment_id = this.dataset['comment_id'];
    $(".comment-reply[data-comment_id='" + comment_id +"']").css('display', 'none');
});

//show/hide comment replies
$(document).on("click", ".comment-show-replies-btn", function(event) {
    let comment_id = this.dataset['comment_id'];
    let replies_count = this.dataset['count'];
    let replies = $(".comment-replies[data-comment_id='" + comment_id +"']");

    //show replies
    if(replies.css('display') == 'none') {
        replies.css('display', 'block');
        if (replies_count > 1) {
            $(this).html('Ukryj '+ replies_count +' odpowiedzi');
        }
        else {
            $(this).html('Ukryj 1 odpowiedź');
        }
    }
    //hide replies
    else {
        replies.css('display', 'none');
        if (replies_count > 1) {
            $(this).html('Pokaż '+ replies_count +' odpowiedzi');
        }
        else {
            $(this).html('Pokaż 1 odpowiedź');
        }
    }

    console.log('click');
    updateShowMoreButtons();
});

//comment edit cancel
$(document).on("click", ".comment-edit-cancel-btn", function(event) {
    let comment_id = this.dataset['comment_id'];
    $(".comment-edit[data-comment_id='" + comment_id +"']").css('display', 'none');
    $(".comment-text[data-comment_id='" + comment_id +"']").css('display', 'block');
});

//comment show edit form
$(document).on("click", ".comment-edit-dropdown", function(event) {
    event.preventDefault();
    let comment_id = this.dataset['comment_id'];
    let comment_text = $(".comment-text[data-comment_id='" + comment_id +"']");
    $(".comment-edit[data-comment_id='" + comment_id +"']").css('display', 'block');
    comment_text.css('display', 'none');
    $(".comment-edit-textarea[data-comment_id='" + comment_id +"']").val(comment_text.html());
});
