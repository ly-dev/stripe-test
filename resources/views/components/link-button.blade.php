<?php
$class = (isset($class) ? $class : 'btn btn-primary');
$href = (isset($href) ? $href : '#');
?>
<a class="{{ $class }}" href="{{ $href }}">{{$label or ''}}</a>