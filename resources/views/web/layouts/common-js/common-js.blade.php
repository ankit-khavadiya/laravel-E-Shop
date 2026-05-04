<script>
    AOS.init({
        duration: 800,
        once: true,
        offset: 100
    });

    // Back to top
    $('#backToTop').click(function() {
        $('html, body').animate({scrollTop: 0}, 500);
    });

    $(window).scroll(function() {
        if ($(this).scrollTop() > 300) {
            $('#backToTop').fadeIn();
        } else {
            $('#backToTop').fadeOut();
        }
    });

    {{--// Newsletter Subscription--}}
    {{--$('#newsletterForm').submit(function(e) {--}}
    {{--    e.preventDefault();--}}
    {{--    let email = $(this).find('input[type="email"]').val();--}}

    {{--    $.ajax({--}}
    {{--        url: "{{ route('newsletter.subscribe') }}",--}}
    {{--        type: "POST",--}}
    {{--        data: {email: email, _token: '{{ csrf_token() }}'},--}}
    {{--        success: function(response) {--}}
    {{--            Swal.fire('Success!', 'Subscribed successfully!', 'success');--}}
    {{--            $('#newsletterForm')[0].reset();--}}
    {{--        },--}}
    {{--        error: function() {--}}
    {{--            Swal.fire('Error!', 'Something went wrong!', 'error');--}}
    {{--        }--}}
    {{--    });--}}
    {{--});--}}

    // Cart count update
    function updateCartCount() {
        $.get("{{ route('cart-count') }}", function(data) {
            $('#cartCount').text(data.count);
        });
    }

    // Wishlist count update
    function updateWishlistCount() {
        $.get("{{ route('wishlist-count') }}", function(data) {
            $('#wishlistCount').text(data.count);
        });
    }

    setInterval(updateCartCount, 30000);
    setInterval(updateWishlistCount, 30000);
</script>
<script type="module">
    import {initializeApp} from "https://www.gstatic.com/firebasejs/9.17.2/firebase-app.js";
    import { getAuth, GoogleAuthProvider, FacebookAuthProvider, signInWithPopup } from 'https://www.gstatic.com/firebasejs/9.17.2/firebase-auth.js';

    // Your web app's Firebase configuration
    const firebaseConfig = {
        apiKey: "AIzaSyCsOg_xujzNWZq4kggtsKH1_QUDrO2Vizo",
        authDomain: "laravel-e-shop-abb9f.firebaseapp.com",
        projectId: "laravel-e-shop-abb9f",
        storageBucket: "laravel-e-shop-abb9f.firebasestorage.app",
        messagingSenderId: "899543916987",
        appId: "1:899543916987:web:88eb017ade3554917a249e",
        measurementId: "G-W0DJ0XYJHG"
    };

    // Initialize Firebase
    const app = initializeApp(firebaseConfig);
    const auth = getAuth(app);
    const provider = new GoogleAuthProvider();
    provider.setCustomParameters({
        prompt: 'select_account'
    });

    // Function to handle Google Sign-in
    $('#loginWithGoogleBtn').click(function () {
        let isLoginPage = "{{ request()->segment(1) == 'login'}}";
        signInWithPopup(auth, provider).then((result) => {
            const user = result.user;
            user.getIdToken().then((idToken) => {
                $.ajax({
                    url: "{{ route('google-login') }}",
                    method: "POST",
                    dataType: "json",
                    data: {
                        _token: "{{ csrf_token() }}",
                        firebase: idToken,
                    },
                    beforeSend: function () {
                        $("#loginWithGoogleBtn").attr('disabled',true);
                    },
                    success: function () {
                        if(isLoginPage){
                            window.location.href = "{{ url()->previous()}}";
                        }else{
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        let data = xhr.responseJSON;
                        toastr.error(data.message);
                    },
                    complete: function () {
                        $("#loginWithGoogleBtn").attr('disabled',false);
                    }
                });
            });
        }).catch((error) => {
            const errorMessage = error.message;
            console.error("Error during Google sign-in:", errorMessage);
        });
    });

    const fbProvider = new FacebookAuthProvider();

    fbProvider.setCustomParameters({
        display: 'popup'
    });

    $('#loginWithFacebookBtn').click(function () {

        let isLoginPage = "{{ request()->segment(1) == 'login'}}";

        signInWithPopup(auth, fbProvider)
            .then((result) => {

                const user = result.user;

                user.getIdToken().then((idToken) => {

                    $.ajax({
                        url: "{{ route('facebook-login') }}",
                        method: "POST",
                        dataType: "json",
                        data: {
                            _token: "{{ csrf_token() }}",
                            firebase: idToken,
                        },
                        beforeSend: function () {
                            $("#loginWithFacebookBtn").attr('disabled', true);
                        },
                        success: function () {
                            if (isLoginPage) {
                                window.location.href = "{{ url()->previous() }}";
                            } else {
                                location.reload();
                            }
                        },
                        error: function (xhr) {
                            toastr.error(xhr.responseJSON.message);
                        },
                        complete: function () {
                            $("#loginWithFacebookBtn").attr('disabled', false);
                        }
                    });

                });

            })
            .catch((error) => {
                console.error("Facebook login error:", error.message);
            });
    });
</script>
