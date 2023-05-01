<ul class="metismenu list-unstyled" id="side-menu">
    <li class="menu-title" key="t-menu">Dashboard</li>
    <li>
        <a href="{{ route('dashboard')}}"  class="waves-effect {{ Route::is('dashboard') ? "li-active" : ""}}">
            <i class="bx bx-home"></i>
            <span key="t-chat">Home</span>
        </a>
    </li>
    <li class="menu-title" key="t-menu">Reports</li>
    <li>
        <a href="{{ route('transactions')}}" class="waves-effect {{ Route::is('transactions') ? "li-active" : ""}}">
            <i class="bx bx-grid"></i>
            <span key="t-file-manager">Transactions</span>
        </a>
    </li>
    <li>
        <a href="{{ route('budgets')}}" class="waves-effect {{ Route::is('budgets') ? "li-active" : ""}}">
            <i class="bx bx-money"></i>
            <span key="t-file-manager">Budget</span>
        </a>
    </li>
    {{-- <li>
        <a href="{{ route('goals')}}" class="waves-effect {{ Route::is('goals') ? "li-active" : ""}}">
            <i class="bx bx-money"></i>
            <span key="t-file-manager">Goals</span>
        </a>
    </li> --}}
    <li>
        <a href="{{ route('app.users')}}" class="waves-effect {{ (Route::is('app.users') || Route::is('user.profile')) ? "li-active" : ""}}">
            <i class="bx bx-user"></i>
            <span key="t-file-manager">App Users</span>
        </a>
    </li>
    <li class="menu-title" key="t-menu">System Management</li>
    <li>
        <a href="{{ route('account_types.index')}}" class="waves-effect {{ Route::is('account_types.index') ? "li-active" : ""}}">
            <i class="bx bx-list-ol"></i>
            <span key="t-file-manager">Account Types</span>
        </a>
    </li>
    <li>
        <a href="{{ route('banks.index')}}" class="waves-effect {{ Route::is('banks.index') ? "li-active" : ""}}">
            <i class="bx bx-list-check"></i>
            <span key="t-file-manager">Banks</span>
        </a>
    </li>
    <li>
        <a href="{{ route('group.index')}}" class="waves-effect {{ Route::is('group.index') ? "li-active" : ""}}">
            <i class="bx bx-file"></i>
            <span key="t-file-manager">Categories Group</span>
        </a>
    </li>
    <li>
        <a href="{{ route('category.index')}}" class="waves-effect {{ Route::is('category.index') ? "li-active" : ""}}">
            <i class="bx bx-list-plus"></i>
            <span key="t-file-manager">Categories</span>
        </a>
    </li>
    <li class="menu-title" key="t-menu">System User Management</li>
    <li>
        <a href="{{ route('users.index')}}" class="waves-effect {{ (Route::is('users.index') || Route::is('users.show')) ? "li-active" : ""}}">
            <i class="bx bx-user"></i>
            <span key="t-file-manager">Users</span>
        </a>
    </li>
    <li>
        <a href="{{ route('roles.index')}}" class="waves-effect {{ (Route::is('roles.index') || Route::is('roles.show')) ? "li-active" : ""}}">
            <i class="bx bx-align-justify"></i>
            <span key="t-file-manager">Roles</span>
        </a>
    </li>
    <li>
        <a href="{{ route('permissions.index')}}" class="waves-effect {{ Route::is('permissions.index') ? "li-active" : ""}}">
            <i class="bx bx-key"></i>
            <span key="t-file-manager">Permissions</span>
        </a>
    </li>
    <li>
        <a href="{{ route('logout')}}" class="waves-effect">
            <i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i>
            <span key="t-file-manager">Logout</span>
        </a>
    </li>

</ul>