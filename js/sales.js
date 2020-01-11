$('document').ready(function(){
  loadRefunds();
});

function loadRefunds(){
  $.ajax({
      url: 'php/sales.php?q=getRefunds',
      type: 'get',
      success: function (response) {
          if(response.includes('.html')){
              window.location = (response);
          }else{
              $('#refunds').append(response);
          }
      }
  });
}

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

function refundThis(data){
  var split = data.split("+");
  var max = split[1];
  var id = split[0];
  $('#id').val(id);
  $("#refundVal").attr({
       "max" : max,        // substitute your own
       "min" : 1          // values (or variables) here
    });
}

function refund(data){
  var qty = $('#refundVal').val();
  console.log(data.value + " " + qty);
  // $('#exampleModalCenter').modal('hide');
    $.ajax({
      url: 'php/sales.php?q=refund&id='+data.value,
      type: 'post',
      data: {id: data.value, qty: qty},
      success: function (response) {
        if(response == 1){

            // alert('Refunded!');
            loadSalesLine();
            loadRefunds();
        }else{
            $('.container').html(response);
        }
      }
    });

}

function back(){
    window.location = ('sales.html');
}
