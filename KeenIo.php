<?php
namespace br0sk\keenio;

use yii\base\Component;
use KeenIO\Client\KeenIOClient;

class KeenIo extends Component
{
	public $projectId = '';
	public $writeKey = '';
	public $readKey = '';
	public $masterKey = null;
	public $version = null;
    private $_keenio = null;


	public function init()
	{
		if (!$this->projectId) {
			throw new InvalidConfigException('ProjectId cannot be empty!');
		}
		if (!$this->writeKey) {
			throw new InvalidConfigException('WriteKey cannot be empty!');
		}
		if (!$this->readKey) {
			throw new InvalidConfigException('Readkey cannot be empty!');
		}
	}

	public function getKeenio()
	{
		if ($this->_keenio === null) {
			$this->_keenio = KeenIOClient::factory([
				'projectId' => $this->projectId,
				'writeKey'  => $this->writeKey,
				'readKey'   => $this->readKey,
			]);
		}
		return $this->_keenio;
	}
	
	public function __call($method, $params)
	{
		$client = $this->getKeenio();
		if (method_exists($client, $method))
			return call_user_func_array(array($client, $method), $params);
		return parent::__call($method, $params);
	}
}

