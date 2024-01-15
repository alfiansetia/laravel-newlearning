<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        @if ($user->role == 'admin')
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#master_data" aria-expanded="false"
                    aria-controls="master_data">
                    <i class="ti-save menu-icon"></i>
                    <span class="menu-title">Master Data</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="master_data">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.index') }}"> User </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('category.index') }}">Category </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('subcategory.index') }}"> Sub Category </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('course.index') }}"> Course </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('key.index') }}"> Key </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('content.index') }}">Video Content</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('quiz.index') }}">Quiz</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('transaction.index') }}">Transaction</a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif

        <li class="nav-item">
            <a class="nav-link" href="{{ route('list.course.index') }}">
                <i class="ti-agenda menu-icon"></i>
                <span class="menu-title">Course</span>
            </a>
        </li>
        @if ($user->role == 'mentor')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('index.profile') }}">
                    <i class="ti-agenda menu-icon"></i>
                    <span class="menu-title">My Course</span>
                </a>
            </li>
        @endif

        {{-- <li class="nav-item">
            <a class="nav-link" href="{{ route('chat.index') }}">
                <i class="ti-comments menu-icon"></i>
                <span class="menu-title">Chat</span>
            </a>
        </li> --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ route('topup.index') }}">
                <i class="ti-money menu-icon"></i>
                <span class="menu-title">Topup</span>
            </a>
        </li>
        @if ($user->role == 'admin')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('upgrade.index') }}">
                    <i class="ti-medall menu-icon"></i>
                    <span class="menu-title">Upgrade</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('setting.company') }}">
                    <i class="ti-settings menu-icon"></i>
                    <span class="menu-title">Setting</span>
                </a>
            </li>
        @endif
    </ul>
</nav>
