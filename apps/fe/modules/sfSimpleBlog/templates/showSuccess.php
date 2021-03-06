<?php use_helper('I18N') ?>
<?php if(sfConfig::get('app_sfSimpleBlog_use_ajax', true)): ?>
  <?php use_javascript(sfConfig::get('sf_prototype_web_dir') . '/js/prototype.js') ?>
<?php endif; ?>
<?php $sf_context->getResponse()->setTitle($post->getTitle().' - blog - '.sfConfig::get('app_main_title')) ?>

<div class="row" id="tabs-container">
    <ul id="content-tabs" class="float-container tools-container">
      <li class="current">
        <h2>
          <?php echo link_to('Blog', '@blog_index') ?>
        </h2>
      </li>
    </ul>
</div>

<div class="row">
	<div class="ninecol">
		
		<!-- post intero -->
	      <a name="top"></a>
	      <?php include_partial('sfSimpleBlog/post', array('post' => $post, 'in_list' => false)) ?>

	      <!-- commenti -->
	      <br/>
	      <br/>

	      <div id="sfSimpleBlog_comment_list">
	      <a name="comments"></a>

	      <?php if($nb_comments = count($comments)): ?>
	          <h4><strong><?php echo format_number_choice('[1]One comment so far|(1,+Inf]%1% comments so far', array('%1%' => $nb_comments), $nb_comments) ?></strong></h4>

	          <p style="text-align:right; margin-right:6%;" ><a href="#leave">lascia il tuo commento</a>&nbsp;|&nbsp;<a href="#top" class="go-top">torna su</a></p>
	          <hr class="blog-comments-separator"/>
	      <?php endif; ?>


	        <?php include_partial('sfSimpleBlog/comment_list', array('post' => $post, 'comments' => $comments, 'user' => $user)) ?>
	      </div>
		
	</div>
	<div class="threecol last">
		
		<?php include_partial('sfSimpleBlog/sidebar') ?>
		
	</div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  <?php echo link_to('blog', '@blog_index') ?> / 
  <?php echo $post->getTitle() ?>
<?php end_slot() ?>
