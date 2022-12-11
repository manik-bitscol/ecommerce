<script>
    @if (session()->has('error'))
        Swal.fire({
            icon: 'error',
            text: "{{ session('error') }}"
        })
    @endif
</script>
