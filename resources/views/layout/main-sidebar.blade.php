<!-- main-sidebar -->
		<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
		<aside class="app-sidebar sidebar-scroll">
			<div class="main-sidebar-header active">
				<a class="desktop-logo logo-light active" href="{{ url('/' . $page='index') }}"><img src="{{URL::asset('assets/img/brand/logo.png')}}" class="main-logo" alt="logo"></a>
				<a class="desktop-logo logo-dark active" href="{{ url('/' . $page='index') }}"><img src="{{URL::asset('assets/img/brand/logo-white.png')}}" class="main-logo dark-theme" alt="logo"></a>
				<a class="logo-icon mobile-logo icon-light active" href="{{ url('/' . $page='index') }}"><img src="{{URL::asset('assets/img/brand/favicon.png')}}" class="logo-icon" alt="logo"></a>
				<a class="logo-icon mobile-logo icon-dark active" href="{{ url('/' . $page='index') }}"><img src="{{URL::asset('assets/img/brand/favicon-white.png')}}" class="logo-icon dark-theme" alt="logo"></a>
			</div>
			<div class="main-sidemenu">
				<div class="app-sidebar__user clearfix">
					<div class="dropdown user-pro-body">
						<div class="">
							<img alt="user-img" class="avatar avatar-xl brround" src="{{URL::asset('assets/img/faces/6.jpg')}}"><span class="avatar-status profile-status bg-green"></span>
						</div>
						<div class="user-info">
							@if (auth()->check())
								<h4 class="font-weight-semibold mt-3 mb-0">{{ auth()->user()->name }}</h4>
								<span class="mb-0 text-muted">{{ auth()->user()->email }}</span>
							@endif
						</div>
					</div>
				</div>
				<ul class="side-menu">
					<li class="side-item side-item-category">برنامج الفواتير</li>
					<li class="slide">
						<a class="side-menu__item" href="{{ url('/' . $page='admin') }}"> <i class="fa fa-dashboard text-dark fa-1x"></i> <span class="side-menu__label mr-1">الرئيسية</span></a>
					</li>

					@can('الفواتير')
						<li class="side-item side-item-category">الفواتير</li>
						<li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}"><i class="fa fa-th-list text-dark fa-1x"></i> <span class="side-menu__label mr-1">الفواتير</span><i class="angle fe fe-chevron-down"></i></a>
							<ul class="slide-menu">

								@can('قائمة الفواتير')
									<li><a class="slide-item" href="{{ adminUrl($page='invoices') }}">قائمة الفواتير</a></li>
								@endcan

								@can('الفواتير المدفوعة')
									<li><a class="slide-item" href="{{ adminUrl($page='invoicesStatus/1') }}">فواتير مدفوعة</a></li>
								@endcan

								@can('الفواتير الغير مدفوعة')
									<li><a class="slide-item" href="{{ adminUrl($page='invoicesStatus/2') }}">فواتير غير مدفوعة</a></li>
								@endcan

								@can('الفواتير المدفوعة جزئيا')
									<li><a class="slide-item" href="{{ adminUrl($page='invoicesStatus/3') }}">فواتير مدفوعة جزئيا</a></li>
								@endcan

								@can('أرشيف الفواتير')
									<li><a class="slide-item" href="{{ adminUrl($page='invoicesArchived') }}">أرشيف الفواتير</a></li>
								@endcan
							</ul>
						</li>
					@endcan

					@can('التقارير')
						<li class="side-item side-item-category">التقارير</li>
						<li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}"><i class="fa fa-bar-chart text-dark fa-1x"></i><span class="side-menu__label mr-1">التقارير</span><i class="angle fe fe-chevron-down"></i></a>
							<ul class="slide-menu">

								@can('تقرير الفواتير')
									<li><a class="slide-item" href="{{ adminUrl($page='invoices_report') }}">تقارير الفواتير</a></li>
								@endcan

								@can('تقرير العملاء')
									<li><a class="slide-item" href="{{ adminUrl($page='customers_report') }}">تقارير العملاء</a></li>
								@endcan
							</ul>
						</li>
					@endcan

					@can('المستخدمين')
						<li class="side-item side-item-category">المستخدمين</li>
						<li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}"><i class="fa fa-users text-dark fa-1x"></i><span class="side-menu__label mr-1">المستخدمين</span><i class="angle fe fe-chevron-down"></i></a>
							<ul class="slide-menu">

								@can('قائمة المستخدمين')
									<li><a class="slide-item" href="{{ adminUrl($page='users') }}">قائمة المستخدمين</a></li>
								@endcan
								@can('صلاحيات المستخدمين')
									<li><a class="slide-item" href="{{ adminUrl($page='roles') }}">صلاحيات المستخدمين</a></li>
								@endcan
							</ul>
						</li>
					@endcan

					@can('الاعدادات')
						<li class="side-item side-item-category">الاعدادات</li>
						<li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}"><i class="fa fa-cogs text-dark fa-1x"></i><span class="side-menu__label mr-1">الاعدادات</span><i class="angle fe fe-chevron-down"></i></a>
							<ul class="slide-menu">

								@can('الأقسام')
									<li><a class="slide-item" href="{{ adminUrl($page='sections') }}">الأقسام</a></li>
								@endcan
								
								@can('المنتجات')
									<li><a class="slide-item" href="{{ adminUrl($page='products') }}">المنتجات</a></li>
								@endcan
							</ul>
						</li>
					@endcan
				</ul>
			</div>
		</aside>
<!-- main-sidebar -->
