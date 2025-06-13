<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('assets/images/AgilityEco_WhiteLogo.png') }}" alt="AdminLTE Logo" class="d-block m-auto"
            style="width:80%;">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                @foreach ($navigations as $navigation)
                    @if (!$navigation->has_dropdown && $navigation->parent_id == 0)
                        @if ($navigation->userNavigations->where('account_level_id', auth()->user()->accountLevel->id)->count())
                            <li class="nav-item">
                                <a href="{{ $navigation->link ? route("{$navigation->link}.index") : '#' }}"
                                    class="nav-link">
                                    <i class="nav-icon fas fa-{{ $navigation->icon }}"></i>
                                    <p>
                                        {{ $navigation->name }}
                                    </p>
                                </a>
                            </li>
                        @endif
                    @elseif ($navigation->parent_id == 0 && $navigation->has_dropdown)
                        <li class="nav-item ">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-{{ $navigation->icon }}"></i>
                                <p>
                                    {{ $navigation->name }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @foreach ($navigations as $sub_navigation)
                                    @if ($sub_navigation->parent_id == $navigation->id)
                                        @if ($navigation->userNavigations->where('account_level_id', auth()->user()->accountLevel->id)->count())
                                            <li class="nav-item">
                                                <a href="{{ $sub_navigation->link ? route("{$sub_navigation->link}.index") : '#' }}"
                                                    class="nav-link">
                                                    <i class="fa fa-{{ $sub_navigation->icon }} nav-icon"></i>
                                                    <p>{{ $sub_navigation->name }}</p>
                                                </a>
                                            </li>
                                        @endif
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endforeach
            </ul>
        </nav>
    </div>
    <!-- /.sidebar -->
</aside>
