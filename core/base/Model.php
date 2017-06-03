<?php

namespace Core\Base;

class Model
{
	
	public function toArray()
	{
		$ret = [];
		$reflect = new \ReflectionClass($this);
		$props = $reflect->getProperties(\ReflectionProperty::IS_PUBLIC);

		foreach($props as $prop)
		{
			$name = $prop->getName();
			$ret[$name] = $this->$name;
		}
		return $ret;
	}

}
