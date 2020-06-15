<?php

if (!function_exists('env')) {
	/**
	 * Get a value from the environment.
	 *
	 * @param string $label
	 * @param mixed $default
	 * @param boolean $localOnly
	 *
	 * @return mixed
	 */
	function env(string $label, $default = null, bool $localOnly = false)
	{
		$value = getenv($label, $localOnly);

		if ($value === false) {
			return $default;
		}

		$trValue = trim($value);
		$lcValue = strtolower(trim($value));

		if ($lcValue == 'null' || strlen($lcValue) === 0) {
			return null;
		}
		if (filter_var($trValue, FILTER_VALIDATE_INT) !== false) {
			return intval($trValue);
		}
		if (filter_var($trValue, FILTER_VALIDATE_FLOAT) !== false) {
			return floatval($trValue);
		}
		if (!is_null(filter_var($trValue, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE))) {
			return boolval($trValue);
		}
		return $trValue;
	}
}
