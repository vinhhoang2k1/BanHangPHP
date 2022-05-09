$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$('#customFileImage').change(function(){
    let img = $('.preview__avatar')[0];

    $(img).prop('src', URL.createObjectURL(this.files[0]));
    img.width = 100;
    img.height = 130;
    $(img).addClass('mt-2');
});

function removeRow(id, url) {
    if (confirm('Bạn có chắc chắn muốn xóa')){
        $.ajax({
            type: "DELETE",
            url: url,
            data: {id:id},
            dataType: "json",
            success: function(res) {
                if (res.error == false){
                    alert(res.message);
                    location.reload();
                    return false;
                }
                alert(res.message);
            }
        });
    }
}
function removeFile(id, url) {
    if (confirm('Bạn có chắc chắn muốn xóa')){
        $.ajax({
            type: "DELETE",
            url: url,
            data: {id:id},
            dataType: "json",
            success: function(res) {
                if (res.error == false){
                    alert(res.message);
                    $('.item-file[file_id="'+id+'"]').remove();
                    return false;
                }
                alert(res.message);
            }
        });
    }
}
function changeStatusItem(id, url) {
    if (confirm('Bạn có chắc chắn muốn thay đổi trạng thái')){
        $.ajax({
            type: "POST",
            url: url,
            data: {id:id},
            dataType: "json",
            success: function(res) {

            }
        });
    }
}
