{{-- admin/partials/questions.blade.php --}}
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

    <tbody id="categoryTable">
      @foreach($data as $val)
      <tr data-id="{{ $val->id }}">
        <td class="cat-id">{{ $val->id }}</td>
        <td class="cat-title">{{ $val->title }}</td>
        <td>
          <button class="btn btn-sm btn-outline-secondary btn-edit">Edit</button>
          <button class="btn btn-sm btn-danger btn-delete">Delete</button>

          <!-- ⭐ NEW BUTTON: View & Add Questions -->
          <button class="btn btn-sm btn-success btn-view-questions" data-id="{{ $val->id }}">
            <i class="fa-solid fa-circle-question"></i> Questions
          </button>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
{{-- Add / Edit Modal --}}
<div class="modal fade" id="categoryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="categoryForm">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="categoryModalTitle">Add Category</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" id="category_id" name="category_id" value="">
          <div class="mb-3">
            <label class="form-label">Category Title</label>
            <input type="text" name="title" id="category_title" class="form-control" required>
            <div class="invalid-feedback" id="titleError"></div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="saveCategory" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Delete confirmation modal --}}
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body">
        <p class="mb-0">Are you sure you want to delete this category?</p>
        <input type="hidden" id="delete_cat_id" value="">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
        <button type="button" id="confirmDeleteBtn" class="btn btn-danger btn-sm">Delete</button>
      </div>
    </div>
  </div>
</div>

<script>
$(function(){


  $('#categoryTable').on('click', '.btn-view-questions', function(){
      let category_id = $(this).data('id');

      $.ajax({
        url: "/admin/questions/list/" + category_id,
        type: "GET",
        success: function(res){
            $('#ajax-content').html(res);
        },
        error: function(){
            alert("Unable to load questions page.");
        }
      });
  });

  
  $('#openAddModal').on('click', function(){
    $('#categoryModalTitle').text('Add Category');
    $('#categoryForm')[0].reset();
    $('#category_id').val('');
    $('#titleError').text('').hide();
    $('#category_title').removeClass('is-invalid');
    var modal = new bootstrap.Modal(document.getElementById('categoryModal'));
    modal.show();
  });

  $('#categoryForm').on('submit', function(e){
    e.preventDefault();

    let id = $('#category_id').val();
    let url = id ? "{{ url('admin/category/update') }}/" + id : "{{ route('category.store') }}";
    let data = $(this).serialize();

    $('#saveCategory').prop('disabled', true).text('Saving...');

    $.ajax({
      url: url,
      method: 'POST',
      data: data,
      success: function(res){
        $('#saveCategory').prop('disabled', false).text('Save');

        if(res.success && res.data){
          let cat = res.data;

          if(id){
            let row = $('#categoryTable').find('tr[data-id="'+cat.id+'"]');
            row.find('.cat-title').text(cat.title);
          } else {
            $('#categoryTable').prepend(`
              <tr data-id="${cat.id}">
                <td class="cat-id">${cat.id}</td>
                <td class="cat-title">${cat.title}</td>
                <td>
                    <button class="btn btn-sm btn-outline-secondary btn-edit">Edit</button>
                    <button class="btn btn-sm btn-danger btn-delete">Delete</button>
                    <button class="btn btn-sm btn-success btn-view-questions" data-id="${cat.id}">
                        <i class="fa-solid fa-circle-question"></i> Questions
                    </button>
                </td>
              </tr>
            `);
          }

          var modalEl = document.getElementById('categoryModal');
          var modal = bootstrap.Modal.getInstance(modalEl);
          modal.hide();

        } else {
          alert('Something went wrong.');
        }
      }
    });

  });
  $('#categoryTable').on('click', '.btn-edit', function(){
    let id = $(this).closest('tr').data('id');

    $.ajax({
      url: "{{ url('admin/category') }}/" + id,
      method: 'GET',
      success: function(res){
        if(res.success){
          $('#categoryModalTitle').text('Edit Category');
          $('#category_id').val(res.data.id);
          $('#category_title').val(res.data.title);
          var modal = new bootstrap.Modal(document.getElementById('categoryModal'));
          modal.show();
        }
      }
    });
  });

 
  $('#categoryTable').on('click', '.btn-delete', function(){
    let id = $(this).closest('tr').data('id');
    $('#delete_cat_id').val(id);

    var modal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
    modal.show();
  });

  $('#confirmDeleteBtn').on('click', function(){
    let id = $('#delete_cat_id').val();

    $.ajax({
      url: "{{ url('admin/category/delete') }}/" + id,
      method: 'DELETE',
      success: function(res){
        if(res.success){
          $('#categoryTable').find(`tr[data-id="${id}"]`).remove();

          var modalEl = document.getElementById('deleteConfirmModal');
          var modal = bootstrap.Modal.getInstance(modalEl);
          modal.hide();
        }
      }
    });
  });

});
</script>
