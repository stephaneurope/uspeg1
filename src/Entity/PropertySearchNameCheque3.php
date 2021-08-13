<?php

namespace App\Entity;

class PropertySearchNameCheque3
{
/**
 * @var string|null
 */
private $name3;


/**
 * Get the value of name3
 *
 * @return  string|null
 */ 
public function getName3()
{
return $this->name3;
}

/**
 * Set the value of name3
 *
 * @param  string|null  $name3
 *
 * @return  self
 */ 
public function setName3($name3)
{
$this->name3 = $name3;

return $this;
}
}