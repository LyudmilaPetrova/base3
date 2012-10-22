<?php
// $Id: page.tpl.php,v 1.47 2010/11/05 01:25:33 dries Exp $

/**
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['header']: Items for the header region.
 * - $page['footer']: Items for the footer region.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see template_process()
 */
?>
<div class="wrapper">
  <div class="header clearfix">
    <div class="top-line">
      <div class="in">
        <?php print $print_link; ?>
        <?php if(module_exists('search')): ?>
        <div class="search-block">
          <?php 
            $block = module_invoke('search', 'block_view', 'search');
            print render($block);
          ?>
        </div>
        <?php endif; ?>
      </div>
    </div><!--/.top-line-->
    <div class="in">
    <?php if ($logo): ?>
      <a href="<?php print $front_page; ?>" title="<?php print $front_page; ?>" id="logo">
        <img src="<?php print $logo; ?>" alt="<?php print $site_name; ?>" />
      </a>
     
      <?php endif; ?>
    <?php print render($page['header']); ?>
    
      <div class="menu-line">
    
        <?php
       /*
          $tree = menu_tree_page_data('main-menu', 2);
          $tree = menu_tree_output($tree);
          print drupal_render($tree); */
          
          $tree = menu_tree('main-menu');
          $tree['#theme_wrappers'][0] = 'sf_menu_tree';
          print drupal_render($tree);
          
        ?>
        
        
      </div><!--/.menu-line-->
    </div><!--/.in-->
  </div> <!-- /.header -->
  <div class="all-content-wrapper">

  
  <?php if($messages): ?>
    <div class="in"><?php print $messages; ?></div>
  <?php endif; ?>
  <div class="in">
    <?php print render($page['ext_menu']); ?>
    
  <?php //print $breadcrumb; ?>
  <div id="mainContentWrapper">
    <div class="center-content" >
      <?php if ($page['highlighted']): ?><div id="highlighted"><?php print render($page['highlighted']); ?></div><?php endif; ?>
      <?php print render($title_prefix); ?>
      <?php if ($title && !$is_front): ?><h1 class="page-title"><?php print $title; ?></h1><?php endif; ?>
      <?php print render($title_suffix); ?>
      <?php //print_r($tabs); ?>
      <?php if ($tabs['#primary']): ?><div class="system-tabs"><?php print render($tabs); ?></div><?php endif; ?>
      <?php print render($page['help']); ?>
      <?php if ($action_links): ?><ul class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>
        <?php print render($page['content']); ?>

      <?php print $feed_icons; ?>
    </div><!-- /.center-content -->
  </div><!--/#contentWrapper-->    
     
    <?php if ($page['sidebar_second']): ?>
      <?php print render($page['sidebar_second']); ?>
    <?php endif; ?>
    
    <?php if ($page['sidebar_first']): ?>
      <?php print render($page['sidebar_first']); ?>
    <?php endif; ?>
  </div><!--/.in -->
  
  </div><!--/.all-content-wrapper-->

 
<div class="footer-null"></div>
<div class="footer">
  <div class="in">
    <?php print render($page['footer_banners']); ?>
    <div class="footer-right">
      <?php print render($page['footer']); ?>
      <div class="seenta">Создание сайта &mdash; веб-студия «<a href="http://seenta.ru/">Seenta</a>»</div> 
    </div><!-- /.footer-right -->    
       
  </div><!--/.in -->
</div><!-- /.footer -->

</div> <!-- /.wrapper -->