<ul class="nav nav-pills nav-center bg-light p-3">
  <li class="nav-item">
    <a class="nav-link nav-link <?=isset($page) && $page==='all'? 'active': '' ?>" href="/all">All</a>
  </li>
  <li class="nav-item">
    <a class="nav-link nav-link <?=isset($page) && $page==='home'? 'active': '' ?>" href="/page/1">Users</a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?=isset($page) && $page==='contact'? 'active': '' ?>" href="/contact">Contact</a>
  </li>
  <li class="nav-item">
    <a class="nav-link nav-link <?=isset($page) && $page==='about'? 'active': '' ?>" href="/about">About</a>
  </li>
</ul>
