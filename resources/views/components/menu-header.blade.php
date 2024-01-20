<nav class="navbar border rounded">
    <div class="container">
        <div class="navbar-left">
            <div class="navbar-btn">
                <a href="/" class="text-info"> <i class="fa fa-home"></i>Home </a>
            </div>
        </div>
        <div class="navbar-right">
            <div id="navbar-menu" class="xs-hide">
                @php $count_menu_display = env('COUNT_MENU_DISPLAY')? env('COUNT_MENU_DISPLAY') :5 ;  $menu_2 = [];@endphp
                <ul class="nav navbar-nav">
                    @foreach($menus as $key=>$menu)
                    @if( $key > ($count_menu_display-1))
                    @php
                    array_push($menu_2,$menu);
                    continue;
                    @endphp
                    @endif
                    <li><a href="/{{ __('acara') }}/{{ $menu->slug }}" class="icon-menu">{{ $menu->name }}</a></li>
                    @endforeach
                    @if($menu && $menu->count()>5)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Upcara Lainya
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @foreach($menu_2 as $menu)
                            <a class="dropdown-item" href="/{{ __('acara') }}/{{ $menu["slug"] }}">{{ $menu["name"] }}</a>
                        @endforeach
                        </div>
                    </li>
                    @endif
                </ul>

            </div>
            <div class="xs-show menu-mobile">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modalMenu">
                  Daftar Upacara
                </button>

                <!-- Modal -->
                <div class="modal fade" id="modalMenu" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                                <div class="modal-header">
                                        <h5 class="modal-title"></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                    </div>
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <ul class="nav navbar-nav">
                                        @foreach($menus as $menu)
                                        <li><a href="/{{ __('acara') }}/{{ $menu->slug }}" class="icon-menu">{{ $menu->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
