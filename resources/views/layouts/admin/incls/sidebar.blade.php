<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('assets/dist/img/logo.png') }}" alt="Logo" class="brand-image">
        <span class="brand-text font-weight-light">&nbsp;</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('assets/images/users/' . Auth::user()->profile->user_image) }}"
                    class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{ route('user.profile') }}" class="d-block">{{ ucwords(Auth::user()->name) }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item has-treeview menu-open">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ $page_name == 'dashboard' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-header">SYSTEM COMPONENTS</li>
                <li class="nav-item">
                    <a href="{{ route('user.profile') }}"
                        class="nav-link {{ $page_name == 'profile' ? 'active' : '' }}">
                        <i class="fa fa-user nav-icon"></i>
                        <p>
                            Profile
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user.assets') }}" class="nav-link {{ $page_name == 'assets' ? 'active' : '' }}">
                        <i class="fa fa-list-alt nav-icon"></i>
                        <p>
                            Assigned Assets
                        </p>
                    </a>
                </li>

                <!-- BEGINNING : Admin Menus -->
                @if (Auth::user()->hasRole('admin|motor maintenance'))
                    <li class="nav-item">
                        <a href="{{ route('admin.assets.index') }}"
                            class="nav-link {{ $page_name == 'assets' ? 'active' : '' }}">
                            <i class="fa fa-desktop nav-icon"></i>
                            <p>
                                Assets Management
                            </p>
                        </a>
                    </li>
                @endif

                @if (Auth::user()->hasRole('admin'))
                    <li class="nav-item">
                        <a href="{{ route('shop.index') }}"
                            class="nav-link {{ $page_name == 'shop' ? 'active' : '' }}">
                            <i class="fa fa-list-alt nav-icon"></i>
                            <p>
                                Bimas Online Shop
                            </p>
                        </a>
                    </li>

                    <li class="nav-item has-treeview">
                        <a href="{{ route('admin.users.index') }}"
                            class="nav-link {{ $page_name == 'users' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Users Management
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.audit.index') }}" class="nav-link">
                                    <i class="fa fa-arrow-right nav-icon"></i>
                                    <p>Audit Trails</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.users.index') }}" class="nav-link">
                                    <i class="fa fa-arrow-right nav-icon"></i>
                                    <p>Manage Users</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.roles.index') }}" class="nav-link">
                                    <i class="fa fa-arrow-right nav-icon"></i>
                                    <p>User Roles</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.roles.management') }}" class="nav-link">
                                    <i class="fa fa-arrow-right nav-icon"></i>
                                    <p>Manage Roles</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.permissions') }}" class="nav-link">
                                    <i class="fa fa-arrow-right nav-icon"></i>
                                    <p>Permissions</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item has-treeview">
                        <a href="{{ route('admin.packages.index') }}"
                            class="nav-link {{ $page_name == 'packages' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-list-alt"></i>
                            <p>
                                CVP Data Management
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.packages.index') }}" class="nav-link">
                                    <i class="fa fa-arrow-right nav-icon"></i>
                                    <p>Staffs Packages</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.packages.data') }}" class="nav-link">
                                    <i class="fa fa-arrow-right nav-icon"></i>
                                    <p>CVP Packages</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.insurances.index') }}"
                            class="nav-link {{ $page_name == 'insurance' ? 'active' : '' }}">
                            <i class="fa fa-list-alt nav-icon"></i>
                            <p>
                                Insurance Policies
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.messages.index') }}"
                            class="nav-link {{ $page_name == 'messages' ? 'active' : '' }}">
                            <i class="fa fa-envelope nav-icon"></i>
                            <p>
                                Messages
                            </p>
                        </a>
                    </li>
                @endif
                <!-- END : Admin Menus -->

                <!--BEGINNING : Admin,Communication-->
                @if (Auth::user()->hasRole('admin|communication'))
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link {{ $page_name == 'customers' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Customers Module
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('customers.campaigns.index') }}" class="nav-link">
                                    <i class="fa fa-arrow-right nav-icon"></i>
                                    <p>Customers Campaigns</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('customers.loans') }}" class="nav-link">
                                    <i class="fa fa-arrow-right nav-icon"></i>
                                    <p>Website Loans</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('customers.contacts') }}" class="nav-link">
                                    <i class="fa fa-arrow-right nav-icon"></i>
                                    <p>Website Contacts</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                <!--END : Admin,Communication-->

                <!--BEGINNING : Records Management-->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link {{ $page_name == 'records' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Records Management
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if (Auth::user()->hasRole('admin|records'))
                            <li class="nav-item">
                                <a href="{{ route('records.clients.index') }}" class="nav-link">
                                    <i class="fa fa-arrow-right nav-icon"></i>
                                    <p>Records Clients</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('records.change-forms.index') }}" class="nav-link">
                                    <i class="fa fa-arrow-right nav-icon"></i>
                                    <p>Change Forms</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('records.loan-forms.index') }}" class="nav-link">
                                    <i class="fa fa-arrow-right nav-icon"></i>
                                    <p>Loan Forms</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('records.requested-forms.index') }}" class="nav-link">
                                    <i class="fa fa-arrow-right nav-icon"></i>
                                    <p>Requested Forms</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('records.filing-labels.index') }}" class="nav-link">
                                    <i class="fa fa-arrow-right nav-icon"></i>
                                    <p>Filing Labels</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('records.loan-forms.products') }}" class="nav-link">
                                    <i class="fa fa-arrow-right nav-icon"></i>
                                    <p>Loan Products</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('records.reports.index') }}" class="nav-link">
                                    <i class="fa fa-arrow-right nav-icon"></i>
                                    <p>Record Reports</p>
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ route('user.loan-forms.view') }}" class="nav-link">
                                    <i class="fa fa-arrow-right nav-icon"></i>
                                    <p>Loan Forms</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('user.change-forms.view') }}" class="nav-link">
                                    <i class="fa fa-arrow-right nav-icon"></i>
                                    <p>Change Forms</p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>

                <!--END : Records Management-->

                <!-- BEGINNING : Finance, Admin Menus -->
                @if (Auth::user()->hasRole('admin|finance'))
                    <li class="nav-item has-treeview">
                        <a href="{{ route('admin.groups.index') }}"
                            class="nav-link {{ $page_name == 'finance' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-briefcase"></i>
                            <p>
                                Finance Management
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('user.expenses.claims') }}" class="nav-link">
                                    <i class="fa fa-arrow-right nav-icon"></i>
                                    <p>Claim Expenses</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('user.expenses.transactions') }}" class="nav-link">
                                    <i class="fa fa-arrow-right nav-icon"></i>
                                    <p>Transactions</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.budgets.index') }}"
                            class="nav-link {{ $page_name == 'budgets' ? 'active' : '' }}">
                            <i class="fa fa-list nav-icon"></i>
                            <p>
                                Budget Templates
                            </p>
                        </a>
                    </li>
                @endif
                <!-- END : Finance, Admin Menus -->

                <!-- BEGINNING : Staff, Branch Manager Menus -->
                @if (Auth::user()->hasRole('bimas staff|branch manager'))
                    <li class="nav-item">
                        <a href="{{ route('user.budgets') }}"
                            class="nav-link {{ $page_name == 'budgets' ? 'active' : '' }}">
                            <i class="fa fa-list nav-icon"></i>
                            <p>
                                User Budgets
                            </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="{{ route('shop.products.index') }}"
                            class="nav-link {{ $page_name == 'shop' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-motorcycle"></i>
                            <p>
                                Biddings Shop
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('shop.products.index') }}" class="nav-link">
                                    <i class="fa fa-arrow-right nav-icon"></i>
                                    <p>Motorbikes</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('shop.orders') }}" class="nav-link">
                                    <i class="fa fa-arrow-right nav-icon"></i>
                                    <p>User Biddings</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link {{ $page_name == 'customers' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Branch Customers
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('customers.branch_customers') }}" class="nav-link">
                                    <i class="fa fa-arrow-right nav-icon"></i>
                                    <p>Customers Campaigns</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('customers.loans') }}" class="nav-link">
                                    <i class="fa fa-arrow-right nav-icon"></i>
                                    <p>Website Loans</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                <!-- END : Staff, Branch Manager Menus -->

                <li class="nav-item">
                    <a href="{{ route('user.password') }}"
                        class="nav-link {{ $page_name == 'password' ? 'active' : '' }}">
                        <i class="fa fa-unlock nav-icon"></i>
                        <p>
                            Change Password
                        </p>
                    </a>
                </li>
                @if (Auth::user()->hasRole('admin'))
                    <li class="nav-item">
                        <a href="{{ route('admin.processes.index') }}"
                            class="nav-link {{ $page_name == 'processes' ? 'active' : '' }}">
                            <i class="fa fa-cog nav-icon"></i>
                            <p>
                                System Processes
                            </p>
                        </a>
                    </li>
                @endif

                <li class="nav-item">
                    <a href="{{ 'logout' }}" class="nav-link"
                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        @csrf
                        <i class="fa fa-power-off nav-icon"></i>
                        <p>
                            System Logout
                        </p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
