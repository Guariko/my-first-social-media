<?php

if (!isset($scripts)) {
    $scripts = "";
}

?>

<script src="<?= $scripts ?>"></script>

<?php

if (isset($subScripts)) : ?>

    <script src="<?= $subScripts ?>"></script>

<?php endif; ?>

</body>

</html>