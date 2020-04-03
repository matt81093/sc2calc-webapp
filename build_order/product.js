<SCRIPT type="text/javascript">

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
	// @var array | List of designated products for specific types.

	public static $all = array();
	// @var array | List of all exposed products.

	private static $last_uid = 0;
	// @var int | Last unique identifier created.

	public $exposed = true;
	// @var bool | Decides whether to show this product in build log.

	public $energyCost = 0.0;
	// @var float | Energy cost of this product.

	public $energyMax = 0.0;
	// @ var float | Maximum energy on this spellcaster.

	public $energyStart = 0.0;
	// @var float | Initial energy on this spellcaster.

	public $expends = array();
	// @var array | Production queues expended to build this product.

	public $expendsAll = false;
	// @var bool | If true, all production queues are required; if false, only one of them.

	public $mineralCost = 0.0;
	// @var float | Mineral cost of this product.

	public $gasCost = 0.0;
	// @var float | Gas cost of this product.

	public $larvaCost = 0;
	// @var int | Larva cost of this product.

	public $name = "Placeholder";
	// @var string | Name of this product.

	public $prerequisites = array();
	// @var array | Prerequisite structures or upgrades to build this product.

	public $spellcaster = array();
	// @var Array of Product | Type of spellcaster needed to use this ability.

	public $supplyCapacity = 0;
	// @var int | Supply capacity provided by this product.

	public $supplyCost = 0;
	// @var int | Supply cost of this product.

	public $spellCooldown = 0;
	// @var int | Time until Ability can be used again.

	public $timeCost = 0.0;
	// @var float | Time it takes to complete this product.

	public $race = 0;
	//@var int | Race of this product.

	public $type = 0;
	// @var int | Type of this product.

	public $uid;
	// @var int | Unique identifier of this product.

	public $yeilds = array();
	// @var array | For a morph, a list of products that are yielded by the morph.

	/** /// constructor
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

		if (empty($Product)) {
			throw_error("Attempted to construct empty object.");
		} else {
			$this->race = (Helper::toRace($Product->race));
			$this->name = $Product->name;
			$this->prerequisites = (Helper::sortToArray($Product->prerequisites));
			$this->timeCost = $Product->timeCost;
			$this->mineralCost = $Product->mineralCost;
			$this->gasCost = $Product->gasCost;
			$expendsAll = false;

			// Type checking and assigning values.
			// for loop with switches? can test out and keep
			// unknown if I can move this to function

			$types = explode(" | ", $Product->type);
			$count = count($types);
			for($strings = 0; $strings < $count; ++$strings) {
				$type = $types[$strings];
				switch ($type) {
					case $type === "Unit":
						$this->type |= Unit;
						$this->expends = (Helper::sortToArray($Product->expends));
						$this->supplyCost = $Product->supplyCost;
						$this->race & Zerg ? $this->larvaCost = 1 : 0;
						continue;
					case $type === "Structure":
						$this->type |= Structure;
						$this->race & Zerg ? $this->supplyCost = -1 : null;
						continue;
					case $type === "Upgrade":
						$this->type |= Upgrade;
						$this->expends = (Helper::sortToArray($Product->expends));
						continue;
					case $type === "Morph":
						$this->type |= Morph;
						$this->expends = (Helper::sortToArray($Product->expends));
						$this->supplyCost = $Product->supplyCost;
						$this->yeilds = (Helper::sortToArray($Product->yeilds));
						$this->expendsAll = true;
						continue;
					case $type === "Ability":
						$this->type |= Ability;
						$this->spellCaster = (Helper::sortToArray($Product->spellCaster));
						$this->energyCost = $Product->energyCost;
						$this->spellCooldown = $Product->spellCooldown;
						continue;
					case $type === "Spellcaster":
						$this->type |= Spellcaster;
						$this->energyStart = $Product->energyStart;
						$this->energyMax = $Product->energyMax;
						continue;
					// Special types
					case $type === "Base":
						$this->type |= Base;
						$_setType = Base | $this->race;
						Product::$_designated[$_setType] = &$this;
						unset($_setType); continue;
					case $type === "Worker":
						$this->type |= Worker;
						$_setType = Worker | $this->race;
						Product::$_designated[$_setType] = &$this;
						continue;
					case $type === "Geyser":
						$this->type |= Geyser;
						$_setType = Geyser | $this->race;
						Product::$_designated[$_setType] = &$this;
						continue;
					case $type === "Booster":
						$this->type |= Booster;
						$_setType = Booster | $this->race;
						Product::$_designated[$_setType] = &$this;
						continue;
					case $type === "Farm":
						$this->type |= Farm;
						// $_designated[$type] = $this;
						$this->supplyCapacity = $Product->supplyCapacity;
						continue;
				}
			}
			unset($types); unset($count);

			// $this->larvaCost = (($this->race & Zerg) && ($this->type & Unit)) ? 1 : 0;

			// set uid & append to all
			$this->uid = Product::$last_uid++;
			if($exposed) {
				Product::$all[] = $this;
			}
		}
	}

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

	public function race() {
		return $this->race & (Protoss | Terran | Zerg);
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
		$products = Product::$all;
		$count = count(Product::$all);
		for($candidate = 0; $candidate < $count; ++$candidate) {
			if ($products[$candidate]->name === $name) {
				return $products[$candidate];
			}
		}

		/*
		foreach(Product::$all as $candidate) {
			// if($value == $name) {
				if(strcasecmp($name, $candidate->name) === 0) {// $value) == 0) {
				// if($candidate->name == $name) { // if ($value == '$name') {
					return $candidate; // if(strcasecmp($name, $value) == 0) {
				}
			// }
		} */
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
};

// Product::designate(); // Need to run this once elsewhere

Helper::processProductArray();
//echo '<pre>'; print_r(Product::$all); echo '</pre>';
//throw_error("Halt");
//Product::designate(Product::$all);
// echo '<pre>'; print_r(Product::$_designate); echo '</pre>';
	// echo(var_dump($CommandCenter));
// throw_error("Halt");

/// Supply
//$InfCommandCenter->supplyCapacity		=  7;
//$InfOverlord->supplyCapacity			=  8;
//$InfOverseer->supplyCapacity			=  8;

// Patch 1.4.2
?>
