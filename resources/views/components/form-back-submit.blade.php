<?php
$class = (isset($class) ? ' ' . $class : '');
$backUrl = (isset($backUrl) ? $backUrl : url()->previous());
$backLabel = (isset($backLabel) ? $backLabel : 'Back');
$submitLabel = (isset($submitLabel) ? $backLabel : 'Save');
?>
<div class="form-group{{ $class }}">
    @include ('components.link-button', [
        'class' => 'btn btn-secondary',
        'href' => $backUrl,
        'label' => $backLabel,
    ])
    @include ('components.button', [
        'class' => null, // force to use default
        'type' => 'submit',
        'label' => $submitLabel,
    ])
</div>