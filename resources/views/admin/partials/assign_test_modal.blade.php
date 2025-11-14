<div class="modal fade" id="assignTestModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Assign Test: {{ $test->title }}</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="assign_test_id" value="{{ $test->id }}">

                <label>Select User</label>
                <select id="assign_student_id" class="form-control">
                    @foreach($users as $u)
                        <option value="{{ $u->id }}">{{ $u->email }}</option>
                    @endforeach
                </select>
            </div>

            <div class="modal-footer">
                <button class="btn btn-success btn-assign-submit">Assign</button>
            </div>

        </div>
    </div>
</div>

<script>
$(document).off("click", ".btn-assign-submit").on("click", ".btn-assign-submit", function () {

    let test_id = $("#assign_test_id").val();
    let student_id = $("#assign_student_id").val();

    $.ajax({
        url: "/admin/test/assign",
        type: "POST",
        data: {
            test_id: test_id,
            student_id: student_id
        },
        success: function (res) {
            alert("Assigned Successfully!");
            $("#assignTestModal").modal("hide");
            loadPage("/admin/tests");
        },
        error: function () {
            alert("Error assigning test!");
        }
    });
});
</script>
