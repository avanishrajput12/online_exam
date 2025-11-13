<div class="card shadow-sm p-4">
    <h4 class="mb-3">All Generated Tests</h4>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Total Questions</th>
                <th>Created At</th>
                <th>Test ID</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach($tests as $t)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $t->title }}</td>
                <td>{{ $t->questions_count }}</td>
                <td>{{ $t->created_at->format('d M, Y') }}</td>
                <td><b>{{ $t->id }}</b></td>

                <td>
    <!-- View -->
    <button class="btn btn-primary btn-sm btn-view" data-id="{{ $t->id }}">
        View
    </button>

    <!-- Assign -->
    <button class="btn btn-success btn-sm btn-assign" data-id="{{ $t->id }}">
        Assign to User
    </button>

    <!-- Delete -->
    <button class="btn btn-danger btn-sm btn-delete" data-id="{{ $t->id }}">
        Delete
    </button>
</td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>
