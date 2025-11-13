<div class="card shadow-sm p-4">
    <h4 class="mb-3">Generate Test (Multiple Categories)</h4>

    <form id="createTestForm">
        @csrf

        <div class="mb-3">
            <label class="form-label">Test Title</label>
            <input type="text" name="title" class="form-control" required placeholder="Enter Test Title">
        </div>

        <hr>
        <h5>Choose Categories & No. of Questions</h5>

        <div id="category-wrapper">

            <!-- DEFAULT ROW -->
            <div class="row mb-2 category-row">

                <div class="col-md-6">
                    <label class="form-label">Select Category</label>
                    <select class="form-select" name="categories[]" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}">{{ $c->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">No. of Questions</label>
                    <input type="number" class="form-control" name="counts[]" min="1" required>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-remove">X</button>
                </div>

            </div>

        </div>

        <button type="button" id="add-category" class="btn btn-secondary mt-2">
            + Add Category
        </button>

        <hr>

        <button type="submit" class="btn btn-primary mt-3" id="submitTestBtn">
            Create Test
        </button>

    </form>
</div>

<script>
// ⭐ Add another category row dynamically
$(document).on("click", "#add-category", function () {

    let row = `
    <div class="row mb-2 category-row">

        <div class="col-md-6">
            <select class="form-select" name="categories[]" required>
                <option value="">Select Category</option>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}">{{ $c->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <input type="number" class="form-control" name="counts[]" min="1" required>
        </div>

        <div class="col-md-2 d-flex align-items-end">
            <button type="button" class="btn btn-danger btn-remove">X</button>
        </div>

    </div>
    `;

    $("#category-wrapper").append(row);
});

// ⭐ Remove category row
$(document).on("click", ".btn-remove", function () {
    $(this).closest('.category-row').remove();
});

// ⭐ Submit Test
$("#createTestForm").on("submit", function(e){
    e.preventDefault();

    $("#submitTestBtn").prop("disabled", true).text("Saving...");

    $.ajax({
        url: "{{ route('test.create') }}",
        type: "POST",
        data: $(this).serialize(),
        success: function(res){
            $("#submitTestBtn").prop("disabled", false).text("Create Test");

            if(res.success){
                alert("✔ Test Created Successfully!");
            } else {
                alert("⚠ " + res.msg);
            }
        },
        error: function(err){
            $("#submitTestBtn").prop("disabled", false).text("Create Test");
            alert("Server Error!");
        }
    });

});
</script>
