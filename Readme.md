# ChickenASM

This repository contains PHP code for working with programs written in [Chicken programming language](http://torso.me/chicken) and the ChickenASM programming language.

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
 * `exit` - Terminates the execution of the program.
 * `chicken` - Pushes string "chicken" onto the stack.
 * `add` - Removes the two topmost values from the stack and replaces them with their sum (can be used to add numbers or concatenate strings).
 * `subtract` - Removes the two topmost values from the stack and replaces them with their difference.
 * `multiply` - Removes the two topmost values from the stack and replaces them with their product.
 * `compare` - Removes the two topmost values from the stack, checks if they are equal, and pushes either true or false instead.
 * `load` - The topmost value is interpreted as an address. This is a double wide instruction that uses the next value to determine what to load from: 0 for loading from the stack, 1 for loading from input.
 * `store` - The topmost values are interpreted as an address. The second topmost value get stored at that address on the stack.
 * `jump` - Jumps to a different instruction if the condition is truthy. The topmost value is interpreted as a relative offset. The second topmost value is the condition.
 * `char` - Converts the topmost value into a character.
 * `push N` - Pushes (N - 10) onto the stack.

## Testing
To build all example ChickenASM programs (*.cha), run the compile.php script. To decompile all example Chicken programs (*.chn), run the decompile.php script. To test the Chicken interpreter, run the index.php script.

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