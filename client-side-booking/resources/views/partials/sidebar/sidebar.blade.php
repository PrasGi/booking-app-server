<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link {{ Request::route()->getName() == 'dashboard' ? 'active' : '' }} collapsed"
                href="{{ route('dashboard') }}">
                <i class="bi bi-house"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-heading">booking</li>

        <li class="nav-item">
            <a class="nav-link {{ Request::route()->getName() == 'food.index' ? 'active' : '' }} collapsed"
                href="{{ route('food.index') }}">
                <i class="bi bi-egg-fill"></i>
                <span>Food</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::route()->getName() == 'car.index' ? 'active' : '' }} collapsed"
                href="{{ route('car.index') }}">
                <i class="bi bi-car-front"></i>
                <span>Car</span>
            </a>
        </li>
    </ul>

</aside><!-- End Sidebar-->
