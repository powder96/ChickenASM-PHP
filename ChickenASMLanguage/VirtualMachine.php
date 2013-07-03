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
	
	define('ChickenASMLanguage\\OPCODE_EXIT'     , 0);
	define('ChickenASMLanguage\\OPCODE_CHICKEN'  , 1);
	define('ChickenASMLanguage\\OPCODE_ADD'      , 2);
	define('ChickenASMLanguage\\OPCODE_SUBTRACT' , 3);
	define('ChickenASMLanguage\\OPCODE_MULTIPLY' , 4);
	define('ChickenASMLanguage\\OPCODE_COMPARE'  , 5);
	define('ChickenASMLanguage\\OPCODE_LOAD'     , 6);
	define('ChickenASMLanguage\\OPCODE_STORE'    , 7);
	define('ChickenASMLanguage\\OPCODE_JUMP'     , 8);
	define('ChickenASMLanguage\\OPCODE_CHAR'     , 9);
	
	final class VirtualMachineException extends \RuntimeException {}
	
	final class VirtualMachine {
		private $stack;
		private $programCounter;
		private $executedOpcodes;
		private $executedOpcodesLimit;
		private $executionLog;
		
		public function getExecutionLog() {
			return $this->executionLog;
		}
		
		public function setExecutedOpcodesLimit($limit) {
			$this->executedOpcodesLimit = $limit;
		}
		
		public function __construct($opcodes, $input = '') {
			$this->stack = array();

			array_push($this->stack, &$this->stack);
			array_push($this->stack, $input);

			foreach($opcodes as $opcode)
				array_push($this->stack, $opcode);

			array_push($this->stack, null);
			
			$this->programCounter = 2;
			
			$this->executedOpcodes = 0;
			$this->setExecutedOpcodesLimit(30000);
			
			$this->executionLog = '';
		}
		
		public function execute() {
			while($this->programCounter < count($this->stack)) {
				if($this->executedOpcodes++ > $this->executedOpcodesLimit)
					throw new VirtualMachineException('Maximum number of executed opcodes is exceeded');
				
				$opcode = $this->stack[$this->programCounter];
				
				switch($opcode) {
					case OPCODE_EXIT:
						$this->executionLog .= "EXIT\n";
						break 2;
					
					case OPCODE_CHICKEN:
						array_push($this->stack, 'chicken');
						$this->executionLog .= "PUSH \"chicken\"\n";
						break;
					
					case OPCODE_ADD:
						$a = array_pop($this->stack);
						$b = array_pop($this->stack);
						if(is_int($a) && is_int($b))
							array_push($this->stack, $b + $a);
						else {
							$a = self::valueToStringJavaScript($a);
							$b = self::valueToStringJavaScript($b);
							array_push($this->stack, $b . $a);
						}
						$this->executionLog .= "ADD {$b} + {$a}\n";
						break;
					
					case OPCODE_SUBTRACT:
						$a = array_pop($this->stack);
						$b = array_pop($this->stack);
						array_push($this->stack, $b - $a);
						$this->executionLog .= "SUBTRACT {$b} - {$a}\n";
						break;
					
					case OPCODE_MULTIPLY:
						$a = array_pop($this->stack);
						$b = array_pop($this->stack);
						array_push($this->stack, $a * $b);
						$this->executionLog .= "MULTIPLY {$a} * {$b}\n";
						break;
					
					case OPCODE_COMPARE:
						$a = array_pop($this->stack);
						$b = array_pop($this->stack);
						array_push($this->stack, $a == $b);
						$this->executionLog .= "COMPARE {$a} ?= {$b}\n";
						break;
					
					case OPCODE_LOAD:
						$address = array_pop($this->stack);
						$source = $this->stack[++$this->programCounter];
						if(!isset($this->stack[$source][$address]))
							array_push($this->stack, null);
						else
							array_push($this->stack, $this->stack[$source][$address]);
						$this->executionLog .= "LOAD {$source}/{$address}\n";
						break;
					
					case OPCODE_STORE:
						$address = array_pop($this->stack);
						$value = array_pop($this->stack);
						$this->stack[$address] = $value;
						$this->executionLog .= "STORE {$value} AT {$address}\n";
						break;
					
					case OPCODE_JUMP:
						$offset = array_pop($this->stack);
						$condition = array_pop($this->stack);
						if($condition)
							$this->programCounter += $offset;
						$this->executionLog .= "JUMP IF {$condition} TO {$offset}\n";
						break;
					
					case OPCODE_CHAR:
						$value = array_pop($this->stack);
						array_push($this->stack, '&#' . $value . ';');
						$this->executionLog .= "CHAR {$value}\n";
						break;
					
					default: // push n
						$value = $opcode - 10;
						array_push($this->stack, $value);
						$this->executionLog .= "PUSH {$value}\n";
						break;
				}
				
				++$this->programCounter;
			}
			
			$output = end($this->stack);
			
			$this->executionLog .= "Executed {$this->executedOpcodes} opcodes. Output: {$output}\n";
			
			return $output;
		}
		
		private static function valueToStringJavaScript($value) {
			switch(gettype($value)) {
				case 'boolean':
					return $value ? 'true' : 'false';
				case 'integer':
				case 'double':
					return (string)$value;
				case 'string':
					return $value;
				case 'array':
					// TODO
					throw new VirtualMachineException('toStringJavaScript(array) is not implemented');
				case 'object':
					// TODO
					throw new VirtualMachineException('toStringJavaScript(object) is not implemented');
				case 'resource':
					// TODO
					throw new VirtualMachineException('toStringJavaScript(resource) is not implemented');
				case 'NULL':
				case 'unknown type':
					return 'undefined';
			}
		}
	}