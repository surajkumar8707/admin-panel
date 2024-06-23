<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

@if (Session::has('success'))
    <script>
        toastr.success("{{ Session::get('success') }}", 'Success!')
    </script>
@endif

@if (Session::has('error'))
    <script>
        toastr.error("{{ Session::get('error') }}", 'error!')
    </script>
@endif

@if (Session::has('info'))
    <script>
        toastr.info("{{ Session::get('info') }}", 'info!')
    </script>
@endif

@if (Session::has('warning'))
    <script>
        toastr.warning("{{ Session::get('warning') }}", 'warning!')
    </script>
@endif
