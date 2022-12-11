<script>
    @if (session()->has('success'))
        Swal.fire({
            icon: 'success',
            text: "{{ session('success') }}"
        })
    @endif
</script>
