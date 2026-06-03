<?php

session_start();

session_unset();

session_destroy();

header(
    "Location: Formularios/login_form.php"
);

exit;