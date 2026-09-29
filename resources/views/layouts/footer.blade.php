<footer class="bg-dark text-white mt-5">

    <div class="container py-4">

        <div class="row">

            <div class="col-md-6 mb-3 mb-md-0">

                <h5 class="fw-bold">
                    MarketPlace
                </h5>

                <p class="text-white-50 mb-0">
                    Buy and sell products and services near you.
                </p>

            </div>


            <div class="col-md-6 text-md-end">

                <a
                    href="{{ route('home') }}"
                    class="text-white text-decoration-none me-3"
                >
                    Home
                </a>

                <a
                    href="#"
                    class="text-white text-decoration-none me-3"
                >
                    About
                </a>

                <a
                    href="#"
                    class="text-white text-decoration-none"
                >
                    Contact
                </a>

            </div>

        </div>


        <hr class="border-secondary">


        <div class="text-center text-white-50 small">
            © {{ date('Y') }} MarketPlace. All rights reserved.
        </div>

    </div>

</footer>