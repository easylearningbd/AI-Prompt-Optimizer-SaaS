@extends('admin.admin_master')
@section('admin')
 
<div class="page-container">

  <div class="row">
<div class="col-12">
    <div class="card">
        <div class="card-header border-bottom border-dashed d-flex align-items-center">
            <h4 class="header-title">Add Category</h4>
        </div>

        <div class="card-body">
             
<form action="{{ route('store.category') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row g-2">
        <div class="mb-3 col-md-4">
            <label for="name" class="form-label">Category Name</label>
            <input type="text" name="name" class="form-control" id="name"  >
        </div>
        <div class="mb-3 col-md-4">
            <label for="icon" class="form-label">Icon</label>
            <input type="text" name="icon" class="form-control" id="icon"  >
        </div>
        <div class="mb-3 col-md-4">
            <label for="order" class="form-label">Order</label>
            <input type="text" name="order" class="form-control" id="order"  >
        </div>

          <div class="mb-3 col-md-12">
            <label for="address" class="form-label">Description</label>
       <textarea name="description" class="form-control" rows="3"></textarea>
        </div>

         

    </div>

        
    
    <button type="submit" class="btn btn-primary">Save Changes </button>
</form>
        </div> <!-- end card-body -->
    </div> <!-- end card-->
</div> <!-- end col -->
</div>  




</div>

 


@endsection