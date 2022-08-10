<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="/" title="SIMS CODING SCHOOL">YOLO</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">
            @role('Quản trị viên')
            <li class="dropdown {{ request()->is('admin') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" title="" class="nav-link "><i class="fas fa-fire"></i><span>Báo cáo</span></a>
            </li>
            <li class="dropdown {{ request()->is('admin/users') ? 'active' : '' }}">
                <a href="{{ route('users.index') }}" title="" class="nav-link "><i class="fas fa-fire"></i><span>Quản lý người dùng</span></a>
            </li>
            <li class="dropdown {{ request()->is('admin/customers') ? 'active' : '' }}">
                <a href="{{ route('customers.index') }}" title="" class="nav-link "><i class="fas fa-fire"></i><span>Quản lý khách hàng</span></a>
            </li>
            <li class="dropdown {{ request()->is('admin/categories') ? 'active' : '' }}">
                <a href="{{ route('categories.index') }}" title="" class="nav-link "><i class="fas fa-fire"></i><span>Quản lý danh mục</span></a>
            </li>
            <li class="dropdown {{ request()->is('admin/products') ? 'active' : '' }}">
                <a href="{{ route('products.index') }}" title="" class="nav-link "><i class="fas fa-fire"></i><span>Quản lý sản phẩm</span></a>
            </li>
            <li class="dropdown {{ request()->is('admin/sliders') ? 'active' : '' }}">
                <a href="{{ route('sliders.index') }}" title="" class="nav-link "><i class="fas fa-fire"></i><span>Quản lý slider</span></a>
            </li>
            <li class="dropdown {{ request()->is('admin/orders') ? 'active' : '' }}">
                <a href="{{ route('orders.index') }}" title="" class="nav-link "><i class="fas fa-fire"></i><span>Quản lý đơn hàng</span></a>
            </li>
            @else
                <li class="dropdown {{ request()->is('admin') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" title="" class="nav-link "><i class="fas fa-fire"></i><span>Báo cáo</span></a>
                </li>

                <li class="dropdown {{ request()->is('admin/categories') ? 'active' : '' }}">
                    <a href="{{ route('categories.index') }}" title="" class="nav-link "><i class="fas fa-fire"></i><span>Quản lý danh mục</span></a>
                </li>
                <li class="dropdown {{ request()->is('admin/customers') ? 'active' : '' }}">
                    <a href="{{ route('customers.index') }}" title="" class="nav-link "><i class="fas fa-fire"></i><span>Quản lý khách hàng</span></a>
                </li>
                <li class="dropdown {{ request()->is('admin/products') ? 'active' : '' }}">
                    <a href="{{ route('products.index') }}" title="" class="nav-link "><i class="fas fa-fire"></i><span>Quản lý sản phẩm</span></a>
                </li>
                <li class="dropdown {{ request()->is('admin/sliders') ? 'active' : '' }}">
                    <a href="{{ route('sliders.index') }}" title="" class="nav-link "><i class="fas fa-fire"></i><span>Quản lý slider</span></a>
                </li>
                <li class="dropdown {{ request()->is('admin/orders') ? 'active' : '' }}">
                    <a href="{{ route('orders.index') }}" title="" class="nav-link "><i class="fas fa-fire"></i><span>Quản lý đơn hàng</span></a>
                </li>
            @endrole
        </ul>
    </aside>
</div>
