$('document').ready(function(){
    
});

function loadSales(){
    $.ajax({
        url: 'php/sales.php?q=getSales',
        type: 'get',
        success: function (response) {
            if(response.includes('.html')){
                window.location = (response);
            }else{
                $('#bodyProducts').append(response);
            }
        }
    });
}

function viewSale(data){
    var o_id = data.value;
    $.ajax({
        url: 'php/sales.php?q=setId&id='+o_id,
        type: 'get',
        success: function (response) {
            console.log(response);
            if(response == 1){
                window.location = ('seesales.html');
            }else{
                alert('Something Went Wrong!');
            }
        }
    });
}

function loadSalesLine(){
    $.ajax({
        url: 'php/sales.php?q=getLine',
        type: 'get',
        success: function (response) {
            if (response.includes('.html')) {
                window.location = (response);
            }else{
                $('#salesLine').html(response);
            }
        }
    });
}

function refund(data){
    $.ajax({
        url: 'php/sales.php?q=refund&id='+data.value,
        type: 'post',
        data: {id: data.value},
        success: function (response) {
            if(response == 1){
                alert('Refunded!');
                loadSalesLine();
            }else{
                $('.container').html(response);
            }
        }
    });
}

function back(){
    window.location = ('sales.html');
}