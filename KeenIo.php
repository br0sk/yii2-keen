<?php
namespace br0sk\keen;

use yii\base\Component;
use KeenIO\Client\KeenIOClient;

/**
 * This comopnent let's you use keen.io in yii2.
 * 
 * note:
 */ 
class KeenIo extends Component
{
    private $_keenio = null;
    private $_projectId = null;
    private $_readKey = null;
    private $_writeKey = null;
    private $_masterKey = null;
    private $_version = null;

    public function init()
    {
        parent::init();
        if (!$this->_projectId) {
            throw new InvalidConfigException('ProjectId cannot be empty!');
        }
        if (!$this->_writeKey) {
            throw new InvalidConfigException('WriteKey cannot be empty!');
        }
        if (!$this->_readKey) {
            throw new InvalidConfigException('Readkey cannot be empty!');
        }
        //Create a new Keen object if it hasn't already been created
        if ($this->_keenio === null) {
            $configArray = [
                'projectId' => $this->_projectId,
                'masterKey' => $this->_masterKey,
                'writeKey'  => $this->_writeKey,
                'readKey'   => $this->_readKey,
            ];
            //Only add the version if it is properly set, if not use the version the 
            //PHP SDK choses
            if($this->_version !== null) {
                $configArray['version'] = $this->_version;
            }
            $this->_keenio = KeenIOClient::factory($configArray);
        }
    }

    
    public function setReadKey($value) {
        if($this->_keenio !== null) {
            $this->_keenio->setReadKey($value);
        }
        $this->_readKey = $value;
    }
    
    public function getReadKey() {
        return $this->_readKey;
    }
    
    public function setWriteKey($value) {
        if($this->_keenio !== null) {
            $this->_keenio->setWriteKey($value);
        }
        $this->_writeKey = $value;
    }

    public function getWriteKey() {
        return $this->_writeKey;
    }
    
    public function setMasterKey($value) {
        if($this->_keenio !== null) {
            $this->_keenio->setMasterKey($value);
        }
        $this->_masterKey = $value;
    }

    public function getMasterKey() {
        return $this->_masterKey;
    }

    public function setVersion($value) {
        if($this->_keenio !== null) {
            $this->_keenio->setVersion($value);
        }
        $this->_version = $value;
    }
    public function getVersion() {
        return $this->_version;
    }
    
    public function setProjectId($value) {
        if($this->_keenio !== null) {
            $this->_keenio->setProjectId($value);
        }
        $this->_projectId = $value;
    }
    public function getProjectId() {
        return $this->_projectId;
    }
    
    /**
     * Proxy the calls to the Keen object if the methods doesn't explixitly exist in this class.
     * See the getters and setters above for methods that shall work directly on this component
     * rather than on the Keen Object. 
     * 
     * If the method called is not found in the Keen Object continue with standard Yii behaviour
     */ 
    public function __call($method, $params)
    {
        //Override the normal Yii functionality checking the Keen SDK for a matching method
        if (method_exists($this->_keenio, $method)) {
            return call_user_func_array(array($this->_keenio, $method), $params);
        }
        
        //Use standard Yii functionality, checking behaviours
        return parent::__call($method, $params);
    }
}
