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
        
        $('#bootModal').click(function (e) { 
        e.preventDefault();

        let modalUrl = $(this).attr('href');
        $.ajax({
            type: "GET",
            url: modalUrl,
            dataType: "html",
            success: function (res) {
                let dialog = bootbox.dialog({
                title: 'Create Student',
                message: "<div id='studentContent'></div>",
                size: 'large',
                buttons: {
                    cancel: {
                        label: "Cancle",
                        className: 'btn-danger',
                        callback: function(){
                            
                        }
                    },
                    ok: {
                        label: "Save",
                        className: 'btn-info',
                        callback: function() {
                            
                        }
                    }
                }
            });

            $('#studentContent').html(res);



            }
        });






        });
    });
</script>
@endsection