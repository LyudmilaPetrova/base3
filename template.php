<?php

drupal_theme_rebuild();

/**
 * Implements hook_css_alter().
 * @TODO: Once http://drupal.org/node/901062 is resolved, determine whether
 * this can be implemented in the .info file instead.
 *
 * Omitted:
 * - color.css
 * - contextual.css
 * - dashboard.css
 * - field_ui.css
 * - image.css
 * - locale.css
 * - shortcut.css
 * - simpletest.css
 * - toolbar.css
 */
function base2_css_alter(&$css) {
  $exclude = array(
    'modules/system/system.base.css' => FALSE,
  //  'modules/system/admin.css' => FALSE,
  //  'modules/system/maintenance.css' => FALSE,
  //  'modules/system/system.css' => FALSE,
  //  'modules/system/system.admin.css' => FALSE,
    
  //  'modules/system/system.maintenance.css' => FALSE,
    'modules/system/system.menus.css' => FALSE,
  //  'modules/system/system.messages.css' => FALSE,
    'modules/system/system.theme.css' => FALSE,
  //  'misc/vertical-tabs.css' => FALSE,
  //  'modules/aggregator/aggregator.css' => FALSE,
  //  'modules/block/block.css' => FALSE,
  //  'modules/book/book.css' => FALSE,
  //  'modules/comment/comment.css' => FALSE,
  //  'modules/dblog/dblog.css' => FALSE,
  //  'modules/file/file.css' => FALSE,
  //  'modules/filter/filter.css' => FALSE,
  //  'modules/forum/forum.css' => FALSE,
  //  'modules/help/help.css' => FALSE,
  //  'modules/menu/menu.css' => FALSE,
  //  'modules/node/node.css' => FALSE,
  //  'modules/openid/openid.css' => FALSE,
  //  'modules/poll/poll.css' => FALSE,
  //  'modules/profile/profile.css' => FALSE,
  //  'modules/search/search.css' => FALSE,
  //  'modules/statistics/statistics.css' => FALSE,
  //  'modules/syslog/syslog.css' => FALSE,
  //  'modules/taxonomy/taxonomy.css' => FALSE,
  //  'modules/tracker/tracker.css' => FALSE,
  //  'modules/update/update.css' => FALSE,
  //  'modules/user/user.css' => FALSE,
  );
  $css = array_diff_key($css, $exclude);
}

function base2_preprocess_html(&$vars) {
//  $vars['classes_array'][] = 'debug'; $vars['classes_array'][] = 'debug-index';
 
}

function base2_preprocess_page(&$vars) {
  global $base_path;
  $vars['path_to_theme'] = $base_path.drupal_get_path('theme', variable_get('theme_default', NULL));
  
  $vars['main_content_class'] = 'span16';
  if($vars['page']['sidebar_first'] && $vars['page']['sidebar_second']) {
    $vars['main_content_class'] = 'span8';
  } else if($vars['page']['sidebar_first'] || $vars['page']['sidebar_second']) {
    $vars['main_content_class'] = 'span12';
  }
  
  
  $vars['print_link'] = '';
  if(array_key_exists('node', $vars) && strpos($_SERVER["REQUEST_URI"], "print") === false) {
    $vars['print_link'] = print_insert_link();//l("Версия для печати", 'print/'.$vars['node']->nid, array('attributes' => array('class' => array('printer-frendly'))));
   //print_r($vars['node']);
  } 
  //print_r(arg(0));
//  print_r(array_keys($vars));
}


function base2_preprocess_block(&$variables) {
 $variables['title_attributes_array']['class'][] = "block-title";
}

function base2_preprocess_node(&$variables) {
  $variables['title_attributes_array']['class'][] = "node-title";
  
  $theme_path = drupal_get_path('theme', 'dao');
  
  $variables['date'] = format_date($variables['node']->created, 'medium');
  
  if($variables['submitted']) {
    $variables['submitted'] = t('Published: !datetime', array('!datetime' => $variables['date']));
  }
  
  //print_r($variables['content']['links']);
  
  unset($variables['content']['links']['comment']);

}

/*
function base2_preprocess_maintenance_page(&$variables)
{
  $variables['theme_path'] = drupal_get_path('theme', 'dao');
} */

function base2_preprocess_field(&$vars, $hook) {
  // Add specific suggestions that can override the default implementation.
  array_unshift($vars['theme_hook_suggestions'], 'field__' . $vars['element']['#field_type']);
  array_unshift($vars['theme_hook_suggestions'], 'field__' . $vars['element']['#field_name']);
 // print_r($vars['element']['#field_type']);
}

function base2_field__image($vars) {
  $output = '';
  
 // print_r($vars);
  $vars['element']['#field_name'];

  // Render the label, if it's not hidden.
  if (!$vars['label_hidden']) {
    $output .= '<h3>' . $vars['label'] . '</h3>';
  }
  
  if(count($vars['items']) > 1)
  {
    
    // Render the items.
    $output .= '<ul class="thumbnails">';
    foreach ($vars['items'] as $delta => $item) {
      //print_r($item);
      $output .= '<li>' . drupal_render($item) . '</li>';
    }
    $output .= '</ul>';
  }
  else
  {
    foreach ($vars['items'] as $delta => $item) {
      $output .= drupal_render($item); 
    }
  }

  

  // Render the top-level DIV.
  $output = '<div class="image-field '.$vars['field_name_css'].'">' . $output . '</div>'; 

  return $output;
}

function base2_colorbox_imagefield($variables) {
  $class = array('colorbox');
  $class[] = 'thumbnail';

  if ($variables['image']['style_name'] == 'hide') {
    $image = '';
    $class[] = 'js-hide';
  }
  else if (!empty($variables['image']['style_name'])) {
    $image = theme('image_style', $variables['image']);
  }
  else {
    $image = theme('image', $variables['image']);
  }

  $options = array(
    'html' => TRUE, 
    'attributes' => array(
      'title' => $variables['title'], 
      'class' => implode(' ', $class), 
      'rel' => $variables['gid'],
    ),
  );

  return l($image, $variables['path'], $options);
}

function base2_field__text_long($vars) {
  $output = '';

  // Render the label, if it's not hidden.
  if (!$vars['label_hidden']) {
    $output .= '<h3>' . $vars['label'] . '</h3>';
  }

  // Render the items.

  foreach ($vars['items'] as $delta => $item) {
    $output .= '' . drupal_render($item) . '';
  }


  // Render the top-level DIV.
  $output = '<div class="'.$vars['field_name_css'].'">' . $output . '</div>';

  return $output;
}




function base2_menu_link__main_menu($variables) 
{
  //print_r($element['#attributes']);
  
  $element = $variables['element'];
  $sub_menu = '';
  
 // print_r($element['#attributes']);
  
  $attrs = $element['#attributes'];
  
  $menu_delim = "";
  
  //if(!array_key_exists('last',array_flip($attrs['class'])))
  //{
  // // print_r($attrs);
  //  $menu_delim = "<li class='delim'>/</li>\n";
  //}

  $item_id = 'mlid-'.$element['#original_link']['mlid'];
  $element['#localized_options']['attributes']['class'][] = $item_id;

  if ($element['#below']) {
    $sub_menu = drupal_render($element['#below']);
  }
  $output = l($element['#title'], $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n" . $menu_delim;
}

function base2_pager($variables) {
  $tags = $variables['tags'];
  $element = $variables['element'];
  $parameters = $variables['parameters'];
  $quantity = $variables['quantity']; // Сколько страниц показано
 // print_r($element); 
  global $pager_page_array; // Текущая страница
  global $pager_total; // сколько страниц всего
  
  //print_r($pager_total);

  // Calculate various markers within this pager piece:
  // Middle is used to "center" pages around the current page.
  $pager_middle = ceil($quantity / 2);
  // current is the page we are currently paged to
  $pager_current = $pager_page_array[$element] + 1;
  // first is the first page listed by this pager piece (re quantity)
  $pager_first = $pager_current - $pager_middle + 1;
  // last is the last page listed by this pager piece (re quantity)
  $pager_last = $pager_current + $quantity - $pager_middle;
  // max is the maximum page number
  $pager_max = $pager_total[$element];
  // End of marker calculations.

  // Prepare for generation loop.
  $i = $pager_first;
  if ($pager_last > $pager_max) {
    // Adjust "center" if at end of query.
    $i = $i + ($pager_max - $pager_last);
    $pager_last = $pager_max;
  }
  if ($i <= 0) {
    // Adjust "center" if at start of query.
    $pager_last = $pager_last + (1 - $i);
    $i = 1;
  }
  // End of generation loop preparation.

  $li_first = theme('pager_first', array('text' => (isset($tags[0]) ? $tags[0] : t('« first')), 'element' => $element, 'parameters' => $parameters));
  $li_previous = ''; //theme('pager_previous', array('text' => (isset($tags[1]) ? $tags[1] : t('‹ previous')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
  $li_next = ''; //theme('pager_next', array('text' => (isset($tags[3]) ? $tags[3] : t('next ›')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
  $li_last = theme('pager_last', array('text' => (isset($tags[4]) ? $tags[4] : t('last »')), 'element' => $element, 'parameters' => $parameters));

  if ($pager_total[$element] > 1) {
    if ($li_first) {
      $items[] = array(
        'class' => array('pager-first'), 
        'data' => $li_first,
      );
    }
    if ($li_previous) {
      $items[] = array(
        'class' => array('pager-previous'), 
        'data' => $li_previous,
      );
    }

    // When there is more than one page, create the pager list.
    if ($i != $pager_max) {
      if ($i > 1) {
        $items[] = array(
          'class' => array('pager-ellipsis'), 
          'data' => '…',
        );
      }
      // Now generate the actual pager piece.
      for (; $i <= $pager_last && $i <= $pager_max; $i++) {
        if ($i < $pager_current) {
          $items[] = array(
            'class' => array('pager-item'), 
            'data' => theme('pager_previous', array('text' => $i, 'element' => $element, 'interval' => ($pager_current - $i), 'parameters' => $parameters)),
          );
        }
        if ($i == $pager_current) {
          $items[] = array(
            'class' => array('pager-current'), 
            'data' => $i,
          );
        }
        if ($i > $pager_current) {
          $items[] = array(
            'class' => array('pager-item'), 
            'data' => theme('pager_next', array('text' => $i, 'element' => $element, 'interval' => ($i - $pager_current), 'parameters' => $parameters)),
          );
        }
      }
      if ($i < $pager_max) {
        $items[] = array(
          'class' => array('pager-ellipsis'), 
          'data' => '…',
        );
      }
    }
    // End generation.
    if ($li_next) {
      $items[] = array(
        'class' => array('pager-next'), 
        'data' => $li_next,
      );
    }
    if ($li_last) {
      $items[] = array(
        'class' => array('pager-last'), 
        'data' => $li_last,
      );
    }
    return '<h2 class="element-invisible">' . t('Pages') . '</h2>' . theme('item_list', array(
      'items' => $items, 
      'attributes' => array('class' => array('pager')),
    ));
  }
}

function base2_file_link($variables) {
  $file = $variables['file'];
  $icon_directory = $variables['icon_directory'];

  $url = file_create_url($file->uri);
  $icon = theme('file_icon', array('file' => $file, 'icon_directory' => $icon_directory));

  // Set options as per anchor format described at
  // http://microformats.org/wiki/file-format-examples
  $options = array(
    'attributes' => array(
      'type' => $file->filemime . '; length=' . $file->filesize,
    ),
  );

  // Use the description as the link text if available.
  if (empty($file->description)) {
    $link_text = $file->filename;
  }
  else {
    $link_text = $file->description;
    $options['attributes']['title'] = check_plain($file->filename);
  }

  return '<span class="file">' . $icon . ' ' . l($link_text, $url, $options) . ' (' . format_size($file->filesize) .')'.'</span>';
}

function base2_file_formatter_table($variables) {
  //print_r($variables);
  
  $rows = array();
  foreach ($variables['items'] as $delta => $item) {
    $rows[] = array(
      theme('file_link', array('file' => (object) $item)),
      array('data' => format_size($item['filesize']), 'class' => 'file-weight'),
    );
  }
  return empty($rows) ? '' : theme('table', array('rows' => $rows));
}

function base2_button($variables) {
  $element = $variables['element'];
  $element['#attributes']['type'] = 'submit';
  element_set_attributes($element, array('id', 'name', 'value'));
  
  $element['#attributes']['class'][] = 'btn';
  $element['#attributes']['class'][] = 'btn-large';
  

  $element['#attributes']['class'][] = 'form-' . $element['#button_type'];
  if (!empty($element['#attributes']['disabled'])) {
    $element['#attributes']['class'][] = 'form-button-disabled';
  }

  return '<input' . drupal_attributes($element['#attributes']) . ' />';
}

