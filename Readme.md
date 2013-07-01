# ChickenASM

This repository contains PHP code for translating programs between the [Chicken programming language](http://torso.me/chicken) and the ChickenASM programming language.

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
To build all example ChickenASM programs (*.cha), run the build.php script.

## Requirements
* PHP 5.3

## License

Copyright (C) 2013 powder96 <https://github.com/powder96/>

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.