<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<h1>ModernQuery Settings</h1>
<form method="POST" action="options.php">
<?php
    settings_fields( 'modernquery' );
    do_settings_sections( 'modernquery' );
    submit_button();
?>
</form>
