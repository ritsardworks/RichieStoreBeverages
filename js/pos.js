$('document').ready(function(){
    $('#btnPay').click(function (){
        var json = JSON.stringify(getJson());
        $.ajax({
            url:"php/pos.php?q=pay&data="+json,
            type: 'post',
            data:{data: json},
            success: function (response) {
                // if (response == 0) {
                //     alert('No Products in Cart. Please add one or more products to cart to procedd for payment');
                // }else{
                //     alert(response);
                // }
                if(response == 1){
                    // alert('Success!');
                    // clear();
                    $.ajax({
                        url: 'php/pos.php?q=orderNo',
                        type: 'get',
                        success: function (response1) {
                            if(response1 == "" || response1 == 0){
                                alert("Something Went Wrong!");
                            }else{
                                window.location = ('printing/print.php?q='+ response1);
                            }
                        }
                    });
                }else{
                    $(".error").html(response);
                }
            }
        });
    });
});

function getJson() {
    var TableData = new Array();
    $('#listOfProducts tr').each(function (row, tr) {
        TableData[row] = {
            "qty": $(tr).find('td:eq(0) input').val()
            , "dscprtn": $(tr).find('td:eq(1)').text()
            , "prc": $(tr).find('td:eq(2)').text()
            , "depType": $(tr).find('td:eq(3)').text()
            , "depQty": $(tr).find('td:eq(4)').text()
            , "depPrice": $(tr).find('td:eq(5)').text()
        }
    });
    return TableData;
}

function setValue(data){
    $("#productsTable").on('click', '.btnSelect', function () {
        // get the current row
        var currentRow = $(this).closest("tr");

        var col3 = currentRow.find("td:eq(2)").text();
        var col4 = currentRow.find("td:eq(3)").text();
        currentRow.find("td:eq(4)").text((parseInt(col3) * data.value) + parseInt(col4));
        compute();
    });
    compute();
}

function compute(){
    var ttl = 0;
    $('#listOfProducts tr').each(function (row, tr) {
        ttl += ($(tr).find('td:eq(0) input').val() * parseInt($(tr).find('td:eq(2)').text()) 
        + (parseInt($(tr).find('td:eq(4)').text()) * parseInt($(tr).find('td:eq(5)').text())));
    });
    $('#ttlAmnt').val(ttl);
}

function remove(o){
    var p = o.parentNode.parentNode;
    p.parentNode.removeChild(p);
    compute();
}

function loadProd(){
    $.ajax({
        url: 'php/pos.php?q=loadProducts',
        type: 'get',
        success: function (response) {
            if (response.includes('.html')) {
                window.location = (response);
            } else {
                $('#products').append(response);
                checkVal();
            }
        }
    });
}

function getItem(){
    var offset = 0;
    var name = $('#product').val();
    var qty = $('#qtty').val();
    var depType = $('#type').val();
    var depqty = $('#depqtty').val();
    if(name == ""){
        offset++;
        $('#lblProd').html('Cannot Be Blank!');
    }
    if (qty == "") {
        offset++;
        $('#lblQty').html('Cannot Be Blank!');
    }
    if (depType != "" && depqty == ""){
        offset++;
        $('#lblDeposit').html('Cannot Be Blank!');
    }
    if (depType == "" && depqty != ""){
        offset++;
        $('#lblDepType').html('Cannot Be Blank!');
    }
    if (depType == "" && depqty == ""){
        depType = "N-A";
        depqty = 0;
    }
    if(offset == 0){
        $.ajax({
            url: 'php/pos.php?q=addProduct&name='+name+"&qty="+qty+"&type="+depType+"&dqty="+depqty,
            type: 'post',
            data: { name: name, qty: qty , type: depType, dq: depqty},
            success: function (response) {
                if (response == 0) {
                    alert('Something Went Wrong!');
                } else if(response.includes('Remaining')){
                    alert(response);
                    clear();
                }else {
                    $('#listOfProducts').append(response);
                    compute();
                    clear();
                }
            }
        });
    }
}

function checkVal() {
    if ($('#type').val() == ""){
        $('#depqtty').prop('disabled', true);
    }else{
        $('#depqtty').prop('disabled', false);
    }
}

function clear(){
    $('#product').val('');
    $('#qtty').val('');
    $('#type').val('');
    $('#depqtty').val('');
    $('#product').focus();
}