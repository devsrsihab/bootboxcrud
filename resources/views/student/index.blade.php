@extends('student.layouts.app')
@section('content')
<div class="container">
    <div class="row mt-5">
        <div class="col text-end">
            <a actionUrl="{{ route('students.store') }}" href="{{ route('students.create') }}" class="btn btn-primary"
                id="bootModal">Create Student</a>
        </div>
    </div>

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
                            <a class="btn btn-info" href=""><i class="fa-regular fa-eye"></i></a>

                            <a id="bootModal" actionUrl="{{ route('students.update',$student->id) }}"
                                class="btn btn-success" href="{{ route('students.edit',$student->id) }}"><i
                                    class="fa-regular fa-pen-to-square"></i></a>

                            <a class="btn btn-danger" href=""><i class="fa-regular fa-trash-can"></i></a>
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




    });

</script>
@endsection
