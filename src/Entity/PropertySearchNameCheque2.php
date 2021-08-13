<?php

namespace App\Entity;

class PropertySearchNameCheque2
{
/**
 * @var string|null
 */
private $name2;


/**
 * Get the value of name2
 *
 * @return  string|null
 */ 
public function getName2()
{
return $this->name2;
}

/**
 * Set the value of name2
 *
 * @param  string|null  $name2
 *
 * @return  self
 */ 
public function setName2($name2)
{
$this->name2 = $name2;

return $this;
}
}