//ajax token setup
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

//rate film
$(document).on("click", ".vote", function(event) {
    event.preventDefault();

    let film_id = $('.film-top-title').data('film_id');
    let rating = this.dataset['vote'];

    $.ajax({
        method: "POST",
        url: '/review',
        data: {
            rating: rating,
            film_id: film_id,
            ajax: true
        },
        success: function(response) {
            let store = response['store'];
            let btn = $(".vote[data-vote='" + rating +"']");
            let section = $('#rateFilmSection');
            $('.vote').removeClass('hover');
            if (store) {
                btn.addClass('hover');
                section.html('Twoja Ocena:');
            }
            else {
                section.html('Oceń Film');
            }
        }
    });
});

//add to favourites or remove
$(document).on("click", "#svgHeartButton", function(event) {
    event.preventDefault();

    let film_id = $('.film-top-title').data('film_id');

    $.ajax({
        method: "POST",
        url: '/film/favourite',
        data: {
            film_id: film_id,
            ajax: true
        },
        success: function(response) {
            let store = response['store'];
            let svg = $('#svg-heart');
            if(store) {
                svg.removeClass('heart-blank');
                svg.addClass('heart');
                svg.attr('data-original-title', 'Usuń z ulubionych');
            }
            else {
                svg.removeClass('heart');
                svg.addClass('heart-blank');
                svg.attr('data-original-title', 'Dodaj do ulubionych');
            }
            $('#favouritesCount').html(response['favouritesCount']);
        }
    });
});

//add to want to see or remove
$(document).on("click", "#svgEyeButton", function(event) {
    event.preventDefault();

    let film_id = $('.film-top-title').data('film_id');

    $.ajax({
        method: "POST",
        url: '/film/want_to_see',
        data: {
            film_id: film_id
        },
        success: function(response) {
            let store = response['store'];
            let svg = $('#svg-eye');
            if(store) {
                svg.removeClass('eye-blank');
                svg.addClass('eye');
                svg.attr('data-original-title', 'Już nie chcę obejrzeć');
            }
            else {
                svg.removeClass('eye');
                svg.addClass('eye-blank');
                svg.attr('data-original-title', 'Chcę obejrzeć');
            }
            $('#wantToSeeCount').html(response['wantToSeeCount']);
        }
    });
});

function updateGradient() {
    let height = $(".film-top-title").height();
    let lineHeight = parseInt($(".film-top-title").css('line-height'), 10);
    let lineCount = Math.round(height / lineHeight);

    let div = $(".film-top-title-container");

    switch (lineCount) {
        case 1: div.css('background', 'linear-gradient(to bottom, rgba(255,255,255,0.05) 50%, rgba(255,255,255,0.15) 70%, rgba(255,255,255,0.3) 80%, rgba(255,255,255,1) 100%)'); break;
        case 2: div.css('background', 'linear-gradient(to bottom, rgba(255,255,255,0.1) 50%, rgba(255,255,255,0.5) 70%, rgba(255,255,255,0.6) 80%, rgba(255,255,255,1) 100%)'); break;
        default: div.css('background', 'linear-gradient(to bottom, rgba(255,255,255,0.1) 50%, rgba(255,255,255,0.5) 70%, rgba(255,255,255,0.6) 80%, rgba(255,255,255,1) 100%)'); break;
    }
}
$(document).ready(function() {
    updateGradient();
});
window.onresize = function() {
    updateGradient();
}

window.onload = function() {
    if (typeof chartData === 'undefined' || typeof chartLabels === 'undefined') {
        return null;
    }

    const data = {
        labels: chartLabels,
        datasets: [{
            label: 'Średnia Wartość Ocen',
            backgroundColor: "#d48446",
            borderColor: "#d48446",
            data: chartData,
            spanGaps: true,
            pointBackgroundColor: "#c06014",
            pointBorderColor: "#c06014"
        }]
    };
    const config = {
        type: 'line',
        data: data,
        options: {
            scales: {
                y : {
                    min : 0,
                    max : 10,
                    autoSkip : 0
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    };
    const myChart = new Chart(
        document.getElementById('myChart'),
        config
    );
};
