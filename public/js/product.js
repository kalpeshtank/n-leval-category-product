$(document).ready(function () {
    var orderimgRenderer = function (data, type, full, meta) {
        return full.image_url ? '<img src="' + data + '" height="42" width="42">' : '';
    };
    var categoryRenderer = function (data, type, full, meta) {
        return full.category_data ? full.category_data.name : '';
    };
    productTable = $('#product_data').DataTable({
        "processing": true,
        "serverSide": true,
//        "scrollX": true,
        ajax: {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST',
            url: APP_URL + '/product-data'
        },
        columns: [
            {data: 'name', name: 'name'},
            {"className": '', data: 'category_id',
                "render": categoryRenderer
            },
            {data: 'descriptions', name: 'descriptions'},
            {data: 'price', name: 'price'},
            {"className": '', data: 'image_url',
                "render": orderimgRenderer
            },
            {data: 'action', name: "action"},
        ]
    });
});

$(document).on('click', '.delete-product', function (e) {
    var idData = $(this).attr('data-id');
    e.preventDefault();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: APP_URL + '/product/' + idData,
        method: 'DELETE',
        success: function (result) {
            if (result.status = "success") {
                productTable.ajax.reload();
            }
        }
    });
});