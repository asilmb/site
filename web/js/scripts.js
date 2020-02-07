$('.btn-primary').on('click',function () {
    $('.invisible').css("visibility", "visible");
})
$('.btn-success').on('click', function(){
    $.ajax({
        url: '/deck/study?id='+this.id,
        type: 'POST',
        data: "id="+this.id,
        success: function(res){
            console.log(res);
        },
        error: function(){

        }
    });
    return false;
});