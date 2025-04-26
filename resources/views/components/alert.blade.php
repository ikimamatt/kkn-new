<div id="autoDismissAlert"
    class="alert alert-{{ $type ?? 'success' }} alert-dismissible fade show fixed-top mx-auto mt-4 shadow z-50 w-75 px-3"
    role="alert">
    {{ $slot }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

<script>
    setTimeout(() => {
        const alert = document.getElementById('autoDismissAlert');
        if (alert) {
            alert.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => alert.remove(), 500);
        }
    }, 4000);
</script>
