@include('layouts/header')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Admin</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Admin</li>
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
              <h3 class="card-title">Role List</h3>
              <a href="{{url('create/admin')}}" class="btn btn-success" style="float: right;">Create Admin</a>
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
                  @foreach($institute as $value)
                  <tr>
                    <td>{{$i}}</td>
                    <td>{{$value->institute_name}}</td>
                    <td>{{$value->email}}</td>
                    <td>{{$value->contact_no}}</td>
                    <td>{{$value->status}}</td>
                    <td>
                      <div class="d-flex">
                      <input type="submit" class="btn btn-primary editButton" data-role-id="{{ $value->id }}" value="Edit">&nbsp;&nbsp;
                      &nbsp;&nbsp;
                      <input type="submit" class="btn btn-danger deletebutton" data-role-id="{{ $value->id }}" value="Delete">
                      </div>
                  </tr>
                  @php $i++ @endphp
                  @endforeach
               </tbody>
              </table>
            </div>

            <div class="d-flex justify-content-end">
              {!! $users->withQueryString()->links('pagination::bootstrap-5') !!}

            </div>
          </div>

        </div>
  </section>

</div>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Role </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{ url('roles/update') }}">
          @csrf
          <div class="card-body">
            <div class="form-group">
              <label for="exampleInputEmail1">Edit Role : </label>
              <input type="hidden" id="role_id" name="id">
              <input type="text" name="role_name" class="form-control" id="role_name" placeholder="Edit role">
            </div>
          </div>
          <hr>
          <div class="">
            <button type="submit" class="btn btn-primary" style="float:right">Update</button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>
<script>
  document.querySelectorAll('.editButton').forEach(function(button) {
    button.addEventListener('click', function() {
      var roleId = this.getAttribute('data-role-id');

      axios.post('/roles/edit', {
          roleId: roleId
        })
        .then(response => {
          var reponse_data = response.data.roles;
          $('#role_id').val(reponse_data.id);
          $('#role_name').val(reponse_data.role_name);
          $('#exampleModal').modal('show');
        })
        .catch(error => {
          console.error(error);
        });
    });
  });
  document.querySelectorAll('.deletebutton').forEach(function(button) {
    button.addEventListener('click', function(event) {
      event.preventDefault(); // Prevent the default form submission

      var roleId = this.getAttribute('data-role-id');

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
          axios.post('/roles/delete', {
              roleId: roleId
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