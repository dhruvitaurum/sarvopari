@include('layouts/header')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Institute Admin</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Institute Admin</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
  <div class="row">
    <div class="col-md-8 offset-md-2">
      @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
      @endif
    </div>
  </div>

  <script>
    window.setTimeout(function() {
      $(".alert-success").slideUp(500, function() {
        $(this).remove();
      });
    }, 3000);
  </script>
  <!-- Main content -->

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Institute Admin List</h3>
              <a href="{{url('student/create')}}" class="btn btn-success" style="float: right;">Create Student</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th style="width: 10px"><Sr class="No"></Sr></th>
                    <th style="width: 400px">Name</th>
                    <th style="width: 400px">Email</th>
                    <th style="width: 400px">Mobile</th>
                    <th style="width: 400px">Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @php $i=1 @endphp
                  @foreach($student as $value)
                  <tr>
                    <td>{{$i}}</td>
                    <td>{{$value->name}}</td>
                    <td>{{$value->email}}</td>
                    <td>{{$value->mobile}}</td>
                    <td>{{$value->status}}</td>
                    <td>
                      <div class="d-flex">
                      <input type="submit" class="btn btn-primary editButton" data-student-id="{{ $value->id }}" value="Edit">&nbsp;&nbsp;
                      &nbsp;&nbsp;
                      <input type="submit" class="btn btn-danger deletebutton" data-student-id="{{ $value->id }}" value="Delete">
                      </div>
                  </tr>
                  @php $i++ @endphp
                  @endforeach
               </tbody>
              </table>
            </div>

            <div class="d-flex justify-content-end">
              {!! $student->withQueryString()->links('pagination::bootstrap-5') !!}

            </div>
          </div>

        </div>
  </section>

</div>
<div class="modal fade" id="usereditModal" tabindex="-1" aria-labelledby="usereditModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="usereditModalLabel">Student </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{ url('student/update') }}">
          @csrf
          <div class="card-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="exampleInputEmail1">Name  : </label>
                                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name">
                                            @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label for="exampleInputEmail1">Mobile  : </label>
                                            <input type="tel" name="mobile" id="mobile" class="form-control" placeholder="Enter Mobile No.">
                                            @error('mobile')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label for="exampleInputEmail1">EmailID  : </label>
                                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email ID">
                                            @error('email')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label for="exampleInputEmail1">Address  : </label>
                                            <textarea name="address" id="address" class="form-control" placeholder="Address"></textarea>
                                            @error('address')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label for="exampleInputEmail1">DOB  : </label>
                                            <input type="date" name="dob" id="dob" class="form-control" placeholder="Date Of Birth">
                                            @error('dob')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <label for="exampleInputEmail1">Image  : </label>
                                            <input type="file" name="image"  class="form-control" placeholder="Image">
                                            <img id="image">
                                            @error('image')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label for="exampleInputEmail1">Institute For  : </label>
                                            <select name="institute_for_id" id="institute_for_id">
                                                @foreach($institute_for as $stage)
                                                    <option value="{{ $stage->id }}">{{ $stage->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('institute_for_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label for="exampleInputEmail1">Board  : </label>
                                            <select name="board_id" id="board_id">
                                                @foreach($board as $instituteboard)
                                                    <option value="{{ $instituteboard->id }}">{{ $instituteboard->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('board_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label for="exampleInputEmail1">Medium : </label>
                                            <select name="medium_id" id="medium_id">
                                                @foreach($medium as $institutemedium)
                                                    <option value="{{ $institutemedium->id }}">{{ $institutemedium->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('medium_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label for="exampleInputEmail1">Student Class  : </label>
                                            <select name="class_id" id="class_id">
                                                @foreach($class as $instituteclass)
                                                    <option value="{{ $instituteclass->id }}">{{ $instituteclass->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('class_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label for="exampleInputEmail1">Stream  : </label>
                                            <select name="stream_id" id="stream_id">
                                                @foreach($stream as $institutestream)
                                                    <option value="{{ $institutestream->id }}">{{ $institutestream->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('stream_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label for="exampleInputEmail1">Subject  : </label>
                                            <select name="subject_id" id="subject_id">
                                                @foreach($subject as $institutesubject)
                                                    <option value="{{ $institutesubject->id }}">{{ $institutesubject->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('subject_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                       
                                        <div class="col-md-3">
                                            <label for="exampleInputEmail1">status : </label>
                                            <select class="form-control" name="status" id="status">
                                                 <option value=" ">Select Option</option>
                                                 <option value="1">Active</option>
                                                 <option value="0">Inactive</option>
                                            </select>
                                            @error('status')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>

                                </div>
                            </div>
          <hr>
          <div class="">
            <button type="submit" class="btn btn-info" style="float:right">Update</button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>
<script>
  document.querySelectorAll('.editButton').forEach(function(button) {
    button.addEventListener('click', function() {
      var student_id = this.getAttribute('data-student-id');

      axios.post('/student/edit', {
        student_id: student_id
        })
        .then(response => {
          var reponse_student = response.data.studentDT;
          var reponse_studentdetail = response.data.studentsdetailsDT;
          
          $('#student_id').val(reponse_student.id);
          $('#name').val(reponse_student.name);
          $('#email').val(reponse_student.email);
          $('#mobile').val(reponse_student.mobile);
          $('#address').val(reponse_student.address);
          $('#dob').val(reponse_student.dob);
          $('#image').attr('src', reponse_student.image);
          $('#status').val(reponse_student.status);
          $('#institute_for_id').val(reponse_student.institute_for_id);
          $('#board_id').val(reponse_student.board_id);
          $('#medium_id').val(reponse_student.medium_id);
          $('#class_id').val(reponse_student.class_id);
          $('#stream_id').val(reponse_student.stream_id);
          $('#subject_id').val(reponse_student.subject_id);
          $('#usereditModal').modal('show');
        })
        .catch(error => {
          console.error(error);
        });
    });
  });
  document.querySelectorAll('.deletebutton').forEach(function(button) {
    button.addEventListener('click', function(event) {
      event.preventDefault(); // Prevent the default form submission

      var user_id = this.getAttribute('data-student-id');

      // Show SweetAlert confirmation
      Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          axios.post('/student/delete', {
            user_id: user_id
            })
            .then(response => {
              location.reload(true);

            })
            .catch(error => {
              console.error(error);
            });
        }
      });
    });
  });
  
  
</script>
@include('layouts/footer ')