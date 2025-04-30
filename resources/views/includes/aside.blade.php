<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('assets/images/AgilityEco_WhiteLogo.png') }}" alt="AdminLTE Logo" class="d-block m-auto"
            style="width:80%;">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
   <div class="image">
    <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
   </div>
   <div class="info">
    <a href="#" class="d-block">{{ auth()->user()->firstname }} </a>
   </div>
  </div> -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('job.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-briefcase"></i>
                        <p>
                            Manage Jobs
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Open NC
                        </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Exceptions
                            <i class="right fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('job-entry-exception.index') }}" class="nav-link ">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Job Entry Exceptions</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('property-inspector-exception.index') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Property Inspector Exceptions</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('data-validation-exception.index') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Data Validation Exceptions</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('document-exception.index') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Document Exceptions</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('booking-exception.index') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Booking Exceptions</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('remove-job-exception.index') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Remove Jobs</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item ">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Platform Configurations
                            <i class="right fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('client-configuration.index') }}" class="nav-link ">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Client Configuration</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./index2.html" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>User Configuration</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./index3.html" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>User Profile Configuration</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('measure.index') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Measure Configuration</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('property-inspector.index') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Property Inspector Configuration</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('scheme.index') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Scheme Configuration</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('survey-question-set.index') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Survey Question Set</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('installer-configuration.index') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Installer Configuration</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item ">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fas fa-globe-asia"></i>
                        <p>
                            Global Settings
                            <i class="right fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="./index.html" class="nav-link ">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>PI Email Template</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./index2.html" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Uphold Email Template</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./index3.html" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Remediation Template</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./index3.html" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>First Template</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./index3.html" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Second Template</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./index3.html" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Automated Email Passed</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item ">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fas fa-calendar-alt"></i>
                        <p>
                            Bookings
                            <i class="right fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="./index.html" class="nav-link ">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Make Booking</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./index2.html" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Manage Bookings</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./index3.html" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Restore Max Attempts</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Reports
                        </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Accounts
                            <i class="right fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="./index.html" class="nav-link ">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Account Reconciliation</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-list"></i>
                        <p>
                            History
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
