<!-- toastify messages on session success/error/status and validation errors -->
@if (session('status'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Toastify({
            text: '{{session("status")}}',
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
            style: {
                background: "linear-gradient(to right,rgb(140, 92, 155),rgb(86, 33, 116))",
            },
        }).showToast();
    });
</script>
@endif

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Toastify({
            text: '{{session("success")}}',
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
            style: {
                background: "linear-gradient(to right, #00b09b, #96c93d)",
            },
        }).showToast();
    });
</script>
@endif

@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Toastify({
            text: '{{session("error")}}',
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
            style: {
                background: "linear-gradient(to right,rgb(158, 45, 54),rgb(88, 4, 4))",
            },
        }).showToast();
    });
</script>
@endif

@if ($errors->any())
<script>
        document.addEventListener('DOMContentLoaded', function() {
            @foreach ($errors->all() as $error)

                    Toastify({
                            text: '{{ $error }}',
                            duration: 3000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            stopOnFocus: true,
                            style: {
                                background: "linear-gradient(to right,rgb(158, 45, 54),rgb(88, 4, 4))",
                            },
                        }).showToast();
            @endforeach
        });
</script>
@endif
