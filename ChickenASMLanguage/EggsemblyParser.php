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
	
	final class EggsemblyParser extends ChickenASMParser {
		protected function defineInstructions() {
			$this->instructions = array(
				OPCODE_EXIT     => 'axe',
				OPCODE_CHICKEN  => 'chicken',
				OPCODE_ADD      => 'add',
				OPCODE_SUBTRACT => 'fox',
				OPCODE_MULTIPLY => 'rooster',
				OPCODE_COMPARE  => 'compare',
				OPCODE_LOAD     => 'pick',
				OPCODE_STORE    => 'peck',
				OPCODE_JUMP     => 'fr',
				OPCODE_CHAR     => 'bbq',
				'push'          => 'push',
				'comment'       => '#'
			);
		}
	}