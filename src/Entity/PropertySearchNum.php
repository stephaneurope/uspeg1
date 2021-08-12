<?php

namespace App\Entity;

class PropertySearchNum
{
/**
 * @var string|null
 */
private $numcheque;


/**
 * Get the value of numcheque
 *
 * @return  string|null
 */ 
public function getNumcheque()
{
return $this->numcheque;
}

/**
 * Set the value of numcheque
 *
 * @param  string|null  $numcheque
 *
 * @return  self
 */ 
public function setNumcheque($numcheque)
{
$this->numcheque = $numcheque;

return $this;
}


}