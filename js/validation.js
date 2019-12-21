$(document).ready(function (){
    $('#logout').click(function(){
        $.ajax({
            url: "php/logout.php",
            type: 'get',
            success: function (response) {
                window.location = ("index.html");
            }
        });
    });
    $('#uRegSubmit').click(function (){
        var offset = 0;
        var fname = $('#fname').val().replace(/'/g, '').replace(/"/g, '');;
        var mname = $('#mname').val().replace(/'/g, '').replace(/"/g, '');;
        var lname = $("#lname").val().replace(/'/g, '').replace(/"/g, '');;
        var address = $('#address').val().replace(/'/g, '').replace(/"/g, '');;
        var cntctnmbr = $('#cntctnmbr').val().replace(/'/g, '').replace(/"/g, '');;
        var utyp = $('#utyp').val().replace(/'/g, '').replace(/"/g, '');;
        var psswrd = $('#psswrd').val().replace(/'/g, '').replace(/"/g, '');;
        var cnfrmpsswrd = $('#cnfrmpsswrd').val().replace(/'/g, '').replace(/"/g, '');;
        if(fname == ""){
            $("#lblfname").html('Cannot be Blank!');
            offset += 1;
        }else{
            $("#lblfname").html('');
        }
        if(mname == ""){
            $("#lblmname").html('Cannot be Blank!');
            offset += 1;
        }else{
            $("#lblmname").html('');
        }
        if(lname == ""){
            $("#lbllname").html('Cannot be Blank!');
            offset += 1;
        }else{
            $("#lbllname").html('');
        }
        if(address == ""){
            $("#lbladdress").html('Cannot be Blank!');
            offset += 1;
        }else{
            $("#lbladdress").html('');
        }
        if(cntctnmbr == ""){
            $("#lblcntctnmbr").html('Cannot be Blank!');
            offset += 1;
        }else{
            $("#lblcntctnmbr").html('');
        }
        if(utyp == "-"){
            $("#lblutyp").html('Please Choose!');
            offset += 1;
        }else{
            $("#lblutyp").html('');
        }
        if(psswrd == ""){
            $("#lblpsswrd").html('Cannot be Blank!');
            offset += 1;
        }else{
            $("#lblpsswrd").html('');
        }
        if(cnfrmpsswrd == ""){
            $("#lblcnfrmpsswrd").html('Cannot be Blank!');
            offset += 1;
        }else{
            $("#lblcnfrmpsswrd").html('');
        }
        if(psswrd != cnfrmpsswrd){
            alert('Passwords do not Match!');
            $("#lblpsswrd").html('Passwords do not match');
            offset += 1;
        }
        if(offset == 0){
            $.ajax({
                url: "php/backend.php?q=regUser",
                type: 'post',
                data: {fname: fname, mname: mname, lname: lname, cntctnmbr:cntctnmbr, utyp: utyp, psswrd: psswrd, address: address},
                success: function (response){
                    // Reponse 1 or 0
                    if(response == 1){
                        alert('Successfully Registered User!');
                        rstUReg();
                        showUsers();
                    }else if(response == 3){
                        alert("Please Don't Leave Anything Blank!");
                        rstUReg();
                    }
                    else{
                        alert('Something Went Wrong!');
                    }
                }
            });
        }
    });
    $('#newProd').click(function(){
        if ($('#newProd').val() > 0){
            console.log($('#newProd').val());
            var desc = $('#dscrptn').val().replace(/'/g, '').replace(/"/g, '');;
            var rtl = $('#rtl_prc').val().replace(/'/g, '').replace(/"/g, '');;
            var btl = $('#BTL_empty_prc').val().replace(/'/g, '').replace(/"/g, '');;
            var cs = $('#CASE_empty_prc').val().replace(/'/g, '').replace(/"/g, '');;
            var shell = $('#SHELL_empty_prc').val().replace(/'/g, '').replace(/"/g, '');
            var offset = 0;
            if (desc == "") {
                $('#lblDesc').html("Cannot be Blank!");
                offset++;
            }
            if (rtl == "") {
                $('#lblRtl').html("Cannot be Blank!");
                offset++;
            }
            if (btl == "") {
                $('#lblBtl').html("Cannot be Blank!");
                offset++;
            }
            if (cs == "") {
                $('#lblCs').html("Cannot be Blank!");
                offset++;
            }
            if (shell == "") {
                $('#lblSh').html("Cannot be Blank!");
                offset++;
            }
            if (offset == 0) {
                $.ajax({
                    url: "php/backend.php?q=updProd&id="+$('#newProd').val(),
                    type: "post",
                    data: { id: $('#newProd').val(),desc: desc, rtl: rtl, btl: btl, cs: cs, sh:shell },
                    success: function (response) {
                        if (response == 1) {
                            hideProdModal();
                            alert('Successfully Updated The Product!');
                            showProducts();
                            rstPReg();
                            showUsers();
                        } else if (response == 3) {
                            alert("Please Don't Leave Anything Blank!");
                            rstPReg();
                        }
                        else {
                            // alert('Something Went Wrong!');
                            $("#productTable").html(response);
                        }
                    }
                });
            }
        }else{
            var desc = $('#dscrptn').val().replace(/'/g, '').replace(/"/g, '');;
            var rtl = $('#rtl_prc').val().replace(/'/g, '').replace(/"/g, '');;
            var btl = $('#BTL_empty_prc').val().replace(/'/g, '').replace(/"/g, '');;
            var cs = $('#CASE_empty_prc').val().replace(/'/g, '').replace(/"/g, '');;
            var shell = $('#SHELL_empty_prc').val().replace(/'/g, '').replace(/"/g, '');
            var offset = 0;
            if (desc == "") {
                $('#lblDesc').html("Cannot be Blank!");
                offset++;
            }
            if (rtl == "") {
                $('#lblRtl').html("Cannot be Blank!");
                offset++;
            }
            if (btl == "") {
                $('#lblBtl').html("Cannot be Blank!");
                offset++;
            }
            if (cs == "") {
                $('#lblCs').html("Cannot be Blank!");
                offset++;
            }
            if (shell == "") {
                $('#lblSh').html("Cannot be Blank!");
                offset++;
            }
            if (offset == 0) {
                $.ajax({
                    url: "php/backend.php?q=newProduct",
                    type: "post",
                    data: { desc: desc, rtl: rtl, btl: btl, cs: cs, sh: shell },
                    success: function (response) {
                        if (response == 1) {
                            alert('Successfully Added a New Product!');
                            showProducts();
                            rstPReg();
                            showUsers();
                        } else if (response == 3) {
                            alert("Please Don't Leave Anything Blank!");
                            rstPReg();
                        }
                        else {
                            alert(response);
                            // $("#productTable").html(response);
                        }
                    }
                });
            }
        }
    });
    $('#btnNewCat').click(function () {
        var name = $('#name').val();
        if (name == "") {
            $('#lblName').html('Cannot Be Blank!');
        } else {
            $.ajax({
                url: 'php/categories.php?q=new&data=' + name,
                type: 'post',
                data: { name: name },
                success: function (response) {
                    if (response == 0) {
                        alert('Something Went Wrong!')
                    } else {
                        alert("Added A New Category");
                        refresh();
                    }
                }
            });
        }
    });
    $('#addProductModal').on('hidden.bs.modal', function () {
        // will only come inside after the modal is shown
        $('#newProd').val(0);
    });
});

function refresh() {
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

function newStock(){
    var newStock = $('#qntty').val().replace(/'/g, '').replace(/"/g, '');;
    var untPrc = $('#untPrc').val().replace(/'/g, '').replace(/"/g, '');;
    var btlRl = $('#btlRl').val().replace(/'/g, '').replace(/"/g, '');;
    var shRl = $('#shRl').val().replace(/'/g, '').replace(/"/g, '');;
    var crRl = $('#crRl').val().replace(/'/g, '').replace(/"/g, '');;
    var offSet = 0;
    if(shRl == ""){
        shRl = 0;
    }
    if(btlRl == ""){
        btlRl = 0;
    }
    if(crRl == ""){
        crRl = 0;
    }
    if(newStock == ""){
        $("#lblQntty").html('Cannot Be Blank!').addClass('text-danger');
        offSet++;
    }
    if(untPrc == ""){
        $("#lblPrc").html('Cannot Be Blank!').addClass('text-danger');
        offSet++;
    }
    if(offSet == 0){
        $.ajax({
            url: "php/backend.php?q=newStock&stock="+newStock+"&prc="+untPrc+"&btlRl="+btlRl+"&shRl="+shRl+"&crRl="+crRl,
            type: "post",
            data: {stock: newStock, btRl: btlRl, shRl: shRl, crRl: crRl},
            success: function(response){
                if(response == 0){
                    alert("Something Went Wrong!");
                }else if(response == 1){
                    showProd();
                }else{
                    alert(response);
                }
                // $('#result').html(response);
                $("#addProductModal").modal('hide');
            }
        });
    }
}

function deleteProd(data){
    var r = confirm("Are you sure you want to delete this Product?");
    if (r == true) {
        $.ajax({
            url: "php/backend.php?q=deleteProd&id=" + data.value,
            type: 'get',
            success: function (response) {
                if (response == 1) {
                    alert('Product Deleted!');
                    showProducts();
                }else{
                    alert('reponse');
                }
            }
        });
    }
}

function updateProd(data) {
    var id = data.value;
    $("#prodTable").on('click', '.btn', function () {
        // get the current row
        var currentRow = $(this).closest("tr");
        var col1 = currentRow.find("td:eq(0)").text();
        var col2 = currentRow.find("td:eq(1)").text();
        var col3 = currentRow.find("td:eq(2)").text();
        var col4 = currentRow.find("td:eq(3)").text();
        var col5 = currentRow.find("td:eq(4)").text();
        console.log(col1, col2, col3, col4, col5);
        $('#dscrptn').val(col1).focus();
        $('#rtl_prc').val(col2.substr(1));
        $('#BTL_empty_prc').val(col3.substr(1));
        $('#CASE_empty_prc').val(col4.substr(1));
        $('#SHELL_empty_prc').val(col5.substr(1));
        $('#newProd').val(id);
    });
    $('#addProfileTrigger').click();
}

function hideProdModal(){
    $('#closeProdModal').click();
}

function showProd() {
    $.ajax({
        url: "php/backend.php?q=stock",
        type: 'get',
        success: function (response) {
            // Reponse 1 or 0
            if (response == 0) {
                alert('Product Not Found!');
            } else {
                // $("#productTable").html(response);
                $("#stockInProd").html(response);
            }
        }
    });
}

function showLogProd(data){
    var id = data.value;
    $.ajax({
        url: "php/backend.php?q=showProduct&id="+id,
        type: 'get',
        success: function (response) {
            // Reponse 1 or 0
            if(response == 0){
                alert('Product Not Found!');
            }else{
                // $("#productTable").html(response);
                window.location = ("stockin.html");
                // alert(response);
            }
        }
    });
}

function showProducts(){
    $.ajax({
        url: "php/backend.php?q=getProducts",
        type: 'get',
        success: function (response){
            // Reponse 1 or 0
            if(response.includes('.html')){
                window.location = response
            }else{
                $("#productTable").html(response);
            }
        }
    });
}

function rstPReg(){
    $('#dscrptn').val("").focus();
    $('#rtl_prc').val("");
    $('#BTL_empty_prc').val("");
    $('#CASE_empty_prc').val("");
    $('#SHELL_empty_prc').val("");
}
function rstUReg(){
    $('#fname').val("").focus();
    $('#mname').val("");
    $("#lname").val("");
    $('#address').val("");
    $('#cntctnmbr').val("");
    $('#utyp').val("");
    $('#psswrd').val("");
    $('#cnfrmpsswrd').val("");
}
function showUsers()
{
    $.ajax({
        url: "php/backend.php?q=users",
        type: 'get',
        success: function (response){
            // Reponse 1 or 0
            console.log(response);
            if(response.includes('.html')){
                window.location = response;
            }
            $("#userTable").html(response);
        }
    });
}

function getUser(){
    $.ajax({
        url: "php/backend.php?q=getUser",
        type: 'get',
        success: function (response){
            // Reponse 1 or 0
            $("#name").html(response);
        }
    });
}

function backStockIn(){
    window.location = ('products.html');
}