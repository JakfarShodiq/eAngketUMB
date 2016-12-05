<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>E-Angket Universitas Mercubuana | Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{ URL::asset('bootstrap/css/bootstrap.min.css') }}">
    <!-- Star RATING -->
    <link rel="stylesheet" href="{{ URL::asset('star-rating\star-rating.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ URL::asset('dist/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ URL::asset('dist/css/skins/_all-skins.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/iCheck/flat/blue.css') }}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/jvectormap/jquery-jvectormap-1.2.2.css') }}">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/datepicker/datepicker3.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('plugins\datatables\dataTables.jqueryui.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('plugins\datatables\jquery.dataTables.min.1.10.12.css') }}">
    <link rel="stylesheet"
          href="{{ URL::asset('plugins\datatables\extensions\RawReorder\rowReorder.dataTables.min.css') }}">
    <link rel="stylesheet"
          href="{{ URL::asset('plugins\datatables\extensions\Responsive\responsive.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('plugins\datatables\select.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('plugins/timepicker/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('plugins\datatables\jquery.dataTables_themeroller.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('plugins\select2\select2.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('plugins\datatables\dataTables.bootstrap.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/datepicker/datepicker3.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js') }}"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js') }}"></script>
    <!-- jQuery 1.12.3 -->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <script src="{{ URL::asset('plugins\jQuery\jquery-1.12.3.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ URL::asset('plugins\select2\select2.full.min.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <!-- Datatables -->
    <script src="{{ URL::asset('plugins\datatables\jquery.dataTables.min.1.10.12.js') }}"></script>
    <script src="{{ URL::asset('plugins\datatables\extensions\RawReorder\dataTables.rowReorder.min.js') }}"></script>
    <script src="{{ URL::asset('plugins\datatables\extensions\Responsive\dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('plugins\datatables\dataTables.select.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.6 -->
    <script src="{{ URL::asset('bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <!-- Sparkline -->
    <script src="{{ URL::asset('plugins/sparkline/jquery.sparkline.min.js') }}"></script>
    <!-- jvectormap -->
    <script src="{{ URL::asset('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ URL::asset('plugins/knob/jquery.knob.js') }}"></script>
    <!-- daterangepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
    <script src="{{ URL::asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- datepicker -->
    <script src="{{ URL::asset('plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{ URL::asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
    <!-- Slimscroll -->
    <script src="{{ URL::asset('plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ URL::asset('plugins/fastclick/fastclick.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ URL::asset('dist/js/app.min.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <!-- AdminLTE for demo purposes -->
    <script src="{{ URL::asset('dist/js/demo.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
    <script src="{{ URL::asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- bootstrap datepicker -->
    <script src="{{ URL::asset('plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <!-- bootstrap color picker -->
    <script src="{{ URL::asset('plugins/colorpicker/bootstrap-colorpicker.min.js') }}"></script>
    <!-- bootstrap time picker -->
    <script src="{{ URL::asset('plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
    <!-- Star Rating -->
    <script src="{{ URL::asset('star-rating\star-rating.min.js') }}"></script>


</head>
<body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="/home" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><img src="{{ URL::asset('umb.png') }}" height="50px" width="50px"></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg">E-Angket<b>UMB</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Messages: style can be found in dropdown.less-->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{ URL::asset('user.png') }}" class="user-image" alt="User Image">
                            <span class="hidden-xs">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="{{ URL::asset('user.png') }}" class="img-circle" alt="User Image">

                                <p>
                                    {{ Auth::user()->name }} - {{ Auth::user()->role->name }}
                                    <small>Member
                                        since {{ date(' d M Y', strtotime(Auth::user()->join_date )) }}</small>
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ url('/logout') }}" class="btn btn-default btn-flat"
                                       onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                </div>

                                <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                    <!-- Control Sidebar Toggle Button -->
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="header">MAIN NAVIGATION</li>
                @if(in_array(Auth::user()->role->name,['LPPM','KAPRODI','DEKAN','Administrator']))
                    <li class="treeview {{ in_array(Request::path(),array('categories','kelas','jenis_pertanyaan','pertanyaan')) ? 'active' : '' }}">
                        <a href="/">
                            <i class="fa fa-file-text"></i> <span>Master Angket</span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="{{ Request::is('categories') ? 'active' : '' }}"><a
                                        href="{{ route('categories.index') }}"><i class="fa fa-tag"></i>Kategori
                                    Pelayanan</a></li>
                            <li class="{{ Request::is('kelas') ? 'active' : '' }}"><a href="{{ route('kelas.index') }}"><i
                                            class="fa fa-university"></i>Jenis Kelas</a></li>
                            <li class="{{ Request::is('jenis_pertanyaan') ? 'active' : '' }}"><a
                                        href="{{ route('jenis_pertanyaan.index') }}"><i class="fa fa-external-link"></i>Kategori
                                    Pertanyaan</a></li>
                            <li class="{{ Request::is('pertanyaan') ? 'active' : '' }}"><a
                                        href="{{ route('pertanyaan.index') }}"><i class="fa fa-edit"></i>Master
                                    Pertanyaan</a></li>
                        </ul>
                    </li>
                @endif
                <li class="{{ Request::is('user') ? 'active' : '' }}">
                    <a href="{{ route('user.index') }}">
                        <i class="fa fa-user"></i> <span>Profile</span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                </li>
                <li class="treeview {{ in_array(Request::path(),array('jadwal','matakuliah')) ? 'active' : '' }}">
                    <a href="/">
                        <i class="fa fa-list-alt"></i> <span>Jadwal</span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        @if(!in_array(Auth::user()->role->name,['Mahasiswa','Dosen']))
                            <li class="{{ Request::is('matakuliah') ? 'active' : '' }}"><a
                                        href="{{ route('matakuliah.index') }}"><i class="fa fa-calendar-times-o"></i>Mata
                                    Kuliah</a></li>
                            <li class="{{ Request::is('jadwal') ? 'active' : '' }}"><a
                                        href="{{ route('jadwal.index') }}"><i class="fa fa-calendar-check-o"></i>Jadwal
                                    Mata
                                    Kuliah</a></li>
                        @endif
                        @if(Auth::user()->role->name == "Mahasiswa")
                            <li class="{{ Request::is('jadwal-mhs') ? 'active' : '' }}"><a
                                        href="{{ route('jadwal-mhs.index') }}"><i class="fa fa-calendar-check-o"></i>Enroll
                                    Jadwal</a></li>
                        @endif
                    </ul>
                </li>

                @if(in_array(Auth::user()->role->name,['LPPM','KAPRODI','Administrator','POP','BJM']))
                    <li class="treeview {{ in_array(Request::path(),array('jadwal','matakuliah')) ? 'active' : '' }}">
                        <a href="/">
                            <i class="fa fa-paste "></i> <span>Hasil Angket</span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            @if(in_array(Auth::user()->role->name,['SDM','KAPRODI','Administrator']))
                                <li class="{{ Request::is('report') ? 'active' : '' }}"><a
                                            href="{{ route('report.index') }}"><i class="fa fa-building"></i>Fasilitas
                                        Umum</a>
                                </li>
                            @endif
                            @if(in_array(Auth::user()->role->name,['POP','BJM','Administrator']))
                                <li class="{{ Request::is('report') ? 'active' : '' }}"><a
                                            href="{{ route('report.perf') }}"><i class="fa fa-users"></i>Performa Dosen</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if(Auth::user()->role->name == "Mahasiswa")
                    <li class="{{ Request::is('angket') ? 'active' : '' }}">
                        <a href="{{ route('angket.index') }}">
                            <i class="fa fa-list-ol"></i> <span>Angket</span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                    </li>
                @endif

                @if(!in_array(Auth::user()->role->name,['Mahasiswa','Dosen','DEKAN','BMGS']))
                    <li class="{{ Request::is('issue') ? 'active' : '' }}">
                        <a href="{{ route('issue.index') }}">
                            <i class="fa fa-stack-overflow"></i> <span>Issue</span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                    </li>
                @endif

                @if(!in_array(Auth::user()->role->name,['Mahasiswa','Dosen']))
                    <li class="{{ Request::is('ticket') ? 'active' : '' }}">
                        <a href="{{ route('ticket.index') }}">
                            <i class="fa fa-ticket"></i> <span>Ticket</span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                    </li>
                @endif

                @if(Auth::user()->role->name == "Dosen")
                    <li class="{{ Request::is('dosen') ? 'active' : '' }}">
                        <a href="{{ route('dosen.index') }}">
                            <i class="fa fa-star-half-empty"></i> <span>Penilaian Dosen</span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                    </li>
                @endif

                @if(in_array(Auth::user()->role->name,['Administrator','LPPM']))
                    <li class="{{ Request::is('pengumuman') ? 'active' : '' }}">
                        <a href="{{ route('pengumuman.index') }}">
                            <i class="fa fa-feed"></i> <span>Pengumuman</span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                    </li>
                @endif
                @if(in_array(Auth::user()->role->name,['Administrator']))
                    <li class="treeview {{ in_array(Request::path(),array('user-mgt','matakuliah')) ? 'active' : '' }}">
                        <a href="/">
                            <i class="fa fa-gear"></i> <span>Settings</span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="{{ Request::is('roles') ? 'active' : '' }}"><a
                                        href="{{ route('roles.index') }}"><i class="fa fa-key"></i>Roles</a>
                            </li>
                            <li class="{{ Request::is('user-mgt') ? 'active' : '' }}"><a
                                        href="{{ route('user.role') }}"><i class="fa fa-unlock-alt"></i>User Management</a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                @yield('header')
                <small>
                    @yield('submenu')
                </small>
            </h1>

        </section>

        <!-- Main content -->
    @yield('content')
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0
        </div>
        <strong>Copyright &copy; 2016 Kelompok 2 PPSI Menteng</strong>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
            <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
            <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <!-- Home tab content -->
            <div class="tab-pane" id="control-sidebar-home-tab">
                <h3 class="control-sidebar-heading">Recent Activity</h3>
                <ul class="control-sidebar-menu">
                    <li>
                        <a href="javascript:void(0)">
                            <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                                <p>Will be 23 on April 24th</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <i class="menu-icon fa fa-user bg-yellow"></i>

                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                                <p>New phone +1(800)555-1234</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                                <p>nora@example.com</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <i class="menu-icon fa fa-file-code-o bg-green"></i>

                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                                <p>Execution time 5 seconds</p>
                            </div>
                        </a>
                    </li>
                </ul>
                <!-- /.control-sidebar-menu -->

                <h3 class="control-sidebar-heading">Tasks Progress</h3>
                <ul class="control-sidebar-menu">
                    <li>
                        <a href="javascript:void(0)">
                            <h4 class="control-sidebar-subheading">
                                Custom Template Design
                                <span class="label label-danger pull-right">70%</span>
                            </h4>

                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <h4 class="control-sidebar-subheading">
                                Update Resume
                                <span class="label label-success pull-right">95%</span>
                            </h4>

                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <h4 class="control-sidebar-subheading">
                                Laravel Integration
                                <span class="label label-warning pull-right">50%</span>
                            </h4>

                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <h4 class="control-sidebar-subheading">
                                Back End Framework
                                <span class="label label-primary pull-right">68%</span>
                            </h4>

                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                            </div>
                        </a>
                    </li>
                </ul>
                <!-- /.control-sidebar-menu -->

            </div>
            <!-- /.tab-pane -->
            <!-- Stats tab content -->
            <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
            <!-- /.tab-pane -->
            <!-- Settings tab content -->
            <div class="tab-pane" id="control-sidebar-settings-tab">
                <form method="post">
                    <h3 class="control-sidebar-heading">General Settings</h3>

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Report panel usage
                            <input type="checkbox" class="pull-right" checked>
                        </label>

                        <p>
                            Some information about this general settings option
                        </p>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Allow mail redirect
                            <input type="checkbox" class="pull-right" checked>
                        </label>

                        <p>
                            Other sets of options are available
                        </p>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Expose author name in posts
                            <input type="checkbox" class="pull-right" checked>
                        </label>

                        <p>
                            Allow the user to show his name in blog posts
                        </p>
                    </div>
                    <!-- /.form-group -->

                    <h3 class="control-sidebar-heading">Chat Settings</h3>

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Show me as online
                            <input type="checkbox" class="pull-right" checked>
                        </label>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Turn off notifications
                            <input type="checkbox" class="pull-right">
                        </label>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Delete chat history
                            <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                        </label>
                    </div>
                    <!-- /.form-group -->
                </form>
            </div>
            <!-- /.tab-pane -->
        </div>
    </aside>
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
@yield('script')
</body>
</html>
