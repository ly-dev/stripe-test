<?php
$class = (isset($class) ? ' ' . $class : '');
$name = (isset($name) ? $name : $id);
$hasError = $errors->has($name);
$labelClass = (isset($labelClass) ? ' ' . $labelClass : '');
$controlClass = (isset($controlClass) ? ' ' . $controlClass : '');
$value = (isset($value) ? $value : '');
$controlAttributes = (isset($controlAttributes) ? $controlAttributes : '');
?>
<div class="form-group{{ $class }}">
    <div class="form-check{{ $controlClass }}">
        <input id="{{ $id }}"
            type="checkbox"
            class="form-check-input{{ $hasError ? ' is-invalid' : '' }}"
            name="{{ $name }}"
            value="{{ $value }}"
            {{ empty($checked) ? '' : 'checked' }} {{ empty($required) ? '' : 'required' }} {{ $controlAttributes }}>

        @if (isset($label))
            <label class="form-check-label{{ $labelClass }}" for="{{ $id }}">{{ $label }}</label>
        @endif


        @if ($hasError)
            @include('components.form-input-invalid', [
                'name' => $name
            ])
        @endif
    </div>

</div>
