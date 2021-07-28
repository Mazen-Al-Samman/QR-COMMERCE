$(document).ready(function () {

    $('.addToCart').click(function () {
        var product_id = $(this).attr('data-id');
        var quantity = $('.quantity_'+product_id).val();
        $.ajax({
            type: "POST",
            url : "./invoice/add-to-cart/",
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            data: {
                'product_id': product_id,
                'quantity': quantity
            },
            success:function(data){
                $('#cart-content').html(data);
            }
        });
    });

});
