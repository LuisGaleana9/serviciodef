@if (!session()->has('name') || !session()->has('matricula'))
    <script>
        window.location.href = "{{ url('login') }}";
    </script>
    @exit
@endif
