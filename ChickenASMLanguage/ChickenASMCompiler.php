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
	
	final class ChickenASMCompiler implements Compiler {
		private $opcodes;
		
		public function __construct($opcodes) {
			$this->opcodes = $opcodes;
		}
		
		public function compile() {
			$code = '';
			foreach($this->opcodes as $opcode) {
				switch($opcode) {
					case OPCODE_EXIT:
						$code .= "exit\n";
						break;
					case OPCODE_CHICKEN:
						$code .= "chicken\n";
						break;
					case OPCODE_ADD:
						$code .= "add\n";
						break;
					case OPCODE_SUBTRACT:
						$code .= "subtract\n";
						break;
					case OPCODE_MULTIPLY:
						$code .= "multiply\n";
						break;
					case OPCODE_COMPARE:
						$code .= "compare\n";
						break;
					case OPCODE_LOAD:
						$code .= "load\n";
						break;
					case OPCODE_STORE:
						$code .= "store\n";
						break;
					case OPCODE_JUMP:
						$code .= "jump\n";
						break;
					case OPCODE_CHAR:
						$code .= "char\n";
						break;
					default:
						$code .= 'push ' . ($opcode - 10) . "\n";
						break;
				}
			}
			return $code;
		}
	}