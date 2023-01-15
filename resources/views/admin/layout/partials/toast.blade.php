<?php
$success = session('success');
$warning = session('warning');
$danger = session('danger');
?>
<script>
    $(function () {
        @if($success)
        toastAlert('Success Message', '{{$success}}', 'success')
        @endif
        @if($warning)
        toastAlert('Warning Message', '{{$warning}}', 'warning')
        @endif
        @if($danger)
        toastAlert('Alert', '{{$danger}}', 'error')
        @endif
    })
</script>
