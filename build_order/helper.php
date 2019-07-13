<?php

class Helper {
	
	// Both decodes and converts
	// StdClass objects into Product objects

	public function makeProduct($input) {
		return json_decode($input);
	//	$temp = json_decode($input);
	//	$whitelist = ["Product"];
	//	$temp = serialize($temp);
	//	$temp = preg_replace('@^O:8:"stdClass":@','O:7:"Product":',$temp);

	//	return (object) unserialize($temp, ['allowed_classes' => $whitelist]);   // Presto a php Class 
	}
	
	public function doesContain($haystack, $needle) {
		return strpos($haystack, $needle) !== false;
		// return strpos($haystack, $needle) > -1;
	}
	
	public function toType($input) {
		$msg = null; 
		if (Helper::doesContain($input, "Unit")) {
			$msg = Unit;
		} elseif (Helper::doesContain($input, "Structure")) {
			$msg = Structure;
		} elseif (Helper::doesContain($input, "Upgrade")) {
			$msg = Upgrade;
		} elseif (Helper::doesContain($input, "Morph")) {
			$msg = Morph;
		}
		if (Helper::doesContain($input, "Base")) {
			$msg |= Base;
		}
		if (Helper::doesContain($input, "Ability")) {
			$msg |= Ability;
		}
		if (Helper::doesContain($input, "Spellcaster")) {
			$msg |= Spellcaster;
		}
		if (Helper::doesContain($input, "Worker")) {
			$msg |= Worker;
		}
		if (Helper::doesContain($input, "Geyser")) {
			$msg |= Geyser;
		} 
		if (Helper::doesContain($input, "Booster")) {
			$msg |= Booster;
		} 
		if (Helper::doesContain($input, 'Farm')) {
			$msg |= Farm;
		}
		return $msg;
	}
	
	public function toRace($input) {
		$msg = null;
		if ((Strcmp($input, "Terran")) === 0) {
			$msg = Terran;
		} elseif ((Strcmp($input, "Zerg")) === 0) {
			$msg = Zerg;
		} elseif ((Strcmp($input, "Protoss")) === 0) {
			$msg = Protoss;
		}
		return $msg;
	}
	
	public function toCommander($input) {
		$msg = null;
		if ((Strcmp($input, "Raynor")) === 0) {
			$msg = Terran;
		} elseif ((Strcmp($input, "Kerrigan")) === 0) {
			$msg = Kerrigan;
		} elseif ((Strcmp($input, "Artanis")) === 0) {
			$msg = Artanis;
		} elseif ((Strcmp($input, "Swann")) === 0) {
			$msg = Swann;
		} elseif ((Strcmp($input, "Zagara")) === 0) {
			$msg = Zagara;
		} elseif ((Strcmp($input, "Vorazun")) === 0) {
			$msg = Vorazun;
		} elseif ((Strcmp($input, "Karax")) === 0) {
			$msg = Karax;
		} elseif ((Strcmp($input, "Abathur")) === 0) {
			$msg = Abathur;
		} elseif ((Strcmp($input, "Alarak")) === 0) {
			$msg = Alarak;
		} elseif ((Strcmp($input, "Nova")) === 0) {
			$msg = Nova;
		} elseif ((Strcmp($input, "Stukov")) === 0) {
			$msg = Stukov;
		} elseif ((Strcmp($input, "Fenix")) === 0) {
			$msg = Fenix;
		} elseif ((Strcmp($input, "Dehaka")) === 0) {
			$msg = Dehaka;
		} elseif ((Strcmp($input, "Han&Horner")) === 0) {
			$msg = Han&Horner;
		} elseif ((Strcmp($input, "Tycus")) === 0) {
			$msg = Tycus;
		} elseif ((Strcmp($input, "Zeratul")) === 0) {
			$msg = Zeratul;
		} elseif ((Strcmp($input, "Stetmann")) === 0) {
			$msg = Stetmann;
		}
		return $msg;
	}
	
	public function processProductArray() {
		global $validTerran; //, $validZerg, $validProtoss;
		global $validProducts;
		$validProducts = $validTerran; //array_merge($validTerran, $validZerg, $validProtoss);
		
		foreach($validProducts as $newProductname => $newProduct) {//$newProductname => $newProductvariables) {
			//Helper::makeProduct($newProduct);//($newProductname, $newProductvariables);
//				$newProduct = new spawnObjects($newProduct)
			global ${$newProductname};
			${$newProductname} = new Product(json_decode($newProduct));	
		}
		
		echo ("Completed Processing Product Array!" . "\n");
	}
	
	public function processLoop ($array) {
		$size = count($array);
		for($product = 1; $product < $size; ++$product) {
			$newArray += global ${$array[$product]};
		}
		return $newArray;
	}
	
	/*
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
		//		
		
		// print_r($Object->name);
		
		if($Object->name == null) {
			print_r($Object);
			throw_error("Is this " . $Array['$name'] . "?");		
		}
		//echo var_dump($Object);
		return new Product($Object);
		
		// $Object = Product();
		
	} */
	
	public function isRace() {
		return $this->race & (Protoss | Terran | Zerg);
	}
	
	public function isCommander() {
		return $this->commander & (Stukov);
	}

};
?>