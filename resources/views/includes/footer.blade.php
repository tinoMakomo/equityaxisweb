<footer class="">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-7 mb-3">
                <div class="row">
                    <div class="col-sm-4">
                        <ul class="list-unstyled">
                            <li>
                                <h5 class="mb-3"><span class="pe-4 pb-1 text-truncate">Support</span></h5>
                            </li>
                            <li><i class="fa fa-arrow-right me-1" aria-hidden="true"></i><a href="{{ route('help-centre') }}">Help Centre</a>
                            </li>
                            <li><i class="fa fa-arrow-right me-1" aria-hidden="true"></i><a href="{{ route('contact') }}">Contact Us</a>
                            </li>
                            <li><i class="fa fa-arrow-right me-1" aria-hidden="true"></i><a href="{{ route('about-us') }}">Our Company</a>
                            </li>
                            <li><i class="fa fa-arrow-right me-1" aria-hidden="true"></i><a href="{{ route('services') }}">Our Services</a>
                            </li>
                            <li><i class="fa fa-arrow-right me-1" aria-hidden="true"></i><a href="{{ route('careers') }}">Careers</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-4">
                        <ul class="list-unstyled">
                            <li>
                                <h5 class="mb-3"><span class="pe-4 pb-2 text-truncate">Legal & Privacy</span></h5>
                            </li>
                            <li> <i class="fa fa-arrow-right me-1" aria-hidden="true"></i> <a href="{{ route('terms') }}">Terms &
                                    Conditions</a></li>
                            <li> <i class="fa fa-arrow-right me-1" aria-hidden="true"></i> <a href="{{ route('privacy') }}">Privacy
                                    Policy</a></li>
                            <li> <i class="fa fa-arrow-right me-1" aria-hidden="true"></i> <a href="{{ route('cookies') }}">Cookies
                                    Policy</a></li>
                            <li> <i class="fa fa-arrow-right me-1" aria-hidden="true"></i> <a href="{{ route('disclaimer') }}">Disclaimer</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-4">
                        <ul class="list-unstyled">
                            <li>
                                <h5 class="mb-3"><span class="pe-4 pb-1 text-truncate">Tools</span></h5>
                            </li>
                            <li><i class="fa fa-arrow-right me-1" aria-hidden="true"></i> <a href="">Stock
                                    Street</a></li>
                            <li><i class="fa fa-arrow-right me-1" aria-hidden="true"></i> <a href="">The Axis</a>
                            </li>
                            <li><i class="fa fa-arrow-right me-1" aria-hidden="true"></i> <a href="{{ url('/sitemap.xml') }}">Sitemap</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <ul class="list-unstyled">
                    <li>
                        <h5 class="mb-3"><span class="pe-4 pb-1 text-truncate">Trending Stories</span></h5>
                    </li>
                    @foreach (Helper::getRecentPosts() as $post)
                        <li class="d-flex"><i class="fa d-block fa-arrow-right me-1 mt-1"
                                aria-hidden="true"></i> <a class="d-block"
                                href="{{ Helper::getRouteForPost($post) }}">{{ $post->title }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</footer>
<div class="footer-bottom">
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <div class="d-flex socials">
                <a href="https://www.facebook.com/equityaxis/" target="_blank"><i class="fab fa-facebook"></i></a>
                <a href="https://twitter.com/EquityAxis" target="_blank"><i class="fab fa-twitter"></i></a>
                <a href="https://www.linkedin.com/company/equity-axis" target="_blank"><i
                        class="fab fa-linkedin-in"></i></a>
                <a href="https://www.youtube.com/channel/UClG2XiX-TOyR-HK0Yn11Kyw" target="_blank"><i
                        class="fab fa-youtube"></i></a>
            </div>
            <div class="w-100 divider-container">
                <div class="thin-divider"></div>
            </div>
            <div class="flex">
                <a href="/"><img src="{{ asset('images/logos/logo-white.png') }}" class="footer-logo"></a>
            </div>
        </div>
    </div>
</div>
