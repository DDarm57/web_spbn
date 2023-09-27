<?php

session_start();
unset($_SESSION['log']);
unset($_SESSION['id_user']);
unset($_SESSION['role']);
session_destroy();

echo "
<script>
window.location.href = 'index.php';
</script>
";
