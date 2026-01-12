$(document).on("click", ".get-title", function(event) {
    let title = this.dataset['title'];
    $('#title').val(title);
});

$(document).ready(function() {
    $('#title').typeahead({
        source: function (query, process) {
            return $.get(route, {query: query}, function (data) {
                return process(data);
            });
        },
        displayText: function(item){ return item.title;}
    });
});
