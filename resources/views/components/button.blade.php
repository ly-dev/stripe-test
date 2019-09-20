<?php
$class = (isset($class) ? ' ' . $class : ' btn-primary');
$type = (isset($type) ? $type : 'button');
?>
<button type="submit" class="btn{{ $class }}">{{$label ?? ''}}</button>