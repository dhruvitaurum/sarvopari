@include('layouts/header')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Student</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Student</li>
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
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Create Student</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="post" action="{{ url('student/save') }}">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="exampleInputEmail1">Name  : </label>
                                            <input type="text" name="name" class="form-control" placeholder="Enter Name">
                                            @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label for="exampleInputEmail1">Mobile  : </label>
                                            <input type="tel" name="mobile" class="form-control" placeholder="Enter Mobile No.">
                                            @error('mobile')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label for="exampleInputEmail1">EmailID  : </label>
                                            <input type="email" name="email" class="form-control" placeholder="Enter Email ID">
                                            @error('email')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label for="exampleInputEmail1">Address  : </label>
                                            <textarea name="address" class="form-control" placeholder="Address"></textarea>
                                            @error('address')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label for="exampleInputEmail1">DOB  : </label>
                                            <input type="date" name="dob" class="form-control" placeholder="Date Of Birth">
                                            @error('dob')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label for="exampleInputEmail1">Student Stage  : </label>
                                            <select name="stage">
                                                @foreach($institute_for as $stage)
                                                    <option value="{{ $stage->id }}">{{ $stage->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('stage')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label for="exampleInputEmail1">Board  : </label>
                                            <select name="board">
                                                @foreach($board as $instituteboard)
                                                    <option value="{{ $instituteboard->id }}">{{ $instituteboard->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('board')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label for="exampleInputEmail1">Medium : </label>
                                            <select name="medium">
                                                @foreach($medium as $institutemedium)
                                                    <option value="{{ $institutemedium->id }}">{{ $institutemedium->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('medium')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label for="exampleInputEmail1">Student Class  : </label>
                                            <select name="class">
                                                @foreach($class as $instituteclass)
                                                    <option value="{{ $instituteclass->id }}">{{ $instituteclass->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('dob')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label for="exampleInputEmail1">Stream  : </label>
                                            <select name="stream">
                                                @foreach($stream as $institutestream)
                                                    <option value="{{ $institutestream->id }}">{{ $institutestream->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('stream')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label for="exampleInputEmail1">Subject  : </label>
                                            <select name="subject">
                                                @foreach($subject as $institutesubject)
                                                    <option value="{{ $institutesubject->id }}">{{ $institutesubject->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('subject')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                       
                                        <div class="col-md-3">
                                            <label for="exampleInputEmail1">status : </label>
                                            <select class="form-control" name="status">
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
                            <div class="card-footer">
                                <button type="submit" class="btn btn-info" style="float: right;">Submit</button>
                            </div>
                    </div>
                </div>


                </form>
            </div>

        </div>

</div>

</div>
</section>
</div>

@include('layouts/footer')