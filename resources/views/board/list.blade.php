@include('layouts/header')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Board List</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Board List</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
  @include('alert')
  <!-- Main content -->

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Board List</h3>
              @canButton('add', 'Board')
              <a href="{{url('create/board-list')}}" class="btn btn-success" style="float: right;">Create Board </a>
              @endCanButton
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th style="width: 10px"><Sr class="No">No</Sr></th>
                    <th style="width: 200px">Name</th>
                    <th style="width: 200px">Institute name</th>
                    <th style="width: 200px">Icon</th>
                    <th style="width: 500px">Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @php $i=1 @endphp
                  @foreach($board_list as $value)
                  <tr>
                    <td>{{$i}}</td>
                    <td>{{$value->name}}</td>
                    <td>{{$value->institute_name}}</td>
                    <td><img src="{{asset($value->icon) }}" alt="Icon"></td>
                    <td>@if($value->status == 'active')
                            <input type="button" value="Active" class="btn btn-success">
                        @else
                        <input type="button" value="Inactive" class="btn btn-danger">

                        @endif</td>
                   
                    <td>
                      <div class="d-flex">
                      @canButton('edit', 'Board')
                      <input type="submit" class="btn btn-primary editButton" data-user-id="{{ $value->id }}" value="Edit">&nbsp;&nbsp;
                      @endCanButton
                      &nbsp;&nbsp;
                      @canButton('delete', 'Board')
                      <input type="submit" class="btn btn-danger deletebutton" data-user-id="{{ $value->id }}" value="Delete">
                      @endCanButton
                      </div>
                  </tr>
                  @php $i++ @endphp
                  @endforeach
               </tbody>
              </table>
            </div>

            <div class="d-flex justify-content-end">
              {!! $board_list->withQueryString()->links('pagination::bootstrap-5') !!}

            </div>
          </div>

        </div>
  </section>

</div>
<div class="modal fade" id="usereditModal" tabindex="-1" aria-labelledby="usereditModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="usereditModalLabel">Edit Board </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="post" action="{{ url('board/update') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="row">
                                    <div class="col-md-12">
                                            <label for="exampleInputEmail1">Select Institute : </label>
                                            <select class="form-control" name="institute_for_id" id="institute_for_id">
                                                 <option value=" ">Select Institute</option>
                                                 @foreach($institute_list as $value)
                                                 <option value="{{$value['id']}}">{{$value['name']}}</option>
                                                 @endforeach
                                            </select>
                                            @error('institute_for_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <input type="hidden" id="board_id" name="board_id">
                                            <label for="exampleInputEmail1">Name  : </label>
                                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name">
                                            @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-9">
                                            <label for="exampleInputEmail1">Icon  : </label>
                                            <input type="hidden" name="old_icon" id="old_icon">
                                            <input type="file" onchange="previewFile()" name="icon" class="form-control">
                                            @error('icon')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3">
                                             <img src="" id="icon"  alt="Icon" class="mt-4">
                                        </div>
                                       
                                        <div class="col-md-12">
                                            <label for="exampleInputEmail1">status : </label>
                                            <select class="form-control" name="status" id="status">
                                                 <option value=" ">Select Option</option>
                                                 <option value="active">Active</option>
                                                 <option value="inactive">Inactive</option>
                                            </select>
                                            @error('status')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" style="float: right;">Update</button>
                            </div>
                    </div>
                </div>
                </form>
      </div>

    </div>
  </div>
</div>
<script>
  document.querySelectorAll('.editButton').forEach(function(button) {
    button.addEventListener('click', function() {
      var board_id = this.getAttribute('data-user-id');

      axios.post('/board-list/edit', {
        board_id: board_id
        })
        .then(response => {
          
          var reponse_data = response.data.board_list;
          var iconSrc ='{{ asset('') }}' + reponse_data.icon;
          $('#board_id').val(reponse_data.id);
          $('#institute_for_id').val(reponse_data.institute_for_id);

          $('#name').val(reponse_data.name);
          $('#icon').attr('src', iconSrc);
          $('#status').val(reponse_data.status);
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

      var board_id = this.getAttribute('data-user-id');

      // Show SweetAlert confirmation
      Swal.fire({
        title: 'Are you sure want to delete?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          axios.post('/board/delete', {
            board_id: board_id
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
  
  
  function previewFile() {
  const preview = document.getElementById("icon");
  const fileInput = document.querySelector("input[type=file]");
  const file = fileInput.files[0];
  const reader = new FileReader();

  reader.addEventListener("load", () => {
    preview.src = reader.result;
  }, false);

  if (file) {
    reader.readAsDataURL(file);
  }
}
</script>
@include('layouts/footer ')