@include('layouts/header')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Chapter</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Chapter</li>
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
              <h3 class="card-title">Chapter</h3>
             
            </div>
            <!-- /.card-header -->
            <div class="card-body">
            <div class="col-md-6">
                <label for="exampleInputEmail1">Standard : </label>
                <select class="form-control" name="standard_id" id="standard_id" onchange="getsubject()">
                        <option value=" ">Select Option</option>
                        @foreach($Standard as $stdval)
                        <option value="{{$stdval->base_id}}">{{$stdval->name .'('.$stdval->board.','.$stdval->medium.','.$stdval->stream.')'}}</option>
                        @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="exampleInputEmail1">Subject : </label>
                <select class="form-control" name="subject" id="subject">
                        <option value=" ">Select Option</option>
                </select>
            </div>
            <br>
              <table class="table table-bordered">
                <thead>
                    <tr style="width: 200px" id="board">Board :</tr><br>
                    <tr style="width: 200px" id="medium">Medium :</tr><br>
                    <tr style="width: 200px" id="standard">Standard :</tr><br>
                    <tr style="width: 200px" id="stream">Stream :</tr><br>
                  <tr>
                    <th style="width: 10px"><Sr class="No">No</Sr></th>
                    <th style="width: 200px">Subject</th>
                    <th style="width: 500px">Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                 
               </tbody>
              </table>
            </div>

            <div class="d-flex justify-content-end">
            </div>
          </div>

        </div>
        <div class="col-md-12">
          <div class="card">
          <div class="modal fade" id="usereditModal" tabindex="-1" aria-labelledby="usereditModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="usereditModalLabel">Edit Stream </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
       
    </div>
  </div>
</div>
</div>
</div>  
        
</section>

</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    
    $(document).ready(function () {
        
        $('#standard_id').on('change', function () {
            var standard_id = $(this).val();
            axios.post('chapter/get-subject', {
                    standard_id: standard_id,
                })
                .then(function (response) {
                    console.log(response.subject);
                    var secondDropdown = document.getElementById('subject');
                        secondDropdown.innerHTML = ''; // Clear existing options

                        secondDropdown.appendChild(new Option('Select Subject', ''));

                        response.subject.forEach(function(subject) {
                            var option = new Option(subject.name, subject.id);
                            secondDropdown.appendChild(option);
                        });

                })
                .catch(function (error) {
                    console.error(error);
                });

            
        });
    });
    
    //add more

$(document).ready(function(){
  var maxFields = 10; // Maximum number of input fields
  var addButton = $('#addmore'); // Add button selector
  var container = $('#container'); // Container selector

  var x = 1; // Initial input field counter

  // Triggered on click of add button
  $(addButton).click(function(){
    // Check maximum number of input fields
    if(x < maxFields){ 
      x++; // Increment field counter
      // Add input field
      $(container).append('<input type="text" name="chap[]" class="form-control" placeholder="Enter Subject Name"/><a class="btn btn-success" id="delete"><i class="fas fa-trash"></i></a>');
    } else{
      alert('Maximum '+maxFields+' input fields allowed.'); // Alert when maximum is reached
    }
  });
});
</script>
@include('layouts/footer ')