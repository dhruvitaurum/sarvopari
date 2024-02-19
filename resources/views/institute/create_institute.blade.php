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
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Create Institute</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="post" action="{{ url('roles/save') }}">
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
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="school" value="institute_for[]">
                                                <label for="school" class="custom-control-label">School</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="Univercity" value="institute_for[]">
                                                <label for="Univercity" class="custom-control-label">Univercity</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="Pre school" value="institute_for[]">
                                                <label for="Pre school" class="custom-control-label">Pre school</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="Competitive exam" value="institute_for[]">
                                                <label for="Competitive exam" class="custom-control-label">Competitive exam</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="other_institute" value="institute_for[]">
                                                <label for="other_institute" class="custom-control-label">other</label>
                                            </div>
                                            <div id="otherTextboxinstitute" style="display: none;">
                                                <label for="otherText">Institute Name:</label>
                                                <input type="text" id="otherText" placeholder="Institute_name" name="otherText" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="exampleInputEmail1">Board : </label>
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="State board" name="board[]">
                                                <label for="State board" class="custom-control-label">State board</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="CBSE" name="board[]">
                                                <label for="CBSE" class="custom-control-label">CBSE</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="ICSE" name="board[]">
                                                <label for="ICSE" class="custom-control-label">ICSE</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="Other_board" name="board[]">
                                                <label for="Other_board" class="custom-control-label">Other</label>
                                            </div>
                                            <div id="otherText_board" style="display: none;">
                                                <label for="otherText">Board Name:</label>
                                                <input type="text" id="otherText" placeholder="Board name" name="otherText" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="exampleInputEmail1">Medium: </label>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="Gujarati" name="language[]">
                                                    <label for="Gujarati" class="custom-control-label">Gujarati</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="English" name="language[]">
                                                    <label for="English" class="custom-control-label">English</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="Hindi" name="language[]">
                                                    <label for="Hindi" class="custom-control-label">Hindi</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                            <div class="row">
        <div class="col-md-12">
            <label>Select Education Level:</label><br>
            
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input educationCheckbox" type="checkbox" id="prePrimaryCheckbox" value="prePrimary">
                <label for="prePrimaryCheckbox" class="custom-control-label">Pre Primary</label>
            </div>

            <!-- Primary -->
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input educationCheckbox" type="checkbox" id="primaryCheckbox" value="primary">
                <label for="primaryCheckbox" class="custom-control-label">Primary</label>
            </div>

            <!-- Secondary -->
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input educationCheckbox" type="checkbox" id="secondaryCheckbox" value="secondary">
                <label for="secondaryCheckbox" class="custom-control-label">Secondary</label>
            </div>

            <!-- High Secondary -->
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input educationCheckbox" type="checkbox" id="highSecondaryCheckbox" value="highSecondary">
                <label for="highSecondaryCheckbox" class="custom-control-label">High Secondary</label>
            </div>
       </div>
    </div>

    <div class="row" id="prePrimaryContent" style="display: none;">
        <div class="col-md-12">
            <label>Select :</label>
            <!-- Content for Pre Primary -->
            <p>  <div class="custom-control custom-checkbox">
                <input class="custom-control-input educationCheckbox" type="checkbox" id="nurseryCheckbox" value="nursery">
                <label for="nurseryCheckbox" class="custom-control-label">Nursery</label>
            </div>

            <!-- Junior -->
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input educationCheckbox" type="checkbox" id="juniorCheckbox" value="junior">
                <label for="juniorCheckbox" class="custom-control-label">Junior</label>
            </div>

            <!-- Senior -->
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input educationCheckbox" type="checkbox" id="seniorCheckbox" value="senior">
                <label for="seniorCheckbox" class="custom-control-label">Senior</label>
            </div></p>
        </div>
    </div>

    <div class="row" id="primaryContent" style="display: none;">
        <div class="col-md-12">
            <p>  <div class="custom-control custom-checkbox">
                <input class="custom-control-input educationCheckbox" type="checkbox" id="grade1Checkbox" value="grade1">
                <label for="grade1Checkbox" class="custom-control-label">1 Standard</label>
            </div>

            <!-- Grade 2 -->
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input educationCheckbox" type="checkbox" id="grade2Checkbox" value="grade2">
                <label for="grade2Checkbox" class="custom-control-label">2 Standard</label>
            </div>

            <!-- Grade 3 -->
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input educationCheckbox" type="checkbox" id="grade3Checkbox" value="grade3">
                <label for="grade3Checkbox" class="custom-control-label">3 Standard</label>
            </div>

            <!-- Grade 4 -->
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input educationCheckbox" type="checkbox" id="grade4Checkbox" value="grade4">
                <label for="grade4Checkbox" class="custom-control-label">4 Standard</label>
            </div>

            <!-- Grade 5 -->
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input educationCheckbox" type="checkbox" id="grade5Checkbox" value="grade5">
                <label for="grade5Checkbox" class="custom-control-label">5 Standard</label>
            </div>

            <!-- Grade 6 -->
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input educationCheckbox" type="checkbox" id="grade6Checkbox" value="grade6">
                <label for="grade6Checkbox" class="custom-control-label">6 Standard</label>
            </div>

            <!-- Grade 7 -->
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input educationCheckbox" type="checkbox" id="grade7Checkbox" value="grade7">
                <label for="grade7Checkbox" class="custom-control-label">7 Standard</label>
            </div>

            <!-- Grade 8 -->
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input educationCheckbox" type="checkbox" id="grade8Checkbox" value="grade8">
                <label for="grade8Checkbox" class="custom-control-label">8 Standard</label>
            </div>  </p>
        </div>
    </div>

    <div class="row" id="secondaryContent" style="display: none;">
        <div class="col-md-12">
            <!-- Content for Secondary -->
            <p> <div class="custom-control custom-checkbox">
                <input class="custom-control-input educationCheckbox" type="checkbox" id="grade9Checkbox" value="grade9">
                <label for="grade9Checkbox" class="custom-control-label">9 Standard</label>
            </div>

            <!-- Grade 10 -->
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input educationCheckbox" type="checkbox" id="grade10Checkbox" value="grade10">
                <label for="grade10Checkbox" class="custom-control-label">10 Standard</label>
            </div></p>
        </div>
    </div>

    <div class="row" id="highSecondaryContent" style="display: none;">
        <div class="col-md-12">
            <!-- Content for High Secondary -->
            <p> <div class="custom-control custom-checkbox">
                <input class="custom-control-input educationCheckbox" type="checkbox" id="grade11Checkbox" value="grade11">
                <label for="grade11Checkbox" class="custom-control-label">11 Standard</label>
            </div>

            <!-- Grade 12 -->
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input educationCheckbox" type="checkbox" id="grade12Checkbox" value="grade12">
                <label for="grade12Checkbox" class="custom-control-label">12 Standard</label>
            </div></p>
        </div>
    </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

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
<script>
    document.getElementById('other_institute').addEventListener('change', function() {
        var otherTextbox = document.getElementById('otherTextboxinstitute');
        otherTextbox.style.display = this.checked ? 'block' : 'none';
    });
    document.getElementById('Other_board').addEventListener('change', function() {
        var otherTextbox = document.getElementById('otherText_board');
        otherTextbox.style.display = this.checked ? 'block' : 'none';
    });
</script>
<script>
    var checkboxes = document.querySelectorAll('.educationCheckbox');

    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            updateContentVisibility();
        });
    });

    function updateContentVisibility() {
        checkboxes.forEach(function(checkbox) {
            var contentId = checkbox.value + 'Content';
            var contentDiv = document.getElementById(contentId);

            if (checkbox.checked) {
                contentDiv.style.display = 'block';
            } else {
                contentDiv.style.display = 'none';
            }
        });
    }
</script>