<script src="{{ asset('assets/frontend') }}/js/vendor/jquery-2.2.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
        crossorigin="anonymous"></script>
<script src="{{ asset('assets/frontend') }}/js/vendor/bootstrap.min.js"></script>
<script src="{{ asset('assets/frontend') }}/js/jquery.ajaxchimp.min.js"></script>
<script src="{{ asset('assets/frontend') }}/js/jquery.nice-select.min.js"></script>
<script src="{{ asset('assets/frontend') }}/js/jquery.sticky.js"></script>
<script src="{{ asset('assets/frontend') }}/js/nouislider.min.js"></script>
<script src="{{ asset('assets/frontend') }}/js/countdown.js"></script>
<script src="{{ asset('assets/frontend') }}/js/jquery.magnific-popup.min.js"></script>
<script src="{{ asset('assets/frontend') }}/js/owl.carousel.min.js"></script>
<!--gmaps Js-->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
<script src="{{ asset('assets/frontend') }}/js/gmaps.min.js"></script>
<script src="{{ asset('assets/frontend') }}/js/main.js"></script>

{{--sweetAlert2--}}
{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>--}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
    $(document).ready(function() {

        $('.delete-form').on('submit', function(e) {
            e.preventDefault();
            var button = $(this);

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: button.data('route'),
                        data: {
                            '_method': 'delete'
                        },
                        success: function (response, textStatus, xhr) {
                            Swal.fire({
                                icon: 'success',
                                confirmButtonColor: "#ffba00",
                                title: response,
                            }).then((result) => {
                                window.location='/myBlogs'
                            });
                        }
                    });
                }
            });

        })
    });
</script>
