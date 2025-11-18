<?php
function get_kontak_data() {
    if (!isset($_SESSION['kontak'])) {
        $_SESSION['kontak'] = [];
    }
    return $_SESSION['kontak'];
}

function save_kontak_data($kontak) {
    $_SESSION['kontak'] = $kontak;
}
?>