<div class="header p-2">
    <div class="container">
        <div class="top_header">
            <div class="email">
                <i class="fa-regular fa-envelope"></i> &nbsp; info@steadyformation.com
            </div>

            <div class="social_icons ">
                
                <?php if (!empty($setting->facebook_url) ) : ?>
                     <a class="text-white" target="_blank" href="{{$setting->facebook_url}}"><i class="fa-brands fa-facebook"></i></a>&nbsp;
			    <?php endif; ?>
			    
			     <?php if (!empty($setting->instagram_url) ) : ?>
                      <a class="text-white" target="_blank" href="{{$setting->instagram_url}}"><i class="fa-brands fa-instagram"></i></a>&nbsp;
			    <?php endif; ?>
			    
			    
			    <?php if (!empty($setting->x_url) ) : ?>
                          <a class="text-white" target="_blank" href="{{$setting->x_url}}"><i class="fa-brands fa-x-twitter"></i></a>&nbsp;
			    <?php endif; ?>
                
               
                <?php if (!empty($setting->linkedin_url) ) : ?>
                         <a class="text-white" target="_blank" href="{{$setting->linkedin_url}}"><i class="fa-brands fa-linkedin"></i></a>&nbsp;
			    <?php endif; ?>
			    
			    <?php if (!empty($setting->youtube_url) ) : ?>
                          <a class="text-white" target="_blank" href="{{$setting->youtube_url}}"><i class="fa-brands fa-youtube"></i></a>&nbsp;
			    <?php endif; ?>
			    
			    
			     <?php if (!empty($setting->tiktok_url) ) : ?>
                          <a class="text-white" target="_blank" href="{{$setting->tiktok_url}}"><i class="fa-brands fa-tiktok"></i></a>&nbsp;
			    <?php endif; ?>
			    
			    
			    <?php if (!empty($setting->pinterest_url) ) : ?>
                           <a class="text-white" target="_blank" href="{{$setting->pinterest_url}}"><i class="fa-brands fa-pinterest"></i></a>&nbsp;
			    <?php endif; ?>
               
               
                 <?php if (!empty($setting->threads_url) ) : ?>
                          <a class="text-white" target="_blank" href="{{$setting->threads_url}}"><i class="fa-brands fa-threads"></i></a>
			    <?php endif; ?>
            
                
                
                
               
                
               
                
                
               
                
                
            </div>
        </div>
    </div>
</div>


<!-- Navbar -->
<nav class="navbar navbar-expand-lg  bg-white navbar-white mt-3 mb-5" id="navbar_sticky">
    <div class="container">
        <a class="navbar-brand" href="/"
        ><img src="{{asset('assets/images/logo.webp')}}" alt="Steady Formation Logo" class="logo-img">
        </a>
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link mx-2 navitem" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-2 navitem" href="{{route('web.about_us')}}"></i>About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-2 navitem" href="/contact-us">Contact Us</a>
                </li> <li class="nav-item">
                    <a class="nav-link mx-2 navitem" href="/blog">Blog</a>
                </li>
                @if(auth()->check())
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{auth()->user()->first_name}} {{auth()->user()->last_name}}
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

                            @if(auth()->user()->role == 1)
                                <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                    Dashboard
                                </a>
                            @else
                                <a class="dropdown-item" href="{{ route('web.dashboard') }}">
                                    Dashboard
                                </a>
                            @endif

                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @else
                    <li class="nav-item ms-3">
                        <a class="btn btn-first" href="{{route('login')}}">Login</a>
                    </li>
                @endif

            </ul>
        </div>
    </div>
</nav>
<!-- Navbar -->
