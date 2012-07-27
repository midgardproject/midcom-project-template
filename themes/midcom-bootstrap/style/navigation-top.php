<?php
// Loads the component for the first time
midcom::get('componentloader')->load('fi.protie.navigation');

$navigation = new fi_protie_navigation();
$navigation->list_levels = 1;
$navigation->css_list_style = 'nav';
$navigation->draw();
?>
