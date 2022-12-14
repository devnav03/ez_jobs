<nav class="main-menu noPrint">
    <ul>
        <li><a href="{!! route('dashboard') !!}"><i class="fa fa-home nav_icon"></i><span class="nav-text">Dashboard</span></a></li>
     
        <li class="has-subnav"> 
            <a href="{!! route('job-seekers.index') !!}">
            <i class="fa fa-users" aria-hidden="true"></i><span class="nav-text"> Job Seekers</span></a>
        </li>  
        <li class="has-subnav"> 
            <a href="{!! route('employer.index') !!}">
            <i class="fa fa-users" aria-hidden="true"></i><span class="nav-text"> Employer</span></a>
        </li>

        <li class="has-subnav"> 
            <a href="{!! route('category.index') !!}">
            <i class="fa fa-pen" aria-hidden="true"></i><span class="nav-text"> Category List</span></a>
        </li>
        <li class="has-subnav"> 
            <a href="{!! route('designation.index') !!}">
            <i class="fa fa-user" aria-hidden="true"></i><span class="nav-text"> Designation List</span></a>
        </li>

        <li class="has-subnav"> 
            <a href="{!! route('plans.index') !!}">
            <i class="fa fa-dollar-sign" aria-hidden="true"></i><span class="nav-text"> Plan Master</span></a>
        </li>

        <li class="has-subnav"> 
            <a href="{!! route('education.index') !!}">
            <i class="fa fa-graduation-cap" aria-hidden="true"></i><span class="nav-text"> Education Master</span></a>
        </li>
        
        <li class="has-subnav"> 
            <a href="{!! route('jobs-list.index') !!}">
            <i class="fa fa-briefcase"></i> <span class="nav-text">Jobs</span></a>
        </li>

        <li class="has-subnav"> 
            <a href="{!! route('transaction.index') !!}">
            <i class="fa fa-money"></i> <span class="nav-text">Transactions</span></a>
        </li>

        <li class="has-subnav"> 
            <a href="{!! route('testimonials.index') !!}">
            <i class="fa fa-star"></i> <span class="nav-text">Testimonials</span></a>
        </li>

        <li class="has-subnav"> 
            <a href="{!! route('blogs.index') !!}">
            <i class="fa fa-pen"></i> <span class="nav-text">Blogs</span></a>
        </li>

        <li class="has-subnav"> 
            <a href="{!! route('faqs.index') !!}">
            <i class="fa fa-question"></i> <span class="nav-text">FAQ's</span></a>
        </li>

        <li class="has-subnav"> 
            <a href="{!! route('slider.index') !!}">
            <i class="fa fa-image"></i> <span class="nav-text">Banners</span></a>
        </li>

        <li class="has-subnav"> 
            <a href="{!! route('content-management') !!}">
            <i class="fa fa-pen"></i> <span class="nav-text">CMS Pages</span></a>
        </li>

        <li class="has-subnav"> 
            <a href="{!! route('contact-enquiry.index') !!}">
            <i class="fa fa-envelope"></i> <span class="nav-text">Manage Enquiries</span></a>
        </li>

        


        <!--  <li class="has-subnav">
            <a href="{!! route('login-logs.index') !!}"><i class="fa fa-user-lock" aria-hidden="true"></i><span class="nav-text">Login Attempts</span></a>
        </li> -->

        </ul>
        </li>
        <li><a href="{!! route('admin-logout') !!}"><i class="icon-off nav-icon"></i><span class="nav-text">Logout</span></a></li>
    </ul>
   
</nav>