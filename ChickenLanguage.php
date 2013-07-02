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

	error_reporting(E_ALL);
	
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
	 * Interprets the ChickenASM code.
	 *
	 * @param string $code
	 * @param string input
	 * @return string
	 */
	 function interpretChickenASMCode($code, $input = '') {
		$tokens = tokenizeChickenASMCode($code);
		return interpretTokens($tokens, $input);
	 }
	
	/**
	 * Interprets the Chicken code.
	 *
	 * @param string $code
	 * @param string input
	 * @return string
	 */
	 function interpretChickenCode($code, $input = '') {
		$tokens = tokenizeChickenCode($code);
		return interpretTokens($tokens, $input);
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
					if(empty($command))
						break;
					elseif($command[0] === '#')
						$tokens[] = array(TOKEN_COMMENT, substr($command, 1));
					elseif(substr($command, 0, strlen('push')) === 'push')
						$tokens[] = array(TOKEN_PUSH, (int)substr($command, strlen('push')));
					else
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
			$instructions = substr_count($line, 'chicken');
			$tokens[] = getTokenForNumberOfChickenCodeInstructions($instructions);
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
			$instructions = getNumberOfChickenCodeInstructionsForToken($token);
			if($instructions === false)
				continue;
			$code .= "\n" . substr(str_repeat(' chicken', $instructions), 1);
		}
		return substr($code, 1);
	}
	
	/**
	 * Executes Chicken(ASM) tokens.
	 *
	 * @param array $tokens
	 * @param string $input
	 * @param int $executedTokensLimit
	 * @return string
	 */
	function interpretTokens($tokens, $input = '', $executedTokensLimit = 30000) {
		$stack = array();
		
		array_push($stack, &$stack);
		array_push($stack, $input);
		
		foreach($tokens as $token) {
			$instructions = getNumberOfChickenCodeInstructionsForToken($token);
			if($instructions !== false)
				array_push($stack, $instructions);
		}
		
		array_push($stack, null);
		
		$pToken = 2;
		
		for($executedTokens = 0; $pToken < count($stack); ++$pToken, ++$executedTokens) {
			if($executedTokens > $executedTokensLimit)
				throw new \RuntimeException('Maximum number of executed tokens is exceeded (token #' . $pToken . ')');
			$token = getTokenForNumberOfChickenCodeInstructions($stack[$pToken]);
			switch($token[0]) {
				case TOKEN_EXIT;
					break 2;
				case TOKEN_CHICKEN:
					array_push($stack, 'chicken');
					break;
				case TOKEN_ADD:
					$a = array_pop($stack);
					$b = array_pop($stack);
					$typeA = gettype($a);
					$typeB = gettype($b);
					if($typeA === 'integer' && $typeA === $typeB)
						array_push($stack, $b + $a);
					else
						array_push($stack, toStringJavaScript($b) . toStringJavaScript($a));
					break;
				case TOKEN_SUBTRACT:
					$a = array_pop($stack);
					$b = array_pop($stack);
					array_push($stack, $b - $a);
					break;
				case TOKEN_MULTIPLY:
					$a = array_pop($stack);
					$b = array_pop($stack);
					array_push($stack, $a * $b);
					break;
				case TOKEN_COMPARE:
					$a = array_pop($stack);
					$b = array_pop($stack);
					array_push($stack, $a == $b);
					break;
				case TOKEN_LOAD:
					$address = array_pop($stack);
					$source = $stack[++$pToken];
					if(!isset($stack[$source][$address]))
						array_push($stack, null);
					else
						array_push($stack, $stack[$source][$address]);
					break;
				case TOKEN_STORE:
					$address = array_pop($stack);
					$value = array_pop($stack);
					$stack[$address] = $value;
					break;
				case TOKEN_JUMP:
					$offset = array_pop($stack);
					$condition = array_pop($stack);
					if($condition)
						$pToken += $offset;
					break;
				case TOKEN_CHAR:
					array_push($stack, '&#' . (array_pop($stack)) . ';');
					break;
				case TOKEN_PUSH:
					array_push($stack, $token[1]);
					break;
				default:
					throw new \RuntimeException("Unsupported token \"{$token[0]}\"");
			}
		}
		
		return end($stack);
	}
	
	/**
	 * Converts variable into a string.
	 *
	 * @param mixed $value
	 * @return string
	 */
	function toStringJavaScript($value) {
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
				throw new \Exception('toStringJavaScript(array) is not implemented');
			case 'object':
				// TODO
				throw new \Exception('toStringJavaScript(object) is not implemented');
			case 'resource':
				// TODO
				throw new \Exception('toStringJavaScript(resource) is not implemented');
			case 'NULL':
			case 'unknown type':
				return 'undefined';
		}
	}
	
	/**
	 * Returns the number of Chicken code instructions, needed to represent a token. Returns false if token should not
	 * be included in the Chicken code.
	 *
	 * @param array $token
	 * @return boolean|integer
	 */
	function getNumberOfChickenCodeInstructionsForToken($token) {
		if($token[0] >= TOKEN_EXIT && $token[0] <= TOKEN_CHAR)
			return $token[0];
		elseif($token[0] === TOKEN_PUSH)
			return $token[1] + 10;
		elseif($token[0] === TOKEN_COMMENT)
			return false;
		else
			throw new \RuntimeException("Unsupported token \"{$token[0]}\"");
	}
	
	/**
	 * Returns the token, represented by a number of Chicken code instructions.
	 *
	 * @param int $instructions
	 * @return array
	 */
	function getTokenForNumberOfChickenCodeInstructions($instructions) {
		switch($instructions) {
			case TOKEN_EXIT:
				return array(TOKEN_EXIT);
				break;
			case TOKEN_CHICKEN:
				return array(TOKEN_CHICKEN);
				break;
			case TOKEN_ADD:
				return array(TOKEN_ADD);
				break;
			case TOKEN_SUBTRACT:
				return array(TOKEN_SUBTRACT);
				break;
			case TOKEN_MULTIPLY:
				return array(TOKEN_MULTIPLY);
				break;
			case TOKEN_COMPARE:
				return array(TOKEN_COMPARE);
				break;
			case TOKEN_LOAD:
				return array(TOKEN_LOAD);
				break;
			case TOKEN_STORE:
				return array(TOKEN_STORE);
				break;
			case TOKEN_JUMP:
				return array(TOKEN_JUMP);
				break;
			case TOKEN_CHAR:
				return array(TOKEN_CHAR);
				break;
			default:
				return array(TOKEN_PUSH, $instructions - 10);
				break;
		}
	}