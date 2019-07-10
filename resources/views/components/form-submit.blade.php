<?php
$class = (isset($class) ? ' ' . $class : '');
$controlClass = (isset($controlClass) ? ' ' . $controlClass : 'btn-primary');
?>
<div class="form-group{{ $class }}">
    @include ('components.button', [
        'type' => 'submit',
        'class' => $controlClass
    ])
</div>