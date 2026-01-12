var modal = document.getElementsByClassName("myModal");

function showModal(id) {
    $modal = document.getElementById(`modal${id}`);
    $modal.style.display = "block";

    window.onclick = function(event) {
        if (event.target == $modal) {
            $modal.style.display = "none";
        }
    }
}

function hideModal(id) {
    try {
        $modal = document.getElementById(`modal${id}`);
        $modal.style.display = "none";
    } catch (error) {
    }
}
