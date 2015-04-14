<div class="comment<?php if (isset($comment->status) && $comment->status == COMMENT_NOT_PUBLISHED) print ' comment-unpublished'; print ($zebra ? ' comment-'.$zebra : ''); ?>">
<?php if ($new != '') { ?><span class="new"><?php print $new; ?></span><?php } ?>

  <div class="comment-top">
    <?php print $picture; ?>
    <?php print render($title_prefix); ?>
    <h3 class="title"<?php print $title_attributes; ?>><?php print $title ?></h3>
    <?php print render($title_suffix); ?>
    <span class="submitted"><?php print $submitted; ?></span>
  </div>
  <div class="content"><?php print render($content); ?></div>
   <?php if ($signature): ?>
     <div class="signature">
       <?php print $signature ?>
      </div>
   <?php endif; ?>
  <div class="hr"><span></span></div>
</div>
