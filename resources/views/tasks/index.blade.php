<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery and jQuery UI -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Styling for Drag-and-Drop -->
    <style>
        #task-list {
            list-style-type: none;
            padding-left: 0;
        }

        #task-list li {
            padding: 10px;
            margin: 5px 0;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            cursor: move;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h1 class="display-4 text-primary">Task Manager</h1>
                <p class="text-muted">Organize and manage your tasks efficiently</p>
            </div>
        </div>

        <!-- Add Task Form -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Add New Task</h5>
                <a href="{{ route('projects.index') }}" class="btn btn-light">Manage Projects</a>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('tasks.store') }}" class="row g-3">
                    @csrf
                    <div class="col-md-6">
                        <input type="text" name="name" class="form-control" placeholder="Task name" required>
                    </div>
                    <div class="col-md-4">
                        <select name="project_id" class="form-select" required>
                            <option value="" disabled selected>Select Project</option>
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success w-100">Add Task</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Task List -->
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Your Tasks</h5>
            </div>
            <div class="card-body">
                @if ($tasks->count() > 0)
                    <ul id="task-list" class="list-group">
                        @foreach ($tasks as $task)
                            <li class="list-group-item d-flex justify-content-between align-items-center"
                                data-id="{{ $task->id }}">
                                <div>
                                    <strong>{{ $task->name }}</strong>
                                    <span class="badge bg-secondary ms-2">Priority: {{ $task->priority }}</span>
                                    <span class="badge bg-info ms-2">Project: {{ $task->project->name }}</span>
                                </div>
                                <div>
                                    <!-- Edit Button -->
                                    <button class="btn btn-warning btn-sm edit-task" data-id="{{ $task->id }}"
                                        data-name="{{ $task->name }}" data-project-id="{{ $task->project_id }}"
                                        data-bs-toggle="modal" data-bs-target="#editTaskModal">
                                        Edit
                                    </button>

                                    <!-- Delete Form -->
                                    <form method="POST" action="{{ route('tasks.destroy', $task) }}"
                                        style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">No tasks available. Add some tasks to get started!</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Edit Task Modal -->
    <div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="editTaskModalLabel">Edit Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editTaskForm" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="task-name" class="form-label">Task Name</label>
                            <input type="text" name="name" id="task-name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="project-id" class="form-label">Project</label>
                            <select name="project_id" id="project-id" class="form-select" required>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning">Update Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript for Edit Modal and Drag-and-Drop -->
    <script>
        $(document).ready(function() {
            // Trigger Edit Modal with Task Data
            $('.edit-task').on('click', function() {
                let taskId = $(this).data('id');
                let taskName = $(this).data('name');
                let projectId = $(this).data('project-id');

                // Populate Modal Fields
                $('#task-name').val(taskName);
                $('#project-id').val(projectId);

                // Set Form Action URL dynamically
                let updateUrl = "{{ url('tasks') }}/" + taskId;
                $('#editTaskForm').attr('action', updateUrl);
            });

            // Enable Drag-and-Drop Reordering
            $("#task-list").sortable({
                update: function() {
                    let order = [];
                    $("#task-list li").each(function(index, element) {
                        order.push($(element).data('id'));
                    });

                    $.ajax({
                        url: "{{ route('tasks.reorder') }}",
                        method: "POST",
                        data: {
                            order: order,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log('Order updated', response);
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>
