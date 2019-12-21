function searchProd(data){
    var name = data.value.replace(/'/g, '').replace(/"/g, '');
    $.ajax({
        url: "php/search.php?q=searchProd&data="+name,
        type: "get",
        success: function(response){
            $('#productTable').html(response);
        }
    })
}

function searchOrder(data) {
    var name = data.value.replace(/'/g, '').replace(/"/g, '');
    $.ajax({
        url: "php/search.php?q=searchOrder&data=" + name,
        type: "get",
        success: function (response) {
            $('#bodyProducts').html(response);
        }
    })
}

function searchProfile(data){
    var name = data.value.replace(/'/g, '').replace(/"/g, '');
}