<?php
$class = (isset($class) ? ' ' . $class : '');
$name = (isset($name) ? $name : $id);
$hasError = $errors->has($name);
$labelClass = (isset($labelClass) ? ' ' . $labelClass : '');
$type = (isset($type) ? $type : 'text');
$controlClass = (isset($controlClass) ? ' ' . $controlClass : '');
$value = (isset($value) ? $value : '');
$controlAttributes = (isset($controlAttributes) ? ' ' . $controlAttributes : '');
$placeholder = (isset($placeholder) ? $placeholder : (isset($label) ? $label : null));
?>
<div class="form-group{{ $class }}">

    @if (isset($label))
        <label for="{{ $id }}" class="{{ $labelClass }}">{{ $label }}</label>
    @endif

    <input id="{{ $id }}"
           type="{{ $type }}"
           class="form-control{{ $controlClass }}{{ $hasError ? ' is-invalid' : '' }}"
           name="{{ $name }}"
           value="{{ $value }}"
           @if (!empty($placeholder)) placeholder ="{{ $placeholder }}" @endif
           @if (!empty($required)) required @endif
           @if (!empty($controlAttributes)) {{ $controlAttributes }} @endif
           >

    @if ($hasError)
        @include('components.form-input-invalid', [
            'name' => $name
        ])
    @endif
</div>
