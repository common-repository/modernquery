<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$rand_id = uniqid();

?>

<div class="mq-chat-form-wrapper">
  <div class="mq-chat-form-label">
    <label for="mq-chat-prompt-<?php print esc_html($rand_id);?>">Enter a question:</label>
  </div>
  <div class="mq-chat-form-wrapper">
    <form class="mq-chat-form" action="#">
      <input data-mq-id="<?php print esc_html($rand_id); ?>" id="mq-chat-prompt-<?php print esc_html($rand_id);?>" class="mq-chat-prompt" type="text"></input>
    </form>
  </div>
  <div class="mq-chat-form-submit-wrapper">
    <button data-mq-id="<?php print esc_html($rand_id); ?>" class="mq-chat-form-submit-button">Submit</button>
  </div>
</div>
<div class="mq-chat-results-wrapper">
  <div class="mq-chat-results" data-mq-id="<?php print esc_html($rand_id);?>">
  </div>
</div>

