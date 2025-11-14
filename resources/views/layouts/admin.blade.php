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
/* -----------------------------------------
   ⭐ AJAX PAGE LOADER (Reusable)
----------------------------------------- */
function loadPage(url) {

    $("#ajax-content").html(`
      <div class="text-center py-5">
        <div class="spinner-border text-primary"></div>
        <p>Loading...</p>
      </div>
    `);

    $.get(url, function(response){

        $("#ajax-content").html(response);

        // ⭐ Execute inline scripts from loaded HTML
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


/* -----------------------------------------
   ⭐ Sidebar Navigation Click
----------------------------------------- */
$(document).on("click", ".sidebar .nav-link", function(e){
    e.preventDefault();

    $(".sidebar .nav-link").removeClass("active");
    $(this).addClass("active");

    loadPage($(this).attr("href"));
});


/* -----------------------------------------
   ⭐ Mobile sidebar toggle
----------------------------------------- */
$("#toggleSidebar").on("click", function(){
    $("#sidebar").toggleClass("active");
});


/* -----------------------------------------
   ⭐ CSRF Setup for POST/DELETE
----------------------------------------- */
$.ajaxSetup({
    headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") }
});
</script>



<!-- ========================================================= -->
<!-- ⭐⭐ ALL TESTS — Button Click HANDLERS ⭐⭐ -->
<!-- ========================================================= -->

<script>

/* ---------------------------------------
   VIEW Test
--------------------------------------- */
$(document).on("click", ".btn-view", function () {
    let id = $(this).data("id");
    loadPage("/admin/test/view/" + id);
});


/* ---------------------------------------
   ASSIGN Test
--------------------------------------- */
$(document).on("click", ".btn-assign", function () {
    let id = $(this).data("id");

    $.get("/admin/test/assign-modal/" + id, function (modalHtml) {
        $("body").append(modalHtml);
        $("#assignTestModal").modal("show");
    });
});


/* ---------------------------------------
   DELETE Test
--------------------------------------- */
$(document).on("click", ".btn-delete", function () {

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

</body>
</html>
