<?php 

$setting = App\Models\Settings::where('type', 'logo')->first();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="robots" content="noindex, nofollow">
    <title>Admin Dashboard</title>

    <link rel="shortcut icon" type="image/x-icon" href=" admin/img/favicon.png">

    <link rel="stylesheet" href="{{ asset('admin/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('admin/css/animate.css') }}">

    
    <link rel="stylesheet" href="{{ asset('admin/css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/fontawesome.min.css') }}">

    <link rel="stylesheet" href="{{ asset('admin/css/all.min.css') }}">
    
    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/stocks.css') }}">
    <script src="{{ asset('admin/js/jquery-3.6.0.min.js') }}"></script>


    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

    <style>
        .customizer-links {
            display: none;
        }

        .paging_numbers span {
            display: flex;
            gap: 5px;
        }
        .paginate_button{
            background: #f3eded;
            padding: 10px;
            border-radius: 10px;
        }

        .paginate_button.current{
            background: rgba(254, 159, 67, 0.08);
            /* padding: 10px;
            border-radius: 10px; */
        }
    </style>

</head>

<body>

    <div class="main-wrapper">
        <div class="header">

            <div class="header-left active">
                @if($setting && $setting->value)
                    <a href="{{ route('admin.home') }}" class="logo logo-normal">
                        <img src="{{ asset($setting->value) }}" alt>
                    </a>
                    <a href="{{ route('admin.home') }}" class="logo logo-white">
                        <img src="{{ asset($setting->value) }}" alt>
                    </a>
                    <a href="{{ route('admin.home') }}" class="logo-small">
                        <img src="{{ asset($setting->value) }}" alt>
                    </a>
                @else
                    <a href="{{ route('admin.home') }}" class="logo logo-normal">
                        <img src="{{ asset('logo-light.png') }}" alt>
                    </a>
                    <a href="{{ route('admin.home') }}" class="logo logo-white">
                        <img src="{{ asset('logo-light.png') }}" alt>
                    </a>
                    <a href="{{ route('admin.home') }}" class="logo-small">
                        <img src="{{ asset('logo-light.png') }}" alt>
                    </a>
                @endif
                <a id="toggle_btn" href="javascript:void(0);">
                    <i data-feather="chevrons-left" class="feather-16"></i>
                </a>
            </div>

            <a id="mobile_btn" class="mobile_btn" href="#sidebar">
                <span class="bar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>

            <ul class="nav user-menu">

                <li class="nav-item nav-searchinputs">
                    <div class="top-nav-search">
                        <a href="javascript:void(0);" class="responsive-search">
                            <i class="fa fa-search"></i>
                        </a>
                        <form action="#">
                            <div class="searchinputs">
                                <input type="text" placeholder="Search">
                                <div class="search-addon">
                                    <span><i data-feather="search" class="feather-14"></i></span>
                                </div>
                            </div>

                        </form>
                    </div>
                </li>

 

                <li class="nav-item nav-item-box">
                    <a href="javascript:void(0);" id="btnFullscreen">
                        <i data-feather="maximize"></i>
                    </a>
                </li>
             

               
                <li class="nav-item dropdown has-arrow main-drop">
                    <a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
                        <span class="user-info">
                            <span class="user-letter">
                                <img src="admin/img/profiles/avator1.jpg" alt class="img-fluid">
                            </span>
                            <span class="user-detail">
                                <span class="user-name">{{ Auth::user()->name }}</span>
                                <span class="user-role">Super Admin</span>
                            </span>
                        </span>
                    </a>
                    <div class="dropdown-menu menu-drop-user">
                        <div class="profilename">
                            <div class="profileset">
                                <span class="user-img"><img src=" admin/img/profiles/avator1.jpg" alt>
                                    <span class="status online"></span></span>
                                <div class="profilesets">
                                    <h6>{{ Auth::user()->name }}</h6>
                                    <h5>Super Admin</h5>
                                </div>
                            </div>
                            <hr class="m-0">
                            <a class="dropdown-item" href="{{ route('admin.profile') }}"> <i class="me-2" data-feather="user"></i> My
                                Profile</a>
                            <a class="dropdown-item" href="{{ route('settings.index') }}"><i class="me-2"
                                    data-feather="settings"></i>Settings</a>
                            <hr class="m-0">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                          document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            
                        </div>
                    </div>
                </li>
            </ul>


            <div class="dropdown mobile-user-menu">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" height="20" width="7.5" viewBox="0 0 192 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#ff9f43" d="M96 184c39.8 0 72 32.2 72 72s-32.2 72-72 72-72-32.2-72-72 32.2-72 72-72zM24 80c0 39.8 32.2 72 72 72s72-32.2 72-72S135.8 8 96 8 24 40.2 24 80zm0 352c0 39.8 32.2 72 72 72s72-32.2 72-72-32.2-72-72-72-72 32.2-72 72z"/></svg>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ route('admin.profile') }}">My Profile</a>
                    <a class="dropdown-item" href="{{ route('settings.index') }}">Settings</a>
                    <a class="dropdown-item" href="{{ route('logout') }}"  onclick="event.preventDefault();
                                          document.getElementById('logout-form').submit();">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>

        </div>


        <div class="sidebar" id="sidebar" style="overflow-y: scroll">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li class="submenu-open">
                            <h6 class="submenu-hdr">Main</h6>
                            <ul>
                                <li class="{{ request()->is('home') ? 'active' : '' }}">
                                    <a href="{{ route('admin.home') }}"><i
                                            data-feather="grid"></i><span>Dashboard</span></a>
                                </li>
                                <li class="{{ request()->is('customers') ? 'active' : '' }}">
                                    <a href="{{ route('admin.customers') }}"><i
                                            data-feather="users"></i><span>Customers</span></a>
                                </li>
                            </ul>
                        </li>
                        <li class="submenu-open  ">
                            <h6 class="submenu-hdr">Products</h6>
                            <ul>
                                <li class="{{ request()->is('product') ? 'active' : '' }}"><a
                                        href="{{ route('product.index') }}"><i
                                            data-feather="box"></i><span>Products</span></a></li>
                                <li class="{{ request()->is('product_stocks') ? 'active' : '' }}"><a
                                        href="{{ route('product.stocks') }}"><i
                                            data-feather="package"></i><span>Product Stocks</span></a></li>
                                <li class="{{ request()->is('category') ? 'active' : '' }}"><a
                                        href="{{ route('category.index') }}"><i
                                            data-feather="codepen"></i><span>Category</span></a>
                                </li>
                                <li class="{{ request()->is('sub_category') ? 'active' : '' }}"><a
                                        href="{{ route('sub_category.index') }}"><i
                                            data-feather="speaker"></i><span>Sub
                                            Category</span></a></li>
                                <li class="{{ request()->is('unit') ? 'active' : '' }}"><a
                                        href="{{ route('unit.index') }}"><i data-feather="tag"></i><span>Unit
                                            Types</span></a>
                                </li>
                               

                                <li class="submenu">
                                    <a href="javascript:void(0);"><i
                                            data-feather="shopping-cart"></i><span>Orders</span><span
                                            class="menu-arrow"></span></a>
                                    <ul>
                                        <li><a href="{{ route('orders.pending') }}">Pending Orders</a></li>
                                        <li><a href="{{ route('orders.completed') }}">Completed Orders</a></li>
                                        <li><a href="{{ route('orders.rejected') }}">Rejected Orders</a></li>
                                        <li><a href="{{ route('orders.index') }}">All Orders</a></li>
                                    </ul>
                                </li>
                                <li class="{{ request()->is('blog') ? 'active' : '' }}">
                                    <a href="{{ route('blog.index') }}"><i
                                            data-feather="align-left"></i><span>Blogs</span></a>
                                </li>
                                <li class="{{ request()->is('sliders') ? 'active' : '' }}">
                                    <a href="{{ route('admin.sliders') }}"><i
                                            data-feather="align-left"></i><span>Slider</span></a>
                                </li>
                                <!-- <li class="{{ request()->is('admin/profile') ? 'active' : '' }}">
                                    <a href="{{ route('admin.profile') }}">
                                    <i data-feather="user"></i>
                                    <span>Profile</span></a></li>
                                <li class="{{ request()->is('settings') ? 'active' : '' }}">
                                    <a href="{{ route('settings.index') }}"><i
                                            data-feather="settings"></i><span>Settings</span></a>
                                </li> -->
                            </ul>
                            
                         
                           
                        
                           
                           

                            
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @yield('content')

    <script src="{{ asset('admin/js/script.js') }}"></script>


    <script src="{{ asset('admin/js/feather.min.js') }}"></script>

    <script src="{{ asset('admin/js/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('admin/js/jquery.dataTables.min.js') }}"></script>

    <script src="{{ asset('admin/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('admin/js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('admin/js/chart-data.js') }}"></script>

    <script src="{{ asset('admin/js/fileupload.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('button[type="submit"]').click(function() {
                var buttonEl = $(this);
                buttonEl.parents('form').submit();
                buttonEl.prop('disabled', true);
                return true;
            });
            // configure ckeditor
            CKEDITOR.replace('groupContent', {
                filebrowserUploadMethod: 'form'
            });
            $('form').submit(function() {
                for (instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].updateElement();
                }
            });

        });
    </script>


    <script>
        function createSlug(data) {
            const slugify = str =>
                str
                .toLowerCase()
                .trim()
                .replace(/[^\w\s-]/g, '')
                .replace(/[\s_-]+/g, '-')
                .replace(/^-+|-+$/g, '');

            var val = slugify(data);
            document.getElementById('slug').value = val;
        }
    </script>
</body>

</html>
