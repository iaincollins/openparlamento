<?php use_helper('Date', 'I18N') ?>

<ul class="float-container tools-container" id="content-tabs">
	<li class="current"><h2>On.<?php echo $parlamentare->getNome() ?>&nbsp;<?php echo $parlamentare->getCognome() ?></h2></li>
</ul>



<div class="tabbed float-container" id="content">
	<div id="main">
			
	  <div class="W100_100 float-left">
	    <?php echo include_partial('secondlevelmenu', 
	                               array('current' => 'atti', 
	                                     'parlamentare_id' => $parlamentare->getId())); ?>
	                                     	
   		<p class="tools-container"><a class="ico-help" href="#">eventuale testo micro-help</a></p>
   		<div style="display: none;" class="help-box float-container">
   			<div class="inner float-container">

   				<a class="ico-close" href="#">chiudi</a><h5>eventuale testo micro-help ?</h5>
   				<p>In pan philologos questiones interlingua. Sitos pardona flexione pro de, sitos africa e uno, maximo parolas instituto non un. Libera technic appellate ha pro, il americas technologia web, qui sine vices su. Tu sed inviar quales, tu sia internet registrate, e como medical national per. (fonte: <a href="#">Wikipedia</a>)</p>
   			</div>
   		</div>

      <?php include_partial('attiFilter',
                            array('tags_categories' => $all_tags_categories,
                                  'selected_tags_category' => array_key_exists('tags_category', $filters)?$filters['tags_category']:0,
                                  'selected_act_type' => array_key_exists('act_type', $filters)?$filters['act_type']:0,                                
                                  'selected_act_firma' => array_key_exists('act_ramo', $filters)?$filters['act_firma']:0,
                                  'selected_act_stato' => array_key_exists('act_stato', $filters)?$filters['act_stato']:0)) ?>

      <?php include_partial('attiSort', array('parlamentare_id' => $parlamentare->getId())) ?>

      <?php include_partial('attiList', 
                            array('pager' => $pager, 'parlamentare_id' => $parlamentare->getId())) ?>


	  </div>


    <div class="clear-both"/>			
    </div>
		
  </div>
</div>
