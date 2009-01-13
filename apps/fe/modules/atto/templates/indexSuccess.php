<?php use_helper('Date', 'I18N') ?>

<ul id="content-tabs" class="float-container tools-container">
  <li class="current"><h2><?php echo Text::denominazioneAtto($atto, 'index') ?></h2></li>
</ul>

<div id="content" class="tabbed float-container">
  <div id="main">
    
    <div class="W25_100 float-right">
      <?php echo include_component('atto', 'monitor_n_vote', array('atto' => $atto)); ?>
	  </div>
    
    <div class="W73_100 float-left">
      <h4 class="grey-888"><?php echo $atto->getOppTipoAtto()->getDenominazione() ?></h4>
	  
	    <?php include_partial('attoWiki') ?>
	  
	    <!-- SINOSSI -->
	    <p class="synopsis"><!--Interventi urgenti in materia di adeguamento dei prezzi di materiali da costruzione, di sostegno ai settori  dell�autotrasporto, dell�agricoltura e della pesca professionale, nonche' di finanziamento delle opere per il G8 e definizione degli adempimenti tributari per le regioni Marche ed Umbria, colpite dagli eventi sismici del 1997 (Gazzetta Ufficiale n. 247 del 23/10/2008)--></p>

      <ul class="presentation float-container">
        <li><h6>presentato il: <em><?php echo format_date($atto->getDataPres(), 'dd/MM/yyyy') ?></em></h6></li>
        
        <?php if($tipo_iniziativa != ''): ?>
          <li><h6>tipo di iniziativa: <em><?php echo $tipo_iniziativa ?></em></h6></li>
        <?php endif; ?>			  
        <?php if($link != '#'): ?>
          <li><?php echo link_to("link alla fonte", $link, array('class' => 'external', 'target' => '_blank')) ?></li>
        <?php endif; ?>		  
      </ul>
	  
	    <!-- partial per la descrizione wiki -->
      <?php echo include_component('nahoWiki', 'showContent', array('page_name' => 'atto_' . $atto->getId())); ?>
	  
      <!-- partial per la visualizzazione e l'edit-in-place dei tags associati all'atto -->
      <?php echo include_component('deppTagging', 'edit', array('content' => $atto)); ?>


	    <?php include_component('atto', 'firmatari', 
	                            array('primi_firmatari' => $primi_firmatari, 'relatori' => $relatori)) ?>

      <?php if(count($co_firmatari)!=0): ?>
        <?php include_partial('coFirmatari', 
	                      array('co_firmatari' => $co_firmatari)) ?>						
	
	    <?php endif; ?>

      <?php if(count($votazioni)!=0): ?>
        <?php include_component('atto', 'votazioni', array('votazioni' => $votazioni)) ?>
      <?php endif; ?>

      <?php if(count($interventi)!=0): ?>
        <?php include_component('atto', 'interventi', array('interventi' => $interventi)) ?>
      <?php endif; ?> 	  

      <a name="monitoringusersdo"></a>
      <?php echo include_component('atto', 'monitoringusersdo', array('item' => $atto)); ?>

      <a name="prousersdo"></a>
      <?php echo include_component('atto', 'prousersdo', array('item' => $atto)); ?>

      <a name="antiusersdo"></a>
      <?php echo include_component('atto', 'antiusersdo', array('item' => $atto)); ?>
	  
    </div>

    <div class="clear-both"></div>

  </div>
</div>