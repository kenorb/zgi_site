<?php if (!empty($page['header'])): ?>
  <div id="header-region" class="clear-block"><?php print render($page['header']); ?></div>
<?php endif; ?>

<div id="container" class="clear-block">
  <div id="header"><div class="container clear-block">
    <div id="top-bar">
      <?php if (isset($secondary_menu)) : ?>
        <div class="region-content">
	        <?php print render(menu_tree('secondary-menu'));?>
         </div>
	     <?php endif; ?>
     </div>
     <div class="region-content">
   	   <?php
	       if ($logo || $site_title) {
           print '<h1><a style="float:left;" href="'. check_url($base_path) .'" title="'. $site_title .'">';
          	 if ($logo) {
          	   print '<span id="logo-wrapper"><img style="float:left;" src="'. check_url($logo) .'" alt="'. $site_title .'" id="logo" /></span>';
             }
           print ($logo ? '&nbsp;&nbsp;' . '<span id="site-name">'. $site_title_html .'</span>': '<span id="site-name" style="float:left; ">'. $site_title_html . '</span>') .'</a></h1>';
         }
        ?>
	    </div>
	  </div>
	  <?php if (isset($main_menu)) : ?>
	  	<?php print render($primary_menu);?>
  	<?php endif; ?>
  </div> <!-- /header -->
  <div id="center">
    <div id="featured">
      <?php if ($page['featured']): ?>
  	    <div class="region-content">
	        <?php if ($page['featured']): print render($page['featured']); endif; ?>
   	    </div>
	    <?php endif; ?>
     </div>
	   <div id="breadcrumb"><div class="region-content">
	     <?php if ($breadcrumb): print $breadcrumb; endif; ?>
	   </div></div>
     <div id="main">
       <div id="sidebar-wrapper">
	       <?php if (!$sidebar_triple): ?><div class="top-corners"><div class="bottom-corners"><?php endif; ?>
	         <?php if ($page['sidebar_first']): ?>
		         <div id="sidebar-left" class="sidebar">
		           <?php print render($page['sidebar_first']) ?>
	       	   </div> <!-- /sidebar-first -->
	         <?php endif; ?>
	         <?php if (!$sidebar_triple): ?>
		         <div id="content">
		           <div id="squeeze">
		             <?php if ($page['pre_content']) { print render($page['pre_content']); } ?>
		             <?php print deco_render_content($tabs, $title, $messages, $classes)?>
                 <?php print render($page['content']); ?>
                 <?php print render($feed_icons); ?>
               </div>
             </div> <!-- /content -->
           <?php endif; ?>
	         <?php if ($page['sidebar_right_sec']): ?>
	           <div id="sidebar-right-sec" class="sidebar">
		           <?php print render($page['sidebar_right_sec']) ?>
	           </div> <!-- /sidebar-right-sec -->
	         <?php endif; ?>
	         <?php if ($page['sidebar_second']): ?>
	           <div id="sidebar-right" class="sidebar">
		           <?php print render($page['sidebar_second']); ?>
	           </div> <!-- /sidebar-right -->
	         <?php endif; ?>
      		 <?php if ($sidebar_triple): ?>
		         <div id="content">
		           <?php print deco_render_content($tabs, $title, $messages, $classes)?>
               <?php print render($page['content']); ?>
               <?php print render($feed_icons); ?>
             </div>
	         <?php endif; ?>
	         <span class="clear"></span>
   	    </div><?php if (!$sidebar_triple): ?></div></div><?php endif; ?> <!-- /sidebar_wrapper -->
       </div> <!-- /main -->
       <div id="content-bottom">
	       <?php if ($page['content_bottom']): print render($page['content_bottom']); endif; ?>
       </div>
     </div> <!-- /center -->
     <div id="footer"><div class="top-border"><div class="bottom-border">
       <div class="region-content">
         <?php if (isset($page['footer'])) { print render($page['footer']); } ?>
	       <?php if (isset($main_menu)) : ?>
	         <?php print render($primary_menu);?>
	       <?php endif; ?>
         <span class="clear"></span>
       </div>
     </div></div></div> <!-- /footer -->
 </div> <!-- /container -->
