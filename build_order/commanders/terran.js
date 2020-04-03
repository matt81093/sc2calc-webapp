var name = "",
race = "",
type = "",
mineralCost = 0,
gasCost = 0,
timeCost = 0,
prerequisites = "",
supplyCost = 0,
supplyCapacity = 0,
expends = "";

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
But if there’s a lot to import, we can import everything as an object using import * as <obj>, for instance:

// 📁 main.js
import * as say from './say.js';

say.sayHi('John');
say.sayBye('John');

*/
var CommandCenter;
var TerranStructures = [
  CommandCenter = {
    name:"Command Center",
    race:"Terran",
    type:"Structure | Base | Farm",
    mineralCost:400,
    gasCost:0,
    timeCost:100,
    prerequisites:null,
    supplyCapacity:11
  },
];

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
  name:"SCV",
  race:"Terran",
  type:"Unit | Worker",
  mineralCost:50,
  gasCost:0,
  timeCost:17,
  prerequisites:null,
  supplyCost:1,
  expends:"$CommandCenter | $OrbitalCommand | $PlanetaryFortress"
};
// Terran Units
