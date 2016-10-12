    <!-- begin #header -->
    <div id="header" class="header navbar navbar-default navbar-fixed-top">
      <!-- begin container-fluid -->
      <div class="container-fluid">
        <!-- begin mobile sidebar expand / collapse button -->
        <div class="navbar-header">
          <a href="javascript:;" class="navbar-brand"><span class="navbar-logo"></span> {{$header}}</a>
          <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>




        </div>
        <!-- end mobile sidebar expand / collapse button -->

        <div class="col-md-5">

              <br>
              <h5>
                @yield('content_top')
              </h5>
        </div>


        <ul class="nav navbar-nav navbar-right">

			{{-- TODO: discuss the following draft (position, coding) --}}
			<?php
				if (\PPModule::is_active('provvoipenvia')) {

					echo "<!-- count of user interaction needing EnviaOrders -->";

					echo "<li style='font-size: 2em; font-weight: bold'>";

					$user_interaction_needing_enviaorder_count = Modules\ProvVoipEnvia\Entities\EnviaOrder::get_user_interaction_needing_enviaorder_count();
					echo '<a href="/lara/admin/EnviaOrder?show_filter=action_needed" target="_self">';

					if ($user_interaction_needing_enviaorder_count > 0) {
						echo "<span style='color: #f00; text-decoration:none' title='".$user_interaction_needing_enviaorder_count." user interaction needing EnviaOrders'>✘<sup>";
						echo $user_interaction_needing_enviaorder_count.'</sup>';
					}
					else {
						echo "<span style='color: #080; text-decoration:none' title='No user interaction needing EnviaOrders'>✔";
					}
					echo "</a>";

					echo "</li>";
				}
			?>

        <!-- global search form -->
          <li>
            <div class="navbar-form full-width">

                {{ Form::model(null, array('route'=>'Base.fulltextSearch', 'method'=>'GET'), 'simple') }}

                  {{ Form::hidden('mode', 'simple') }}
                  {{ Form::hidden('scope', 'all') }}

                  <input type="text" name="query" placeholder="Enter keyword" class="form-control">
                  <button class="btn btn-search" type="submit"><i class="fa fa-search"></i></button>

                {{ Form::close() }}

            </div>
          </li>

<!--
          <li class="dropdown">
            <a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle f-s-14">
              <i class="fa fa-bell-o"></i>
              <span class="label">0</span>
            </a>

            <ul class="dropdown-menu media-list pull-right animated fadeInDown">
              <li class="dropdown-header">Notifications (5)</li>
              <li class="media">
                <a href="javascript:;">
                  <div class="pull-left media-object bg-red"><i class="fa fa-bug"></i></div>
                  <div class="media-body">
                    <h6 class="media-heading">Server Error Reports</h6>
                    <div class="text-muted">3 minutes ago</div>
                  </div>
                </a>
              </li>
              <li class="media">
                <a href="javascript:;">
                  <div class="pull-left"><img src="assets/img/user-1.jpg" class="media-object" alt="" /></div>
                  <div class="media-body">
                    <h6 class="media-heading">John Smith</h6>
                    <p>Quisque pulvinar tellus sit amet sem scelerisque tincidunt.</p>
                    <div class="text-muted">25 minutes ago</div>
                  </div>
                </a>
              </li>
              <li class="media">
                <a href="javascript:;">
                  <div class="pull-left"><img src="assets/img/user-2.jpg" class="media-object" alt="" /></div>
                  <div class="media-body">
                    <h6 class="media-heading">Olivia</h6>
                    <p>Quisque pulvinar tellus sit amet sem scelerisque tincidunt.</p>
                    <div class="text-muted">35 minutes ago</div>
                  </div>
                </a>
              </li>
              <li class="media">
                <a href="javascript:;">
                  <div class="pull-left media-object bg-green"><i class="fa fa-plus"></i></div>
                  <div class="media-body">
                    <h6 class="media-heading"> New User Registered</h6>
                    <div class="text-muted">1 hour ago</div>
                  </div>
                </a>
              </li>
              <li class="media">
                <a href="javascript:;">
                  <div class="pull-left media-object bg-blue"><i class="fa fa-envelope"></i></div>
                  <div class="media-body">
                    <h6 class="media-heading"> New Email From John</h6>
                    <div class="text-muted">2 hour ago</div>
                  </div>
                </a>
              </li>
              <li class="dropdown-footer text-center">
                <a href="javascript:;">View more</a>
              </li>
            </ul>
          </li>
-->
          <li class="dropdown navbar-user">
            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{asset('components/assets-admin/img/user-11.jpg')}}" alt="" />
              <span class="hidden-xs">{{\Auth::user()->first_name.' '.\Auth::user()->last_name}}</span> <b class="caret"></b>
            </a>
            <ul class="dropdown-menu animated fadeInLeft">
              <li class="arrow"></li>
              <li><a href="{{route('Authuser.edit', \Auth::user()->id)}}">{{trans('messages.user_settings')}}</a></li>
              <li><a href="{{route('Authuser.index')}}">{{trans('messages.user_glob_settings')}}</a></li>
              <!-- <li><a href="javascript:;"><span class="badge badge-danger pull-right">2</span> Inbox</a></li> -->
              <li class="divider"></li>
              <li><a href="{{route('Auth.logout')}}">{{trans('messages.log_out')}}</a></li>
            </ul>
          </li>

          <li class="dropdown navbar-user">
            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
              <span class="hidden-xs">{{ \App\Http\Controllers\BaseViewController::translate('Main Menu') }}</span> <b class="caret"></b>
            </a>
            <ul class="dropdown-menu animated fadeInLeft">
              <li class="arrow"></li>

                @foreach ($view_header_links as $module_name => $module)
                  <li><a href="#"><b>{{$module_name}}</b></a>
                    @foreach ($module as $name => $link)
                      <a href="{{route($link)}}">&nbsp;&nbsp;&nbsp;&nbsp;{{ $name }}</a>
                    @endforeach
                  </li>
                @endforeach

            </ul>
          </li>

        </ul>
        <!-- end header navigation right -->
      </div>
      <!-- end container-fluid -->
    </div>
    <!-- end #header -->

