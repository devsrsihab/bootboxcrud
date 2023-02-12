
<form id="createStudentForm" action="{{ route('students.store') }}" method="post" autocomplete="off">

  @csrf
  @method('POST')

    <div class="mb-3">
      <label for="name" class="form-label">Name</label>
      <input type="text" class="form-control" id="name" name="name">
      <div class="nameError errors text-danger d-none"></div>
    </div>
    
    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="text" class="form-control" id="email" name="email">
      <div class="emailError errors text-danger d-none"></div>

    </div>

    <div class="mb-3">
      <label for="photo" class="form-label">Photo</label>
      <input type="file" class="form-control" id="photo" name="photo">
      <div class="photoError errors text-danger d-none"></div>

    </div>


    <div class="mb-4 form-check">
      <input type="checkbox" class="form-check-input" id="accepeted" name="accepeted">
      <label class="form-check-label" for="accepeted">Check me out</label>
      <div class="accepetedError errors text-danger d-none"></div>

    </div>

    {{-- buttons --}}
    <div class="buttons mt-4 text-end">
      <button type="button" class="btn me-3  btn-danger bootbox-cancel">Cancle</button>
      {{-- bootbox-accept --}}
      <button type="submit" class="btn me-3  btn-success">Save</button>

    </div>
  </form>
