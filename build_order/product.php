<?php

			/*
			$count = count($Product);
			for ($i = 0; $i < $count; ++$i){
				
			}
			foreach ($Product as $key => $value) {
				$key = $value;
			}
			*/
			
require 'product defines.php';
require './commanders/terran.php';
require './commanders/zerg.php';
require './commanders/protoss.php';

/**
 * Products are structures, units, upgrades, morphs, addons, addon swaps,
 * abilities, etc. Basically, anything that is buildable in the game.
 */
class Product {
	/// private static members

	/**
	 * List of designated products for specific types.
	 * @var array
	 */
	private static $_designated = array();
	
	/// public static members

	/**
	 * List of all exposed products.
	 * @var array
	 */
	public static $all = array();
	
	/// private static members

	/**
	 * Last unique identifier created.
	 * @var int
	 */
	private static $last_uid = 0;

	/// public members

	/**
	 * Energy cost of this product.
	 * @var float
	 */
	public $energyCost;

	/**
	 * Maximum energy on this spellcaster.
	 * @var float
	 */
	public $energyMax;

	/**
	 * Initial energy on this spellcaster.
	 * @var float
	 */
	public $energyStart;

	/**
	 * Production queues expended to build this product.
	 * @var array
	 */
	public $expends;

	/**
	 * If true, all production queues are required; if false, only one of them.
	 * @var bool
	 */
	public $expendsAll;

	/**
	 * Mineral cost of this product.
	 * @var float
	 */
	 
	public $materials;
	
	public $mineralCost;

	/**
	 * Gas cost of this product.
	 * @var float
	 */
	public $gasCost;

	/**
	 * Larva cost of this product.
	 * @var int
	 */
	public $larvaCost;

	/**
	 * Name of this product.
	 * @var string
	 */
	public $name;

	/**
	 * Prerequisite structures or upgrades to build this product.
	 * @var array
	 */
	public $prerequisites;

	/**
	 * Type of spellcaster needed to use this ability.
	 * @var Product 
	 */
	public $spellcaster;

	/**
	 * Supply capacity provided by this product.
	 * @var int
	 */
	public $supplyCapacity;

	/**
	 * Supply cost of this product.
	 * @var int
	 */
	public $supplyCost;

	/**
	 * Time it takes to complete this product.
	 * @var float
	 */
	public $spellCooldown;
	
	public $build_time;
	
	public $timeCost;
	
	public $race;
	
	public $commander;

	/**
	 * Type of product.
	 * @var int
	 */
	public $type;

	/**
	 * Unique identifier of this product.
	 * @var int
	 */
	public $uid;

	/**
	 * For a morph, a list of products that are yielded by the morph.
	 * @var array
	 */
	public $transformation_to;
	
	/*
	
	public $validStructures = array();
	
	public $validAbilities = array();
	
	public $validMorphs = array();
	
	public $validUnits = array();
	
	public $validUpgrades = array();
	
	public $validProducts = array();
	
	public $TerranStructures = array();
	
	*/
	
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
	
	// public $Product = array();
	 
	public function __construct($Product, $exposed = true) { //$name, $type, $prerequisites, $expends, $supplyCost, $materials, $build_time, $exposed = true]) {

		if (empty($Product)) { //|| !is_array($Product)) {
			throw_error("This object is empty. Please report to webmaster.");
		} else {
			$this->race = $Product->race;
			$this->commander = $Product->commander;
			$this->name = $Product->name;
			$this->type = $Product->type;
			
			if(count($Product->prerequisites) !== 0) {
				// throw_error(get_class($this));
				// temp array?
				foreach($Product->prerequisites as $candidate) {
					$candidate = new $candidate;
					// unset($candidate);
					/*
					$prereq = $candidate;
					// 1 == 0 ? 1 : 0
					$this->prerequisites[] = $prereq; */
				}
			} else {
				$this->prerequisites = $Product->prerequisites;
			}
			if(count($Product->prerequisites) == 3) {
				throw_error(var_dump($this->prerequisites));
			}
			
			$this->expendsAll = $Product->expendsAll;
			
			if (isset($Product->time)) {
				$this->time = $Product->time;
				echo($this->time);
			}
			
			if(isset($Product->mineralCost)) {	
				$this->mineralCost = $Product->mineralCost;
			}
			
			if(isset($Product->gasCost)) {
				$this->gasCost = $Product->gasCost;	
			}
			
			if ($this->type && Morph | Unit) {
				if(isset($Product->supplyCost)) {
					$this->supplyCost = $Product->supplyCost;
				}
			}
			
			if (($this->type && Structure) && ($this->race & Zerg)) {
				$this->supplyCost = -1;
			}
			
			if ($this->type && Farm) {
				if(isset($Product->supplyCapacity)) {
					$this->supplyCapacity = $Product->supplyCapacity;
				}
			}
			
			if ($this->type && Upgrade | Morph | Unit) {
				if(isset($Product->expends)) {
					$this->expends = $Product->expends;
				}
			}
		
			if ($this->type && Morph) {
				if(isset($Product->yeilds)) {
					$this->yeilds = $Product->yeilds;
				}
			}
		
			if($this->type && Spellcaster) {
				if(isset($Product->energyStart)) {
					$this->energyStart = $Product->energyStart;
				}
				if(isset($Product->energyMax)) {
					$this->energyMax = $Product->energyMax;
				}
			}
		
			if($this->type && Ability) {
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
	
	public function DebugMe($arg = '') {
	throw_error(var_dump($arg));
	}
	
	public function DebugObject($arg = '') {
	throw_error(var_dump(get_object_vars($arg)));
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
				

	/*
		$current_all = Product::$all;
		$tempArray = array_filter( $current_all = [], function($var) use ($name) {
			return ($var['$name'] == $name);
		return $tempArray;
		});
		unset ($filter);
		// return $somevalue
	*/

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

	public function race() {
		return $this->race & (Protoss | Terran | Zerg);
	}
	
	public function commander() {
		return $this->commander & (Stukov);
	}
	
	public function assign_commander($commander1) {
		return $this->$Product[$commander] = $commander1;
	}
	
	public function which_commander() {
		return $this->$Product[$commander];
	}
	
	// recursively reduces deep arrays to single-dimensional arrays
	// $preserve_keys: (0=>never, 1=>strings, 2=>always)
	public function array_flatten($array, $preserve_keys = 1, &$newArray = Array()) {
		foreach ($array as $key => $child) {
			if (is_array($child)) {
				$newArray =& array_flatten($child, $preserve_keys, $newArray);
			} elseif ($preserve_keys + is_string($key) > 1) {
				$newArray[$key] = $child;
			} else {
				$newArray[] = $child;
			}
		}
		return $newArray;
	}
	
	public function makeObject(string $Object, array $Array) {
		// $Object2 = (object) $Array;
		// Need to check what variables is being assigned to new objects.. see if can assign to Product
		$Object = new stdClass();
		
		$Object->race = $Array['$race'];
		$Object->commander = $Array['$commander'];
		$Object->name = $Array['$name'];
		$Object->type = $Array['$type'];
		$Object->prerequisites = $Array['$prerequisites'];
		$Object->expendsAll = false;
		
		if(isset($Array['build_time'])) {
			$Object->time = $Array['$build_time'];
		}
		
		if (isset($Array['$materials'])) {
			$Object->mineralCost = $Array['$materials']['$minerals'];
			$Object->gasCost = $Array['$materials']['$gas'];
		}
		
		if ($Object->type && Morph | Unit) {
			if(isset($Array['$supplyCost'])) {
				$Object->supplyCost = $Array['$supplyCost'];
			}
		}
		
		if (($Object->type && Structure) && ($Object->race && Zerg)) {
			$Object->supplyCost = -1;
		}		
		
		if ($Object->type & Farm) {
			if(isset($Array['$supplyCapacity'])) {
				$Object->supplyCapacity = $Array['$supplyCapacity'];
			}
		}
		
		if ($Object->type && Upgrade | Morph | Unit) {
			if(isset($Array['$expends'])) {
				$Object->expends = $Array['$expends'];
			}
		}
		
		if ($Object->type && Morph) {
			if(isset($Array['$yeilds'])) {
				$Object->yeilds = $Array['$yeilds'];
			}
		}
		
		if($Object->type && Spellcaster) {
			if(isset($Array['$energyStart'])) {
				$Object->energyStart = $Array['$energyStart'];
			}
			
			if(isset($Array['$energyMax'])) {
				$Object->energyMax = $Array['$energyMax'];
			}
		}
		
		if($Object->type && Ability) {
			if(isset($Array['$spellCaster'])) {
				$Object->spellCaster = $Array['$spellCaster'];
			}
			
			if(isset($Array['$energyCost'])) {
				$Object->energyCost = $Array['$energyCost'];
			}
			
			if(isset($Array['$spellCooldown'])) {
				$Object->spellCooldown = $Array['$spellCooldown'];
			}
		}
		// */		
		
		// print_r($Object->name);
		
		if($Object->name == null) {
			print_r($Object);
			throw_error("Is this " . $Array['$name'] . "?");		
		}
		echo var_dump($Object);
		return new Product($Object);
		
		// $Object = Product();
		
	}
	
	public function processProductArrays() {
		global $validTerran, $validZerg, $validProtoss;
		$validProducts = array_merge($validTerran, $validZerg, $validProtoss);
		
		foreach($validProducts as $newProductname => $newProductvariables) {
			Product::makeObject($newProductname, $newProductvariables);
//				$newProduct = new spawnObjects($newProduct);
			
		}
	}
};

Product::processProductArrays();
// Product::designate(); // Need to run this once elsewhere
	
/// Supply
//$InfCommandCenter->supplyCapacity		=  7;
//$InfOverlord->supplyCapacity			=  8;
//$InfOverseer->supplyCapacity			=  8;

// Patch 1.4.2
?>