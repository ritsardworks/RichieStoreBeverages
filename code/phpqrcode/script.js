const $btnPrint = document.querySelector("#btnPrint");
$btnPrint.addEventListener("click", () => {
    window.print();
});

function getSales(){
    // if(q != ""){
    //     $.ajax({
    //         url: "print.php/q=getsales&id="+id,
    //         type: "get",
    //         success: function(response){
    //             getName(id);
    //             $('#salesTicket').append(reponse);
    //         }
    //     });
    // }
}

function getName(id){
    if(q != ""){
        $.ajax({
            url: "print.php/q=getinfo&id="+id,
            type: "get",
            success: function(response){
                getName(id);
                $('#info').html(reponse);
            }
        });
    }
}