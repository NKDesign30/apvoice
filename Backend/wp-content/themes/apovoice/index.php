<?php
// Silence is golden.
wp_redirect( get_option('apo_frontend_sso_url', 'https://apovoice.es/?option=apo-sso') );
exit;
