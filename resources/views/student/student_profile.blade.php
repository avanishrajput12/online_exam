<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Update</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .profile-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ddd;
        }
    </style>
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow p-4">
        <h3 class="mb-3">Update Profile</h3>

        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                   @csrf

            <div class="text-center mb-3">
                <img src="default.png" class="profile-img" id="previewImg">
                <br>
                <label class="btn btn-primary mt-2">
                    Upload Profile Photo
                    <input type="file" class="d-none" name="profile_image" onchange="preview(event)">
                </label>
            </div>

            <div class="row">
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Full Name</label>
                  <input type="text" name="name" value="{{ $user->fname }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ $user->email }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Mobile Number</label>
                    <input type="text" name="mobile" class="form-control" placeholder="Enter mobile number" maxlength="10" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">10th Percentage</label>
                    <input type="number" step="0.1" name="tenth_percentage" class="form-control" placeholder="Ex: 84.5" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">12th Percentage</label>
                    <input type="number" step="0.1" name="twelfth_percentage" class="form-control" placeholder="Ex: 88.25" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Current Graduation CGPA</label>
                    <input type="number" step="0.01" name="cgpa" class="form-control" placeholder="Ex: 8.45" required>
                </div>

            </div>

            <button type="submit" class="btn btn-success mt-3 w-100">Update Profile</button>

        </form>
    </div>
</div>

<script>
    function preview(event) {
        let output = document.getElementById('previewImg');
        output.src = URL.createObjectURL(event.target.files[0]);
    }
</script>

</body>
</html>
