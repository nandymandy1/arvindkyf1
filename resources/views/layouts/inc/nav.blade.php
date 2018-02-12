<nav class="navbar navbar-default col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="bg-white text-center navbar-brand-wrapper">
    <a class="navbar-brand brand-logo" href="/"><img src="{{asset('./assets/logo.png')}}" /></a>
    <a class="navbar-brand brand-logo-mini" href="/"><img src="{{asset('./assets/logo-sm.png')}}" alt="" height="25px"></a>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-center">
    <button class="navbar-toggler navbar-toggler d-none d-lg-block navbar-dark align-self-center mr-3" type="button" data-toggle="minimize">
      <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav ml-lg-auto d-flex align-items-center flex-row">
      <li class="nav-item">
        <a class="nav-link profile-pic" href=""><img class="rounded-circle" src="images/face.jpg" alt=""></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href=""><i class="fa fa-th"></i></a>
      </li>
      <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              {{ Auth::user()->name }} <span class="caret"></span>
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="{{ route('logout') }}"
                 onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                  Logout
              </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>
          </div>
      </li>
    </ul>
    <button class="navbar-toggler navbar-dark navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="navbar-toggler-icon"></span>
    </button>
  </div>
</nav>
