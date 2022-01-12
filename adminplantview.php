<?php
include 'scripts/phpFunctions.php';
sessionCheck();

include 'content/head.html';
include 'content/header.html';

if (accessLvlCheck() != 4) {
  echo "you do not have permission to view this content.";
} else {  
  include 'content/adminplantview_content.html';
}

include 'content/footer.html';


 ?>
