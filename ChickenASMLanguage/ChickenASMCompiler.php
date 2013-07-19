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
	
	class ChickenASMCompiler implements Compiler {
		private $code;
		protected $instructions;
		
		public function __construct($code) {
			$this->defineInstructions();
			$this->code = $code;
		}
		
		public function compile() {
			$opcodes = array();
			$lines = explode("\n", $this->code);
			$currentLine = 0;
			foreach($lines as $line) {
				++$currentLine;
				$instruction = trim($line);
				switch($instruction) {
					case $this->instructions[OPCODE_EXIT]:
						$opcodes[] = OPCODE_EXIT;
						break;
					case $this->instructions[OPCODE_CHICKEN]:
						$opcodes[] = OPCODE_CHICKEN;
						break;
					case $this->instructions[OPCODE_ADD]:
						$opcodes[] = OPCODE_ADD;
						break;
					case $this->instructions[OPCODE_SUBTRACT]:
						$opcodes[] = OPCODE_SUBTRACT;
						break;
					case $this->instructions[OPCODE_MULTIPLY]:
						$opcodes[] = OPCODE_MULTIPLY;
						break;
					case $this->instructions[OPCODE_COMPARE]:
						$opcodes[] = OPCODE_COMPARE;
						break;
					case $this->instructions[OPCODE_LOAD]:
						$opcodes[] = OPCODE_LOAD;
						break;
					case $this->instructions[OPCODE_STORE]:
						$opcodes[] = OPCODE_STORE;
						break;
					case$this->instructions[OPCODE_JUMP]:
						$opcodes[] = OPCODE_JUMP;
						break;
					case $this->instructions[OPCODE_CHAR]:
						$opcodes[] = OPCODE_CHAR;
						break;
					default:
						if(strpos($instruction, $this->instructions['push']) === 0)
							$opcodes[] = (int)substr($instruction, strlen($this->instructions['push'])) + 10;
						break;
				}
			}
			return $opcodes;
		}
		
		protected function defineInstructions() {
			$this->instructions = array(
				OPCODE_EXIT     => 'exit',
				OPCODE_CHICKEN  => 'chicken',
				OPCODE_ADD      => 'add',
				OPCODE_SUBTRACT => 'subtract',
				OPCODE_MULTIPLY => 'multiply',
				OPCODE_COMPARE  => 'compare',
				OPCODE_LOAD     => 'load',
				OPCODE_STORE    => 'store',
				OPCODE_JUMP     => 'jump',
				OPCODE_CHAR     => 'char',
				'push'          => 'push'
			);
		}
	}