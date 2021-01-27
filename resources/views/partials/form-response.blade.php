@if ($errors->any())
    @foreach ($errors->all() as $error)
        <script type="module" defer>
            let message = "{{$error}}"
            toastr.error(message, '👋 Alert', {
                progressBar: true,
                closeButton: true,
                tapToDismiss: false
            });
        </script>
    @endforeach
@elseif(session('success'))
<script type="module" defer>
    let message = "{{session('success')}}"
    toastr.success(message, '👋 Alert', {
        progressBar: true,
        closeButton: true,
        tapToDismiss: false
    });
</script>
@elseif(session('error'))
<script type="module" defer>
    let message = "{{session('error')}}"
    toastr.error(message, '👋 Alert', {
        progressBar: true,
        closeButton: true,
        tapToDismiss: false
    });
</script>
@endif
