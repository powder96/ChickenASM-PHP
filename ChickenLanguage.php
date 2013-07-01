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
	
	namespace ChickenLanguage;
	
	define('ChickenLanguage\\TOKEN_EXIT'     , 0);
	define('ChickenLanguage\\TOKEN_CHICKEN'  , 1);
	define('ChickenLanguage\\TOKEN_ADD'      , 2);
	define('ChickenLanguage\\TOKEN_SUBTRACT' , 3);
	define('ChickenLanguage\\TOKEN_MULTIPLY' , 4);
	define('ChickenLanguage\\TOKEN_COMPARE'  , 5);
	define('ChickenLanguage\\TOKEN_LOAD'     , 6);
	define('ChickenLanguage\\TOKEN_STORE'    , 7);
	define('ChickenLanguage\\TOKEN_JUMP'     , 8);
	define('ChickenLanguage\\TOKEN_CHAR'     , 9);
	define('ChickenLanguage\\TOKEN_PUSH'     , 10);
	define('ChickenLanguage\\TOKEN_COMMENT'  , 11);
	
	/**
	 * Converts the ChickenASM code into the Chicken code.
	 *
	 * @param string $code
	 * @return string
	 */
	function convertChickenASMCodeToChickenCode($code) {
		$tokens = tokenizeChickenASMCode($code);
		return makeChickenCode($tokens);
	}
	
	/**
	 * Converts the Chicken code into the ChickenASM code.
	 *
	 * @param string $code
	 * @return string
	 */
	function convertChickenCodeToChickenASMCode($code) {
		$tokens = tokenizeChickenCode($code);
		return makeChickenASMCode($tokens);
	}
	
	/**
	 * Parses the ChickenASM code into tokens.
	 *
	 * @param string $code
	 * @return array
	 */
	function tokenizeChickenASMCode($code) {
		$tokens = array();
		$lines = explode("\n", $code);
		$currentLine = 0;
		foreach($lines as $line) {
			++$currentLine;
			$command = trim($line);
			switch($command) {
				case 'exit';
					$tokens[] = array(TOKEN_EXIT);
					break;
				case 'chicken':
					$tokens[] = array(TOKEN_CHICKEN);
					break;
				case 'add':
					$tokens[] = array(TOKEN_ADD);
					break;
				case 'subtract':
					$tokens[] = array(TOKEN_SUBTRACT);
					break;
				case 'multiply':
					$tokens[] = array(TOKEN_MULTIPLY);
					break;
				case 'divide': // #4.5
					throw new \RuntimeException('Division is not supported by the language specification (line ' .
							$currentLine . ')');
					break;
				case 'compare':
					$tokens[] = array(TOKEN_COMPARE);
					break;
				case 'load':
					$tokens[] = array(TOKEN_LOAD);
					break;
				case 'store':
					$tokens[] = array(TOKEN_STORE);
					break;
				case 'jump':
					$tokens[] = array(TOKEN_JUMP);
					break;
				case 'char':
					$tokens[] = array(TOKEN_CHAR);
					break;
				default:
					if($command[0] === '#')
						$tokens[] = array(TOKEN_COMMENT, substr($command, 1));
					elseif(substr($command, 0, strlen('push')) === 'push')
						$tokens[] = array(TOKEN_PUSH, (int)substr($command, strlen('push')));
					elseif(!empty($command))
						throw new \RuntimeException("Unknown command \"{$command}\" (line {$currentLine})");
					
					break;
			}
		}
		return $tokens;
	}
	
	/**
	 * Builds the ChickenASM code from tokens.
	 *
	 * @param array $tokens
	 * @return string
	 */
	function makeChickenASMCode($tokens) {
		$code = '';
		foreach($tokens as $token) {
			switch($token[0]) {
				case TOKEN_EXIT;
					$command = 'exit';
					break;
				case TOKEN_CHICKEN:
					$command = 'chicken';
					break;
				case TOKEN_ADD:
					$command = 'add';
					break;
				case TOKEN_SUBTRACT:
					$command = 'subtract';
					break;
				case TOKEN_MULTIPLY:
					$command = 'multiply';
					break;
				case TOKEN_COMPARE:
					$command = 'compare';
					break;
				case TOKEN_LOAD:
					$command = 'load';
					break;
				case TOKEN_STORE:
					$command = 'store';
					break;
				case TOKEN_JUMP:
					$command = 'jump';
					break;
				case TOKEN_CHAR:
					$command = 'char';
					break;
				case TOKEN_PUSH:
					$command = 'push ' . $token[1];
					break;
				case TOKEN_COMMENT:
					$command = '#' . $token[1];
					break;
				default:
					throw new \RuntimeException("Unsupported token \"{$token[0]}\"");
			}
			$code .= $command . "\n";
		}
		return $code;
	}
	
	/**
	 * Parses the Chicken code into tokens.
	 *
	 * @param string $code
	 * @return array
	 */
	function tokenizeChickenCode($code) {
		$tokens = array();
		$lines = explode("\n", $code);
		foreach($lines as $line) {
			$instruction = substr_count($line, 'chicken');
			switch($instruction) {
				case TOKEN_EXIT:
					$tokens[] = array(TOKEN_EXIT);
					break;
				case TOKEN_CHICKEN:
					$tokens[] = array(TOKEN_CHICKEN);
					break;
				case TOKEN_ADD:
					$tokens[] = array(TOKEN_ADD);
					break;
				case TOKEN_SUBTRACT:
					$tokens[] = array(TOKEN_SUBTRACT);
					break;
				case TOKEN_MULTIPLY:
					$tokens[] = array(TOKEN_MULTIPLY);
					break;
				case TOKEN_COMPARE:
					$tokens[] = array(TOKEN_COMPARE);
					break;
				case TOKEN_LOAD:
					$tokens[] = array(TOKEN_LOAD);
					break;
				case TOKEN_STORE:
					$tokens[] = array(TOKEN_STORE);
					break;
				case TOKEN_JUMP:
					$tokens[] = array(TOKEN_JUMP);
					break;
				case TOKEN_CHAR:
					$tokens[] = array(TOKEN_CHAR);
					break;
				default:
					$tokens[] = array(TOKEN_PUSH, $instruction - 10);
					break;
			}
		}
		return $tokens;
	}
	
	/**
	 * Builds the Chicken code from tokens.
	 *
	 * @param array $tokens
	 * @return string
	 */
	function makeChickenCode($tokens) {
		$code = '';
		foreach($tokens as $token) {
			if($token[0] >= TOKEN_EXIT && $token[0] <= TOKEN_CHAR)
				$instruction = $token[0];
			elseif($token[0] === TOKEN_PUSH)
				$instruction = $token[1] + 10;
			elseif($token[0] === TOKEN_COMMENT)
				continue;
			else
				throw new \RuntimeException('Unsupported token "' . $token[0] . '"');
			$code .= "\n" . substr(str_repeat(' chicken', $instruction), 1);
		}
		return substr($code, 1);
	}