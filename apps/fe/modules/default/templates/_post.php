<?php use_helper('Date', 'sfSimpleBlog') ?>

<li>
  <div class="odd">
  <p style="font-size:16px; font-weight: bolder;">
    <?php echo link_to($post->getTitle(), $post->getLink()) ?>
  </p>
  <p class="box">
   <span class="arrow-up"></span>
   <?php echo $post->getDescription()?>
  </p>   
  </div>
</li> 