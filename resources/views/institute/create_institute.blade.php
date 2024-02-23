@include('layouts/header')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Institute</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Institute</li>
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
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Create Institute</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="post" action="{{ url('institute/register') }}">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="exampleInputEmail1">Name of Institute : </label>
                                            <input type="text" name="institute_name" class="form-control" id="exampleInputEmail1" placeholder="Enter Name of Institute">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="exampleInputEmail1">Email address : </label>
                                            <input type="email" name="email" class="form-control" placeholder="Email address">
                                        </div>

                                        <div class="col-md-4">
                                            <label for="exampleInputEmail1">Contact No : </label>
                                            <input type="text" name="contact_no" class="form-control" placeholder="Contact_no">
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="exampleInputEmail1">Address : </label>
                                            <textarea name="address" class="form-control" placeholder="Address"></textarea>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="exampleInputEmail1">Institute : </label>
                                            @foreach($institute_for as $value)
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="school{{$value['id']}}" value="institute_for[]">
                                                <label for="school{{$value['id']}}" class="custom-control-label">{{$value['name']}}</label>
                                            </div>
                                            @endforeach

                                            <div id="otherTextboxinstitute" style="display: none;">
                                                <label for="otherText">Institute Name:</label>
                                                <input type="text" id="otherText" placeholder="other_institute_for" name="otherText" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="exampleInputEmail1">Board : </label>
                                            @foreach($board_list as $value)
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="board{{$value['id']}}" name="board[]">
                                                <label for="board{{$value['id']}}" class="custom-control-label">{{$value['name']}}</label>
                                            </div>
                                            @endforeach

                                            <div id="otherTextboxboard" style="display: none;">
                                                <label for="otherText">Board Name:</label>
                                                <input type="text" id="otherText" placeholder="Board name" name="boardother" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="exampleInputEmail1">Medium: </label>
                                            @foreach($medium_list as $value)
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="medium{{$value['id']}}" name="medium[]">
                                                <label for="medium{{$value['id']}}" class="custom-control-label">{{$value['name']}}</label>
                                            </div>
                                            @endforeach

                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label>Select Education Level:</label><br>
                                                    @foreach($class_list as $value)
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input classlist" name="classname[]" type="checkbox" id="prePrimaryCheckbox{{$value['id']}}" value="prePrimary" data-id="{{$value['id']}}">
                                                            <label for="prePrimaryCheckbox{{$value['id']}}" class="custom-control-label">{{$value['name']}}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <div class="row" id="prePrimaryContent">
                                                <div class="col-md-12">
                                                    <p>
                                                    <div class="custom-control custom-checkbox " id="standardCheckboxdiv">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" id="prePrimaryContent">
                                                <div class="col-md-12">
                                                    <p>
                                                    <div class="custom-control custom-checkbox " id="streamCheckboxdiv">
                                                    </div>
                                                </div>
                                            </div>

                                            
                                        </div>
                                    </div>

                                </div>
                            </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    </form>
                </div>

            </div>

        </div>

</div>
</section>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var schoolCheckbox = document.getElementById('school5'); // replace '5' with the actual ID

        schoolCheckbox.addEventListener('change', function() {
            var targetElement = document.getElementById('otherTextboxinstitute');

            if (this.checked) {
                targetElement.style.display = 'block';
            } else {
                targetElement.style.display = 'none';
            }
        });
        var schoolCheckbox1 = document.getElementById('board4'); // replace '5' with the actual ID

        schoolCheckbox1.addEventListener('change', function() {
            var targetElement = document.getElementById('otherTextboxboard');

            if (this.checked) {
                targetElement.style.display = 'block';
            } else {
                targetElement.style.display = 'none';
            }
        });
        var checkboxes = document.querySelectorAll('.classlist');

        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
               // var checkboxId = this.id;
                var classId = this.getAttribute('data-id');
                axios.post('/class/get_standard', {
                classId: classId
                })
                .then(response => {
                    var response_data = response.data.standard_list;

// Append the checkbox container to a parent element (e.g., a form or a div)
                    var checkboxContainer = $('#standardCheckboxdiv');

                    $.each(response_data, function(index, data) {
                       

                        var checkbox = $('<input>')
                            .attr('type', 'checkbox')
                            .attr('id', 'standardCheckbox' + data.id)
                            .attr('name', 'standardname[]')
                            .addClass('custom-control-input standardCheckbox')
                            .val(data.id);

                        // Create a label element for the checkbox
                        var label = $('<label>')
                            .attr('for', 'standardCheckbox' + data.id)
                            .addClass('custom-control-label')
                            .text(data.name);

                        // Create a div element to contain the checkbox and label
                        var checkboxWrapper = $('<div>')
                            .addClass('custom-control custom-checkbox')
                            .append(checkbox)
                            .append(label);

                        // Append the checkbox container to a parent element
                        checkboxContainer.append(checkboxWrapper);
                    });
                    var targetElement = document.getElementById('standardCheckboxdiv');
                    targetElement.style.display = 'block';
                   
                    document.getElementById('standardCheckboxdiv').addEventListener('change', function(event) {
                    var targetCheckbox = event.target;

                    if (targetCheckbox.classList.contains('standardCheckbox')) {
                        // Your logic here when a checkbox changes state
                        if (targetCheckbox.checked) {
                            // Code to execute when the checkbox is checked
                            standard_id = targetCheckbox.value;
                            axios.post('/class/get_stream', {
                                standard_id: standard_id
                                })
                                .then(response => {
                                var stream_response = response.data.stream_list;
                                var stream_response = response.data.subject_list;
                               
                                var checkboxContainer = $('#streamCheckboxdiv');

                                $.each(stream_response, function(index, data) {
                                    var checkbox = $('<input>')
                                        .attr('type', 'checkbox')
                                        .attr('id', 'streamCheckbox' + data.id)
                                        .attr('name', 'streamname[]')
                                        .addClass('custom-control-input streamCheckbox')
                                        .val(data.id);

                                    // Create a label element for the checkbox
                                    var label = $('<label>')
                                        .attr('for', 'streamCheckbox' + data.id)
                                        .addClass('custom-control-label')
                                        .text(data.name);

                                    // Create a div element to contain the checkbox and label
                                    var standardcheckbox = $('<div>')
                                        .addClass('custom-control custom-checkbox')
                                        .append(checkbox)
                                        .append(label);

                                    // Append the checkbox container to a parent element
                                    checkboxContainer.append(standardcheckbox);
                                });
                                var targetElement = document.getElementById('streamCheckboxdiv');
                                targetElement.style.display = 'block';
                            
                                })
                                .catch(error => {
                                console.error(error);
                                });     
                        } else {
                            $('#streamCheckboxdiv').empty();
                        }
                    }
                });
                                    
                })
                .catch(error => {
                console.error(error);
                });  
               }else {
                $('#standardCheckboxdiv').empty();

                }
            });

        });

    });
    
</script>
@include('layouts/footer')