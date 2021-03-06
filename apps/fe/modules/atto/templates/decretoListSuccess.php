<?php use_helper('I18N', 'Date') ?>

<?php include_partial('tabs', array('current' => 'decreti')) ?>

<div class="row">
	<div class="ninecol">
		
		<?php include_partial('decretoWiki') ?>  		

	      <?php include_partial('decretoFilter',
	                            array('tags_categories' => $all_tags_categories,
	                                  'active' => deppFiltersAndSortVariablesManager::arrayHasNonzeroValue(array_values($filters)),                            
	                                  'selected_tags_category' => array_key_exists('tags_category', $filters)?$filters['tags_category']:0,
	                                  'selected_act_stato' => array_key_exists('act_stato', $filters)?$filters['act_stato']:0)) ?>

	      <?php include_partial('decretoSort') ?>

	      <?php echo include_partial('default/listNotice', array('filters' => $filters, 'results' => $pager->getNbResults())); ?>

	      <?php include_partial('decretoList', array('pager' => $pager)) ?>
		
	</div>
	<div class="threecol last">
		
		<!-- 
	      <p class="last-update">data di ultimo aggiornamento: <strong><?php echo $last_updated_item->getDataAgg('d-m-Y') ?></strong></p>			
	      -->

	      <?php 
	        echo include_partial('sfSolr/specialized_controls', 
	                            array('query' => $query, 
	                                  'type' => 'decreti', 
	                                  'title' => 'nei decreti legge'));
	      ?>


	      <?php echo include_partial('news/newsbox', 
	                                 array('title' => 'Decreti legge', 
	                                       'all_news_url' => '@news_attiDecreti',
	                                       'news'   => oppNewsPeer::getAttiListNews(oppNewsPeer::ATTI_DECRETI_TIPO_IDS, 10),
	                                       'context' => 1,
	                                       'rss_link' => '@feed_decreti')); ?>
		
	</div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  decreti legge
<?php end_slot() ?>