# ChickenASM-PHP

This repository contains PHP code for working with programs written in [Chicken programming language](http://torso.me/chicken), ChickenASM, and [Eggsembly](https://github.com/igorw/chicken-php).

## Example
### ChickenASM code
```
# Prints 'A' (ASCII 65)
push 5
push 13
multiply
char
exit
```
### Equivalent Chicken code
```
chicken chicken chicken chicken chicken chicken chicken chicken chicken chicken chicken chicken chicken chicken chicken
chicken chicken chicken chicken chicken chicken chicken chicken chicken chicken chicken chicken chicken chicken chicken chicken chicken chicken chicken chicken chicken chicken chicken
chicken chicken chicken chicken
chicken chicken chicken chicken chicken chicken chicken chicken chicken

```

## ChickenASM Instructions
### exit
Terminates the execution of the program.
### chicken
Pushes string `"chicken"` onto the stack.
### add
Removes the two topmost values from the stack and replaces them with their sum (can be used to add numbers or concatenate strings).
### subtract
Removes the two topmost values from the stack and replaces them with their difference.
### multiply
Removes the two topmost values from the stack and replaces them with their product.
### compare
Removes the two topmost values from the stack, checks if they are equal, and pushes either `true` or `false` instead.
### load N
The topmost value is interpreted as an address. `N` determines what to load from: 0 for loading from the stack, 1 for loading from input.
### store
The topmost values are interpreted as an address. The second topmost value get stored at that address on the stack.
### jump
Jumps to a different instruction if the condition is truthy. The topmost value is interpreted as a relative offset. The second topmost value is the condition.
### char
Converts the topmost value into a HTML entity.
### push N
Pushes integer `N` onto the stack.

## Usage
### 0. Include the library:

```php
	require_once('ChickenASMLanguage/ChickenASMLanguage.php');
```

### 1. Compile code into Chicken VM opcodes:

```php
	$compiler = new ChickenASMLanguage\ChickenCompiler($code); // use this to compile Chicken code
	$compiler = new ChickenASMLanguage\ChickenASMCompiler($code); // use this to compile ChickenASM code
	$compiler = new ChickenASMLanguage\EggsemblyCompiler$code); // use this to compile Eggsembly code
	$opcodes = $compiler->parse();
```

### 2. Feed opcodes into the VM:

```php
	$vm = new ChickenASMLanguage\VirtualMachine($opcodes, $input);
	$output = $vm->execute();
```

### 3. Decompile opcodes into Chicken(ASM)/Eggsembly code:

```php
	$decompiler = new ChickenASMLanguage\ChickenDecompiler($opcodes); // use this to get Chicken code
	$decompiler = new ChickenASMLanguage\ChickenASMDecompiler($opcodes); // use this to get ChickenASM code
	$decompiler = new ChickenASMLanguage\EggsemblyDecompiler($opcodes); // use this to get Eggsembly code
	$code = $decompiler->decompile();
```

## Testing
To convert example ChickenASM programs (*.cha), run the cha-to-chn.php script. To convert all example Chicken programs (*.chn), run the chn-to-cha.php script. To test the Chicken interpreter, run the index.php script.

## Requirements
* PHP 5.3

## License

Copyright (C) 2013 powder96 <https://github.com/powder96/>

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.