@if($user)
    <li class="dropdown dropdown-user nav-item">
        <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
            <div class="user-nav d-sm-flex d-none">
                <span class="user-name text-bold-600">{{ $user->name }}</span>
                <span class="user-status"><i class="fa fa-circle text-success"></i> {{ trans('admin.online') }}</span>
            </div>
            <span>
            <img class="round" src="{{ $user->getAvatar() }}" alt="avatar" height="40" width="40" />
        </span>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
            <a href="{{ admin_url('auth/setting') }}" class="dropdown-item setting">
                <img src="/static/admin/images/setting_icon.png" width="25" alt="">&nbsp;&nbsp;&nbsp; 設置
            </a>

            <div class="dropdown-divider"></div>

            <a class="dropdown-item exit" href="{{ admin_url('auth/logout') }}">
                <img src="/static/admin/images/exit_icon.png" width="20" alt="">&nbsp;&nbsp;&nbsp; 登出
            </a>
        </div>
    </li>
@endif
