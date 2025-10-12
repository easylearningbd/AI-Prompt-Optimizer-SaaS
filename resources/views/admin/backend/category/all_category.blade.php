@extends('admin.admin_master')
@section('admin')
  
<div class="page-container">

    <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header border-bottom justify-content-between d-flex flex-wrap align-items-center gap-2">
                <div class="flex-shrink-0 d-flex align-items-center gap-2">
                    <div class="position-relative">
            <h3>All Category </h3>
                    </div>
                </div>

                <a href="{{ route('add.category') }}" class="btn btn-primary"><i class="ti ti-plus me-1"></i>Add Category</a>
            </div>

<div class="table-responsive">
    <table class="table table-hover text-nowrap mb-0">
        <thead class="bg-light-subtle">
<tr> 
    <th class="fs-12 text-uppercase text-muted py-1">Sl</th>
    <th class="fs-12 text-uppercase text-muted py-1">Category Name</th>
    <th class="fs-12 text-uppercase text-muted py-1">Slug</th>
    <th class="fs-12 text-uppercase text-muted py-1">Description</th>
    <th class="fs-12 text-uppercase text-muted py-1">Icon</th>
    <th class="fs-12 text-uppercase text-muted py-1">Order</th> 
    <th class="text-center  py-1 fs-12 text-uppercase text-muted" style="width: 120px;">Action</th>
</tr>
        </thead>
        <!-- end table-head -->

    <tbody>
       @foreach ($category as $key=> $item) 
        <tr> 
            <td><span class="fw-semibold"><a href="apps-invoice-details.html" class="text-reset">#{{ $key+1 }}</a></span></td>  
            <td><span class="text-muted">{{ $item->name }}</span></td>
           <td><span class="text-muted">{{ $item->slug }}</span></td>
            <td>{{ Str::limit($item->description, 40) }}</td>
            <td><span class="text-muted">{{ $item->icon }}</span></td>
             <td><span class="text-muted">{{ $item->order }}</span></td>
            
            <td class="pe-3">
                <div class="hstack gap-1 justify-content-end"> 
                    <a href="javascript:void(0);" class="btn btn-soft-success btn-icon btn-sm rounded-circle"> <i class="ti ti-edit fs-16"></i></a>
                    <a href="javascript:void(0);" class="btn btn-soft-danger btn-icon btn-sm rounded-circle"> <i class="ti ti-trash"></i></a>
                </div>
            </td>
        </tr><!-- end table-row -->
         @endforeach 


                    </tbody><!-- end table-body -->
                </table><!-- end table -->
            </div>

          
        </div> <!-- end card-->
    </div> <!-- end col -->
</div>


</div>
@endsection