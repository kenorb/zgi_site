<div id="node-<?php print $node->nid; ?>" class="node<?php if ($sticky && $page == 0) { print ' node-sticky'; } ?><?php if (!$status) { print ' node-unpublished'; } ?><?php if ($page != 0) { print ' node-page'; } ?>">
  <?php if ($page == 0): ?>
   <div class="node-top"><div class="top-right"><div class="top-middle"></div></div></div>
  <?php endif; ?>
  <div class="node-body">
    <?php print $user_picture; ?>
      <div class="node-title clear-block">
        <?php print render($title_prefix); ?>
 	      <?php if (!$page): ?>
          <h2 class="title"><a href= "<?php print $node_url; ?>"><?php print $title; ?></a></h2>
        <?php endif; ?>
        <?php print render($title_suffix); ?>
	      <div class="submitted">
          <?php if (!$page): ?>
	          <div class="left">
          <?php endif; ?>
          <?php $entity = " &#151;";?>
		      <p<?php print (!$page) ? ' class="right"' : '' ?>><?php print $name; ?><?php print $entity ;?><span class="date"><?php print $date; ?></span></p>
		      <?php if (!$page): ?>
	      </div>
	        <?php endif; ?>
	     </div>
    </div>
    <div class="content">
      <?php
        // We hide the comments and links now so that we can render them later.
        hide($content['comments']);
        hide($content['links']);
        print render($content);
      ?>
    </div>

    <?php
      // Remove the "Add new comment" link on the teaser page or if the comment
      // form is being displayed on the same page.
      if (!empty($content['links']['comment']['#links']['comment-comments'])) {
        unset($content['links']['comment']['#links']['comment-add']);
      }

      // Only display the wrapper div if there are links.
      $links = render($content['links']);
      if ($links):
    ?>
      <div class="links">
        <div class="links-inner">
          <?php print $links; ?>
        </div>
      </div>
    <?php endif; ?>

     <?php print render($content['comments']); ?>
     <div class="hr"><span></span></div>
  </div>
</div>