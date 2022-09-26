@extends('layouts.app')
@section('content')
<!-- Add Studente Modal -->
<div class="modal fade" id="AddStudenteModal" tabindex="-1" aria-labelledby="studentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="studentModalLabel">Add Stduent</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul id="save_msgList"></ul>
                <div class="form-group mb-3">
                    <label for="">Studnet Name</label>
                    <input type="text" class="name form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="">Studnet Email</label>
                    <input type="text" class="email form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="">Studnet Phone</label>
                    <input type="text" class="phone form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="">Studnet Course</label>
                    <input type="text" class="course form-control">
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary add_student">Save</button>
            </div>
        </div>
    </div>
</div>
<!-- End of Add Studente Modal -->

<!-- Edit Studente Modal -->
<div class="modal fade" id="EditStudentModal" tabindex="-1" aria-labelledby="studentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="studentModalLabel">Edit Stduent</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul id="update_msgList"></ul>
                <input type="hidden" id="edit_stud_id">
                <div class="form-group mb-3">
                    <label for="">Studnet Name</label>
                    <input type="text" id="edit_name" class="name form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="">Studnet Email</label>
                    <input type="text" id="edit_email" class="email form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="">Studnet Phone</label>
                    <input type="text" id="edit_phone" class="phone form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="">Studnet Course</label>
                    <input type="text" id="edit_course" class="course form-control">
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary update_student">Update</button>
            </div>
        </div>
    </div>
</div>
<!-- End of Edit Studente Modal -->

<!-- Delete Studente Modal -->
<div class="modal fade" id="DeleteStudentModal" tabindex="-1" aria-labelledby="studentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="studentModalLabel">Delete Stduent</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="delete_stud_id" >
                <h4>Are you sure want to delete student data?</h4>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary delete_student_btn">Yes, Delete</button>
            </div>
        </div>
    </div>
</div>
<!-- End of Delete Studente Modal -->

<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <div id="success_message"></div>
            <div class="card">
                <div class="card-header">
                    <h4>Studnets Data
                        <a href="#" data-bs-toggle="modal" data-bs-target="#AddStudenteModal" class="btn btn-primary float-end btn-sm">Add Student</a>
                    </h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Course</th>
                            <th>Edit</th>
                            <th>Delete</th>
                          </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Fetch: students data and show them in table
    $(document).ready(function () {
        fetchstudent();
        function fetchstudent() {
            $.ajax({
                type: "GET",
                url: "fetch-students",
                dataType: "json",
                success: function (response) {
                    // console.log(response.students);
                    $('tbody').html("");
                    $.each(response.students, function (key, item) { 
                        $('tbody').append(
                            '<tr>\
                                <th>'+item.id+'</td>\
                                <td>'+item.name+'</td>\
                                <td>'+item.email+'</td>\
                                <td>'+item.phone+'</td>\
                                <td>'+item.course+'</td>\
                                <td><button type="button" value="'+item.id+'" class="edit_student btn btn-primary btn-sm">Edit</button></td>\
                                <td><button type="button" value="'+item.id+'" class="delete_student btn btn-danger btn-sm">Delete</button></td>\
                            </tr>' 
                        );
                    });
                }
            });
        }

        // Add a new student
        $(document).on('click', '.add_student', function (e) {
            e.preventDefault(); //Not Lload the Page
            $(this).text('Sending..');
            var data = {
                'name': $('.name').val(),
                'email': $('.email').val(),
                'phone': $('.phone').val(),
                'course': $('.course').val(),
            }

            //console.log(data);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "/students",
                data: data,
                dataType: "json",
                success: function (response) {
                    if (response.status == 400) {
                        $('#save_msgList').html("");
                        $('#save_msgList').addClass('alert alert-danger');
                        $.each(response.errors, function (key, err_value) {
                            $('#save_msgList').append('<li>' + err_value + '</li>');
                        });
                        $('.add_student').text('Save');
                    }else{
                        $('#save_msgList').html("");
                        $('#success_message').addClass('alert alert-success')
                        $('#success_message').text(response.message)
                        $('#AddStudentModal').find('input').val('');
                        $('.add_student').text('Save');
                        $('#AddStudentModal').modal('hide'); 
                        fetchstudent();
                    }
                }
            });
        });

        // Edit: student info
        $(document).on('click', '.edit_student',function (e) {
            e.preventDefault();

            var stud_id = $(this).val();
            // console.log(stud_id);
            $('#EditStudentModal').modal('show');
            $.ajax({
                type: "GET",
                url: "/edit-student/" + stud_id,
                success: function (response) {
                    console.log(response);
                    if(response.status == 404){
                        $('#success_message').html("");
                        $('#success_message').addClass('alert alert-danger');
                        $('#success_message').text(response.message);
                        $('#EditStudentModal').modal('hide'); 
                    } else {
                        $('#edit_name').val(response.student.name);
                        $('#edit_email').val(response.student.email);
                        $('#edit_phone').val(response.student.phone);
                        $('#edit_course').val(response.student.course);
                        $('#edit_stud_id').val(stud_id);
                    }
                }
            });
            $('.btn-close').find('input').val('');
        });

        $(document).on('click', '.update_student',function (e) {
            e.preventDefault();
            $(this).text('Updating..');
            var stud_id = $('#edit_stud_id').val();
            var data = {
                'name' : $('#edit_name').val(),
                'email' : $('#edit_email').val(),
                'phone' : $('#edit_phone').val(),
                'course' : $('#edit_course').val(),
            }

            // To support put method
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "PUT",
                url: "update-student/"+stud_id,
                data: data,
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    if(response.status == 400){
                        $('#update_msgList').html("");
                        $('#update_msgList').addClass('alert alert-danger');
                        $.each(response.errors, function (key, err_value) {
                            $('#update_msgList').append('<li>' + err_value +
                                '</li>');
                        });
                        $('.update_student').text('Update');
                    }else if(response.status == 404){
                        $('#update_msgList').html("");
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('.update_student').text('Update');
                    }else{
                        $('#update_msgList').html("");
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('#EditStudentModal').find('input').val('');
                        $('.update_student').text('Update');
                        $('#EditStudentModal').modal('hide');
                        fetchstudent();
                    }
                }
            });
        });

        $(document).on('click', '.delete_student',function (e) {
            // e.preventDefault();
            var stud_id = $(this).val();
            // alert(stud_id);
            $('#delete_stud_id').val(stud_id);
            $('#DeleteStudentModal').modal('show');
        });

        $(document).on('click', '.delete_student_btn', function (e) {
            e.preventDefault();
            $(this).text('Deleting..');
            var stud_id = $('#delete_stud_id').val();

             // To support put method
             $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "DELETE",
                url: "/delete-student/" + stud_id,
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    if (response.status == 404) {
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('.delete_student_btn').text('Yes Delete');
                    } else {
                        $('#success_message').html("");
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('.delete_student_btn').text('Yes Delete');
                        $('#DeleteStudentModal').modal('hide');
                        fetchstudent();
                    }
                }
            });
        });
    });  
</script>
@endsection