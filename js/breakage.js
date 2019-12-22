$("document").ready(function (){
  loadBreakage();
  loadNames();
  loadProducts();
  $('#newBreak').click(function(){
    newbreakage();
  });
});

function newbreakage(){
  if(checkFields() == true){
    var qty = $('#qty').val();
    var prod_id = $('#desc').val();
    var type = $('#type').val();
    var prof_id = $('#name').val();
    $.ajax({
      url: 'php/breakage.php',
      type: 'post',
      data: {viewKey: 'newBreakage', qty: qty, prd_id: prod_id, type: type, prf_id: prof_id},
      success: function (response) {
        if(response == 0){
          alert("Something Went Wrong! Try Again");
        }else{
          alert(reponse);
          loadBreakage();
        }
      }
    });
  }
}

function loadBreakage(){
  $.ajax({
    url: "php/breakage.php?q=getBreakage",
    type: "get",
    success: function (reponse) {
      if(reponse == 0){
          $("#tbodyBreak").append("No Records Yet!");
      }else if(reponse.includes('.html')){
        window.location = reponse
      }
      else{
          $("#tbodyBreak").append(reponse);
      }
    }
  });
}

function loadNames(){
    $.ajax({
        url: "php/breakage.php?q=getNames",
        type: "get",
        success: function (reponse) {
            if(reponse == 1){
                alert("No Profile Found!");
            }else{
                $("#names").append(reponse);
            }
        }
    });
}

function loadProducts(){
    $.ajax({
        url: "php/breakage.php?q=getProducts",
        type: "get",
        success: function (reponse) {
            if (reponse == 1) {
                alert("No Products Found!");
            } else {
                $("#products").append(reponse);
            }
        }
    });
}

function checkFields(){
  var qty = $('#qty').val();
  var prod_id = $('#desc').val();
  var type = $('#type').val();
  var prof_id = $('#name').val();
  var offset = 0;
  if(qty == "" || qty <= 0){
    $('#lblQty').text('Cannot Be Empty!');
    offset++;
  }
  if(prod_id == "" || prod_id <= 0){
    $('#lblName').text('Cannot Be Empty!');
    offset++;
  }
  if(type == "" || type == "-"){
    $('#lblType').text('Cannot Be Empty!');
    offset++;
  }
  if(prof_id == "" || prof_id <= 0){
    $('#lblBrB').text('Cannot Be Empty!');
    offset++;
  }
  if(offset > 0){
    return false;
  }else{
    return true;
  }
}

function clearFields() {
  var qty = $('#qty').val("");
  var prod_id = $('#desc').val("");
  var type = $('#type').val("");
  var prof_id = $('#name').val("");
}
