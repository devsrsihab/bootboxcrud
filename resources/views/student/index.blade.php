@extends('student.layouts.app')
@section('content')
<div class="container">
    <div class="row mt-5">
        <div class="col text-end">
            <a actionUrl="{{ route('students.store') }}" href="{{ route('students.create') }}" class="btn btn-primary"
                id="bootModal">Create Student</a>
        </div>
    </div>

    <div class="table_parent_div">
        <div class="row">
            <div class="table_content">
                <table class="table table-hover table-striped table-bordered ">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Photo</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
    
                        @forelse ($students as $key => $student )
                        <tr>
                            <th>{{ ++$key }}</th>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>
                                <img style="height:40px;" src="{{ asset('uploads/student_img/'.$student->photo) }}"
                                    alt="profile">
                            </td>
                            <td>
                                <a id="bootModal" class="btn btn-info" href="{{ route('students.show',$student->id) }}"><i class="fa-regular fa-eye"></i></a>
    
                                <a id="bootModal" actionUrl="{{ route('students.update',$student->id) }}"
                                    class="btn btn-success" href="{{ route('students.edit',$student->id) }}"><i class="fa-regular fa-pen-to-square"></i></a>
    
                                <form action="{{ route('students.destroy',$student->id) }}" class="d-inline deleteForm">
                                    @csrf
                                    @method('DELETE')
                                    <a class= "btn btn-danger" href=""><i class="fa-regular fa-trash-can"></i></a>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-danger">No Data</td>
                        </tr>
                        @endforelse
    
                    </tbody>
                </table>
    
                {{ $students->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function () {


        let dialog = '';
        let formId = '';
        let actionUrl = '';
        let msg = '';

        // modal show
        $(document).on('click', '#bootModal', function (e) {
            e.preventDefault();

            modalUrl = $(this).attr('href');
            actionUrl = $(this).attr('actionUrl');
            $.ajax({
                type: "GET",
                url: modalUrl,
                success: function (res) {
                    dialog = bootbox.dialog({
                        title: 'Create Student',
                        message: "<div id='studentContent'></div>",
                        size: 'large',

                    });
                    $('#studentContent').html(res);
                    formId = '#' + $('#studentContent').find('form').attr('id');

                }
            });

        });

        // $('#bootModal').click(function (e) { 
        //  e.preventDefault();

        // modalUrl = $(this).attr('href');
        // actionUrl = $(this).attr('actionUrl');
        // $.ajax({
        //     type: "GET",
        //     url: modalUrl,
        //     success: function (res) {
        //         dialog = bootbox.dialog({
        //         title: 'Create Student',
        //         message: "<div id='studentContent'></div>",
        //         size: 'large',

        //     });

        //     $('#studentContent').html(res);
        //     formId = '#'+$('#studentContent').find('form').attr('id');


        //     }
        // });
        // });


        // modal clicked end
        $(document).on('submit', formId, function (e) {
            e.preventDefault();

            let formData = new FormData($(formId)[0]);

            $.ajax({
                type: "POST",
                url: actionUrl,
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    console.log(res);

                    if (res.status === 400) {

                        $('.errors').html('');
                        $('.errors').removeClass('d-none');
                        $('.nameError').text(res.errors.name)
                        $('.emailError').text(res.errors.email)
                        $('.photoError').text(res.errors.photo)
                        $('.accepetedError').text(res.errors.accepeted)
                    } else {
                        dialog.modal('hide');
                        $('.errors').html('');
                        $('.errors').addClass('d-none');
                        formId === '#createStudentForm' ? msg = 'Created' : msg = 'Updated';
                        toastr.success('Student Successfully ' + msg + '!', 'Student ' +
                            msg + '');
                        $('.table_content').load(location.href + ' .table_content');

                    }

                }
            });

        });


        // delete
        $(document).on('click','.deleteForm', function (e) {
            e.preventDefault();

            let deleteUrl = $(this).attr('action');
            let csrf = $(this).find('input[name="_token"]').val();

            bootbox.confirm({
            message: 'This is a confirm with custom button text and color! Do you like it?',
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'No',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if (result) {
            

                    $.ajax({
                        type: "POST",
                        url: deleteUrl,
                        data: {'_token':csrf,'_method':'DELETE'},
                        success: function (res) {

                            if (res.status===200)
                            {

                            formId !== '#createStudentForm' ||  formId !== '#updateStudentForm' ? msg = 'Deleted' : msg = '';
                            toastr.success('Student Successfully ' + msg + '!', 'Student ' + msg + '');
                            $('.table_content').load(location.href + ' .table_content');

                            }
                            else
                            {
                                
                                toastr.error('Your Student Not Found', '404 Not Found!');

                            }
                            
                        }
                    });
                    
                }
            }
        });
            
        });


        
        // pagination
        $(document).on('click','.page-link', function (e) {
            e.preventDefault();

         let page = $(this).attr('href').split('page=')[1];
         
         $.ajax({
            type: "GET",
            url: "students/pagination?page="+page,
            success: function (res) {
                $('.table_parent_div').html(res);
                
            }
         });
            
        });


        // img preview
      $(document).on("change", "#photo", function (e) {
          e.preventDefault();

            const file = this.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function (event) {
                    $(".img_preview").attr("src", event.target.result);
                };
                reader.readAsDataURL(file);
            }
        });



    });

</script>
@endsection
