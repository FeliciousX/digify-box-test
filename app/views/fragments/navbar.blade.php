{{--- TODO: @feliciousx link the navbar properly ---}}
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
            {{ link_to_route('index', 'Boxify', null, array('class' => 'navbar-brand')) }}
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
            {{--- TODO: @feliciousx list out all links ---}}
            </ul>
            <ul class="nav navbar-nav navbar-right">
            @if (Auth::check())
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    {{ Auth::user()->name }} <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li>{{ link_to_route('profile', 'Profile') }}</li>
                        <li class="divider"></li>
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
