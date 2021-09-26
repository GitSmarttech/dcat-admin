<div class="{{ $configData['horizontal_menu'] ? 'header-navbar navbar-expand-sm navbar navbar-horizontal' : 'main-menu' }}">
    <div class="main-menu-content">
        <aside class="{{ $configData['horizontal_menu'] ? 'main-horizontal-sidebar' : 'main-sidebar shadow' }} {{ $configData['sidebar_style'] }}">

            @if(! $configData['horizontal_menu'])
                <div class="navbar-header">
                    <ul class="nav navbar-nav flex-row">
                        <li class="nav-item mr-auto">
                            <a href="{{ admin_url('/') }}" class="navbar-brand waves-effect waves-light">
                                <span class="logo-mini">{!! config('admin.logo-mini') !!}</span>
                                <span class="logo-lg">{!! config('admin.logo') !!}</span>
                            </a>
                        </li>
                        <li class="nav-item mr-auto">
                            <div class="avatar-info">
                                <div class="avatar-top"><img src="{{ \Dcat\Admin\Admin::user()->getAvatar() }}" alt="">
                                </div>
                                <div class="avatar-name">{{ \Dcat\Admin\Admin::user()->name }}</div>
                            </div>
                        </li>
                    </ul>
                </div>
            @endif

            <div class="p-0 {{ $configData['horizontal_menu'] ? 'pl-1 pr-1' : 'sidebar pb-3' }}">
                <ul class="nav nav-pills nav-sidebar {{ $configData['horizontal_menu'] ? '' : 'flex-column' }}"
                    {!! $configData['horizontal_menu'] ? '' : 'data-widget="treeview"' !!}
                    style="padding-top: 10px">
                    {!! admin_section(Dcat\Admin\Admin::SECTION['LEFT_SIDEBAR_MENU_TOP']) !!}

                    {!! admin_section(Dcat\Admin\Admin::SECTION['LEFT_SIDEBAR_MENU']) !!}

                    {!! admin_section(Dcat\Admin\Admin::SECTION['LEFT_SIDEBAR_MENU_BOTTOM']) !!}
                </ul>
            </div>
            <div class="sidebar-ext-box">
                <div class="ext-action">
                    <a href="{{admin_url('auth/logout')}}">退出</a> <span>&nbsp;&nbsp;|&nbsp;&nbsp;</span> <a
                            href="{{admin_url('auth/setting')}}">编辑</a>
                </div>
            </div>
        </aside>
    </div>
</div>
