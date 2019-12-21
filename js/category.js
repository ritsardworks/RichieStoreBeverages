$(document).ready(function () {
    $('#btnNewCat').click(function () {
        var name = $('#name').val();
        if(name == ""){
            $('#lblName').html('Cannot Be Blank!');
        }else{
            $.ajax({
                url: 'php/categories.php?q=new&data='+name,
                type: 'post',
                data: {name: name},
                success: function (response){
                    if(response == 0){
                        alert('Something Went Wrong!')
                    }else{
                        alert("Added A New Category");
                        refresh();
                    }
                }
            });
        }
    });
    
    $('#btnNewCatProd').click(function () {
        
    });
});

function refresh(){
    $.ajax({
        url: 'php/categories.php?q=refresh',
        type: 'post',
        data: { name: name },
        success: function (response) {
            if (response == 0) {
                alert('Something Went Wrong!')
            } else {
                $('#listOfCategory').html(response);
            }
        }
    });
}