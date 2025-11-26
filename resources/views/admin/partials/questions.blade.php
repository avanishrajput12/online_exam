<div class="card shadow-sm p-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5>Question Bank</h5>

    <button class="btn btn-primary" id="openAddModal">
      <i class="fa-solid fa-circle-plus me-1"></i> Add Category
    </button>
  </div>

  <table class="table table-striped table-hover">
    <thead class="table-primary">
      <tr>
        <th>#</th>
        <th>Category</th>
        <th>Actions</th>
      </tr>
    </thead>

    <tbody id="categoryTableBody">
      @foreach($data as $val)
      <tr data-id="{{ $val->id }}">
        <td>{{ $val->id }}</td>
        <td class="cat-title">{{ $val->title }}</td>
        <td>
          <button class="btn btn-sm btn-outline-secondary btn-edit" data-id="{{ $val->id }}">Edit</button>
          <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $val->id }}">Delete</button>
          <button class="btn btn-sm btn-success btn-view-questions" data-id="{{ $val->id }}">
            <i class="fa-solid fa-circle-question"></i> Questions
          </button>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
