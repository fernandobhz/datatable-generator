<?php
namespace Fernandobhz;

Class DatatableGenerator {

	public static function test() {
		echo ("hello datatable generator");
	}

	public static function minify($code) {
		$code = str_replace(["\n", "\t"], "", $code);
		$code = str_replace("  ", " ", $code);
		
		return $code;
	}
	
	public static function include2string($file) {
		ob_start();
		include($file);
		return ob_get_clean();
	}

	public static function kill($s) {
		echo "</template><pre>";
		var_dump($s);
		echo "</pre>";
		throw new \Exception($s);
		die();
	}

	public static function forceArray(...$values) {
		$ret = [];
		foreach ( $values as $value) {
			if ( $value ) {
				if ( ! is_array($value) ) $ret[] = $value;
				else {
					foreach ( $value as $val ) {
						$ret[] = $val;
					}
				}
			}
		}
		return $ret;
	}

	public static function shortAlias2fullName(&$opts, $short, $long) {
		if ( isset($opts[$short]) ) {
			if ( isset($opts[$long]) ) {
				self::kill(
					"Fernandobhz\DatatableGenerator"
					. " opts cannot have $short and $long"
					. " together "
				);
			} else {
				$opts[$long] = $opts[$short];
				unset($opts[$short]);
			}
		}
	}

	public static function normatize(&$opts) {
		self::shortAlias2fullName($opts, 'ss', 'server-side');
		self::shortAlias2fullName($opts, 'ac', 'action');
		self::shortAlias2fullName($opts, 'nm', 'name');

		if ( ! $opts['rows'] && ! $opts['server-side'] ) self::kill("opts['row'] is required when opts['server-side'||'ss'] not defined" . var_export($opts, true) );
		if ( ! $opts['cols'] ) self::kill("opts['col'] is required" . var_export($opts, true) );

		if ( ! isset($opts['class']) ) $opts['class'] = [];
		if ( ! is_array($opts['class']) ) $opts['class'] = self::forceArray(explode($opts['class'], " "));

		if ( $opts['rows'] ) {
			foreach ( $opts['rows'] as $index => $row ) {
				$opts['rows'][$index] = (array)$row;
			}
		}

		if ( ! isset($opts['attrs']) ) {
			$opts['attrs'] = [];
		}

		if ( ! $opts['rand'] ) $opts['rand'] = mt_rand(1, 10000000);
		if ( ! $opts['name'] ) $opts['name'] = "dt" . $opts['rand'];
		if ( ! $opts['action'] ) $opts['action'] = "add";

		if ( $opts['id'] && $opts['attrs']['id'] ) {
			self::kill("both opts['id'] and opts['attrs']['id'] defined");
		}

		if ( $opts['id'] ) $opts['attrs']['id'] = $opts['id'];

		$opts['cssclass'] = 'dtgen' . $opts['rand'];

		return $opts;
	}

	public static function dtable(...$args) {
		if ( count($args) == 1 ) {
			$opts = $args[0];
			return self::verb2code($args[0], 'data-table');
		} else {
			$row = $args[0]; $cols = $args[1]; $opts = $args[2];
			return self::verb2code($args[0], $args[1], $args[2], 'data-table');
		}
	}

	public static function dlist(...$args) {
		if ( count($args) == 1 ) {
			$opts = $args[0];
			return self::verb2code($args[0], 'data-table-list');
		} else {
			$row = $args[0]; $cols = $args[1]; $opts = $args[2];
			return self::verb2code($rows, $cols, $opts, 'data-table-list');
		}
	}

	public static function dnew($rows, $cols, $opts = []) {
		if ( count($args) == 1 ) {
			$opts = $args[0];
			return self::verb2code($args[0], 'data-table-new');
		} else {
			$row = $args[0]; $cols = $args[1]; $opts = $args[2];
			return self::verb2code($rows, $cols, $opts, 'data-table-new');
		}
	}

	private static function verb2code(...$args) {
		if ( count($args) == 2 ) {
			$opts = $args[0]; $verb = $args[1];
		} else {
			$row = $args[0]; $cols = $args[1]; $opts = $args[2]; $verb = $args[3];

			$opts['rows'] = $rows;
			$opts['cols'] = $cols;
		}
		
		$opts['verb'] = $verb;
		return self::code($opts);
	}

	public static function code($opts) {
		self::normatize($opts);
		$rows = $opts['rows'];
		$cols = $opts['cols'];
		$class = $opts['class'];
		$attrs = $opts['attrs'];
		$name = $opts['name'];
		$action = $opts['action'];
		$cssclass = $opts['cssclass'];
		$verb = $opts['verb'];

		if ( $opts['server-side'] ) {
			$attrs['data-server-side'] = $opts['server-side'];
		}

		$attrs['data-columns-name'] = base64_encode(json_encode($cols));
		$classes = implode(" ", $class);

		$attributes = "";
		foreach( $attrs as $key => $value ) {
			$attributes
				= $attributes
				. $key
				. '="'
				. $value
				. '" '
			;
		}

		$values = [];
		if ( $rows ) {
			foreach ( $rows as $row ) {
				$values[] = array_values($row);
			}
		}

		ob_start(); include('StyleCode.php'); $style = self::minify(ob_get_clean());
		ob_start(); include('ScriptCode.php'); $script = self::minify(ob_get_clean());
		ob_start(); include('TableCode.php'); $body = self::minify(ob_get_clean());
		
		return (object) [
			'body' => "$body\n",
			'style' => "$style\n",
			'script' => "$script\n",
			'head' => "$style $script\n"
		];
	}
}
?>