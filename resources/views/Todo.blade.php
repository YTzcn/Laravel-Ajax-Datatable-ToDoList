<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap 5 To-Do List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            padding-top: 50px;
        }

        .todo-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .todo-item.completed .todo-text {
            text-decoration: line-through;
            color: #aaa;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="text-center mb-4">To-Do List</h2>
            <div class="card">
                <div class="card-body">
                    <form id="todoForm" class="mb-3">
                        <div class="input-group">
                            <input type="text" id="newTodo" class="form-control" name="Title" placeholder="Title"
                                   required>
                            <input type="text" id="newTodo" class="form-control" name="Content" placeholder="Content"
                                   required>
                            <input type="text" id="newTodo" class="form-control" name="Status" placeholder="Status"
                                   required>
                            <a id="addTask" class="btn btn-primary">Add</a>
                        </div>
                    </form>
                    <table class="table table-bordered" id="datatable">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Başlık</th>
                            <th>içerik</th>
                            <th>Durum</th>
                            <th>Oluşturma</th>
                            <th>Güncelleme</th>
                            <th>Güncelle</th>
                            <th>Sil</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Güncelle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- İçerik AJAX ile yüklenecek -->
                    <form id="updateForm">
                        <div class="mb-3">
                            <label for="Title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="Title" name="Title">
                            <input hidden type="text" class="form-control" id="id" name="id">
                        </div>
                        <div class="mb-3">
                            <label for="Content" class="form-label">Content</label>
                            <input type="text" class="form-control" id="Content" name="Content">
                        </div>
                        <div class="mb-3">
                            <label for="Status" class="form-label">Status</label>
                            <input type="text" class="form-control" id="Status" name="Status">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveChanges">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    getData()

    function getData() {
        $(document).ready(function () {
            $('#datatable').DataTable({
                processing: true,
                scrollX: true,
                pageLength: 5,
                lengthMenu: [5, 10, 20],
                serverSide: true,
                ajax: "{{ route('list') }}",
                columns: [
                    {data: 'id', name: 'Id'},
                    {data: 'Title', name: 'Başlık'},
                    {data: 'Content', name: 'içerik'},
                    {data: 'Status', name: 'Durum'},
                    {data: 'created_at', name: 'Oluşturma'},
                    {data: 'updated_at', name: 'Güncelleme'},
                    {data: 'Güncelle', name: 'Güncelle'},
                    {data: 'Sil', name: 'Sil'}
                ]
            })
        });
    }
    function guncelle(id) {
        var url = "{{ route('get', ':id') }}".replace(':id', id);
        $.ajax({
            url: url, // Laravel route to get data
            type: 'GET',
            success: function (response) {
                // Modal içeriğini doldur
                $('#Title').val(response.Title);
                $('#id').val(response.id);
                $('#Content').val(response.Content);
                $('#Status').val(response.Status);

                // Modal'ı göster
                $('#updateModal').modal('show');
            },
            error: function () {
                alert('Error loading data.');
            }
        });
    };
    function reloadTable(){
        $('#datatable').DataTable().ajax.reload();
    }
</script>
<script>
    function sil(id) {
        var url = "{{ route('delete', ':id') }}".replace(':id', id);
        $.ajax({
            url: url, // Laravel route to get data
            type: 'GET',
            success: function () {
                reloadTable()
            },
            error: function () {
                alert('Error loading data.');
            }
        });
    }

    $('#addTask').click(function (){
        const formInputs = $('#todoForm').find('input');
        let formData = {};
        for (let input of formInputs) {
            formData[input.name] = input.value;
            input.value ='';
        }
        $.ajax({
            url:'http://127.0.0.1:8000/add',
            type:'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:formData,
            success:function (){
                reloadTable();
            },
            error:function (data){alert('sıkıntı var aga'+data);},
        })

    })


    $('#saveChanges').click(function(){
            const formInputs = $('#updateForm').find('input');
            let formData = {};
            for (let input of formInputs) {
                formData[input.name] = input.value;
            }
        $.ajax({
            url:'http://127.0.0.1:8000/update',
            type:'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:formData,
            success:function (){
                $('#updateModal').modal('hide');
                reloadTable();
            },
            error:function (data){alert('sıkıntı var aga'+data);},
        })
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
