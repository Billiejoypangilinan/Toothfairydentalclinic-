<!-- Dashboard -->
@if(Auth::user()->user_type != 'patient')
<li class="menu-item @yield('dashboard')">
  <a href="{{ route('dashboard') }}" class="menu-link">
    <i class="menu-icon tf-icons bx bx-home-circle"></i>
    <div data-i18n="Analytics">Dashboard </div>
  </a>
</li>
@endif


<li class="menu-item ">
  <a href="/appointment" class="menu-link">
    <i class="menu-icon tf-icons bx bx-receipt"></i>
    @if(Auth::user()->user_type == 'patient')
    <div data-i18n="Basic">My Appointments</div>
    @elseif(Auth::user()->user_type == 'doctor')
    <div data-i18n="Basic">Appointment List</div>
    @else
    <div data-i18n="Basic">Appointment</div>
    @endif
  </a>
</li>
@if(Auth::user()->user_type != 'patient')
<li class="menu-item">
  <a href="/services" class="menu-link">
    <i class="menu-icon tf-icons bx bx-receipt"></i>
    <div data-i18n="Basic">Services</div>
  </a>
</li>
  @if(Auth::user()->user_type == 'admin')
    <li class="menu-item @yield('users')">
      <a href="/doctor" class="menu-link">
        <i class="menu-icon tf-icons bx bx-user"></i>
        <div data-i18n="Basic">Doctors</div>
      </a>
    </li>
  @endif
@endif

<li class="menu-item">
  <a href="/changepassword" class="menu-link">
    <i class="menu-icon tf-icons bx bx-lock"></i>
    <div data-i18n="Settings">Change Password</div>
  </a>
</li>


