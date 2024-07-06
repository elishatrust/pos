
<aside id="minileftbar" class="minileftbar">
    <ul class="menu_list">
        <li>
            <a href="javascript:" class="bars"></a>
            <a class="navbar-brand" href="{{ route('dashboard') }}"><img src="{{ asset('assets/images/logo.svg') }}"
                    alt="Alpino"></a>
        </li>
        <li><a href="javascript:" class="menu-sm"><i class="zmdi zmdi-swap"></i></a></li>
        <li class="notifications badgebit">
            <a href="javascript:" title="Notification">
                <i class="zmdi zmdi-notifications"></i>
                <div class="notify">
                    <span class="heartbit"></span>
                    <span class="point"></span>
                </div>
            </a>
        </li>
        <li><a href="javascript:" title="Inbox"><i class="zmdi zmdi-email"></i></a></li>
        <li><a href="javascript:" title="Contact List"><i class="zmdi zmdi-account-box-phone"></i></a></li>
        <li><a href="javascript:" title="Message"><i class="zmdi zmdi-comments"></i></a></li>
        <li><a href="javascript:" title="Full-screen" class="fullscreen" data-provide="fullscreen"><i class="zmdi zmdi-fullscreen"></i></a>
        </li>
        <li class="power">
            <a href="{{ route('settings') }}" title="Settings" class="js-right-sidebar"><i
                    class="zmdi zmdi-settings zmdi-hc-spin"></i></a>
            <a href="{{ route('logout') }}" title="Logout" class="mega-menu"><i class="zmdi zmdi-power"></i></a>
        </li>
    </ul>
</aside>

<aside class="right_menu">
    <div id="leftsidebar" class="sidebar">
        <div class="menu">
            <ul class="list">
                <li>
                    <div class="user-info m-b-20">
                        <div class="image" title="My Profile">
                            <a href="{{ url('user/profile')}}"><img src="{{ asset('assets/avatar.jpg') }}" alt="User"></a>
                        </div>
                        <div class="detail">
                            <h6 title="My Name" id="name"></h6>
                            <p title="My E-mail" class="m-b-0" id="email"></p>
                            <span title="My Role" id="role"  class="text-primary"></span>
                        </div>
                    </div>
                </li>
                <li class=" @if (Request::segment(1) == 'dashboard') active open @endif ">
                    <a href="{{ route('dashboard') }}">
                        <i class="zmdi zmdi-home"></i><span>Dashboard</span>
                    </a>
                </li>
                <li class=" @if (Request::segment(1) == 'user') active open @endif ">
                    <a href="{{ route('user') }}">
                        <i class="zmdi zmdi-accounts-alt"></i><span>Users</span>
                    </a>
                </li>
                <li class=" @if (Request::segment(1) == 'warehouse') active open @endif ">
                    <a href="{{ route('warehouse') }}">
                        <i class="zmdi zmdi-apps"></i><span>Warehouse</span>
                    </a>
                </li>
                <li class=" @if (Request::segment(1) == 'category') active open @endif ">
                    <a href="{{ route('category') }}">
                        <i class="zmdi zmdi-layers"></i><span>Category</span>
                    </a>
                </li>
                <li class=" @if (Request::segment(1) == 'product') active open @endif ">
                    <a href="{{ route('product') }}">
                        <i class="zmdi zmdi-chart"></i><span>Product</span>
                    </a>
                </li>
                <li class=" @if (Request::segment(1) == 'sales') active open @endif ">
                    <a href="{{ url('sales') }}">
                        <i class="zmdi zmdi-swap-alt"></i><span>Sales</span>
                    </a>
                </li>
                <li class=" @if (Request::segment(2) == 'orders') active open @endif ">
                    <a href="{{ url('orders') }}">
                        <i class="zmdi zmdi-swap-alt"></i><span>Orders</span>
                    </a>
                </li>
                {{-- <li class=" @if (Request::segment(2) == 'reports') active open @endif ">
                    <a href="{{ url('reports') }}">
                        <i class="zmdi zmdi-swap-alt"></i><span>Reports</span>
                    </a>
                </li>
                <li class=" @if (Request::segment(2) == 'expired') active open @endif ">
                    <a href="{{ url('expired') }}">
                        <i class="zmdi zmdi-swap-alt"></i><span>Expired</span>
                    </a>
                </li> --}}
            </ul>
        </div>
    </div>
</aside>


<script>
    $(document).ready(function() {
        userData();
    });

    function userData() {

        jQuery.ajax({
            type: "GET",
            url: "{{ route('user_data') }}",
            success: function(data) {
                var user = data.data;
                $("#name").html(user.name);
                $("#email").html(user.email);
                $("#role").html(user.role);
            }
        });
    }
</script>
