<?php
$class = (isset($class) ? $class : '');
$href = (isset($href) ? $href : '#');
?>
<a class="{{ $class }}" href="{{ $href }}">{{$label or ''}}</a>