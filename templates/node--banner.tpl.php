<?php
	//print_r($content);
  if($content['field_banner_image'])
  {
    hide($content['field_banner_image'][0]);
   // print ;
    print render($title_prefix);
    print render($title_suffix);
    print "<a href=".$field_banner_link[0]['display_url'].drupal_attributes($field_banner_link[0]['attributes']).">".render($content['field_banner_image'][0])."</a>";
   
  }
