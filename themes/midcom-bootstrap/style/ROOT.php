<?php
$head = midcom::get('head');
$i18n = midcom::get('i18n');
$context = midcom_core_context::get();
?>
<!DOCTYPE html>
<html lang="<?php echo $i18n->get_current_language(); ?>">
  <head>
    <meta charset="utf-8">
    <title><?php echo $context->get_key(MIDCOM_CONTEXT_PAGETITLE); ?> - <(title)></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    $head->add_link_head(array(
        'rel' => 'shortcut icon',
        'type' => 'image/png',
        'href' => MIDCOM_STATIC_URL . '/midcom-bootstrap/img/midcom_favicon.png'
    ));
    $head->add_stylesheet(MIDCOM_STATIC_URL . '/midcom-bootstrap/css/bootstrap.css', 'all');
    $head->add_stylesheet(MIDCOM_STATIC_URL . '/midcom-bootstrap/css/bootstrap-responsive.css', 'all');
    $head->add_stylesheet(MIDCOM_STATIC_URL . '/midcom-bootstrap/css/midcom.css', 'all');
    $head->add_jsfile(MIDCOM_STATIC_URL . '/midcom-bootstrap/js/bootstrap-dropdown.js');
    $head->enable_jquery();
    $head->print_head_elements();
    ?>
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>

  <body<?php $head->print_jsonload(); ?>>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="/"><(title)></a>
          <div class="btn-group pull-right">
            <(user)>
          </div>
          <div class="nav-collapse">
            <(navigation-top)>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span3">
          <div class="well sidebar-nav">
            <(navigation-side)>
          </div><!--/.well -->
        </div><!--/span-->
        <div class="span9">
          <(content)>
        </div><!--/span-->
      </div><!--/row-->

      <hr>

      <footer>
        <p><strong><(title)></strong> is a <a href="http://midgard-project.org/midcom/">MidCOM</a>-powered website built with <a href="http://twitter.github.com/bootstrap/">Bootstrap</a></p>
      </footer>

    </div><!--/.fluid-container-->

    <?php
    $toolbars = midcom::get('toolbars');
    $toolbars->show();
    ?>
  </body>
</html>
