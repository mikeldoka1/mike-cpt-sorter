<?php

/**
 * Autoload classes.
 *
 * @param string $class The fully-qualified class name.
 *
 * @return void
 * @link https://www.php-fig.org/psr/psr-4/
 * @see https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader-examples.md
 */
spl_autoload_register(static function ($class) {

	$prefix = 'Mike\\Src\\';

	$base_dir = __DIR__ . '/src/';

	$len = strlen($prefix);
	if (strncmp($prefix, $class, $len) !== 0) {
		return;
	}

	$relative_class = substr($class, $len);

	$file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

	if (file_exists($file)) {
		require $file;
	}
});
