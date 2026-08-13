<!-- Footer -->
<footer class="main-footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="footer-widget">
                    <h3 class="footer-logo">
                        <i class="fas fa-shopping-bag me-2"></i>
                        <span>E-SHOP</span>
                    </h3>
                    <p class="footer-desc">Premium online store offering the best quality products at affordable prices. Shop with confidence and enjoy worldwide shipping.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                        <a href="#"><i class="fab fa-pinterest"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-md-6">
                <div class="footer-widget">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">FAQs</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Size Guide</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-2 col-md-6">
                <div class="footer-widget">
                    <h4>My Account</h4>
                    <ul>
                        <li><a href="#">My Account</a></li>
                        <li><a href="#">Order History</a></li>
                        <li><a href="#">Wishlist</a></li>
                        <li><a href="#">Returns</a></li>
                        <li><a href="#">Shipping Info</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="footer-widget">
                    <h4>Newsletter</h4>
                    <p>Subscribe to get special offers, free giveaways, and exclusive deals.</p>
                    <form class="newsletter-form" id="newsletterForm">
                        @csrf
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Your email address" required>
                            <button class="btn btn-primary" type="submit">Subscribe</button>
                        </div>
                    </form>
{{--                    <div class="payment-methods mt-4">--}}
{{--                        <img src="{{ asset('frontend/images/payment/visa.png') }}" alt="Visa">--}}
{{--                        <img src="{{ asset('frontend/images/payment/mastercard.png') }}" alt="Mastercard">--}}
{{--                        <img src="{{ asset('frontend/images/payment/paypal.png') }}" alt="PayPal">--}}
{{--                        <img src="{{ asset('frontend/images/payment/amex.png') }}" alt="Amex">--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="row">
                <div class="col-md-6">
                    <p>&copy; 2024 E-SHOP. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <ul class="footer-links">
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Use</a></li>
                        <li><a href="#">Cookie Policy</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
