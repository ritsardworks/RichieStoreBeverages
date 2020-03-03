$('.list-group-item-action').on('click', function(){
    var $this = $(this);
    clearSideItems();
    $this.removeClass('bg-light').addClass('bg-dark').addClass('active');
    $('.mb-header').text($this.text());
    $.ajax({
      url: "/dist/dashboard.php",
      type: "post",
      data: {item: $this.text()},
      success: function(response){
        $('.mb-content').html(response);
      }
    })
})

function clearSideItems(){
  $('.list-group-item-action').removeClass('bg-dark').removeClass('active').addClass('bg-light');
  $('.mb-content').empty();
}
