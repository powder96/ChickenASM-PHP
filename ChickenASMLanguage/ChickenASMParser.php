<?php
	/**
	 * ChickenASM Programming Language
	 * Copyright (C) 2013 powder96 <https://github.com/powder96/>
	 *
	 * This program is free software: you can redistribute it and/or modify
	 * it under the terms of the GNU General Public License as published by
	 * the Free Software Foundation, either version 3 of the License, or
	 * (at your option) any later version.
	 *
	 * This program is distributed in the hope that it will be useful,
	 * but WITHOUT ANY WARRANTY; without even the implied warranty of
	 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	 * GNU General Public License for more details.
	 *
	 * You should have received a copy of the GNU General Public License
	 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
	 */
	
	namespace ChickenASMLanguage;
	
	final class ChickenASMParser implements Parser {
		private $code;
		
		public function __construct($code) {
			$this->code = $code;
		}
		
		public function parse() {
			$opcodes = array();
			$lines = explode("\n", $this->code);
			$currentLine = 0;
			foreach($lines as $line) {
				++$currentLine;
				$instruction = trim($line);
				switch($instruction) {
					case 'exit':
						$opcodes[] = OPCODE_EXIT;
						break;
					case 'chicken':
						$opcodes[] = OPCODE_CHICKEN;
						break;
					case 'add':
						$opcodes[] = OPCODE_ADD;
						break;
					case 'subtract':
						$opcodes[] = OPCODE_SUBTRACT;
						break;
					case 'multiply':
						$opcodes[] = OPCODE_MULTIPLY;
						break;
					case 'compare':
						$opcodes[] = OPCODE_COMPARE;
						break;
					case 'load':
						$opcodes[] = OPCODE_LOAD;
						break;
					case 'store':
						$opcodes[] = OPCODE_STORE;
						break;
					case 'jump':
						$opcodes[] = OPCODE_JUMP;
						break;
					case 'char':
						$opcodes[] = OPCODE_CHAR;
						break;
					default:
						if(empty($instruction) || $instruction[0] === '#') // ignore empty lines and comments
							break;
						if(substr($instruction, 0, strlen('push')) === 'push')
							$opcodes[] = (int)substr($instruction, strlen('push')) + 10;
						else
							throw new ParserException("Unknown instruction \"{$command}\" at line {$currentLine}");
						break;
				}
			}
			return $opcodes;
		}
	}