<!--     
<div class="navbar bg-base-100">
  <div class="flex-1">
    <a class="btn btn-ghost text-xl">EPQA</a>
  </div>
  <div class="flex-none gap-2">
    <a class="text-xl">Hello, {{Auth::User()->name}}</a>
    <div class="dropdown dropdown-end">
      <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
        <div class="w-10 rounded-full">
          <img
          alt="Tailwind CSS Navbar component"
          src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.jpg" />
        </div>
      </div>
      <ul
      tabindex="0"
      class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
      <li>
        <a class="justify-between">
          Profile
          <span class="badge">New</span>
        </a>
      </li>
      <li><a>Settings</a></li>
      <li><a href="{{ route('customerlogout') }}">Logout</a></li>
    </ul>
  </div>
</div>
</div>
-->
<!-- Header -->
<header class="bg-white shadow-md w-full">
  <div class="flex justify-between items-center pl-5 pr-5 pt-2 pb-2">
    <button id="sidebarToggle" class="sm:hidden text-gray-600 focus:outline-none">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16"></path>
      </svg>
    </button>
    <div class="flex items-center space-x-4">
    @if(Auth::user()->user_type != 'customer')
      <div class="relative">
        <input type="text" id="header-search" class="pl-10 pr-4 py-2 input input-bordered border border-primary focus:outline-none focus:border-primary" placeholder="Search...">
        <svg class="absolute left-3 top-3 w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
        </svg>
        <button id="header-search-btn" class="btn btn-primary">Search</button>
        </div>
      @endif
      </div>
      <div class="flex items-center">
        <!-- light and dark mode start -->
                      <label class="swap swap-rotate items-end">
                          <!-- this hidden checkbox controls the state -->
                          <input type="checkbox" id="theme-toggle" />


                          <!-- moon icon -->
                          <svg
                          class="swap-off h-6 w-6 fill-current text-primary"
                          xmlns="http://www.w3.org/2000/svg"
                          viewBox="0 0 24 24">
                          <path
                          d="M21.64,13a1,1,0,0,0-1.05-.14,8.05,8.05,0,0,1-3.37.73A8.15,8.15,0,0,1,9.08,5.49a8.59,8.59,0,0,1,.25-2A1,1,0,0,0,8,2.36,10.14,10.14,0,1,0,22,14.05,1,1,0,0,0,21.64,13Zm-9.5,6.69A8.14,8.14,0,0,1,7.08,5.22v.27A10.15,10.15,0,0,0,17.22,15.63a9.79,9.79,0,0,0,2.1-.22A8.11,8.11,0,0,1,12.14,19.73Z" />
                        </svg>
                        <!-- sun icon -->
                        <svg
                        class="swap-on h-6 w-6 fill-current text-primary"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24">
                        <path
                        d="M5.64,17l-.71.71a1,1,0,0,0,0,1.41,1,1,0,0,0,1.41,0l.71-.71A1,1,0,0,0,5.64,17ZM5,12a1,1,0,0,0-1-1H3a1,1,0,0,0,0,2H4A1,1,0,0,0,5,12Zm7-7a1,1,0,0,0,1-1V3a1,1,0,0,0-2,0V4A1,1,0,0,0,12,5ZM5.64,7.05a1,1,0,0,0,.7.29,1,1,0,0,0,.71-.29,1,1,0,0,0,0-1.41l-.71-.71A1,1,0,0,0,4.93,6.34Zm12,.29a1,1,0,0,0,.7-.29l.71-.71a1,1,0,1,0-1.41-1.41L17,5.64a1,1,0,0,0,0,1.41A1,1,0,0,0,17.66,7.34ZM21,11H20a1,1,0,0,0,0,2h1a1,1,0,0,0,0-2Zm-9,8a1,1,0,0,0-1,1v1a1,1,0,0,0,2,0V20A1,1,0,0,0,12,19ZM18.36,17A1,1,0,0,0,17,18.36l.71.71a1,1,0,0,0,1.41,0,1,1,0,0,0,0-1.41ZM12,6.5A5.5,5.5,0,1,0,17.5,12,5.51,5.51,0,0,0,12,6.5Zm0,9A3.5,3.5,0,1,1,15.5,12,3.5,3.5,0,0,1,12,15.5Z" />
                      </svg>
                    </label>

                    <!-- light and dark moe end -->

                    <!-- notification start -->
                    <!-- <div class="dropdown -mt-0.5 relative" data-strategy="absolute">
                      <div class="dropdown-toggle px-3">
                        <button
                        class="relative mt-1 flex items-center justify-center rounded-full text-slate-500 transition-colors duration-150 hover:text-slate-700 focus:text-primary-500 dark:text-slate-400 dark:hover:text-slate-300 dark:focus:text-primary-500"
                        >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                        </svg>

                        <span
                        class="absolute -right-1 -top-1.5 flex h-4 w-4 items-center justify-center rounded-full bg-danger-500 text-[11px] text-slate-200"
                        >
                        5
                      </span>
                    </button>
                  </div>
                  <div class="dropdown-content mt-3 w-[14rem] right-0 divide-y dark:divide-slate-700 sm:w-80">
                    <div class="flex items-center justify-between">
                      <h6 class="text-slate-800 dark:text-slate-300">Notifications</h6>
                      <button class="text-xs font-medium text-slate-600 hover:text-primary-500 dark:text-slate-300">
                        Clear All
                      </button>
                    </div>

                    <div class="h-80 w-full" data-simplebar>
                      <ul>
                        <li
                        class="flex cursor-pointer gap-4 px-4 py-3 transition-colors duration-150 hover:bg-slate-100/70 dark:hover:bg-slate-700"
                        >
                        <div
                        class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-blue-100 text-blue-500"
                        >
                        <i data-feather="alert-circle" width="20" height="20"></i>
                      </div>

                      <div>
                        <h6 class="text-sm font-normal">New order received</h6>
                        <p class="text-xs text-slate-400">Order #1234 has been placed</p>
                        <p class="mt-1 flex items-center gap-1 text-xs text-slate-400">
                          <i data-feather="clock" width="1em" height="1em"></i>
                          <span>2 min ago</span>
                        </p>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div> -->
            <!-- notification end -->

  <!--           <div class="relative content-end items-end">
              <button class="flex items-center space-x-2">
                <img class="w-8 h-8 rounded-full" src="https://via.placeholder.com/150" alt="Profile">
                <span class="text-gray-700 font-medium">John Doe</span>
              </button>
            </div> -->

                          <!-- Profile Dropdown Starts -->
             <!--  <div class="dropdown relative">
                <div class="dropdown-toggle pl-3">
                  <button class="group relative flex items-center gap-x-1.5" type="button">
                    <div class="avatar avatar-circle avatar-indicator avatar-indicator-online">
                      <img
                        class="avatar-img group-focus-within:ring group-focus-within:ring-primary-500"
                        src="./images/avatar1.png"
                        alt="Avatar 1"
                      />
                    </div>
                  </button>
                </div>

                <div class="dropdown-content mt-1 right-0 w-[14rem] divide-y dark:divide-slate-600">
                  <div class="px-4 py-3">
                    <p class="text-sm">Signed in as</p>
                    <p class="truncate text-sm font-medium">admin@example.com</p>
                  </div>
                  <div class="py-1">
                    <a href="javascript:void(0)" class="dropdown-link">
                      <i width="18" height="18" data-feather="user" class="text-slate-500"></i>
                      <span>Profile</span>
                    </a>
                    <a href="javascript:void(0)" class="dropdown-link">
                      <i width="18" height="18" data-feather="settings" class="text-slate-500"></i>
                      <span>Settings</span>
                    </a>
                    <a href="javascript:void(0)" class="dropdown-link">
                      <i width="18" height="18" data-feather="help-circle" class="text-slate-500"></i>
                      <span>Support</span>
                    </a>
                  </div>
                  <div class="py-1">
                        <a href="{{ route('customerlogout') }}">
                        <i width="18" height="18" data-feather="log-out" class="text-slate-500"></i>
                        <span>Sign out</span>
                      </a>
                  </div>
                </div>
              </div> -->
              <!-- end of profile section -->

              <!-- notification section -->

              <div class="relative dropdown -mt-0.5" data-strategy="absolute">
<!--   <div class="dropdown-toggle px-3">
    <button
      id="notificationButton"
      class="relative mt-1 flex items-center justify-center rounded-full text-slate-500 transition-colors duration-150 hover:text-slate-700 focus:text-primary-500 dark:text-slate-400 dark:hover:text-slate-300 dark:focus:text-primary-500"
    >
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-primary">
        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
      </svg>
      <span class="absolute -right-1 -top-1.5 flex h-4 w-4 items-center justify-center rounded-full bg-primary text-[11px] text-white">5</span>
    </button>
  </div> -->
  <div id="notificationDropdown" class="hidden dropdown-content mt-3 w-[14rem] right-0 divide-y dark:divide-slate-700 sm:w-80 bg-white dark:bg-slate-800 shadow-lg rounded-lg overflow-hidden z-10">
    <div class="flex items-center justify-between px-4 py-2">
      <h6 class="text-slate-800 dark:text-slate-300">Notifications</h6>
      <button class="text-xs font-medium text-slate-600 hover:text-primary-500 dark:text-slate-300">Clear All</button>
    </div>
    <div class="h-80 w-full overflow-y-auto" data-simplebar>
      <ul>
        <li class="flex cursor-pointer gap-4 px-4 py-3 transition-colors duration-150 hover:bg-slate-100/70 dark:hover:bg-slate-700">
          <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-blue-100 text-blue-500">
            <i data-feather="alert-circle" width="20" height="20"></i>
          </div>
          <div>
            <h6 class="text-sm font-normal">New order received</h6>
            <p class="text-xs text-slate-400">Order #1234 has been placed</p>
            <p class="mt-1 flex items-center gap-1 text-xs text-slate-400">
              <i data-feather="clock" width="1em" height="1em"></i>
              <span>2 min ago</span>
            </p>
          </div>
        </li>
      </ul>
    </div>
  </div>
</div>

              <!-- end notification section -->

<!-- profile section -->
              <div class="relative">
  <div class="pl-3">
    <button id="dropdownButton" class="group relative flex items-center gap-x-1.5 avatar online" type="button">
      <div class="w-9 rounded-full">
        <img
          class="avatar-img group-focus-within:ring group-focus-within:ring-primary-500"
          src="{{asset('public/image/avatar.png')}}"
          alt=""
        />
      </div>
    </button>
  </div>

  <div id="dropdownContent" class="hidden absolute right-0 mt-1 w-[14rem] bg-white dark:bg-slate-800 shadow-lg rounded-md divide-y divide-gray-200 dark:divide-slate-600 z-10">
    <div class="px-4 py-3">
      <p class="text-sm">Signed in as</p>
      <p class="truncate text-sm font-medium">{{Auth::User()->name}}</p>
      <p class="truncate text-sm font-medium">{{Auth::User()->email}}</p>      
    </div>
<!--     <div class="py-1">
      <a href="javascript:void(0)" class="dropdown-link flex items-center space-x-2 px-4 py-2 hover:bg-gray-100 dark:hover:bg-slate-700">
        <i width="18" height="18" data-feather="user" class="text-slate-500"></i>
        <span>Profile</span>
      </a>
      <a href="javascript:void(0)" class="dropdown-link flex items-center space-x-2 px-4 py-2 hover:bg-gray-100 dark:hover:bg-slate-700">
        <i width="18" height="18" data-feather="settings" class="text-slate-500"></i>
        <span>Settings</span>
      </a>
      <a href="javascript:void(0)" class="dropdown-link flex items-center space-x-2 px-4 py-2 hover:bg-gray-100 dark:hover:bg-slate-700">
        <i width="18" height="18" data-feather="help-circle" class="text-slate-500"></i>
        <span>Support</span>
      </a>
    </div> -->
    <div class="py-1">
      <a href="{{ route('customerlogout') }}" class="dropdown-link flex items-center space-x-2 px-4 py-2 hover:bg-gray-100 dark:hover:bg-slate-700">
        <i width="18" height="18" data-feather="log-out" class="text-slate-500"></i>
        <span>Sign out</span>
      </a>
    </div>
  </div>
</div>
<!-- end profile section -->



      </div>

    </div>
  </header>



      <!-- <script src="{{ asset('js/app.js') }}"></script> -->
      <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
          document.querySelector('.sidebar').classList.toggle('hidden');
        });
        const themeToggle = document.getElementById('theme-toggle');
        const currentTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', currentTheme);
    themeToggle.checked = currentTheme === 'dark'; // Check the checkbox if dark theme is set

    themeToggle.addEventListener('change', () => {
      const theme = themeToggle.checked ? 'dark' : 'light';
      document.documentElement.setAttribute('data-theme', theme);
      localStorage.setItem('theme', theme);
    });

      document.getElementById('dropdownButton').addEventListener('click', function () {
    var dropdownContent = document.getElementById('dropdownContent');
    dropdownContent.classList.toggle('hidden');
  });

  window.addEventListener('click', function (e) {
    var dropdownContent = document.getElementById('dropdownContent');
    if (!dropdownContent.contains(e.target) && !document.getElementById('dropdownButton').contains(e.target)) {
      dropdownContent.classList.add('hidden');
    }
  });

    document.getElementById('notificationButton').addEventListener('click', function () {
    var dropdown = document.getElementById('notificationDropdown');
    dropdown.classList.toggle('hidden');
  });

  window.addEventListener('click', function (e) {
    var dropdown = document.getElementById('notificationDropdown');
    if (!dropdown.contains(e.target) && !document.getElementById('notificationButton').contains(e.target)) {
      dropdown.classList.add('hidden');
    }
  });

  </script>