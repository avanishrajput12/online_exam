<div class="card shadow-sm p-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5>Student List</h5>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">
      <i class="fa-solid fa-user-plus me-1"></i> Add New Student
    </button>
  </div>

  <table class="table table-striped table-hover" id="studentTable">
    <thead class="table-primary">
      <tr>
        <th>#</th>
        <th>Name</th>
        <th>Email</th>
        <th>Joined</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody id="studentBody">
@foreach($data as $val)
      <tr>
        <td>{{ $val->id }}</td>
        <td>{{ $val->fname }}</td>
        <td>{{ $val->email }}</td>
        <td>{{ $val->created_at }}</td>
        <td>
          <button class="btn btn-sm btn-info text-white"><i class="fa-solid fa-pen"></i></button>
          <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
        </td>
      </tr>
 @endforeach     
    </tbody>
  </table>
</div>



<div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addStudentModalLabel">Add New Student</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="addStudentForm">
          @csrf
          <div class="mb-3">
            <label for="studentEmail" class="form-label">Student Email</label>
            <input type="email" id="studentEmail" name="email" class="form-control" placeholder="Enter student email" required>
          </div>
          <button type="submit" class="btn btn-primary w-100">Add Student</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
  $('#addStudentForm').on('submit', function(e) {
    e.preventDefault();

    const email = $('#studentEmail').val().trim();
    if (email === '') {
      alert('Please enter email');
      return;
    }

    $.ajax({
      url: '{{ route('addstu') }}',
      method: 'POST',
      data: {
        email: email,
        _token: '{{ csrf_token() }}'
      },
      success: function(response) {
        alert("Data Added Successfully");
        window.location.reload();
        $('#addStudentModal').modal('hide');
        $('#addStudentForm')[0].reset();
      },
      error: function() {
        alert('❌ Failed to add student.');
      }
    });
  });
});
</script>

