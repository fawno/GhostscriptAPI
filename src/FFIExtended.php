<?php
  declare(strict_types=1);

	namespace Fawno\GhostscriptAPI;

	use FFI;
	use FFI\CData;

	class FFIExtended {
		public static function argsPtr(array $argv): ?CData {
			$argv = array_values($argv);
			$argc = count($argv);

			if (!$argc) {
				return null;
			}

			$p = FFI::new("char *[$argc]", false);
			foreach ($argv as $i => $arg) {
				$p[$i] = self::strToCharPtr($arg);
			}
			$a = FFI::addr($p);

			return FFI::cast('char**', $a);
		}

		public static function strToCharPtr(string $string): CData {
			$charArr = self::strToCharArr($string);

			return FFI::cast('char*', FFI::addr($charArr));
		}

		public static function strToCharArr(string $string): CData {
			$string = preg_replace('~[\x00]+$~', "\x00", $string . "\x00");
			$len = strlen($string);

			if (!$len) {
				return FFI::new('char', false);
			}

			$charArr = FFI::new("char[$len]", false);

			foreach ($charArr as $i => $char) {
				$charArr[$i]->cdata = $string[$i];
			}


			return $charArr;
		}
	}
