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
<div id="pageWrapper">
  <header class="page-header">
    <div class="container">
	  <?php if ($logo): ?>
        <a href="<?php print $front_page; ?>" title="<?php print t($site_name); ?>" id="logo">
          <img src="<?php print $logo; ?>" alt="<?php print $site_name; ?>" />
          <?php if ($site_slogan): ?>
            <span class="site-slogan"><?php print $site_slogan; ?></span>
          <?php endif; ?>
          <span class="site-name"><?php print $site_name; ?></span>
          
        </a>
        
        
    <?php endif; ?>
    <?php print render($page['header']); ?>

    <?php
      $tree = menu_tree_all_data('main-menu', NULL, 2);
      $tree = menu_tree_output($tree);

      foreach ($tree as $id => $item) {
        if (is_int($id)) {
          $tree[$id]['#title'] = str_replace(array(' ', '-'), array('||||', '-||||'), $item['#title']);
        }
      }

      foreach($tree as $key => $val)
       {
         if(is_array($val) && intval($key) > 0)
         {
           $tree[$key]['#theme'] = 'main_menu_link';
         }
       }

      $menu = drupal_render($tree);
      print str_replace('||||', '<br/>', $menu);
    ?>
    </div>
  </header>

<div class="container">
  
  <?php if ($page['promo_left'] || $page['promo_right']):  ?>
    <div class="promo_wrapper">
      <?php print render($page['promo_left']); ?>
      <?php print render($page['promo_right']); ?>
    </div>
  <?php endif; ?>
  
    <!-- Grid system
  ================================================== -->
  <section id="gridSystem">
    <div class="row">
      <?php if ($page['sidebar_first']): ?>
        <div class="span4"><?php print render($page['sidebar_first']); ?></div>
      <?php endif; ?>
      
      <div class="<?php print $main_content_class; ?>">
        <?php if ($breadcrumb): ?>
          <?php print $breadcrumb; ?>
        <?php endif; ?>

        <?php print $messages; ?>
        
        
          
        <?php if ($page['highlighted']): ?><div id="highlighted"><?php print render($page['highlighted']); ?></div><?php endif; ?>
        <?php print render($title_prefix); ?>
        <?php print $print_link; ?>
        <?php if ($title && !$is_front): ?><h1 class="page-title"><?php print $title; ?></h1><?php endif; ?>
        <?php print render($title_suffix); ?>
        <?php //print_r($tabs); ?>
        <?php if ($tabs['#primary']): ?><div class="system-tabs"><?php print render($tabs); ?></div><?php endif; ?>
        <?php print render($page['help']); ?>
        
        <?php if ($action_links): ?><ul class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>
        <?php print render($page['content']); ?>     
        
        <?php //print $feed_icons; ?>
      </div>
      
      <?php if ($page['sidebar_second']): ?>
        <div class="span4"><?php print render($page['sidebar_second']); ?></div>
      <?php endif; ?>
    
    </div><!--/.row-->

  </section>
  
  <?php if ($page['line3']) print render($page['line3']); ?>
  
  <?php if($page['ext_left'] || $page['ext_right']): ?>
    <div id="extWrapper">
      <?php if ($page['ext_left']) print render($page['ext_left']); ?>
      <?php if ($page['ext_right']) print render($page['ext_right']); ?>
    </div>
  <?php endif; ?>
  
  <?php if ($page['footer_banners']) print render($page['footer_banners']); ?>

 <!-- Footer
  ================================================== -->
  <footer class="footer">

    <?php print render($page['footer']); ?>
    
    <div class="seenta">
      <a href="http://seenta.ru">Создание сайта</a>&nbsp;&mdash;<br />
      Веб-студия Seenta.ru
    </div><!-- /.seenta -->
    
    <?php print render($page['footer_counters']); ?>
  </footer>

</div><!-- /container -->
</div><!-- /#page-wrapper -->

