//slider arrows
function sliderArrows() {
    let slider = $('#sliderContainer');
    let screen = $(window).width();
    let scrollValue = screen / 2;
    let scrollSpeed = scrollValue;

    $('#sliderRight').attr("onclick", "").unbind("click");
    $('#sliderRight').click(function(){
        slider.animate( { scrollLeft: '+=' + scrollValue }, scrollSpeed);
    });
    $('#sliderLeft').attr("onclick", "").unbind("click");
    $('#sliderLeft').click(function(){
        slider.animate( { scrollLeft: '-=' + scrollValue }, scrollSpeed);
    });
}

$(document).ready(function() {
    sliderArrows();
});

window.onresize = function() {
    sliderArrows();
}
