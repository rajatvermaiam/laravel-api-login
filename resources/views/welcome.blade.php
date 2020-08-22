<!DOCTYPE html>

<html lang="en">
<head>

    <title>Laravel DataTables Todo CRUD Example Tutorial </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ url('/') }}">

    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">

    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container mt-4">
    <h2 class="text-center mt-2 mb-3 alert alert-success">Laravel DataTables Todo CRUD Example Tutorial</h2>
    <a class="text-center btn btn-success mb-1">Create Todo</a>
    <table class="table table-striped" id="laravel-datatable-crud">
        <thead>
        <tr>
            <th>S. no</th>
            <th>Message</th>
            <th>Created at</th>
            <th>From</th>
            <th>Action</th>
        </tr>
        </thead>
    </table>
</div>


<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    baseUrl = $('meta[name="base-url"]').attr('content');

    $(document).ready(function () {
        $('#laravel-datatable-crud').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: baseUrl,
                type: 'GET',
            },
            columns: [
                {data: 'DT_RowIndex', name: 'id'},
                {data: 'message', name: 'message'},
                {data: 'created_at', name: 'created_at'},
                {data: 'user.name', name: 'from'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    });


    function deleteItem(id) {
        if (confirm("Are You sure want to delete !")) {
            $.ajax({
                type: "delete",
                url: baseUrl + '/delete-todo/' + id,
                success: function (data) {
                    var oTable = $('#laravel-datatable-crud').dataTable();
                    oTable.fnDraw(false);
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        }
    }
</script>
</body>
</html>
