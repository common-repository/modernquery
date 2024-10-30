<?php

namespace ModernQuery\lib;

class Constants {

  const PLUGIN_NAME_INTERNAL = 'modernquery';
  const FORM_RENDERER_ALLOWED_HTML = [
    'form' => ['id' => [], 'action' => [], 'class' => [], 'data-mq-id' => []],
    'div' => ['class' => [], 'id' => [], 'data-mq-id' => []],
    'input' => ['class' => [], 'maxlength' => [], 'id' => [], 'name' => [], 'type' => [], 'value' => [], 'data-mq-id' => []], 
    'button' => ['class' => [], 'id' => [], 'name' => [], 'value' => [], 'data-mq-id' => []], 
    'select' => ['option' => ['name' => [], 'id' => [], 'value' => []], 'class' => [], 'id' => [], 'name' => [], 'data-mq-id' => []],
    'option' => ['name' => [], 'id' => [], 'value' => [], 'class' => [], 'selected' => [], 'data-mq-id' => []],
    'label' => ['id' => [], 'for' => [], 'class' => [], 'data-mq-id' => []],
    'a' => ['class' => [], 'href' => [], 'id' => [], 'target' => [], 'data-mq-id' => []],
    'textarea' => ['class' => [], 'maxlength' => [], 'id' => [], 'name' => [], 'rows' => [], 'cols' => [], 'value' => []],
    'span' => ['class' => []],
    'p' => ['class' => []],
    'img' => ['src' => [], 'width' => [], 'height' => [], 'id' => [], 'class' => []],
    'picture' => ['srcset' => [], 'src' => [], 'width' => [], 'height' => [], 'id' => [], 'class' => []],
    'strong' => [], 
    'em' => []
  ];
}

