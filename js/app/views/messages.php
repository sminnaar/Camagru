<?php $this->start('body'); ?>

        <?php
            if ($param == 1) {
                echo "<div class=\"center\">
                <h1> 1 </h1>
                </div>";
            } else if ($param == 2) {
                echo "<div class=\"center\">
                <h1> 2 </h1>
                </div>";
            }
        ?>

<?php $this->end(); ?>
