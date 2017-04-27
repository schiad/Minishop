<?php

function redirect_to($url) {
    ?>
    <script type="text/javascript">
        window.location.href = '<?php echo $url ?>';
    </script>
    <?php
}
?>