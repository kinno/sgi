<div class="navbar-header">
    <button class="navbar-toggle" data-target=".navbar-ex1-collapse" data-toggle="collapse" type="button">
        <span class="sr-only">
            Toggle navigation
        </span>
        <span class="icon-bar">
        </span>
        <span class="icon-bar">
        </span>
        <span class="icon-bar">
        </span>
    </button>
    <a class="navbar-brand" href="/">
        Sistema de Gasto de Inversión {2017}
    </a>
</div>
<!-- Top Menu Items -->
<ul class="nav navbar-right top-nav">
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa fa-envelope">
            </i>
            <b class="caret">
            </b>
        </a>
        <ul class="dropdown-menu message-dropdown">
            <li class="message-preview">
                <a href="#">
                    <div class="media">
                        <span class="pull-left">
                            <img alt="" class="media-object" src="http://placehold.it/50x50">
                            </img>
                        </span>
                        <div class="media-body">
                            <h5 class="media-heading">
                                <strong>
                                    {{Auth::user()->username}}
                                </strong>
                            </h5>
                            <p class="small text-muted">
                                <i class="fa fa-clock-o">
                                </i>
                                Yesterday at 4:32 PM
                            </p>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur...
                            </p>
                        </div>
                    </div>
                </a>
            </li>
            <li class="message-preview">
                <a href="#">
                    <div class="media">
                        <span class="pull-left">
                            <img alt="" class="media-object" src="http://placehold.it/50x50">
                            </img>
                        </span>
                        <div class="media-body">
                            <h5 class="media-heading">
                                <strong>
                                    John Smith
                                </strong>
                            </h5>
                            <p class="small text-muted">
                                <i class="fa fa-clock-o">
                                </i>
                                Yesterday at 4:32 PM
                            </p>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur...
                            </p>
                        </div>
                    </div>
                </a>
            </li>
            <li class="message-preview">
                <a href="#">
                    <div class="media">
                        <span class="pull-left">
                            <img alt="" class="media-object" src="http://placehold.it/50x50">
                            </img>
                        </span>
                        <div class="media-body">
                            <h5 class="media-heading">
                                <strong>
                                    John Smith
                                </strong>
                            </h5>
                            <p class="small text-muted">
                                <i class="fa fa-clock-o">
                                </i>
                                Yesterday at 4:32 PM
                            </p>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur...
                            </p>
                        </div>
                    </div>
                </a>
            </li>
            <li class="message-footer">
                <a href="#">
                    Read All New Messages
                </a>
            </li>
        </ul>
    </li>
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa fa-bell">
            </i>
            <b class="caret">
            </b>
        </a>
        <ul class="dropdown-menu alert-dropdown">
            <li>
                <a href="#">
                    Alert Name
                    <span class="label label-default">
                        Alert Badge
                    </span>
                </a>
            </li>
            <li>
                <a href="#">
                    Alert Name
                    <span class="label label-primary">
                        Alert Badge
                    </span>
                </a>
            </li>
            <li>
                <a href="#">
                    Alert Name
                    <span class="label label-success">
                        Alert Badge
                    </span>
                </a>
            </li>
            <li>
                <a href="#">
                    Alert Name
                    <span class="label label-info">
                        Alert Badge
                    </span>
                </a>
            </li>
            <li>
                <a href="#">
                    Alert Name
                    <span class="label label-warning">
                        Alert Badge
                    </span>
                </a>
            </li>
            <li>
                <a href="#">
                    Alert Name
                    <span class="label label-danger">
                        Alert Badge
                    </span>
                </a>
            </li>
            <li class="divider">
            </li>
            <li>
                <a href="#">
                    View All
                </a>
            </li>
        </ul>
    </li>
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa fa-user">
            </i>
            {{Auth::user()->name}}
            <b class="caret">
            </b>
        </a>
        <ul class="dropdown-menu">
            <li>
                <a href="#">
                    <i class="fa fa-fw fa-user">
                    </i>
                    Profile
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-fw fa-envelope">
                    </i>
                    Inbox
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-fw fa-gear">
                    </i>
                    Settings
                </a>
            </li>
            <li class="divider">
            </li>
            <li>
                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out fa-fw"></i>Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>
    </li>
</ul>