@extends('client.dashboard')
@section('client')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-container">

  <div class="row">
<div class="col-12">
    <div class="card">
        <div class="card-header border-bottom border-dashed d-flex align-items-center">
            <h4 class="header-title">User Profile Page </h4>
        </div>

        <div class="card-body">
             
<form action="{{ route('user.profile.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row g-2">
        <div class="mb-3 col-md-6">
            <label for="name" class="form-label">User Name</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ $profileData->name }}">
        </div>
        <div class="mb-3 col-md-6">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="email" value="{{ $profileData->email }}">
        </div>
        <div class="mb-3 col-md-6">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" id="phone" value="{{ $profileData->phone }}">
        </div>

          <div class="mb-3 col-md-6">
            <label for="address" class="form-label">Address</label>
            <input type="text" name="address" class="form-control" id="address" value="{{ $profileData->address }}">
        </div>

        <div class="mb-3 col-md-6">
            <label for="photo" class="form-label">Profile Image</label>
            <input type="file" name="photo" class="form-control" id="image">
        </div>

        <div class="mb-3 col-md-6">
            <label for="address" class="form-label"> </label>
             <img id="showImage" src="{{ (!empty($profileData->photo)) ? url('upload/admin_images/'.$profileData->photo) : url('upload/no_image.jpg') }}" class="rounded-circle avatar-xl" style="width:100px; height:100px;">
        </div>


    </div>

        
    
    <button type="submit" class="btn btn-primary">Save Changes </button>
</form>
        </div> <!-- end card-body -->
    </div> <!-- end card-->
</div> <!-- end col -->
</div>  




</div>


<script type="text/javascript">
    $(document).ready(function(){
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        })
    })
</script>
 


@endsection