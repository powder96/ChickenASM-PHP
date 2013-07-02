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

	require_once('ChickenLanguage.php');
	
	define('EXAMPLES_DIR', __DIR__ . '/examples');	
	
	echo '<pre>';
	
	$chickenASMFiles = glob(EXAMPLES_DIR . '/*.cha');
	foreach($chickenASMFiles as $chickenASMFile) {
		echo $chickenASMFile . "\n";
		
		try {
			$chickenCodeFile = EXAMPLES_DIR . '/' . pathinfo($chickenASMFile, PATHINFO_FILENAME) . '.chn';
		
			$chickenASMCode = file_get_contents($chickenASMFile);
			if($chickenASMCode === false)
				throw new \RuntimeException('Cannot open the file');
			
			$chickenCode = ChickenLanguage\convertChickenASMCodeToChickenCode($chickenASMCode);
			file_put_contents($chickenCodeFile, $chickenCode);
		}
		
		catch(\RuntimeException $e) {
			echo ' * ' . $e->getMessage() . "\n";
		}
	}
	
	echo '</pre>';