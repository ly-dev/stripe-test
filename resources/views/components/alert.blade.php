<?php
$alertMessage = (isset($alertMessage) ? $alertMessage : session('status'));
$alertClass = (isset($alertClass) ? $alertClass : session('alert-class'));
?>
@if (isset($alertMessage))
<div class="alert alert-{{ isset($alertClass) ? $alertClass : 'success' }}">
    {{ $alertMessage }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif 