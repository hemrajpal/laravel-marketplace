<nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">

    <div class="container">

        {{-- Logo --}}
        <a class="navbar-brand fw-bold text-primary" href="{{ route('home') }}">
            MarketPlace
        </a>


        {{-- Mobile Toggle --}}
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#mainNavbar"
            aria-controls="mainNavbar"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>


        {{-- Navigation --}}
        <div class="collapse navbar-collapse" id="mainNavbar">

            {{-- Left Menu --}}
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                        href="{{ route('home') }}"
                    >
                        Home
                    </a>
                </li>

            </ul>


            {{-- Right Menu --}}
            <ul class="navbar-nav align-items-lg-center">

                @auth

                    <li class="nav-item me-lg-2">
                        <a
                            href="{{ route('products.create') }}"
                            class="btn btn-primary btn-sm"
                        >
                            + Post Product
                        </a>
                    </li>


                    <li class="nav-item dropdown">

                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >
                            {{ Auth::user()->name }}
                        </a>


                        <ul class="dropdown-menu dropdown-menu-end">

                            <li>
                                <a
                                    class="dropdown-item"
                                    href="{{ route('profile') }}"
                                >
                                    Profile
                                </a>
                            </li>

                            <li>
                                <a
                                    class="dropdown-item"
                                    href="{{ route('products.my') }}"
                                >
                                    My Products
                                </a>
                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <form
                                    method="POST"
                                    action="{{ route('logout') }}"
                                >
                                    @csrf

                                    <button
                                        type="submit"
                                        class="dropdown-item"
                                    >
                                        Logout
                                    </button>
                                </form>
                            </li>

                        </ul>

                    </li>

                @else

                    <li class="nav-item">
                        <a
                            class="nav-link"
                            href="{{ route('login') }}"
                        >
                            Login
                        </a>
                    </li>

                    <li class="nav-item ms-lg-2">
                        <a
                            class="btn btn-outline-primary btn-sm"
                            href="{{ route('register') }}"
                        >
                            Register
                        </a>
                    </li>

                @endauth

            </ul>

        </div>

    </div>

</nav>