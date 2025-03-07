<?php
if (isset($_SESSION['message'])) { ?>

<div class="alert alert-success">
    <?= $_SESSION['message'] ?>
</div>
<?php }
unset($_SESSION['message']) ?>