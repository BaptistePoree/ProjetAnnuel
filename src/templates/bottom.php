<?php
    if($this->scriptList != null){
        foreach($this->scriptList as $script){
            echo '<script src="js/' . $script . '.js"></script>';
        }
    }
?>
</body>
</html>