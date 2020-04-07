/*jshint unused: true, node: true */
/*jslint unparam: true, node: true */

// import * from './product defines.js';
// import * from './commanders.js'
// module.exports = new Foo();

var races, t_factions, z_factions, p_factions, classes;
var $_designated, $all, $last_uid, $uid, $name, $type, $faction, $leader, $mineralCost, $gasCost, $larvaCost, $supplyCost, $supplyCapacity, $energyCost, $energyMax, $energyStart, $spellCaster, $spellCooldown, $timeCost, $prerequisites, $yeilds, $expends, $expendsAll, $exposed, $race;
var terran, zerg, protoss;

// Races = Terran, Zerg, Protoss
// Specific racial faction arrays
// Array defining class objects

t_factions = ["raynor"];
z_factions = ["stukov"];
p_factions = ["artanis"];
classes = ["unit", "structure", "upgrade", "morph", "ability", "spellcaster", "base"];

// Set-up groundwork for our Products
// Array.forEach( function(current_value, index, initial_array) {}, this_context )

function constructFactionFoundation() {
    "use strict";
    terran = {}; // Terran Foundation
    terran.base = {}; // Let's construct our base terran faction with object classes
    classes.forEach(function (element, i) {
        terran.base[classes[i]] = {};
    }); // Now for the Terran Commanders
    t_factions.forEach(function (element, i) {
        terran[t_factions[i]] = {};
        classes.forEach(function (element, j) {
            terran[t_factions[i]][classes[j]] = {};
        });
    });
    zerg = {}; // Zerg Foundation
    zerg.base = {}; // Let's construct our base Zerg faction with object classes
    classes.forEach(function (element, i) {
        zerg.base[classes[i]] = {};
    }); // Now for the Zerg Commanders
    z_factions.forEach(function (element, i) {
        zerg[z_factions[i]] = {};
        classes.forEach(function (element, j) {
            zerg[z_factions[i]][classes[j]] = {};
        });
    });
    protoss = {}; // Protoss Foundation
    protoss.base = {}; // Let's construct our base Protoss faction with object classes
    classes.forEach(function (element, i) {
        protoss.base[classes[i]] = {};
    }); // Now for the Protoss Commanders
    p_factions.forEach(function (element, i) {
        protoss[p_factions[i]] = {};
        classes.forEach(function (element, j) {
            protoss[p_factions[i]][classes[j]] = {};
        });
    });
}

function Product() {
    "use strict";

    $_designated = []; // @let array | List of designated products for specific types.
    $all = []; // @let array | List of all exposed products.
    $last_uid = 0; // @let int | Last unique identifier created.
    $uid = null; // @let int | Unique identifier of this product.
    $name = "Placeholder"; // @let string | Name of this product.
    $type = 0;  // @let int | Type of this product.
    $faction = 0; //@let int | Faction of this product.
    $leader = "Base"; //@let int | Commander of this product.
    $mineralCost = 0.0; // @let float | Mineral cost of this product.
    $gasCost = 0.0; // @let float | Gas cost of this product.
    $larvaCost = 0; // @let int | Larva cost of this product.
    $supplyCost = 0; // @let int | Supply cost of this product.
    $supplyCapacity = 0; // @let int | Supply capacity provided by this product.
    $energyCost = 0.0; // @let float | Energy cost of this product.
    $energyMax = 0.0; // @ let float | Maximum energy on this spellcaster.
    $energyStart = 0.0; // @let float | Initial energy on this spellcaster.
    $spellCaster = [];  // @let Array of Product | Type of spellcaster needed to use this ability.
    $spellCooldown = 0; // @let int | Time until Ability can be used again.
    $timeCost = 0.0; // @let float | Time it takes to complete this product.
    $prerequisites = []; // @let array | Prerequisite structures or upgrades to build this product.
    $yeilds = []; // @let array | For a morph, a list of products that are yielded by the morph.
    $expends = []; // @let array | Production queues expended to build this product.
    $expendsAll = false; // @let bool | If true, all production queues are required; if false, only one of them.
    $exposed = true; // @let bool | Decides whether to show this product in build log.
}

    /* constructor(name, type, prerequisites, expends, supplyCost, mineralCost, gasCost, timeCost, exposed = true) {
    this.name = name;
    this.type = type;
    this.prerequisites = prerequisites;
    this.expends = expends;
    this.expendsAll = false;
    this.mineralCost = mineralCost;
    this.gasCost = gasCost;
    this.timeCost = timeCost;
    this.supplyCost = supplyCost;
} */

// Type checking and assigning values.
// for loop with switches? can test out and keep
// unknown if I can move this to function

/* types = explode(" | ", Product->type);
count = count(types);
for(strings = 0; strings < count; ++strings) {
  type = types[strings]; */
  // unset(types); unset(count);
  // set uid & append to all
  /* this.uid = last_uid++;
  if(exposed) {
  all[] = this; */


class Terran extends Product {
  constructor() {
    this.$faction = TERRAN;
  }
}

class Zerg extends Product {
  constructor() {
    this.$faction = ZERG;
  }
}

class Protoss extends Product {
  constructor() {
    this.$faction = PROTOSS;
  }
}

class Unit extends Product {
  constructor() {
    this.$type = $type |= UNIT;
    this.$supplyCost = $supplyCost;
    this.$faction & ZERG ? this.$larvaCost = 1 : 0;
    this.$expends = $expends;
  }
}

class Structure extends Product {
  constructor() {
    this.$type = $type |= STRUCTURE;
    this.$faction & ZERG ? this.$supplyCost = -1 : null;
  }
}

class Upgrade extends Product {
  constructor() {
    this.$type |= UPGRADE;
    this.$expends = $expends;
  }
}

class Morph extends Product {
  constructor(yields) {
    this.$type |= MORPH;
    this.$yields = $yields;
    this.$expends = $expends;
    this.$supplyCost = $supplyCost;
    this.$expendsAll = true;
  }
}

class Ability extends Product {
  constructor(spellCaster, energyCost) {
    this.$type |= ABILITY;
    this.$energyCost = $energyCost;
    this.$spellCaster = $spellCaster;
    this.$spellCooldown = $spellCooldown;
  }
}

class Spellcaster extends Product {
  constructor() {
    this.$type |= SPELLCASTER;
    this.$energyStart = $energyStart;
    this.$energyMax = $energyMax;
  }
}

class Hq extends Product {
  constructor() {
    this.$type |= HQ;
    $_designated[HQ] = &this;
  }
}

class Worker extends Product {
  constructor() {
    this.$type |= WORKER;
    $_designated[WORKER] = &this;
  }
}

class Geyser extends Product {
  constructor() {
    this.$type |= GEYSER;
    $_designated[GEYSER] = &this;
  }
}

class Booster extends Product {
  constructor() {
    this.$type |= BOOSTER;
    $_designated[BOOSTER] = &this;
  }
}

class Farm extends Product {
  constructor() {
    this.$type |= FARM;
    // _designated[type] = this;
    this.$supplyCapacity = $supplyCapacity;
  }
}
	/**
	 * When a product is unset
	 */
function drop() {
	forEach(all as &candidate) {
		if(this.$uid == candidate.$uid) {
			unset(candidate);
			break;
		}
	}
}

function faction() {
	return this->faction & (Protoss | Terran | Zerg);
}

/// operators

/**
 * Convert to a string.
 * @return string
 */
public function __toString() {
	return isset(this->name) ? this->name : "n/a";
}

/// public static methods

/**
 * Find exposed product by name.
 * @param string name
 * @return Product
 */

function byName(name) {
	products = $all;
	count = $all.length;
	for(candidate = 0; candidate < count; ++candidate) {
		if (products[candidate]->name === name) {
			return products[candidate];
		}
	}
}
		/*
		forEach(Product::all as candidate) {
			// if(value == name) {
				if(strcasecmp(name, candidate->name) === 0) {// value) == 0) {
				// if(candidate->name == name) { // if (value == 'name') {
					return candidate; // if(strcasecmp(name, value) == 0) {
				}
			// }
		} */

function findProduct(name) {
	forEach($all as candidate) {
		if(strcasecmp(name, candidate.$name) == 0) {
			return candidate;
		}
	}
}

	/**
	 * Get designated product of given type.
	 * @param int type
	 * @return Product
	 */
function designated(type) {
	return $_designated[type];
}

	/// public methods

	/**
	 * Make a specific product the designated product of its type.
	 * @param int type
	 */

// Patch 1.4.2
