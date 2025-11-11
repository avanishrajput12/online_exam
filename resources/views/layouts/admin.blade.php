<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Admin Dashboard')</title>

  <!-- Bootstrap + Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <style>
    body {
      font-family: "Poppins", sans-serif;
      background-color: #f8f9fa;
      overflow-x: hidden;
      margin: 0;
    }

    /* Sidebar */
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

    /* Header */
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

    /* Main content */
    .main-content {
      margin-left: 240px;
      margin-top: 60px;
      padding: 25px;
      min-height: calc(100vh - 60px);
      background-color: #f8f9fa;
    }

    .user-info {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .user-avatar {
      width: 36px;
      height: 36px;
      background: #007bff;
      color: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 600;
    }

    @media(max-width:991px){
      .sidebar{
        left:-250px;
        transition:.3s;
      }
      .sidebar.active{
        left:0;
      }
      .topbar{
        left:0;
      }
      .main-content{
        margin-left:0;
      }
    }
  </style>
</head>
<body>

  <div class="sidebar" id="sidebar">
    <h4>Admin Panel</h4>
    <nav class="nav flex-column">
      <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
        <i class="fa-solid fa-chart-line"></i> Dashboard
      </a>
      <a href="{{ route('students') }}" class="nav-link {{ request()->is('students') ? 'active' : '' }}">
        <i class="fa-solid fa-users"></i> Students
      </a>
      <a href="{{ route('results') }}" class="nav-link {{ request()->is('results') ? 'active' : '' }}">
        <i class="fa-solid fa-trophy"></i> Results
      </a>
      <a href="{{ route('questions') }}" class="nav-link {{ request()->is('questions') ? 'active' : '' }}">
        <i class="fa-solid fa-question"></i> Questions
      </a>
      <a href="{{ route('settings') }}" class="nav-link {{ request()->is('settings') ? 'active' : '' }}">
        <i class="fa-solid fa-gear"></i> Settings
      </a>
    </nav>
  </div>

  
  <div class="topbar">
    <button id="toggleSidebar" class="btn btn-outline-primary btn-sm d-lg-none">
      <i class="fa-solid fa-bars"></i>
    </button>
    <h6 class="mb-0">@yield('page_title', 'Dashboard')</h6>
    <div class="user-info">
      <span>Avanish Rajput</span>
      <div class="user-avatar">A</div>
    </div>
  </div>


<div class="main-content" id="ajax-content">
  <div class="text-center py-5 text-muted">
    <div class="spinner-border text-primary" style="display:none" id="loading-spinner"></div>
    <h6 class="mt-3">Select a page from sidebar</h6>
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
$(document).ready(function() {


  $('.sidebar .nav-link').on('click', function(e) {
    e.preventDefault();
    const url = $(this).attr('href');  


    $('.sidebar .nav-link').removeClass('active');
    $(this).addClass('active');


    $('#loading-spinner').show();
    $('#ajax-content').html('<div class="text-center py-5 text-muted"><div class="spinner-border text-primary"></div><p class="mt-2">Loading...</p></div>');


    $.ajax({
      url: url,
      method: 'GET',
      success: function(response) {
        $('#ajax-content').html(response);
      },
      error: function() {
        $('#ajax-content').html('<div class="alert alert-danger m-4">⚠️ Failed to load content.</div>');
      }
    });
  });

});
</script>

</body>
</html>
