<?php
/**
 * @file
 * File which contains theme overrides for the Deco theme.
 */


/**
 * Override or insert PHPTemplate variables into the templates.
 */

function deco_preprocess_html(&$vars) {
  $vars['classes_array'] = isset($vars['classes_array']) ? $vars['classes_array'] : '';
  // variable to see if we have a triple sidebars and are not on block admin page
  $vars['sidebar_triple'] = FALSE;
  // add variable for block admin page
  $vars['block_admin'] = FALSE;

    if (arg(2) == 'block' && arg(3) == FALSE) {
      $vars['block_admin'] = TRUE;
      _deco_alert_layout($vars);
      $vars['classes_array'][] .= ' block-admin';
    }

    else {
      // convert secondary right sidebar to right sidebar if there's no right sidebar
      if (!empty($vars['page']['sidebar_right_sec']) && empty($vars['page']['sidebar_second'])) {
	$vars['page']['sidebar_second'] = $vars['page']['sidebar_right_sec'];
	$vars['page']['sidebar_right_sec'] = '';
      }

      // set a class on the body to allow easier css themeing based on the layout type
      if (!empty($vars['page']['sidebar_second']) && !empty($vars['page']['sidebar_right_sec']) && !empty($vars['page']['sidebar_first'])) {
	$vars['classes_array'][] .= ' sidebar-triple';

	$vars['sidebar_triple'] = TRUE;
      }
      elseif (!empty($vars['page']['sidebar_first']) && !empty($vars['page']['sidebar_second'])) {
	$vars['classes_array'][] .= ' sidebar-double';
      }
      elseif (!empty($vars['page']['sidebar_second']) && !empty($vars['page']['sidebar_right_sec'])) {
	$vars['classes_array'][] .= ' sidebar-right-double';
      }
      elseif (!empty($vars['page']['sidebar_first'])) {
	$vars['classes_array'][] .= ' sidebar-left';
      }
      elseif (!empty($vars['page']['sidebar_second']) || !empty($vars['page']['sidebar_right_sec'])) {
	$vars['classes_array'][] .= ' sidebar-right';
      }
      if (!empty($vars['page']['sidebar_second'])) {
	$vars['classes_array'][] .= ' rightbar';
      }
    }
  }

function deco_preprocess_page(&$vars) {
 $vars['sidebar_triple'] = FALSE;
 if (!empty($vars['page']['sidebar_second']) && !empty($vars['page']['sidebar_right_sec']) && !empty($vars['page']['sidebar_first'])) {
	$vars['classes_array'][] .= ' sidebar-triple';
	$vars['sidebar_triple'] = TRUE;
      }
 if (!empty($vars['page']['sidebar_right_sec']) && empty($vars['page']['sidebar_second'])) {
	$vars['page']['sidebar_second'] = $vars['page']['sidebar_right_sec'];
	$vars['page']['sidebar_right_sec'] = '';
      }

  // set variables for the logo and slogan
  $site_fields = array();
  if ($vars['site_name']) {
    $site_fields[] = check_plain($vars['site_name']);
  }
  if ($vars['site_slogan']) {
    $site_fields[] = '- '.check_plain($vars['site_slogan']);
  }

  $vars['site_title'] = implode(' ', $site_fields);

  if (isset($site_fields[0])) {
    $site_fields[0] = '<span class="site-name">'. $site_fields[0] .'</span>';
  }
  if (isset($site_fields[1])) {
    $site_fields[1] = '<span class="site-slogan">'. $site_fields[1] .'</span>';
  }
  $vars['site_title_html'] = implode(' ', $site_fields);

  // convert primary links to lowercase and secondary links to uppercase
  if ($vars['main_menu']) {
    foreach ($vars['main_menu'] as $key => $link) {
      $vars['main_menu'][$key]['title'] =  strtolower($link['title']);
    }
  }
  if ($vars['secondary_menu']) {
    foreach ($vars['secondary_menu'] as $key => $link) {
      $vars['secondary_menu'][$key]['title'] = strtoupper($link['title']);
    }
  }

$vars['primary_menu'] = str_replace('class="menu"', 'class="links primary-links"', render(menu_tree('main-menu')));

}

/**
 * Alert the user when the layout is changed based on the used regions.
 *
 * @param $regions
 *   An associative array containing the regions.
 */
function _deco_alert_layout($regions) {
  if (user_access('administer blocks')) {
    // remove the block indicators first
    $sidebars = array(
		      'sidebar_right_sec' => $regions['page']['content']['system_main']['block_regions']['#value']['sidebar_right_sec'],
		      'sidebar_second'     => $regions['page']['content']['system_main']['block_regions']['#value']['sidebar_second'],
		      'sidebar_first'      => $regions['page']['content']['system_main']['block_regions']['#value']['sidebar_first']
		      );
    foreach ($sidebars as $k => $v) {
      $sidebars[$k] = preg_replace('/(\<div class="block-region"\>)(.*)(\<\/div\>)/', '', $v);
    }

    // warn the user that the secondary right sidebar will look like a regular right sidebar
    if ($sidebars['sidebar_right_sec'] && empty($sidebars['sidebar_right'])) {
      drupal_set_message(t('Warning: if you add blocks to the <em>secondary right sidebar</em> and leave the <em>right sidebar</em> empty, the <em>secondary right
			sidebar</em> will be rendered as a regular <em>right sidebar</em>.'));
    }
    // warn the user that the three sidebars will look like three equal columns
    elseif ($sidebars['sidebar_right'] && $sidebars['sidebar_right_sec'] && $sidebars['sidebar_first']) {
      drupal_set_message(t('Warning: if you add blocks to all three sidebars they will be rendered as three equal columns above the content.'));
    }
  }
}



/**
 * Generates the html to be rendered in the content area. Prevents duplication in the page template file
 */
/*function deco_render_content($page['content'], $tabs, $title, $page['help'],$messages, $feed_icons, $classes) {*/
//function deco_render_content($content, $tabs, $title, $help, $show_messages, $messages, $feed_icons, $classes) {

function deco_render_content($tabs, $title, $messages, $classes) {
  $in_node = (strstr($classes, 'page-node') ? TRUE : FALSE);
  $output = '';
  $output .= ((!empty($title)) ? '<h2 class="content-title">'.$title.'</h2>' : '');
  $primary_tabs = menu_primary_local_tasks();
  $tabs = drupal_render($primary_tabs);
  $output .= ($tabs ? deco_menu_local_tasks('<ul class="tabs primary">'.$tabs.'</ul>') : '');
  $secondary_tab = menu_secondary_local_tasks();
  $secondary_tabs = drupal_render($secondary_tab);
  $output .= ($secondary_tabs ? deco_menu_secondary_local_tasks('<ul class="tabs secondary">'.$secondary_tabs.'</ul>') : '');
  $output .= (($messages) ? $messages : '');
  return $output;

}

/**
 * Format a group of form items.
 * Add HTML hooks for advanced styling
 *
 * @param $element
 *   An associative array containing the properties of the element.
 *   Properties used: attributes, title, value, description, children, collapsible, collapsed
 * @return
 *   A themed HTML string representing the form item group.
 */

function deco_fieldset($variables) {
  $element = $variables['element'];
  element_set_attributes($element, array('id'));
  _form_set_class($element, array('form-wrapper'));

  $output = '<fieldset' . drupal_attributes($element['#attributes']) . '>';
  if (!empty($element['#title'])) {
    // Always wrap fieldset legends in a SPAN for CSS positioning.
    $output .= '<legend><span class="fieldset-legend">' . $element['#title'] . '</span></legend>';
  }
  $output .= '<div class="fieldset-wrapper"><div class="top"><div class="bottom"><div class="bottom-ornament">';
  if (!empty($element['#description'])) {
    $output .= '<div class="fieldset-description">' . $element['#description'] . '</div>';
  }
  $output .= $element['#children'];
  if (isset($element['#value'])) {
    $output .= $element['#value'];
  }
  $output .= '</div></div></div></div>';
  $output .= "</fieldset>\n";

  return $output;
}


/**
 * Returns the rendered local tasks. The default implementation renders
 * them as tabs.
 *
 * @ingroup themeable
 */
function deco_menu_local_tasks($tasks = '') {
  $output = '';
  if (!empty($tasks)) {
    $output = "\n<div class=\"content-bar clear-block\"><div class=\"left\">\n". $tasks ."\n</div></div>\n";
  }

  return $output;
}


/**
 * Returns the rendered local tasks. The default implementation renders
 * them as tabs.
 *
 * @ingroup themeable
 */
function deco_menu_secondary_local_tasks($tasks = '') {
  $output = '';
  if (!empty($tasks)) {
    $output = "\n<div class=\"content-bar-indented\"><div class=\"content-bar clear-block\"><div class=\"left\">\n". $tasks ."\n</div></div></div>\n";
  }

  return $output;
}

/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return a string containing the breadcrumb output.
 */

function deco_breadcrumb($variables) {
  $breadcrumb = $variables['breadcrumb'];
  $output = "";

  if (!empty($breadcrumb)) {
    // Provide a navigational heading to give context for breadcrumb links to
    // screen-reader users. Make the heading invisible with .element-invisible.

    $output .= '<div class="breadcrumb">' . implode(' » ', $breadcrumb) . '</div>';
    return $output;
  }
}

/**
 * 	Format a query pager.
 *
 * Menu callbacks that display paged query results should call theme('pager') to retrieve a pager control so that users can view
 * other results. Format a list of nearby pages with additional query results.
 *
 * Adds HTML hooks for making the pager appear in a horizontal bar
 */


function deco_pager($variables) {
  $output = theme_pager($variables);
  if (!empty($variables)) {
    $output = '<div class="content-bar"><div class="left">'.$output.'</div></div>';
  }
  return $output;
}

/*Adds HTML hooks for making the terms appear in a horizontal bar*/

function deco_field__taxonomy_term_reference($variables) {
  $output = '';
  // Render the items.
  $output .= '<div class= terms>';
  $output .= ($variables['element']['#label_display'] == 'inline') ? '<ul class="links inline">' : '<ul class="links inline">';
  foreach ($variables['items'] as $delta => $item) {
    $output .= '<li class="taxonomy-term-' . $delta . '"' . $variables['item_attributes'][$delta] . '>' . drupal_render($item) . '</li>';
    }
  $output .= '</ul>';
  // Render the top-level DIV.
  $output = '<div class="' . $variables['classes'] . (!in_array('clearfix', $variables['classes_array']) ? ' clearfix' : '') . '">' . $output . '</div></div>';
  return $output;
}


