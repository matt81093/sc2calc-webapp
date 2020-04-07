const ADDON_SWAP_TIME = 10;
const CHRONO_BOOST_RATE = 1.5;
const CHRONO_BOOST_HUMAN_DELAY = 0.1;
const ENERGY_RATE = 0.5625;
const LARVA_TIME = 15;
const MULE_MINING = 2.9;
const WARPGATE_QUEUE_REDUCTION = 10;
const STUKOV_CC_LARVA_RATE = 16;
const STUKOV_BUNKER_CHARGE_RATE = 20;

/**
 * Flags for product types.
 */
 /**
  * Products are structures, units, upgrades, morphs, addons, addon swaps,
  * abilities, etc. Basically, anything that is buildable in the game.
  */

// Faction defines
const TERRAN = (1 << 0); // 1
const ZERG = (1 << 1); // 2
const PROTOSS = (1 << 2); // 4

// Product types
const UNIT = (1 << 3); // 8
const STRUCTURE = (1 << 4); // 16
const UPGRADE = (1 << 5); // 32
const MORPH = (1 << 6); // 64
const ABILITY = (1 << 7); // 128
const SPELLCASTER = (1 << 8); // 256
const HQ = (1 << 8); // 512

// Special product defines
const WORKER = (1 << 9); //1024
const GEYSER = (1 << 10); //2048
const BOOSTER = (1 << 11); //4096
const FARM = (1 << 12); //8192

// Useful macros
const SET_FLAG(n, f) ((n) |= (f))
const CLR_FLAG(n, f) ((n) &= ~(f))
const TGL_FLAG(n, f) ((n) ^= (f))
const CHK_FLAG(n, f) ((n) & (f))

export TERRAN, ZERG, PROTOSS;
export UNIT, STRUCTURE, UPGRADE, MORPH, ABILITY, SPELLCASTER;
export WORKER, GEYSER, BOOSTER, FARM;
