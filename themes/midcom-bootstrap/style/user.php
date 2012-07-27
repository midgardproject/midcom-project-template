<?php
$auth = midcom::get('auth');
if ($auth->is_valid_user()) {
    ?>
    <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
      <i class="icon-user"></i> <?php echo $auth->user->name; ?>
      <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
      <li><a href="/midcom-logout-"><?php echo $i18n->get_string('logout', 'midcom'); ?></a></li>
    </ul>
    <?php
} else {
    ?>
    <a class="btn" href="/midcom-login-"><?php echo $i18n->get_string('login', 'midcom'); ?></a>
    <?php
}
?>
