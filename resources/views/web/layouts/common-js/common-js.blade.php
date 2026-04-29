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
