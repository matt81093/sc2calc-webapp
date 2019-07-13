<?php

require './product defines.php';
require './commanders/terran.php';
require './commanders/zerg.php';
require './commanders/protoss.php';

/**
 * Products are structures, units, upgrades, morphs, addons, addon swaps,
 * abilities, etc. Basically, anything that is buildable in the game.
 */
class Product {

	private static $_designated = array();
	
	public static $all = array();
	// @var array | List of all exposed products.
	
	private static $last_uid = 0;
	// @var int | Last unique identifier created.
	
	public $energyCost;
	// @var float | Energy cost of this product.

	public $energyMax;
	// @ var float | Maximum energy on this spellcaster.
	
	public $energyStart;
	// @var float | Initial energy on this spellcaster.
	 
	public $expends;
	// @var array | Production queues expended to build this product.

	public $expendsAll;
	// @var bool | If true, all production queues are required; if false, only one of them.
	
	public $mineralCost;
	// @var float | Mineral cost of this product.
	
	public $gasCost;
	// @var float | Gas cost of this product.

	public $larvaCost;
	// @var int | Larva cost of this product.
	
	public $name;
	// @var string | Name of this product.
	
	public $prerequisites;
	// @var array | Prerequisite structures or upgrades to build this product.

	public $spellcaster;
	// @var Product | Type of spellcaster needed to use this ability.

	public $supplyCapacity;
	// @var int | Supply capacity provided by this product.
	
	public $supplyCost;
	// @var int | Supply cost of this product.

	public $spellCooldown;
	
	public $buildTime;
	
	public $timeCost;
	// @var float | Time it takes to complete this product.

	public $race;
	//@var int | Race of product.

	public $commander;
	// @var int | Commander of product.

	public $type;
	// @var int | Type of product.

	public $uid;
	// @var int | Unique identifier of this product.

	public $transformation_to;
	// @var array | For a morph, a list of products that are yielded by the morph.

	/// constructor

	/**
	 * Create a new product.
	 * @param string $name
	 * @param int $type
	 * @param array $prerequisites
	 * @param array $expends
	 * @param int $supplyCost
	 * @param float $mineralCost
	 * @param float $gasCost
	 * @param float $timeCost
	 * @param bool $exposed
	 */
	
	public function __construct($Product, $exposed = true) { 

		if (empty($Product)) { //|| !is_array($Product)) {
			throw_error("This object is empty. Please report to webmaster.");
		} else {
			$this->race = Helper::toRace($Product->race);
			$this->commander = $Product->commander;
			$this->name = $Product->name;
			$this->type = (Helper::toType($Product->type));
			
			if(count($Product->prerequisites) !== 0) {
				foreach($Product->prerequisites as $candidate) {
					$candidate = new $candidate;
					// unset($candidate);
				}
			} else {
				$this->prerequisites = $Product->prerequisites;
			}
			
			$this->expendsAll = true;
			
			if (isset($Product->buildTime)) {
				$this->timeCost = $Product->buildTime;
			}
			
			if(isset($Product->mineralCost)) {	
				$this->mineralCost = $Product->mineralCost;
			}
			
			if(isset($Product->gasCost)) {
				$this->gasCost = $Product->gasCost;	
			}
			
			// Type checking and assigning values.
			
			if ($this->type & Morph | Unit) {
				if(isset($Product->supplyCost)) {
					$this->supplyCost = $Product->supplyCost;
				}
			}
			
			if (($this->type & Structure) && ($this->race & Zerg)) {
				$this->supplyCost = -1;
			}

			if ($this->type & Farm) {
				if(isset($Product->supplyCapacity)) {
					$this->supplyCapacity = $Product->supplyCapacity;
				}
			}
			
			if ($this->type & (Upgrade | Morph | Unit)) {
				if(isset($Product->expends)) {
					$this->expends = $Product->expends;
				}
			}
		
			if ($this->type & Morph) {
				if(isset($Product->yeilds)) {
					$this->yeilds = $Product->yeilds;
				}
			}
		
			if($this->type & Spellcaster) {
				if(isset($Product->energyStart)) {
					$this->energyStart = $Product->energyStart;
				}
				if(isset($Product->energyMax)) {
					$this->energyMax = $Product->energyMax;
				}
			}
		
			if($this->type & Ability) {
				if(isset($Product->spellCaster)) {
					$this->spellCaster = $Product->spellCaster;
				}
				if(isset($Product->energyCost)) {
					$this->energyCost = $Product->energyCost;
				}
				if(isset($Product->spellCooldown)) {
					$this->spellCooldown = $Product->spellCooldown;
				}
			}
			
			$this->larvaCost = (($this->race & Zerg) && ($this->type & Unit)) ? 1 : 0;
			
			if(($this->race & Zerg) && ($this->type & Structure)) {
				$this->supplyCost = -1;
			}
			
			// set uid & append to all
			$this->uid = Product::$last_uid++;
			if($exposed) {
				Product::$all[] = $this;
			}
			
			/*
			// Designate product type to array
			if($this->type & (Base | Worker | Farm) {
				$type = $this->type;
				Product::$_designated[$type] = $this;
				unset($type);
			} */
		}
	}
	
	// assigning prerequisites and expends as objects
	/*
	public function assignPrerequisites() {
		foreach(Product::$all as $candidate) {
			$prerequisites = $candidate->prerequisites;
			for () {
				
			}
			if($candidate == $prerequisites)
		}
	}
	*/
			

	/**
	 * When a product is unset
	 */
	public function drop() {
		foreach(Product::$all as &$candidate) { 
			if($this->uid == $candidate->uid) {
				unset($candidate);
				break;
			}
		}
	}
	
	/// operators

	/**
	 * Convert to a string.
	 * @return string
	 */
	public function __toString() {
		return isset($this->name) ? $this->name : "n/a";
	}
	
	/// public static methods

	/**
	 * Find exposed product by name.
	 * @param string $name
	 * @return Product
	 */
	public static function byName($name) : Product {
		foreach(Product::$all as $candidate) {
			// if($value == $name) {
				if(strcasecmp($name, $candidate->name) == 0) {// $value) == 0) {
				// if($candidate->name == $name) { // if ($value == '$name') {
					return $candidate; // if(strcasecmp($name, $value) == 0) {
				}
			// }
		}
	}
	
	public static function findProduct($name) {
		foreach(Product::$all as $candidate) {
			if(strcasecmp($name, $candidate->name) == 0) {
				return $candidate;
			}
		}
	}

	/**
	 * Get designated product of given type.
	 * @param int $type
	 * @return Product
	 */
	public static function designated($type) {
		return Product::$_designated[$type];
	}
	
	/// public methods

	/**
	 * Make a specific product the designated product of its type.
	 * @param int $type
	 */
	/* public function designate() {
		foreach(Product::$all as $candidate) {
			$type = $candidate->type;
			Product::$_designated[$type];
			echo (get_vars(Product::$_designated[]));
			
		}
	} */
};

// Product::designate(); // Need to run this once elsewhere

Helper::processProductArray();

echo(var_dump($CommandCenter));
throw_error("Halt");	

/// Supply
//$InfCommandCenter->supplyCapacity		=  7;
//$InfOverlord->supplyCapacity			=  8;
//$InfOverseer->supplyCapacity			=  8;

// Patch 1.4.2
?>