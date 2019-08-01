<?php
Header("Cache-Control: must-revalidate");
Header("Expires: " . gmdate("D, d M Y H:i:s", time() + 3600*24*7) . " GMT");
?>