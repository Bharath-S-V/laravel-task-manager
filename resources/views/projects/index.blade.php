<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Management</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Project Management</h3>
            </div>

            <div class="card-body">
                <!-- Add New Project Form -->
                <form method="POST" action="{{ route('projects.store') }}" class="mb-4">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="name" class="form-control" placeholder="Enter Project Name"
                            required>
                        <button type="submit" class="btn btn-success">Add Project</button>
                    </div>
                </form>

                <hr>

                <!-- List of Projects -->
                <h4 class="mb-3">Project List</h4>
                @if ($projects->count() > 0)
                    <ul class="list-group">
                        @foreach ($projects as $project)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $project->name }}
                                <span class="badge bg-primary">Project ID: {{ $project->id }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">No projects added yet. Start by adding a new project above.</p>
                @endif
            </div>
        </div>

        <!-- Back to Task Management Button -->
        <div class="text-center mt-4">
            <a href="{{ url('/tasks') }}" class="btn btn-outline-primary">Back to Task Management</a>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
