$(document).ready(function() {
    $('#name').typeahead({
        source: function (query, process) {
            return $.get(route, {query: query}, function (data) {
                return process(data);
            });
        },
        displayText: function(item){ return item.name; },
        afterSelect: function (data) {
            $('#id').val(data.id);

            $('#actorName').html(data.name);
            $('#actorDateOfBirth').html(data.date);
            $('#actorPlaceOfBirth').html(data.place);
            $('#actorDescription').html(data.description);
            if(data.photo && data.photo.trim()) {
                $('#actorPhoto').attr("src", "/storage/" + data.photo);
            }
            else {
                $('#actorPhoto').attr("src", "/img/Person.jpg");
            }
            $('#actorLink').attr("href", "/actor/" + data.id);
        }
    });
});
