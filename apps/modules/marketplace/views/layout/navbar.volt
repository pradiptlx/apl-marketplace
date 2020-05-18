<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">Marketplace</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <form class="form-group mt-2" style="width: 30vh">
                    <select id="searchProduct" class="search-ajax form-control mr-sm-2"></select>
                </form>
                <li class="nav-item active">
                    <a class="nav-link" href="{{ url('/') }}">Home
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                {% if username is defined and fullname is defined %}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ username }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href={{ url('/marketplace/user/dashboard') }}>Dashboard</a>
                            <a class="dropdown-item" href="{{ url('/marketplace/user/logout') }}">Logout</a>
                        </div>
                    </li>
                {% else %}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/marketplace/user/login') }}">Login</a>
                    </li>
                {% endif %}
            </ul>
        </div>
    </div>
</nav>
