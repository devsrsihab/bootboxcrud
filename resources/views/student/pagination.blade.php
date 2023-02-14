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