<aside>
	<div class="inner-box">
		<div class="user-panel-sidebar">
			
			<div class="collapse-box">
				<h5 class="collapse-title no-border">
					@lang('global.My Account')&nbsp;
					<a href="#MyClassified" data-toggle="collapse" class="pull-right"><i class="fa fa-angle-down"></i></a>
				</h5>
				<div class="panel-collapse collapse in" id="MyClassified">
					<ul class="acc-list">
						<li>
							<a{!! (Request::segment(3)=='') ? ' class="active"' : '' !!} href="{{ lurl('account') }}">
							<i class="icon-home"></i> @lang('global.Dashboard')
							</a>
						</li>
						<li>
							<a{!! (Request::segment(3)=='edit') ? ' class="active"' : '' !!} href="{{ lurl('account/edit') }}">
								<i class="icon-docs"></i> @lang('global.Edit Profile')&nbsp;
							</a>
						</li>
						<li>
							<a{!! (Request::segment(3)=='friends-lists') ? ' class="active"' : '' !!} href="{{ lurl('friends-lists/'.auth()->user()->id) }}">
								<i class="icon-docs"></i> @lang('global.Friends')&nbsp;
								<span class="badge">{{ isset($friend_count) ? $friend_count : 0 }}</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
			<!-- /.collapse-box  -->
			
			<div class="collapse-box">
				<h5 class="collapse-title">
					@lang('global.My Events')&nbsp;
					<a href="#MyAds" data-toggle="collapse" class="pull-right"><i class="fa fa-angle-down"></i></a>
				</h5>
				<div class="panel-collapse collapse in" id="MyAds">
					<ul class="acc-list">
					
						<li>
							<a{!! (Request::segment(3)=='myevents') ? ' class="active"' : '' !!} href="{{ lurl('account/myevents') }}">
								<i class="icon-docs"></i> @lang('global.Events List')&nbsp;
								<span class="badge">{{ isset($event_count) ? $event_count : 0 }}</span>
							</a>
						</li>
						<li>
							<a{!! (Request::segment(3)=='event') ? ' class="active"' : '' !!} href="{{ lurl('account/event/graph') }}">
							<i class="icon-cancel-circled "></i> @lang('global.Events Activity Graph')
							</a>
						</li>
					</ul>
				</div>
			</div>
			<!-- /.collapse-box  -->
			
			<div class="collapse-box">
				<h5 class="collapse-title">
					@lang('global.My Orders')&nbsp;
					<a href="#MyBiz" data-toggle="collapse" class="pull-right"><i class="fa fa-angle-down"></i></a>
				</h5>
				<div class="panel-collapse collapse in" id="MyBiz">
					<ul class="acc-list">
						<li>
							<a{!! (Request::segment(3)=='mybusinessorders') ? ' class="active"' : '' !!} href="{{ lurl('account/mybusinessorders') }}">
								<i class="icon-docs"></i> @lang('global.Business Bookings')
							</a>
						</li>
						<li>
							<a{!! (Request::segment(3)=='myeventorders') ? ' class="active"' : '' !!} href="{{ lurl('account/myeventorders') }}">
								<i class="icon-docs"></i> @lang('global.Event Bookings')
							</a>
						</li>
						<li>
							<a{!! (Request::segment(3)=='mycertificateorders') ? ' class="active"' : '' !!} href="{{ lurl('account/mycertificateorders') }}">
								<i class="icon-docs"></i> @lang('global.Gift Certificates')
							</a>
						</li>
					</ul>
				</div>
			</div>
			
			<!-- /.collapse-box  -->
			
		</div>
	</div>
	<!-- /.inner-box  -->
</aside>
