<?php

/**
 * Subclass for representing a row from the 'sf_test_votable' table.
 *
 * 
 *
 * @package lib.model
 */ 
class sfTestVotable extends BasesfTestVotable
{
}

sfPropelBehavior::add(
  'sfTestVotable', 
  array('deppPropelActAsVotableBehavior' =>
        array('voting_range'    => 2,              
              'voting_field'    => 'VotoMedio',
              'neutral_position'=> true,
              'anonymous_voting'=> false )));


