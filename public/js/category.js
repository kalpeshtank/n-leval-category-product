$(document).ready(function () {
    var perentRenderer = function (data, type, full, meta) {
        return full.parent_category ? full.parent_category.name : '';
    };
    categoryTable = $('#category_data').DataTable({
        "processing": true,
        "serverSide": true,
        ajax: {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST',
            url: APP_URL + '/category-data'
        },
        columns: [
            {data: 'name', name: 'name'},
            {"className": '', data: 'perent_id',
                "render": perentRenderer
            },
            {data: 'status', name: 'status'},
            {data: 'action', name: "action"},
        ]
    });
});

$(document).on('click', '.delete-category', function (e) {
    var idData = $(this).attr('data-id');
    e.preventDefault();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: APP_URL + '/category/' + idData,
        method: 'DELETE',
        success: function (result) {
            if (result.status = "success") {
                categoryTable.ajax.reload();
            }
        }
    });
});