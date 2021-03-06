<?php

/**
 * @file page.tpl.php
 *
 * Theme implementation to display a single Drupal page.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $css: An array of CSS files for the current page.
 * - $directory: The directory the theme is located in, e.g. themes/garland or
 *   themes/garland/minelli.
 * - $is_front: TRUE if the current page is the front page. Used to toggle the mission statement.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Page metadata:
 * - $language: (object) The language the site is being displayed in.
 *   $language->language contains its textual representation.
 *   $language->dir contains the language direction. It will either be 'ltr' or 'rtl'.
 * - $head_title: A modified version of the page title, for use in the TITLE tag.
 * - $head: Markup for the HEAD section (including meta tags, keyword tags, and
 *   so on).
 * - $styles: Style tags necessary to import all CSS files for the page.
 * - $scripts: Script tags necessary to load the JavaScript files and settings
 *   for the page.
 * - $body_classes: A set of CSS classes for the BODY tag. This contains flags
 *   indicating the current layout (multiple columns, single column), the current
 *   path, whether the user is logged in, and so on.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 * - $mission: The text of the site mission, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $search_box: HTML to display the search box, empty if search has been disabled.
 * - $primary_links (array): An array containing primary navigation links for the
 *   site, if they have been configured.
 * - $secondary_links (array): An array containing secondary navigation links for
 *   the site, if they have been configured.
 *
 * Page content (in order of occurrance in the default page.tpl.php):
 * - $left: The HTML for the left sidebar.
 *
 * - $breadcrumb: The breadcrumb trail for the current page.
 * - $title: The page title, for use in the actual HTML content.
 * - $help: Dynamic help text, mostly for admin pages.
 * - $messages: HTML for status and error messages. Should be displayed prominently.
 * - $tabs: Tabs linking to any sub-pages beneath the current page (e.g., the view
 *   and edit tabs when displaying a node).
 *
 * - $content: The main content of the current Drupal page.
 *
 * - $right: The HTML for the right sidebar.
 *
 * Footer/closing data:
 * - $feed_icons: A string of all feed icons for the current page.
 * - $footer_message: The footer message as defined in the admin settings.
 * - $footer : The footer region.
 * - $closure: Final closing markup from any modules that have altered the page.
 *   This variable should always be output last, after all other dynamic content.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 */
?>
<div id="page">

	<div id="header">
		<div id="header-image">
			<?php if ($header_image): ?>
			<?php print_r($header_image); ?>
			<?php endif; ?>
		</div>
	
    	<div id="logo-title">
			<?php if (!empty($logo)): ?>
              <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" id="logo"><img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" /></a>
            <?php endif; ?>
    
            <div id="name-and-slogan">
				  <?php if (!empty($site_name)): ?>
                    <h1 id="site-name"><a href="<?php print $front_page ?>" title="<?php print t('Home'); ?>" rel="home"><span><?php print $site_name; ?></span></a></h1>
                  <?php endif; ?>
        
                  <?php if (!empty($site_slogan)): ?>
                    <div id="site-slogan"><?php print $site_slogan; ?></div>
                  <?php endif; ?>              
			</div> <!-- /name-and-slogan -->
		</div> <!-- /logo-title -->

		<?php if (!empty($search_box)): ?>
        	<div id="search-box"><?php print $search_box; ?></div>
        <?php endif; ?>
        
        <?php if (!empty($header)): ?>
        	<div id="header-region"><?php print $header; ?></div>
        <?php endif; ?>
        
        
        	<div id="primary" class="clearfix"><?php print theme('links__system_main_menu', array('links' => $main_menu, 'attributes' => array('id' => 'main-menu', 'class' => array('links', 'inline', 'clearfix')))); ?></div>
        
    </div> <!-- /header -->
    
    <!-- <div id="navigation" class="menu <?php if (!empty($primary_links)) { print "withprimary"; } if (!empty($secondary_links)) { print " withsecondary"; } ?> "> -->
		
        	<div id="secondary" class="clearfix"><?php print theme('links__system_secondary_menu', array('links' => $secondary_menu, 'attributes' => array('id' => 'secondary-menu', 'class' => array('links', 'inline', 'clearfix')))); ?></div>
        
    <!-- </div> --><!-- /navigation -->   

	<div id="container" class="clearfix">
	
		<?php if ($page['sidebar_first']): ?>
      		<div id="sidebar-first" class="column sidebar">
		        <?php print render($page['sidebar_first']); ?>
      		</div> <!-- /.section, /#sidebar-first -->
    	<?php endif; ?>
    
        <div id="main" class="column">
            <div id="main-squeeze">
                <?php if ($breadcrumb): ?>
                    <div id="breadcrumb"><?php print $breadcrumb; ?></div>
                <?php endif; ?>
                
                <?php if (!empty($mission)): ?>
                    <div id="mission"><?php print $mission; ?></div>
                <?php endif; ?>
                
                <?php if ($page['above_content']): ?>
                    <div id="above-content"><?php print render ($page['above_content']); ?></div> <!-- /above-content -->
                <?php endif; ?>
                
                <div id="content">
                    <?php print render($page['highlight']); ?>
                    
                    <?php print render($title_prefix); ?>
                    
                    <?php if ($title): ?>
                        <h1 class="title" id="page-title"><?php print $title; ?></h1>
                    <?php endif; ?>
                    
                    <?php print render($title_suffix); ?>
                    
                    <?php print $messages; ?>
                    
                    <?php if ($tabs = render($tabs)): ?>
                        <div class="tabs"><?php print $tabs; ?></div>
                    <?php endif; ?>
                    
                    <?php print render($page['help']); ?>
                    
                    <?php if ($action_links): ?>
                        <ul class="action-links"><?php print render($action_links); ?></ul>
                    <?php endif; ?>
                    
                    <div id="content-content" class="clearfix">
                    <?php print render($page['content']); ?>
                    </div>
    
                    <?php print $feed_icons; ?>
                </div> <!-- /content -->      
            </div><!-- /main-squeeze -->
        </div> <!-- /main -->

		<?php if ($page['sidebar_second']): ?>
        	<div id="sidebar-second" class="column sidebar"><?php print render($page['sidebar_second']); ?></div> <!-- /sidebar-right -->
        <?php endif; ?>

    </div> <!-- /container -->

    <div id="footer-wrapper">
      <div id="footer">
      	<?php print render($page['footer']); ?>
      </div> <!-- /footer -->
    </div> <!-- /footer-wrapper -->
</div> <!-- /page -->