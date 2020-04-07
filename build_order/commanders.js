

var Structure = {};
Terran.Base.Structure.CommandCenter = "value3";
Terran[Base][Structure][CommandCenter] = "value3";

obj.key3 = "value3";
Using square bracket notation:
obj["key3"] = "value3";

function assignProduct (product) {
  switch(product.faction) {
    case (product.faction & TERRAN):
      switch (product.commander) {
        case "Base":
          break;
        case "Raynor":

        default:
          throw_error("Commander not set");
      }
      default:
        throw_error("Faction not set");
  }
}

switch(expression) {
  case x:
    // code block
    break;
  case y:
    // code block
    break;
  default:
    // code block
}

var getProperty = function (propertyName) {
    return obj[propertyName];
};

getProperty("key1");
getProperty("key2");
getProperty("key3");



Structure.Terran = {commandCenter}
Structure.Terran.CommandCenter = makeObject(true, );
Structure.Terran.CommandCenter.mineralCost = ;


function makeProduct (exposed, ) {
  exposed ? this.exposed = true : this.exposed = false;
  ObjectAssign({}, Product)
}



/*

const unitObject = { type: 'Unit' }
const terranObject = { faction: 'Terran' }

const terranMarine = Object.assign({}, unitObject, terranObject);
Object.assign(target, ...sources)

function setFaction(product, type) { // Terran, Zerg, Protoss
  Object.assign(product, type)
}



var name = null;
var race = null,
type = null,
mineralCost = 0,
gasCost = 0,
timeCost = 0,
prerequisites = null,
supplyCost = 0,
supplyCapacity = 0,
expends = null;
*/
/*
function FirstFunction(x = 1, y) {
  if(y === undefined) {
    y = 0;
  }
}

CommandCenter.name refers to name
CommandCenter.nogo() refers to action

/* js only uses person[0]; person [1]; etc
person["name"] creates an object, unsure of use
if (typeof myObj === "undefined") => if (typeof myObj !== "undefined" && myObj !== null)

var i;
var l = arr.length;
for (i = 0; i < l; i++) {};

adding script after page load ->
<script>
window.onload = function() {
  var element = document.createElement("script");
  element.src = "myScript.js";
  document.body.appendChild(element);
};
</script>

// module.js
export function hello() {
  return "Hello";
}

// main.js
import {hello} from 'module'; // or './module'
let val = hello(); // val is "Hello";

// 📁 main.js
import {sayHi, sayBye} from './say.js';

sayHi('John'); // Hello, John!
sayBye('John'); // Bye, John!
But if there’s a lot to import,
we can import everything as an object using import * as <obj>, for instance:

// 📁 main.js
import * as say from './say.js';

say.sayHi('John');
say.sayBye('John');

*/

// structure.terran.name = "CommandCenter",
// terran.name = "CommandCenter",
var commandCenter;
var terranStructures = {
  CommandCenter: {
    name: "Command Center",
    faction: "Terran",
    type: "Structure | Base | Farm",
    mineralCost: 400,
    gasCost: 0,
    timeCost: 100,
    prerequisites: null,
    supplyCapacity: 11,
  },
};

// Terran Structures
/*
var CommandCenter = {
  name:"Command Center",
  race:"Terran",
  type:"Structure | Base | Farm",
  mineralCost:400,
  gasCost:0,
  timeCost:100,
  prerequisites:null,
  supplyCapacity:11
};
*/

var SCV = {
  name: 'SCV',
  race: "terran",
  type: "unit | worker",
  mineralCost: 50,
  gasCost: 0,
  timeCost: 17,
  prerequisites: null,
  supplyCost: 1,
  expends: "commandCenter | orbitalCommand | $planetaryFortress"
};

// Terran Units

//export everything relevent ie object

export {terranStructures};
