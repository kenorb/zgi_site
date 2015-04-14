<div id="block-<?php print $block->module .'-'. $block->delta; ?>" class="block block-<?php print $block->module ?><?php print (!empty($block->subject) ? ' block-title' : '') ?><?php print ($zebra ? ' block-'.$zebra : '') ?>">
  <div class="blockinner">
    <?php if (!empty($block->subject)): ?><h2 class="title"><?php print $block->subject; ?></h2><?php endif; ?>
    <div class="content">
         <?php print $content; ?>
    </div>
  </div>
</div>

