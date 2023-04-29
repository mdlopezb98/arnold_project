@if (session()->has('message'))
    <script>
        toastr.success( "{{ @session('message')}}", "info", {"iconClass": 'customer-info'});
    </script>
@endif
@if (session()->has('msg-error'))
    <script>
        toastr.error("{{ @session('msg-error') }}", "error", {"iconClass": 'customer-info'});
    </script>
@endif