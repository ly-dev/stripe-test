<?php
$class = (isset($class) ? ' ' . $class : '');
$name = (isset($name) ? $name : $id);
$hasError = $errors->has($name);
$labelClass = (isset($labelClass) ? ' ' . $labelClass : '');
$controlClass = (isset($controlClass) ? ' ' . $controlClass : '');
$controlAttributes = (isset($controlAttributes) ? ' ' . $controlAttributes : '');
$value = (isset($value) ? $value : null);
$isMultiple = (isset($isMultiple) ? $isMultiple : false);
$options = (isset($options) ? $options : []);
?>
<div class="form-group{{ $class }}">

    @if (isset($label))
        <label for="{{ $id }}" class="{{ $labelClass }}">{{ $label }}</label>
    @endif

    <select id="{{ $id }}"
            class="form-control{{ $controlClass }}{{ $hasError ? ' is-invalid' : '' }}"
            name="{{ $name }}{{ empty($isMultiple) ? '' : '[]' }}"
            @if (!empty($isMultiple)) multiple @endif
            @if (!empty($required)) required @endif
            @if (!empty($controlAttributes)) {{ $controlAttributes }} @endif
            >
            @foreach ($options as $optionId=>$optionLabel)
            <option value="{{ $optionId }}"
                @if (isset($value) && (empty($isMultiple) ? ($value == $optionId) : (in_array($optionId, $value)))) selected @endif
                >
                {{ $optionLabel }}
            </option>
        @endforeach
    </select>

    @if ($hasError)
        @include('components.form-input-invalid', [
            'name' => $name
        ])
    @endif
</div>
