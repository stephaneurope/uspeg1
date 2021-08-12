<?php

namespace App\Entity;

class PropertySearchNum2
{
/**
 * @var string|null
 */
private $numcheque2;


/**
 * Get the value of numcheque2
 *
 * @return  string|null
 */ 
public function getNumcheque2()
{
return $this->numcheque2;
}

/**
 * Set the value of numcheque2
 *
 * @param  string|null  $numcheque2
 *
 * @return  self
 */ 
public function setNumcheque2($numcheque2)
{
$this->numcheque2 = $numcheque2;

return $this;
}
}