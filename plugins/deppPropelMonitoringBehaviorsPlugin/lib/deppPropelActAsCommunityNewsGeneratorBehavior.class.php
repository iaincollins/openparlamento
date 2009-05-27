<?php
/*
 * This file is part of the deppPropelMonitoringBehaviors package.
 *
 * (c) 2008 Guglielmo Celata <guglielmo.celata@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
?>
<?php
/**
 * This Propel behavior transforms a Propel object into a community news generator.
 * Community news keep track of the events generated by the community:
 * Comments, Votings, Wiki Descriptions, Monitoring
 *
 * @package    plugins
 * @subpackage monitoring
 * @author     Guglielmo Celata <guglielmo.celata@gmail.com>
 */
class deppPropelActAsCommunityNewsGeneratorBehavior
{
  
  protected $wasNew;
  
  
  /**
   * return news generated by this generator
   *
   * @return array of Objects
   * @author Guglielmo Celata
   **/
  public function getGeneratedNews(BaseObject $object)
  {
    return CommunityNewsPeer::getNewsGeneratedByGenerator($object);
  }
  

  /**
   * return an array of primary keys for the object
   *
   * @param  BaseObject object - the object
   * @return associative array of primary keys (col_name => id_value)
   * @author Guglielmo Celata
   **/
  public function getPrimaryKeysArray(BaseObject $object)
  {
    // get table map and columns map for this generator
    $model_table = call_user_func(get_class($object).'Peer::getTableMap'); 
    $model_columns = $model_table->getColumns();

    // find and store primary keys
    $pks = array();
    foreach($model_columns as $column){
      if ($column->isPrimaryKey())
      {
        $column_php_name = $column->getPhpName();
        $column_getter = 'get'.$column_php_name;
        $pks[$column_php_name] = $object->$column_getter();
      }
    }
    
    return $pks;
  }
  
  /**
   * generate a creation community news (a user has done something on an object)
   *
   * @return void
   * @author Guglielmo Celata
   **/
  public function generateCreationCommunityNews(BaseObject $object)
  {
    try {

      // fetch the object related to this generator
      $mobj = $this->getRelatedObject($object);

      // fetch and set of the user name (wiki case and the rest)
      if ($object instanceof nahoWikiRevision)
        $username = $object->getUserName();
      else if ($object instanceof sfComment || $object instanceof sfEdemComment)
        $username = $object->getAuthorName();
      else
      {
        $user = OppUserPeer::retrieveByPK($object->getUserId());
        $username = $user->__toString();
      }
      // skip the admin user
      if ($username == 'admin') return;


      $n = new CommunityNews();
      $n->setGeneratorModel(get_class($object));
      $n->setGeneratorPrimaryKeys(serialize($this->getPrimaryKeysArray($object)));
      $n->setRelatedModel(get_class($mobj));
      $n->setRelatedId($mobj->getPrimaryKey());      

      $n->setType('C');      

      $n->setUsername($username);
      
      // sets total and vote in case the generator is sfVoting
      // only OppAttos can be voted
      if ($object instanceof sfVoting)
      {
        $vote = $object->getVoting();
        $n->setVote($vote);
        if ($vote > 0)
          $n->setTotal($mobj->getUtFav());
        else
          $n->setTotal($mobj->getUtContr());
      }

      // sets total in case the generator is Monitoring
      if ($object instanceof Monitoring)
        $n->setTotal($mobj->getNMonitoringUsers());

      $n->save();
      
    } catch (Exception $e) {
      throw new deppPropelActAsNewsGeneratorException($e->getMessage());
    }
    
  }

  /**
   * generate a removal community news (a user has un-done something on an object)
   *
   * @return the number of generated news
   * @author Guglielmo Celata
   **/
  public function generateRemovalCommunityNews(BaseObject $object)
  {
    try {

      // fetch the object related to this generator
      $mobj = $this->getRelatedObject($object);


      $n = new CommunityNews();
      $n->setGeneratorModel(get_class($object));
      $n->setGeneratorPrimaryKeys(serialize($this->getPrimaryKeysArray($object)));
      $n->setRelatedModel(get_class($mobj));
      $n->setRelatedId($mobj->getPrimaryKey());      

      $n->setType('D');

      // fetch and set of the user name (wiki case and the rest)
      if ($object instanceof nahoWikiRevision)
        $username = $object->getUserName();
      else
      {
        $user = OppUserPeer::retrieveByPK($object->getUserId());
        $username = $user->__toString();
      }
      $n->setUsername($username);

      $n->save();
      
    } catch (Exception $e) {
      throw new deppPropelActAsNewsGeneratorException($e->getMessage());
    }
  }
              

  /**
   * retrieve the object related to the generator
   *
   * @return void
   * @author Guglielmo Celata
   **/
  public function getRelatedObject(BaseObject $object)
  {
    $related_model_getter =  sfConfig::get(
      sprintf('propel_behavior_deppPropelActAsCommunityNewsGeneratorBehavior_%s_rel_model_getter', 
              get_class($object)), '');
    $related_id_getter =  sfConfig::get(
      sprintf('propel_behavior_deppPropelActAsCommunityNewsGeneratorBehavior_%s_rel_id_getter', 
              get_class($object)), '');
      
    $related_model = call_user_func(array($object, $related_model_getter));
    $related_id    = call_user_func(array($object, $related_id_getter));

    sfLogger::getInstance()->info('xxx:'.$related_model);
    sfLogger::getInstance()->info('xxx:'.$related_id);

    $rel_obj = call_user_func_array($related_model.'Peer::retrieveByPK', array($related_id));
    sfLogger::getInstance()->info('xxx');
    
    
    return $rel_obj;
  }  
  
  
  /**
   * This hook is called before generator object is saved.
   *
   * @param      BaseObject    $object
   */
  public function preSave(BaseObject $object)
  {
    $this->wasNew = $object->isNew();
  }
  
  /**
   * This hook is called after generator object is saved.
   * It generates a creation news
   *
   * @return void
   * @author Guglielmo Celata
   **/
  public function postSave(BaseObject $object)
  {
    if ($this->wasNew === true)
    {
      $object->generateCreationCommunityNews();                
      unset($this->wasNew);    
    }
  }
  
  
  /**
   * This hook is called before generator object is removed
   * It generates removal news
   * 
   * @param  BaseObject  $object
   */
  public function preDelete(BaseObject $object)
  {
    $object->generateRemovalCommunityNews();                
  }
  

}