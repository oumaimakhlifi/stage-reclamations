<?php
if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
    exit();
} elseif ($_SESSION["role"] == "admin" && !in_array(basename($_SERVER['SCRIPT_NAME']), ["admin_dashboard.php", "admin_edit_claim.php"])) {
    header("location: admin_dashboard.php");
    exit();
} elseif ($_SESSION["role"] == "user" && !in_array(basename($_SERVER['SCRIPT_NAME']), ["user_dashboard.php", "submit_claim.php", "edit_claim.php", "delete_claim.php"])) {
    header("location: user_dashboard.php");
    exit();
}
?>
