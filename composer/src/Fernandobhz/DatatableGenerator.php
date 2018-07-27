<?php
namespace Fernandobhz;

Class DatatableGenerator {

	public static function test() {
		echo ("hello datatable generator");
	}

	public static function minify($code) { return $code;
		$code = str_replace(["\n", "\t"], "", $code);
		$code = str_replace("  ", " ", $code);

		return $code;
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
			//strip tabs
			$value = str_replace("\t", " ", $value);

			//strip double spaces
			while (strpos($value, "  "))
				$value = str_replace("  ", " ", $value);

			//convert to array
			$value = explode(" ", $value);

			//remove invalid entries
			foreach ( $value as $val )
				if ( $val ) $ret[] = $val;
		}

		return $ret;
	}

	public static function code($opts) {
		//requirements
		if ( ! $opts['rows'] && ! $opts['server-side'] ) self::kill("opts['row'] is required when opts['server-side'||'ss'] not defined" . var_export($opts, true) );
		if ( ! $opts['cols'] ) self::kill("opts['col'] is required" . var_export($opts, true) );
		if ( $opts['id'] && $opts['attrs']['id'] ) self::kill("both opts['id'] and opts['attrs']['id'] defined");


		//computed
		$opts['rand'] = mt_rand(1, 10000000);


		//default if not set [optional]
		if ( ! isset($opts['class']) ) $opts['class'] = [];
		if ( ! is_array($opts['class']) ) $opts['class'] = self::forceArray($opts['class']);
		if ( ! isset($opts['new']) ) $opts['new'] = false;
		if ( ! isset($opts['export']) ) $opts['export'] = true;
		if ( ! isset($opts['search']) ) $opts['search'] = true;
		if ( ! isset($opts['paging']) ) $opts['search'] = true;
		if ( ! isset($opts['ordering']) ) $opts['ordering'] = true;
		if ( ! isset($opts['attrs']) ) $opts['attrs'] = [];
		if ( ! isset($opts['name']) ) $opts['name'] = "Registro";
		if ( ! isset($opts['action']) ) $opts['action'] = "add";


		//default if invalid value
		if ( ! $opts['action'] ) $opts['action'] = "add";


		//laydown optional attributes
		if ( $opts['id'] ) $opts['attrs']['id'] = $opts['id'];
		if ( $opts['server-side'] ) $opts['attrs']['data-dtgen-server-side'] = $opts['server-side'];
		if ( $opts['new'] ) $opts['attrs']['data-dtgen-new'] = $opts['new'];
		if ( $opts['export'] ) $opts['attrs']['data-dtgen-export'] = $opts['export'];
		if ( $opts['search'] ) $opts['attrs']['data-dtgen-search'] = $opts['search'];
		if ( $opts['paging'] ) $opts['attrs']['data-dtgen-paging'] = $opts['paging'];
		if ( $opts['ordering'] ) $opts['attrs']['data-dtgen-ordering'] = $opts['ordering'];


		//laydown required attributes
		$opts['attrs']['data-dtgen-rand'] = $opts['rand'];
		$opts['attrs']['data-dtgen-name'] = $opts['name'];
		$opts['attrs']['data-dtgen-action'] = $opts['action'];
		$opts['attrs']['data-dtgen-columns-name'] = base64_encode(json_encode($opts['cols']));


		//classes
		$opts['class'][] = 'dtgen';
		$opts['class'][] = 'dtgen-' . $opts['rand'];
		$opts['class'][] = 'table';
		$opts['class'][] = 'table-stripped';
		$opts['class'][] = 'table-bordered';

		//row casting to assoc array
		if ( $opts['rows'] )
			foreach ( $opts['rows'] as $index => $row )
				$opts['rows'][$index] = (array)$row;


		//values array building
		$values = [];
		if ( $opts['rows'] )
			foreach ( $rows as $row )
				$values[] = array_values($row);


		//classes list
		$opts['classes'] = implode(" ", $opts['class']);


		//attributes list
		$opts['attributes'] = "";
		foreach( $opts['attrs'] as $key => $value ) {
			$opts['attributes']
				= $opts['attributes']
				. $key
				. '="'
				. $value
				. '" '
			;
		}
		
		
		//debug
		//echo "</template><pre>"; var_dump($opts); die();
		
		
		//generating codes
		ob_start(); include('StyleCode.php'); $style = self::minify(ob_get_clean());
		ob_start(); include('ScriptCode.php'); $script = self::minify(ob_get_clean());
		ob_start(); include('TableCode.php'); $body = self::minify(ob_get_clean());


		//return codes
		return (object) [
			'body' => "$body\n",
			'style' => "$style\n",
			'script' => "$script\n",
			'head' => "$style $script\n"
		];
	}
}
?>