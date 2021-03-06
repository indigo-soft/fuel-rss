<?php
/**
 * Fuel RSS package
 *
 * @package    Fuel
 * @subpackage RSS
 * @version    1.0
 * @author     Márk Ság-Kazár <sagikazarmark@gmail.com>
 * @link       https://github.com/sagikazarmark/fuel-rss
 */

namespace RSS;

abstract class RSS_Driver
{
	/**
	 * Driver config
	 */
	protected $config = array();

	/**
	 * Library instance
	 * @var object
	 */
	protected $instance = null;

	/**
	 * Driver constructor
	 *
	 * @param	array	$config		driver config
	 */
	public function __construct(array $config)
	{
		$this->config = $config;
		include_once(realpath(PKGPATH.'/rss/vendor/'.$config['path']));
	}

	/**
	 * Set the max number of items
	 * @param  int|null $limit Max number of items
	 * @return $this
	 */
	public function limit($limit = 0)
	{
		is_int($limit) and $limit > -1 and $this->set_config('limit', $limit);
		return $this;
	}

	/**
	 * Set date format
	 * @param  string|null $date_format Date format, e.g. 'Y-m-d H:i'
	 * @return $this
	 */
	public function date_format($date_format = 'Y-m-d H:i')
	{
		!empty($date_format) and is_string($date_format) and $this->set_config('date_format', $date_format);
		return $this;
	}

	public function get($url)
	{
		$rss = $this->_get($url);
		$rss = $this->_order($rss);

		return $rss;
	}

	/**
	 * Abstract class for RSS feed fownload
	 * @param  string $url URL of RSS feed
	 * @return mixed
	 */
	abstract protected function _get($url);

	/**
	 * Order the resultset
	 * @param mixed $rss The returned result
	 * @return bool
	 */
	abstract protected function _order($rss = null);

	/**
	 * Get a driver config setting.
	 *
	 * @param	string		$key		the config key
	 * @return	mixed					the config setting value
	 */
	public function get_config($key, $default = null)
	{
		return \Arr::get($this->config, $key, $default);
	}

	/**
	 * Set a driver config setting.
	 *
	 * @param	string		$key		the config key
	 * @param	mixed		$value		the new config value
	 * @return	object					$this
	 */
	public function set_config($key, $value)
	{
		\Arr::set($this->config, $key, $value);

		return $this;
	}

}
