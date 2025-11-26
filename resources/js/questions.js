// VIEW QUESTIONS
$(document).on('click', '.btn-view-questions', function(){
    let id = $(this).data('id');

    $.get("/admin/questions/list/" + id, function(res){
        $("#ajax-content").html(res);
    });
});


// OPEN ADD
$(document).on('click', '#openAddModal', function(){
    $("#categoryForm")[0].reset();
    $("#category_id").val("");
    $("#categoryModalTitle").text("Add Category");
    new bootstrap.Modal(document.getElementById('categoryModal')).show();
});


// EDIT CATEGORY
$(document).on('click', '.btn-edit', function(){
    let id = $(this).data('id');

    $.get("/admin/category/" + id, function(res){
        $("#categoryModalTitle").text("Edit Category");
        $("#category_id").val(res.data.id);
        $("#category_title").val(res.data.title);

        new bootstrap.Modal(document.getElementById('categoryModal')).show();
    });
});


// SAVE CATEGORY
$(document).on('submit', '#categoryForm', function(e){
    e.preventDefault();

    let id = $("#category_id").val();
    let url = id ? "/admin/category/update/" + id : "/admin/category/store";

    $.post(url, $(this).serialize(), function(res){
        if(res.success){
            location.reload();
        }
    });
});


// DELETE OPEN
$(document).on('click', '.btn-delete', function(){
    $("#delete_cat_id").val($(this).data('id'));
    new bootstrap.Modal(document.getElementById('deleteConfirmModal')).show();
});

// DELETE CONFIRM
$(document).on('click', '#confirmDeleteBtn', function(){
    let id = $("#delete_cat_id").val();

    $.ajax({
        url: "/admin/category/delete/" + id,
        method: "POST",
        data: {
            _method: "DELETE",
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(res){
            if(res.success){
                location.reload();
            }
        }
    });
});





