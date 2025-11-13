<div class="card shadow-sm p-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5>Questions for: <b>{{ $category->title }}</b></h5>

    <button class="btn btn-primary" id="openQuestionModal">
      <i class="fa fa-plus"></i> Add Question
    </button>
  </div>

  <table class="table table-bordered table-hover">
    <thead class="table-primary">
      <tr>
        <th>#</th>
        <th>Question</th>
        <th>Correct</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody id="questionTable">
      @foreach($questions as $q)
      <tr data-id="{{ $q->id }}">
        <td>{{ $q->id }}</td>
        <td>{{ $q->question }}</td>
        <td>{{ strtoupper($q->correct) }}</td>
        <td>
          <button class="btn btn-sm btn-outline-secondary btn-edit-question">Edit</button>
          <button class="btn btn-sm btn-danger btn-delete-question">Delete</button>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>


<div class="modal fade" id="questionModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="questionForm">
        @csrf

        <input type="hidden" id="q_id">
        <input type="hidden" id="q_category_id" value="{{ $category->id }}">

        <div class="modal-header">
          <h5 class="modal-title" id="questionModalTitle">Add Question</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">

          <div class="mb-2">
            <label>Question</label>
            <textarea class="form-control" id="q_question" required></textarea>
          </div>

          <div class="mb-2">
            <label>Option A</label>
            <input type="text" class="form-control" id="q_a" required>
          </div>

          <div class="mb-2">
            <label>Option B</label>
            <input type="text" class="form-control" id="q_b" required>
          </div>

          <div class="mb-2">
            <label>Option C</label>
            <input type="text" class="form-control" id="q_c" required>
          </div>

          <div class="mb-2">
            <label>Option D</label>
            <input type="text" class="form-control" id="q_d" required>
          </div>

          <div class="mb-2">
            <label>Correct Option</label>
            <select class="form-control" id="q_correct" required>
              <option value="a">Option A</option>
              <option value="b">Option B</option>
              <option value="c">Option C</option>
              <option value="d">Option D</option>
            </select>
          </div>

        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="saveQuestion">Save</button>
        </div>

      </form>
    </div>
  </div>
</div>


<script>


$(document).on("click", "#openQuestionModal", function () {
    $("#questionForm")[0].reset();
    $("#q_id").val("");
    $("#questionModalTitle").text("Add Question");

    new bootstrap.Modal(document.getElementById("questionModal")).show();
});

// SAVE QUESTION
$(document).on("submit", "#questionForm", function (e) {
    e.preventDefault();

    let id = $("#q_id").val();
    let url = id
        ? `/admin/questions/update/${id}`
        : `/admin/questions/store`;

    $.ajax({
        method: "POST",
        url: url,
        data: {
            _token: $("meta[name=csrf-token]").attr("content"),
            category_id: $("#q_category_id").val(),
            question: $("#q_question").val(),

            // MAPPING YOUR COLUMN NAMES
            op_1: $("#q_a").val(),
            op_2: $("#q_b").val(),
            op_3: $("#q_c").val(),
            op_4: $("#q_d").val(),
            correct: $("#q_correct").val(),
        },
        success: function (res) {
            if (!res.data) {
                alert("Server error");
                return;
            }

            if (id) {
                // UPDATE ROW
                let row = $(`#questionTable tr[data-id="${id}"]`);
                row.find("td:nth-child(2)").text(res.data.question);
                row.find("td:nth-child(3)").text(res.data.correct.toUpperCase());
            } else {
                // ADD ROW
                $("#questionTable").prepend(`
                    <tr data-id="${res.data.id}">
                        <td>${res.data.id}</td>
                        <td>${res.data.question}</td>
                        <td>${res.data.correct.toUpperCase()}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-secondary btn-edit-question">Edit</button>
                            <button class="btn btn-sm btn-danger btn-delete-question">Delete</button>
                        </td>
                    </tr>
                `);
            }

            bootstrap.Modal.getInstance(document.getElementById("questionModal")).hide();
        },
    });
});

// EDIT QUESTION
$(document).on("click", ".btn-edit-question", function () {
    let id = $(this).closest("tr").data("id");

    $.get(`/admin/questions/get/${id}`, function (res) {
        $("#q_id").val(res.data.id);
        $("#q_question").val(res.data.question);

        // MAPPING
        $("#q_a").val(res.data.op_1);
        $("#q_b").val(res.data.op_2);
        $("#q_c").val(res.data.op_3);
        $("#q_d").val(res.data.op_4);
        $("#q_correct").val(res.data.correct);

        $("#questionModalTitle").text("Edit Question");
        new bootstrap.Modal(document.getElementById("questionModal")).show();
    });
});

// DELETE QUESTION
$(document).on("click", ".btn-delete-question", function () {
    let id = $(this).closest("tr").data("id");

    if (!confirm("Are you sure?")) return;

    $.ajax({
        url: `/admin/questions/delete/${id}`,
        type: "DELETE",
        data: { _token: $("meta[name=csrf-token]").attr("content") },
        success: function () {
            $(`#questionTable tr[data-id="${id}"]`).remove();
        },
    });
});

</script>
