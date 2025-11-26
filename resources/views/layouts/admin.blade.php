<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Admin Dashboard')</title>

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <style>
    body { font-family: Poppins; background:#f8f9fa; margin:0; }
    .sidebar { position:fixed; left:0; top:0; width:240px; height:100vh; background:#007bff; color:#fff; padding-top:20px; }
    .sidebar .nav-link{ color:white; padding:10px 20px; }
    .sidebar .nav-link:hover, .sidebar .nav-link.active{ background:rgba(255,255,255,.2); }
    .topbar { position:fixed; left:240px; right:0; top:0; height:60px; background:white; border-bottom:1px solid #ddd; padding:14px 20px; }
    .main-content { margin-left:240px; margin-top:60px; padding:25px; }
  </style>

</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <h4 class="text-center text-white mb-4">Admin Panel</h4>

    <nav class="nav flex-column">
      <a href="{{ url('admin/dashboard') }}" class="nav-link">Dashboard</a>
      <a href="{{ url('admin/students') }}" class="nav-link">Students</a>
      <a href="{{ url('admin/results') }}" class="nav-link">Results</a>
      <a href="{{ url('admin/questions') }}" class="nav-link">Questions</a>
      <a href="{{ route('generate.test') }}" class="nav-link">Generate Test</a>
      <a href="{{ route('tests.all') }}" class="nav-link">All Tests</a>
      <a href="{{ url('admin/settings') }}" class="nav-link">Settings</a>
    </nav>
  </div>

  <!-- Topbar -->
  <div class="topbar">
    <button id="toggleSidebar" class="btn btn-outline-primary btn-sm d-lg-none">
      <i class="fa fa-bars"></i>
    </button>
    <b>Admin Panel</b>
  </div>

  <!-- AJAX Loaded Content -->
  <div class="main-content" id="ajax-content">
      <div class="text-center py-5 text-muted">Select a page from sidebar</div>
  </div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<script>
function loadPage(url) {

    $("#ajax-content").html(`
      <div class="text-center py-5">
        <div class="spinner-border text-primary"></div>
        <p>Loading...</p>
      </div>
    `);

    $.get(url, function(response){

        $("#ajax-content").html(response);

        $("#ajax-content").find("script").each(function(){
            let code = $(this).text();
            if(code.trim() !== ""){
                eval(code);
            }
        });

    }).fail(function(){
        $("#ajax-content").html(`
          <div class="alert alert-danger m-4">
            Failed to load page.
          </div>
        `);
    });
}

$(document).on("click", ".sidebar .nav-link", function(e){
    e.preventDefault();

    $(".sidebar .nav-link").removeClass("active");
    $(this).addClass("active");

    loadPage($(this).attr("href"));
});

$("#toggleSidebar").on("click", function(){
    $("#sidebar").toggleClass("active");
});

$.ajaxSetup({
    headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") }
});
</script>

<!-- Delete Test (Only Tests) -->
<script>
$(document).on("click", ".btn-test-delete", function () {

    if (!confirm("Are you sure?")) return;

    let id = $(this).data("id");

    $.ajax({
        url: "/admin/test/delete/" + id,
        method: "DELETE",
        success: function () {
            alert("Deleted Successfully");
            loadPage("/admin/tests");
        }
    });
});
</script>


<!-- ⭐ MOVE CATEGORY MODALS HERE -->
<!-- ADD / EDIT CATEGORY MODAL -->
<div class="modal fade" id="categoryModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <form id="categoryForm">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="categoryModalTitle">Add Category</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="category_id" id="category_id">
          <div class="mb-3">
            <label class="form-label">Category Title</label>
            <input type="text" name="title" id="category_title" class="form-control" required>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>

      </form>

    </div>
  </div>
</div>

<!-- DELETE CATEGORY CONFIRM -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body">
        <p>Are you sure?</p>
        <input type="hidden" id="delete_cat_id">
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-danger btn-sm" id="confirmDeleteBtn">Delete</button>
      </div>
    </div>
  </div>
</div>

<!-- ⭐ QUESTIONS JS -->
<script src="/js/questions.js"></script>

</body>
</html>
