<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task Manager</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
</head>

<body class="container py-4">

<h4>Task Manager</h4>
<hr>

{{-- ADD TASK --}}
<form id="taskForm" class="d-flex mb-3">
    @csrf

    <select id="project" class="form-select me-2">
        @foreach ($projects as $project)
            <option value="{{ $project->id }}">{{ $project->name }}</option>
        @endforeach
    </select>

    <input type="text" name="name" class="form-control me-2" placeholder="Task name" required>
    <button class="btn btn-primary">Add</button>
</form>

{{-- TASK LIST --}}
<table class="table table-bordered">
    <thead>
        <tr>
            <th width="10%">#</th>
            <th>Task</th>
            <th width="25%">Actions</th>
        </tr>
    </thead>
    <tbody id="tasks"></tbody>
</table>

{{-- EDIT MODAL --}}
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Task</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="editTaskId">

                <input type="text"
                       id="editTaskName"
                       class="form-control"
                       placeholder="Task name">
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" id="updateTask">Update</button>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    let project = $('#project').val();

    function loadTasks() {
        $.get('/tasks?project_id=' + project, function (tasks) {

            let html = '';

            tasks.forEach(task => {
                html += `
                    <tr data-id="${task.id}">
                        <td>${task.priority}</td>
                        <td class="task-name">${task.name}</td>
                        <td>
                            <button class="btn btn-sm btn-warning edit">Edit</button>
                            <button class="btn btn-sm btn-danger delete">Delete</button>
                        </td>
                    </tr>
                `;
            });

            $('#tasks').html(html);
        });
    }

    loadTasks();

    {{-- CHANGE PROJECT --}}
    $('#project').change(function () {
        project = $(this).val();
        loadTasks();
    });

    {{-- ADD TASK --}}
    $('#taskForm').submit(function (e) {
        e.preventDefault();

        $.post('/tasks', {
            _token: '{{ csrf_token() }}',
            name: $('[name=name]').val(),
            project_id: project
        }, function () {
            $('[name=name]').val('');
            loadTasks();
        });
    });

    {{-- DELETE TASK --}}
    $(document).on('click', '.delete', function () {
        let id = $(this).closest('tr').data('id');

        $.ajax({
            url: '/tasks/' + id,
            type: 'DELETE',
            data: { _token: '{{ csrf_token() }}' },
            success: loadTasks
        });
    });

    {{-- OPEN EDIT MODAL --}}
    $(document).on('click', '.edit', function () {
        let row = $(this).closest('tr');

        $('#editTaskId').val(row.data('id'));
        $('#editTaskName').val(row.find('.task-name').text());

        new bootstrap.Modal('#editModal').show();
    });

    {{-- UPDATE TASK --}}
    $('#updateTask').click(function () {
        let id = $('#editTaskId').val();
        let name = $('#editTaskName').val();

        $.ajax({
            url: '/tasks/' + id,
            type: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                name: name
            },
            success: function () {
                bootstrap.Modal.getInstance(
                    document.getElementById('editModal')
                ).hide();

                loadTasks();
            }
        });
    });

    {{-- SORTABLE --}}
    new Sortable(document.getElementById('tasks'), {
        animation: 150,
        onEnd: function () {
            let order = [];

            $('#tasks tr').each(function () {
                order.push($(this).data('id'));
            });

            $.post('/tasks/reorder', {
                _token: '{{ csrf_token() }}',
                order: order
            });
        }
    });
</script>

</body>
</html>
