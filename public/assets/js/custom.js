function loadFile(event) {
    var output = document.getElementsByClassName('thumbnail-upload')[0];
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
        URL.revokeObjectURL(output.src) // free memory
    }
}

$('.thumbnail-upload').click(function () {
    $('#file-upload').click();
});

