    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="{{ asset('asset/picture-default/img-adminlte/avatar5.png') }}" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p>{{ Auth::user()->name }}</p>
            <a href="{{ route('cms.profile') }}"><i class="fa fa-circle text-success"></i> Profile</a>
          </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
          <li class="header">MAIN NAVIGATION</li>
          <li><a href="{{ route('cms.dashboard') }}">
            <i class="fa fa-th"></i> <span>Dashboard</span>
          </a></li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-group "></i> <span>Accounts</span>
              <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
            </a>
            <ul class="treeview-menu">
              <li><a href="{{ route('cms.account.list') }}">
                <i class="fa fa-circle-o"></i> List
              </a></li>
              <li><a href="{{ route('cms.history.list') }}">
                <i class="fa fa-circle-o"></i> History  
              </a></li>
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-group "></i> <span>Contents</span>
              <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
            </a>
            <ul class="treeview-menu">
              <li><a href="{{ route('cms.content.index', ['index' => 'banner']) }}">
                <i class="fa fa-circle-o"></i> Banner
              </a></li>
            </ul>
          </li>
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>