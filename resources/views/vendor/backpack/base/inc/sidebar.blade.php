@if (Auth::check())
	@if (Auth::user()->id==2)
	<!-- Left side column. contains the sidebar -->
	<aside class="main-sidebar">
		<!-- sidebar: style can be found in sidebar.less -->
		<section class="sidebar">
			<!-- Sidebar user panel -->
			<div class="user-panel">
				<div class="pull-left image">
					<img src="http://placehold.it/160x160/00a65a/ffffff/&text={{ Auth::user()->name[0] }}" class="img-circle" alt="User Image">
				</div>
				<div class="pull-left info">
					<p>{{ Auth::user()->name }}</p>
					<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
				</div>
			</div>
			<!-- sidebar menu: : style can be found in sidebar.less -->
			<ul class="sidebar-menu">
				<li class="header">ADMINISTRATION</li>
				<!-- ================================================ -->
				<!-- ==== Recommended place for admin menu items ==== -->
				<!-- ================================================ -->
				<li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>

				<li><a href="{{ url('admin/businessfix') }}"><i class="fa fa-table"></i>Business List</a></li>	
				<li><a href="{{ url('admin/logout') }}"><i class="fa fa-sign-out"></i> <span>Logout</span></a></li>
			</ul>
		</section>
		<!-- /.sidebar -->
	</aside>
	@else
	<!-- Left side column. contains the sidebar -->
	<aside class="main-sidebar">
		<!-- sidebar: style can be found in sidebar.less -->
		<section class="sidebar">
			<!-- Sidebar user panel -->
			<div class="user-panel">
				<div class="pull-left image">
					<img src="http://placehold.it/160x160/00a65a/ffffff/&text={{ Auth::user()->name[0] }}" class="img-circle" alt="User Image">
				</div>
				<div class="pull-left info">
					<p>{{ Auth::user()->name }}</p>
					<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
				</div>
			</div>
			<!-- sidebar menu: : style can be found in sidebar.less -->
			<ul class="sidebar-menu">
				<li class="header">ADMINISTRATION</li>
				<!-- ================================================ -->
				<!-- ==== Recommended place for admin menu items ==== -->
				<!-- ================================================ -->
				<li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>

				<li class="treeview">
					<a href="#"><i class="fa fa-table"></i> <span>Business</span> <i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						<!--<li><a href="{{ url('admin/ad') }}"><i class="fa fa-table"></i>Ad List</a></li>-->
						<li><a href="{{ url('admin/business') }}"><i class="fa fa-table"></i>Business List</a></li>
						<li><a href="{{ url('admin/category') }}"><i class="fa fa-folder"></i> Categories & Keywords</a></li>
						<!--<li><a href="{{ url('admin/subcategory') }}"><i class="fa fa-list"></i> SubCategories</a></li>-->
						<!--<li><a href="{{ url('admin/picture') }}"><i class="fa fa-picture-o"></i> Pictures</a></li>-->
						<li><a href="{{ url('admin/business-image') }}"><i class="fa fa-picture-o"></i> Business Images</a></li>
						<li><a href="{{ url('admin/business-image-request') }}"><i class="fa fa-picture-o"></i> Business Image Requests</a></li>
						<li><a href="{{ url('admin/business-claim-request') }}"><i class="fa fa-link"></i> Business Claim Requests</a></li>
						<li><a href="{{ url('admin/business-scam') }}"><i class="fa fa-warning"></i> Business Scam Reports</a></li>
						<li><a href="{{ url('admin/business-info') }}"><i class="fa fa-pie-chart"></i> Business Info</a></li>
						<!--<li><a href="{{ url('admin/ad_type') }}"><i class="fa fa-cog"></i> <span>Type</span></a></li>-->
					</ul>
				</li>

				<li class="treeview">
					<a href="#"><i class="fa fa-users"></i> <span>Users</span> <i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						<li><a href="{{ url('admin/user') }}"><i class="fa fa-table"></i> List</a></li>
						<li><a href="{{ url('admin/gender') }}"><i class="fa fa-venus-mars"></i> Gender</a></li>
						<li><a href="{{ url('admin/user-interest') }}"><i class="fa fa-puzzle-piece"></i> Interest </a></li>
					</ul>
				</li>

				<li class="treeview">
					<a href="#"><i class="fa fa-usd"></i> <span>Payments</span> <i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						<li><a href="{{ url('admin/payment-report') }}"><i class="fa fa-table"></i> <span>Report</span></a></li>
						<li><a href="{{ url('admin/payment-settings') }}"><i class="fa fa-table"></i> <span>Settings</span></a></li>
						<!--<li><a href="{{ url('admin/payment') }}"><i class="fa fa-table"></i> <span>List</span></a></li>
						<li><a href="{{ url('admin/pack') }}"><i class="fa fa-pie-chart"></i> <span>Packs</span></a></li>-->
					</ul>
				</li>

				<li><a href="{{ url('admin/advertising') }}"><i class="fa fa-life-ring"></i> <span>Advertising</span></a></li>
				<li><a href="{{ url('admin/offers') }}"><i class="fa fa-gift"></i> <span>Offer</span></a></li>
				<li class="treeview">
					<a href="#"><i class="fa fa-globe"></i> <span>International</span> <i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						<li><a href="{{ url('admin/country') }}"><i class="fa fa-circle-o"></i> Countries</a></li>
						<li><a href="{{ url('admin/subadmin1') }}"><i class="fa fa-circle-o"></i> Location</a></li>
						<li><a href="{{ url('admin/city') }}"><i class="fa fa-circle-o"></i> City</a></li>
						<li><a href="{{ url('admin/currency') }}"><i class="fa fa-circle-o"></i> Currencies</a></li>
						<li class="treeview">
							<a href="#"><i class="fa fa-globe"></i> <span>Translations</span> <i class="fa fa-angle-left pull-right"></i></a>
							<ul class="treeview-menu">
								<li><a href="{{ url('admin/language') }}"><i class="fa fa-circle-o"></i> Languages</a></li>
								<!--<li><a href="{{ url('admin/language/texts') }}"><i class="fa fa-language"></i> Site texts</a></li>-->
							</ul>
						</li>
						<!--<li><a href="{{ url('admin/time_zone') }}"><i class="fa fa-circle-o"></i> TimeZones</a></li>-->
					</ul>
				</li>
				<li class="treeview">
					<a href="#"><i class="fa fa-gift"></i> <span>Events</span> <i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						<li><a href="{{ url('admin/event') }}"><i class="fa fa-table"></i> List</a></li>
						<li><a href="{{ url('admin/event_type') }}"><i class="fa fa-cog"></i> Type</a></li>
						<li><a href="{{ url('admin/event_topic') }}"><i class="fa fa-cog"></i> <span>Topic</span></a></li>
					</ul>
				</li>
				<!--<li><a href="{{ url('admin/deal') }}"><i class="fa fa-money"></i> <span>Deals</span></a></li>-->
				<li><a href="{{ url('admin/cms') }}"><i class="fa fa-file"></i> <span>Cms</span></a></li> 
				<li><a href="{{ url('admin/elfinder') }}"><i class="fa fa-files-o"></i> <span>File manager</span></a></li>
				<li><a href="{{ url('admin/setting') }}"><i class="fa fa-cog"></i> <span>Settings</span></a></li>
				<!--<li><a href="{{ url('admin/blacklist') }}"><i class="fa fa-ban"></i> Blacklist</a></li>
				<li><a href="{{ url('admin/report_type') }}"><i class="fa fa-cog"></i> <span>Report Types</span></a></li>
				<li><a href="{{ url('admin/log') }}"><i class="fa fa-terminal"></i> <span>Logs</span></a></li>
				<li><a href="{{ url('admin/backup') }}"><i class="fa fa-hdd-o"></i> <span>Backups</span></a></li>-->


				<!-- ======================================= -->
				<li class="header">USER</li>
				<li><a href="{{ url('admin/account') }}"><i class="fa fa-sign-out"></i> <span>My account</span></a></li>
				<li><a href="{{ url('admin/logout') }}"><i class="fa fa-sign-out"></i> <span>Logout</span></a></li>
			</ul>
		</section>
		<!-- /.sidebar -->
	</aside>
	@endif
@endif
