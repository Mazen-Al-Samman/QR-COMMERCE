$(document).ready(function () {

    $('.addToCart').click(function () {
        var product_id = $(this).attr('data-id');
        var quantity = $('.quantity_' + product_id).val();
        $.ajax({
            type: "POST",
            url: "./add-to-cart/",
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            data: {
                'product_id': product_id,
                'quantity': quantity
            },
            success: function (data) {
                $('#cart-content').html(data);
            }
        });
    });

    $(document).on('click', '.delete-cart-btn', function (event) {
        var product_id = $(this).attr('data-id');
        $.ajax({
            type: "POST",
            url: "./delete-from-cart/",
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            data: {
                'product_id': product_id
            },
            success: function (data) {
                if (data == '') {
                    var emptyView = `<tr>
                                        <td colspan="6">
                                            <div class="alert alert-warning">
                                               There is no products
                                            </div>
                                        </td>
                                    </tr>`;
                    $('#cart-content').html(emptyView);
                } else {
                    $('#cart-content').html(data);
                }
            }
        });
    });

    var quantity_changes = 1;
    var quantity_data_id = '';
    var check_changes = false;

    $(document).on('change', '.cart_quantity', function (event) {
        quantity_changes = $(this).val();
        quantity_data_id = $(this).attr('data-id');
        check_changes = true;
    });

    $(document).on('click', '.update-cart-btn', function (event) {
        var product_id = $(this).attr('data-id');
        var quantity = $('.cart_quantity_' + product_id).val();
        if (check_changes) {
            if (product_id == quantity_data_id && quantity != quantity_changes) {
                quantity = quantity_changes;
            }
        }
        $.ajax({
            type: "POST",
            url: "./update-cart/",
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            data: {
                'product_id': product_id,
                'quantity': quantity
            },
            success: function (data) {
                if (data == '') {
                    var emptyView = `<tr>
                                        <td colspan="6">
                                            <div class="alert alert-warning">
                                               There is no products
                                            </div>
                                        </td>
                                    </tr>`;
                    $('#cart-content').html(emptyView);
                } else {
                    $('#cart-content').html(data);
                }
            }
        });
        quantity_changes = 1;
        check_changes = false;
        quantity_data_id = '';
    });

})
;
