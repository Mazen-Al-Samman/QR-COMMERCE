$(document).ready(function() {

    $('.addToCart').click(function() {
        var product_id = $(this).attr('data-id');
        var quantity = $('.quantity_' + product_id).val();
        $.ajax({
            type: "POST",

            url: "add-to-cart",

            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            data: {
                'product_id': product_id,
                'quantity': quantity
            },
            success: function(data) {
                $('#cart-content').html(data);
            }
        });
    });

    $(document).on('click', '.delete-cart-btn', function(event) {
        var product_id = $(this).attr('data-id');
        $.ajax({
            type: "POST",
            url: "delete-from-cart",
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            data: {
                'product_id': product_id
            },
            success: function(data) {
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

    $(document).on('change', '.cart_quantity', function(event) {
        quantity_changes = $(this).val();
        quantity_data_id = $(this).attr('data-id');
        check_changes = true;
    });

    $(document).on('click', '.update-cart-btn', function(event) {
        var product_id = $(this).attr('data-id');
        var quantity = $('.cart_quantity_' + product_id).val();
        if (check_changes) {
            if (product_id == quantity_data_id && quantity != quantity_changes) {
                quantity = quantity_changes;
            }
        }
        $.ajax({
            type: "POST",
            url: "update-cart",
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            data: {
                'product_id': product_id,
                'quantity': quantity
            },
            success: function(data) {
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

    $(document).on('click', '#check-btn', function(event) {
        var phone = $("#phone").val();
        $.ajax({
            type: "POST",
            url: "/phoneCheck",
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            data: {
                'phone': phone
            },
            success: function(data) {
                if (data['status']) {
                    $("#generate").removeClass('disabled');
                    $('#not-found').html('');
                    $("#exampleModal").modal('hide');
                    $("#hidden-phone").val(phone);
                } else {
                    $("#generate").addClass('disabled');
                    $('#not-found').html(data['message']['phone']);
                }
            }
        });
    });


    $(document).on('change','#changeStatusField', function(){
        var value = $(this).val();
        var type = $(this).data('type');
        var id = $(this).data('id');
        $.ajax({
            type: "POST",
            url: "ajax/updateStatusField",
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            data: {
                'value': value,
                'type': type,
                'id': id
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Request successfully',
                    showConfirmButton: false,
                    timer: 1000
                })
            }
        });
    })

    $(document).on('click','.published_status,.verify-user', function() {
        var id = $(this).data('id');
        var type = $(this).data('type');
        $.ajax({
            type: "GET",
            url: "ajax/updateFlagField",
            data: {
                'id': id,
                'type': type
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Request successfully',
                    showConfirmButton: false,
                    timer: 1000
                })
            }
        });
    })

    $(document).on('click', '.resubscribe-vendor', function () {
        var id = $(this).data('id');
        $.ajax({
            type: "GET",
            url: "ajax/resubscribeVendor",
            data: {
                'id': id,
            },
            success: function(response) {
                if(response.status != 200) {
                    Swal.fire({
                        icon: 'error',
                        title: 'SomeThing Wrong',
                        showConfirmButton: false,
                        timer: 1500
                    })

                }else {
                    $(".resubscribe-vendor").parent().find("[data-id='" + id + "']").hide();
                    Swal.fire({
                        icon: 'success',
                        title: 'Request successfully',
                        showConfirmButton: false,
                        timer: 1000
                    })
                }
            }
        });
    })

});
