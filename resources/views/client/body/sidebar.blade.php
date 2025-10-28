 <div class="sidenav-menu">

                <!-- Brand Logo -->
<a href="index.html" class="logo">
    <span class="logo-light">
        <span class="logo-lg"><img src="{{ asset('backend/assets/images/logo.png') }}" alt="logo"></span>
        <span class="logo-sm"><img src="{{ asset('backend/assets/images/logo-sm.png') }}" alt="small logo"></span>
    </span>

    <span class="logo-dark">
        <span class="logo-lg"><img src="{{ asset('backend/assets/images/logo-dark.png') }}" alt="dark logo"></span>
        <span class="logo-sm"><img src="{{ asset('backend/assets/images/logo-sm.png') }}" alt="small logo"></span>
    </span>
</a>

                <!-- Sidebar Hover Menu Toggle Button -->
                <button class="button-sm-hover">
                    <i class="ri-circle-line align-middle"></i>
                </button>

                <!-- Full Sidebar Menu Close Button -->
                <button class="button-close-fullsidebar">
                    <i class="ti ti-x align-middle"></i>
                </button>

                <div data-simplebar>

                    <!--- Sidenav Menu -->
    <ul class="side-nav">
        <li class="side-nav-title">
            Menu
        </li>

        <li class="side-nav-item">
            <a href="{{ route('admin.dashboard') }}" class="side-nav-link">
                <span class="menu-icon"><i class="ti ti-dashboard"></i></span>
                <span class="menu-text"> Dashboard </span>
                <span class="badge bg-danger rounded-pill">9+</span>
            </a>
        </li>
 
        <li class="side-nav-item">
            <a href="{{ route('prompts.page') }}" class="side-nav-link">
                <span class="menu-icon"><i class="ti ti-mailbox"></i></span>
                <span class="menu-text"> Create Prompts </span>
            </a>
        </li>


        <li class="side-nav-item">
            <a href="{{ route('template.prompts.index') }}" class="side-nav-link">
                <span class="menu-icon"><i class="ti ti-mailbox"></i></span>
                <span class="menu-text"> Prompt Libary </span>
            </a>
        </li>

         <li class="side-nav-item">
            <a href="{{ route('template.my.variations') }}" class="side-nav-link">
                <span class="menu-icon"><i class="ti ti-mailbox"></i></span>
                <span class="menu-text"> My Template </span>
            </a>
        </li>

        <li class="side-nav-item">
            <a data-bs-toggle="collapse" href="#sidebarInvoice" aria-expanded="false" aria-controls="sidebarInvoice" class="side-nav-link">
                <span class="menu-icon"><i class="ti ti-invoice"></i></span>
                <span class="menu-text"> Invoice</span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="sidebarInvoice">
                <ul class="sub-menu">
                    <li class="side-nav-item">
                        <a href="apps-invoices.html" class="side-nav-link">
                            <span class="menu-text">Invoices</span>
                        </a>
                    </li>
                    <li class="side-nav-item">
                        <a href="apps-invoice-details.html" class="side-nav-link">
                            <span class="menu-text">View Invoice</span>
                        </a>
                    </li>
                    <li class="side-nav-item">
                        <a href="apps-invoice-create.html" class="side-nav-link">
                            <span class="menu-text">Create Invoice</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="side-nav-title mt-2">
            Custom
        </li>

        

<li class="side-nav-item">
    <a data-bs-toggle="collapse" href="#sidebarPagesAuth" aria-expanded="false" aria-controls="sidebarPagesAuth" class="side-nav-link">
        <span class="menu-icon"><i class="ti ti-user-shield"></i></span>
        <span class="menu-text"> Authentication </span>
        <span class="menu-arrow"></span>
    </a>
    <div class="collapse" id="sidebarPagesAuth">
        <ul class="sub-menu">
            <li class="side-nav-item">
                <a href="auth-login.html" class="side-nav-link">
                    <span class="menu-text">Login</span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="auth-register.html" class="side-nav-link">
                    <span class="menu-text">Register</span>
                </a>
            </li>
                
        </ul>
    </div>
</li>


                    
                    </ul>

<!-- Help Box -->
@if (!auth()->user()->isAdmin()) 
<div class="help-box text-left">
    <h5 class="fw-semibold fs-16">Your Plan</h5>
    <p class="mb-3 text-muted">
        <span class="text-muted">Current Plan: </span>
        <span class="badge bg-primary"> {{ strtoupper(auth()->user()->subscription_plan ) }} </span>
    </p>

     <p class="mb-3 text-muted">
    <span class="text-muted"> Used This Month: </span>
    <span class="badge bg-primary">  {{ auth()->user()->prompts_used_this_month }} </span>
   </p>
     <p class="mb-3 text-muted">
    <span class="text-muted"> Remaining: </span>
    <span class="badge bg-primary">  {{ auth()->user()->remaining_prompts }} </span>
    </p>

    @if (auth()->user()->remaining_prompts <= 2 ) 
            <div class="alert alert-warning p-2 mb-2 small">
                <i class="bi bi-exclamation-triangle"></i> Running low on prompts!
            </div>
           @endif
     
    <a href="{{ route('subscriptions.index') }}" class="btn btn-danger btn-sm">Upgrade</a>
</div>
@endif

                    <div class="clearfix"></div>
                </div>
            </div>