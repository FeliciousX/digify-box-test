<header class="navbar navbar-default">
    <nav class="container">
        <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            @if (Auth::check())
            {{ link_to_route('box.index', 'Boxify', null, array('class' => 'navbar-brand')) }}
            @else
            {{ link_to_route('index', 'Boxify', null, array('class' => 'navbar-brand')) }}
            @endif
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
            {{--- TODO: @feliciousx add any links necessary ---}}
            </ul>
            <ul class="nav navbar-nav navbar-right">
            @if (Auth::check())
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    {{ Auth::user()->name }} <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li>{{ link_to_route('logout', 'Logout') }}</li>
                    </ul>
                </li>
            @else
                <li>{{ link_to_route('login.box', 'Login') }}</li>
            @endif
            </ul>
        </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</header>
