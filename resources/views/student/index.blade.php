@extends('student.layouts.app')
@section('content')
<div class="container">
    <div class="row mt-5" style="height:100vh">
        <div class="col text-end">
            <a href="{{ route('students.create') }}" class="btn btn-primary" id="bootModal">Create Student</a>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function () {
        

        // modal clicked start
        let dialog='';

        $('#bootModal').click(function (e) { 
        e.preventDefault();

        modalUrl = $(this).attr('href');

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



            }
        });
        });
        // modal clicked end


        $(document).on('submit','#createStudentForm', function (e) {
            e.preventDefault();

            let formUrl = $(this).attr('action');
            let formData = new FormData($('#createStudentForm')[0]);

            $.ajax({
                type: "POST",
                url: formUrl,
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    console.log(res);

                    if (res.status===400) {
                    
                    $('.errors').html('');    
                    $('.errors').removeClass('d-none');    
                    $('.nameError').text(res.errors.name)
                    $('.emailError').text(res.errors.email)
                    $('.photoError').text(res.errors.photo)
                    $('.accepetedError').text(res.errors.accepeted)
                    }
                    else
                    {
                    dialog.modal('hide');
                    $('.errors').html('');    
                    $('.errors').addClass('d-none');  
                    toastr.success('Student Created Successfully!', 'Student Created')

                    }
    
                }
            });
            
        });




    });
</script>
@endsection