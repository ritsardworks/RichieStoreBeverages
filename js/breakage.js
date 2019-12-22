$("document").ready(function (){
    loadNames();
    loadProducts();
    $('#newBreak').onclick(function(){
      newbreakage();
    });
});

function newbreakage(){
  
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
            console.log(reponse);
            if (reponse == 1) {
                alert("No Products Found!");
            } else {
                $("#products").append(reponse);
            }
        }
    });
}
