<?php

/**
 * Classe base per i calcoli degli indici (attività, rilevanza atti e tag, ...)
 *
 * @package lib.model
 */ 
class OppIndicePeer
{

  public static $soglia_cofirme = 5;
  public static $soglia_cofirme_mozioni = 20;
  

  public static $opp_ns = 'http://www.openpolis.it/2010/opp';
  public static $op_ns = 'http://www.openpolis.it/2010/op';
  public static $xlink_ns = 'http://www.w3.org/1999/xlink';
  
  public static $filesystem;
  
  public static $punteggi = array(
     'ddl'           => array('presentazione'       => array('m' => 0.08, 'o' =>   0.08),
                              'relazione'           => array('m' => 5.00, 'o' =>  10.00),
                              'cofirme_gruppo_lo'   => array('m' => 0.10,  'o' =>  0.10),
                              'cofirme_gruppo_hi'   => array('m' => 0.20,  'o' =>  0.20),
                              'cofirme_altri_lo'    => array('m' => 0.20,  'o' =>  0.20),
                              'cofirme_altri_hi'    => array('m' => 0.40,  'o' =>  0.40),
                              'cofirme_opp_lo'      => array('m' => 0.60,  'o' =>  0.60),
                              'cofirme_opp_hi'      => array('m' => 1.20,  'o' =>  1.20),
                              'cofirme_gov_lo'      => array('m' =>  0.0,  'o' =>   0.0),
                              'cofirme_gov_hi'      => array('m' =>  0.0,  'o' =>   0.0),
                              'discusso_in_comm'    => array('m' =>  1.0,  'o' =>   2.0),
                              'discusso_in_ass'     => array('m' =>  4.0,  'o' =>   8.0),
                              'assorbito'           => array('m' =>  2.0,  'o' =>   4.0),
                              'votato'              => array('m' =>  0.0,  'o' =>   0.0),
                              'approvato'           => array('m' => 20.0,  'o' =>  40.0),
                              'diventato_legge'     => array('m' => 40.0,  'o' =>  80.0),
                              'svolto'              => array('m' =>    0,  'o' =>     0),
                              'bonus_bi_partisan'   => array('m' => 10.0,  'o' =>     0),
                             ),
      'mozione'      => array('presentazione'       => array('m' => 0.06,  'o' =>  0.06),
                              'cofirme_gruppo_lo'   => array('m' => 0.05,  'o' =>  0.05),
                              'cofirme_gruppo_hi'   => array('m' => 0.10,  'o' =>  0.10),
                              'cofirme_altri_lo'    => array('m' => 0.10,  'o' =>  0.10),
                              'cofirme_altri_hi'    => array('m' => 0.20,  'o' =>  0.20),
                              'cofirme_opp_lo'      => array('m' => 0.30,  'o' =>  0.30),
                              'cofirme_opp_hi'      => array('m' => 0.60,  'o' =>  0.60),
                              'discusso_in_comm'    => array('m' =>  0.0,  'o' =>   0.0),
                              'discusso_in_ass'     => array('m' =>  0.0,  'o' =>   0.0),
                              'votato'              => array('m' =>  1.0,  'o' =>   2.0),
                              'approvato'           => array('m' =>  2.0,  'o' =>   4.0),
                              'diventato_legge'     => array('m' =>  0.0,  'o' =>   0.0),
                              'svolto'              => array('m' =>    0,  'o' =>     0),
                              'bonus_bi_partisan'   => array('m' =>  1.0,  'o' =>   0.0),
                             ),
      'risoluzione'  => array('presentazione'       => array('m' => 0.06, 'o' =>   0.06),
                              'cofirme_gruppo_lo'   => array('m' => 0.05,  'o' =>  0.05),
                              'cofirme_gruppo_hi'   => array('m' => 0.10,  'o' =>  0.10),
                              'cofirme_altri_lo'    => array('m' => 0.10,  'o' =>  0.10),
                              'cofirme_altri_hi'    => array('m' => 0.20,  'o' =>  0.20),
                              'cofirme_opp_lo'      => array('m' => 0.30,  'o' =>  0.30),
                              'cofirme_opp_hi'      => array('m' => 0.60,  'o' =>  0.60),
                              'discusso_in_comm'    => array('m' =>  0.0,  'o' =>   0.0),
                              'discusso_in_ass'     => array('m' =>  0.0,  'o' =>   0.0),
                              'votato'              => array('m' =>  1.0,  'o' =>   2.0),
                              'approvato'           => array('m' =>  2.0,  'o' =>   4.0),
                              'diventato_legge'     => array('m' =>  0.0,  'o' =>   0.0),
                              'svolto'              => array('m' =>    0,  'o' =>     0),
                              'bonus_bi_partisan'   => array('m' =>  1.0,  'o' =>   0.0),
                             ),
      'odg'          => array('presentazione'       => array('m' => 0.04, 'o' =>   0.04),
                              'cofirme_gruppo_lo'   => array('m' => 0.05,  'o' =>  0.05),
                              'cofirme_gruppo_hi'   => array('m' => 0.10,  'o' =>  0.10),
                              'cofirme_altri_lo'    => array('m' => 0.10,  'o' =>  0.10),
                              'cofirme_altri_hi'    => array('m' => 0.20,  'o' =>  0.20),
                              'cofirme_opp_lo'      => array('m' => 0.30,  'o' =>  0.30),
                              'cofirme_opp_hi'      => array('m' => 0.60,  'o' =>  0.60),
                              'discusso_in_comm'    => array('m' =>  0.0,  'o' =>   0.0),
                              'discusso_in_ass'     => array('m' =>  0.0,  'o' =>   0.0),
                              'votato'              => array('m' =>  0.5,  'o' =>   1.0),
                              'approvato'           => array('m' =>  1.0,  'o' =>   2.0),
                              'diventato_legge'     => array('m' =>  0.0,  'o' =>   0.0),
                              'svolto'              => array('m' =>    0,  'o' =>     0),
                              'bonus_bi_partisan'   => array('m' =>  0.5,  'o' =>   0.0),
                             ),
     'interrogazione'=> array('presentazione'       => array('m' => 0.05, 'o' =>  0.05),
                              'cofirme_gruppo_lo'   => array('m' => 0.05,  'o' =>  0.05),
                              'cofirme_gruppo_hi'   => array('m' => 0.10,  'o' =>  0.10),
                              'cofirme_altri_lo'    => array('m' => 0.10,  'o' =>  0.10),
                              'cofirme_altri_hi'    => array('m' => 0.20,  'o' =>  0.20),
                              'cofirme_opp_lo'      => array('m' => 0.30,  'o' =>  0.30),
                              'cofirme_opp_hi'      => array('m' => 0.60,  'o' =>  0.60),
                              'discusso_in_comm'    => array('m' =>   0, 'o' =>    0),
                              'discusso_in_ass'     => array('m' =>   0, 'o' =>    0),
                              'votato'              => array('m' =>   0, 'o' =>    0),
                              'approvato'           => array('m' =>   0, 'o' =>    0),
                              'diventato_legge'     => array('m' =>   0, 'o' =>    0),
                              'svolto'              => array('m' => 1.0, 'o' =>  1.0),
                              'bonus_bi_partisan'   => array('m' =>   0, 'o' =>    0),
                             ),
    'interpellanza'  => array('presentazione'       => array('m' => 0.05, 'o' =>  0.05),
                              'cofirme_gruppo_lo'   => array('m' => 0.05,  'o' =>  0.05),
                              'cofirme_gruppo_hi'   => array('m' => 0.10,  'o' =>  0.10),
                              'cofirme_altri_lo'    => array('m' => 0.10,  'o' =>  0.10),
                              'cofirme_altri_hi'    => array('m' => 0.20,  'o' =>  0.20),
                              'cofirme_opp_lo'      => array('m' => 0.30,  'o' =>  0.30),
                              'cofirme_opp_hi'      => array('m' => 0.60,  'o' =>  0.60),
                              'discusso_in_comm'    => array('m' =>   0, 'o' =>    0),
                              'discusso_in_ass'     => array('m' =>   0, 'o' =>    0),
                              'votato'              => array('m' =>   0, 'o' =>    0),
                              'approvato'           => array('m' =>   0, 'o' =>    0),
                              'diventato_legge'     => array('m' =>   0, 'o' =>    0),
                              'svolto'              => array('m' => 1.5, 'o' =>  1.5),
                              'bonus_bi_partisan'   => array('m' =>   0, 'o' =>    0),
                             ),

     'emendamenti'    => array('presentazione'       => array('m' => 0.05, 'o' => 0.05),
                               'cofirme_gruppo_lo'   => array('m' => 0.5, 'o' =>  0.2),
                               'cofirme_gruppo_hi'   => array('m' => 0.5, 'o' =>  0.2),
                               'cofirme_altri_lo'    => array('m' => 0.8, 'o' =>  0.8),
                               'cofirme_altri_hi'    => array('m' => 0.8, 'o' =>  0.8),
                               'cofirme_opp_lo'      => array('m' => 1.5, 'o' =>  2.0),
                               'cofirme_opp_hi'      => array('m' => 1.5, 'o' =>  2.0),
                               'discusso_in_comm'    => array('m' =>   0, 'o' =>    0),
                               'discusso_in_ass'     => array('m' =>   0, 'o' =>    0),
                               'votato'              => array('m' => 0.5, 'o' =>  1.0),
                               'approvato'           => array('m' => 1.0, 'o' =>  2.0),
                               'diventato_legge'     => array('m' =>   0, 'o' =>    0),
                               'svolto'              => array('m' =>   0, 'o' =>    0),
                               'bonus_bi_partisan'   => array('m' => 1.0, 'o' =>    0),
                              ),
     'audizione'      => array( 'presentazione'      => array('m' => 5.0, 'o' =>  5.0)),
     'intervento'                 => 0.4,
     'seduta_in_comm'             => 0.5,
     'seduta_in_ass'              => 1.0,
     'presenze_voti'              => 0.001,
     'presenze_voti_finali'       => 0.1,
     'presenze_voti_magg_battuta' => 0.3,
     'emendamenti_soglia'         => 40.,
     'emendamenti_larghezza'      => 100.,
     'emendamenti_soglia_rilevanza' => 40.,
     'emendamenti_larghezza_rilevanza' => 100.,
     'fattore_diminuzione_ratifica' => 10.
  );
 
  public static function getFileSystem()
  {
    if (self::$filesystem == null)
      self::$filesystem = new sfFileSystem();
      
    return self::$filesystem;
  }
 
  
  /**
   * genera una processing instruction per includere link all'xsl nell'xml
   *
   * @param string $xml_node 
   * @param string $name 
   * @param string $value 
   * @return void
   * @author Guglielmo Celata
   */
  protected static function addProcessingInstruction( $xml_node, $name, $value )
  {
      // Create a DomElement from this simpleXML object
      $dom_sxe = dom_import_simplexml($xml_node);
     
      // Create a handle to the owner doc of this xml
      $dom_parent = $dom_sxe->ownerDocument;
     
      // Find the topmost element of the domDocument
      $xpath = new DOMXPath($dom_parent);
      $first_element = $xpath->evaluate('/*[1]')->item(0);
     
      // Add the processing instruction before the topmost element           
      $pi = $dom_parent->createProcessingInstruction($name, $value);
      $dom_parent->insertBefore($pi, $first_element);
  }
  
  
  
  
  
}
