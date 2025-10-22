@extends('admin.admin_master')
@section('admin')
  
<div class="page-container">

    <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header border-bottom justify-content-between d-flex flex-wrap align-items-center gap-2">
                <div class="flex-shrink-0 d-flex align-items-center gap-2">
                    <div class="position-relative">
            <h3>All Approved Subscription </h3>
                    </div>
                </div> 
                 
            </div>

<div class="table-responsive">
    <table class="table table-hover text-nowrap mb-0">
        <thead class="bg-light-subtle">
<tr> 
    <th class="fs-12 text-uppercase text-muted py-1">User Name</th>
    <th class="fs-12 text-uppercase text-muted py-1">Plan</th>
    <th class="fs-12 text-uppercase text-muted py-1">Amount</th>
    <th class="fs-12 text-uppercase text-muted py-1">Payment Type</th>
    <th class="fs-12 text-uppercase text-muted py-1">Tx Id</th>
    <th class="fs-12 text-uppercase text-muted py-1">Status</th> 
    <th class="text-center  py-1 fs-12 text-uppercase text-muted" style="width: 120px;">Action</th>
</tr>
        </thead>
        <!-- end table-head -->

    <tbody>
       @foreach ($approvesub as $item) 
        <tr> 
            <td><span class="fw-semibold"><a href="apps-invoice-details.html" class="text-reset">{{ $item->user->name }}</a></span></td> 

            <td><span class="text-muted">{{ $item->plan }}</span></td>
           <td><span class="text-muted">${{ $item->amount }}</span></td>
            <td> {{ $item->payment_method  }}</td>
            <td><span class="text-muted">{{ $item->transaction_id }}</span></td>
             <td> 
                @if ($item->status === 'pending')
                    <span class="badge bg-primary">Pending</span>
                @elseif ($item->status === 'approved')
                 <span class="badge bg-success">approved</span>
                @else 
                 <span class="badge bg-danger">Rejected</span>
                @endif  
             </td>
            
            <td class="pe-3">
        <form action="{{ route('subscription.status.update',$item->id) }}" method="POST">
            @csrf
            @method('PUT')
        <button type="submit" class="btn btn-success btn-sm">Approve</button>
        </form>
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