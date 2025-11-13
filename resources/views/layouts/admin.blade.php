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
    body {
      font-family: "Poppins", sans-serif;
      background-color: #f8f9fa;
      overflow-x: hidden;
      margin: 0;
    }

    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      width: 240px;
      height: 100vh;
      background: #007bff;
      color: #fff;
      display: flex;
      flex-direction: column;
      padding-top: 20px;
    }

    .sidebar h4 {
      text-align: center;
      color: #fff;
      margin-bottom: 30px;
    }

    .sidebar .nav-link {
      color: rgba(255, 255, 255, 0.9);
      padding: 10px 20px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .sidebar .nav-link.active,
    .sidebar .nav-link:hover {
      background: rgba(255, 255, 255, 0.15);
      border-radius: 6px;
    }

    .topbar {
      position: fixed;
      top: 0;
      left: 240px;
      right: 0;
      height: 60px;
      background: #fff;
      border-bottom: 1px solid #ddd;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0 20px;
      z-index: 1000;
    }

    .main-content {
      margin-left: 240px;
      margin-top: 60px;
      padding: 25px;
      min-height: calc(100vh - 60px);
      background-color: #f8f9fa;
    }

    @media(max-width:991px){
      .sidebar{ left:-250px; transition:.3s; }
      .sidebar.active{ left:0; }
      .topbar{ left:0; }
      .main-content{ margin-left:0; }
    }
  </style>
</head>
<body>

  <div class="sidebar" id="sidebar">
    <h4>Admin Panel</h4>
    <nav class="nav flex-column">

      <a href="{{ url('admin/dashboard') }}" class="nav-link">Dashboard</a>
      <a href="{{ url('admin/students') }}" class="nav-link">Students</a>
      <a href="{{ url('admin/results') }}" class="nav-link">Results</a>
      <a href="{{ url('admin/questions') }}" class="nav-link">Questions</a>

      <a href="{{ route('generate.test') }}" class="nav-link">
        Generate Test
      </a>

      <a href="{{ route('tests.all') }}" class="nav-link">
        All Tests
      </a>

      <a href="{{ url('admin/settings') }}" class="nav-link">Settings</a>

    </nav>
  </div>

  <div class="topbar">
    <button id="toggleSidebar" class="btn btn-outline-primary btn-sm d-lg-none">
      <i class="fa-solid fa-bars"></i>
    </button>
    <h6 class="mb-0">Dashboard</h6>
  </div>

  <div class="main-content" id="ajax-content">
    <div class="text-center py-5 text-muted">
      <h6>Select a page from sidebar</h6>
    </div>
  </div>


<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
$('#toggleSidebar').on('click', function() {
    $('#sidebar').toggleClass('active');
});
</script>

<script>

/* ⭐ UNIVERSAL AJAX PAGE LOADER (WORKS WITH ALL BUTTONS) */
function loadPage(url) {

    $('#ajax-content').html(`
      <div class="text-center py-5">
        <div class="spinner-border text-primary"></div>
        <p class="mt-2">Loading...</p>
      </div>
    `);

    $.ajax({
        url: url,
        method: 'GET',
        success: function (response) {
            
            $("#ajax-content").html(response);

            // ⭐ RUN ALL SCRIPTS LOADED VIA AJAX
            $("#ajax-content").find("script").each(function(){
                let js = $(this).text().trim();
                if(js !== ""){
                    eval(js);
                }
            });

        },
        error: function () {
            $('#ajax-content').html(`
              <div class="alert alert-danger m-4">
                ⚠️ Failed to load content.
              </div>
            `);
        }
    });
}


/* ⭐ HANDLE SIDEBAR NAV CLICKS */
$(document).on("click", ".sidebar .nav-link", function (e) {
    e.preventDefault();

    $('.sidebar .nav-link').removeClass('active');
    $(this).addClass('active');

    loadPage($(this).attr('href'));
});

</script>

<script>
$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
});
</script>

</body>
</html>
