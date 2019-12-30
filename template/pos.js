// function addToTicket(data){
//   var id = data.value;
//   $.ajax({
//     url: 'php/newpos.php',
//     type: 'post',
//     data:{q: 'getProduct', id: id},
//     success: function(response){
//       getBtl(id);
//       getCase(id);
//       getShell(id);
//       console.log(response);
//       $("#lblQty").removeClass();
//       if(response >= 50){
//         $("#lblQty").addClass('text-success');
//       }else if (response < 50 && response >= 15) {
//         $("#lblQty").addClass('text-warning');
//       }else{
//         $("#lblQty").addClass('text-danger');
//       }
//       $("#lblQty").html(response);
//     }
//   });
//   $('#depositModal').modal('show');
// }
function getBtl(id){
  $.ajax({
    url: '../php/newpos.php',
    type: 'post',
    data:{q: 'gtBtl', id: id},
    success: function(response){
      $("#lblBtl").html(response);
    }
  });
}
function getCase(id){
  $.ajax({
    url: '../php/newpos.php',
    type: 'post',
    data:{q: 'gtCs', id: id},
    success: function(response){
      $("#lblCase").html(response);
    }
  });
}
function getShell(id){
  $.ajax({
    url: '../php/newpos.php',
    type: 'post',
    data:{q: 'gtShll', id: id},
    success: function(response){
      $("#lblShell").html(response);
    }
  });
}
function getProducts(){
  $.ajax({
    url: '/php/newpos.php',
    type: 'post',
    data:{q: 'loadProducts'},
    success: function (response) {
      $('#tproducts').append(response);
    }
  })
}
