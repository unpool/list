<?php

namespace App\Classes;

class ClassResponse {

    private $data = [];

    private $status = true;

    private $type = 'success';

    /**
     * ClassResponse constructor.
     * @param array $data
     */
    public function __construct($data = []) {

        $this->data = array_merge($data, $this->data);
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value) {

        $this->data[$name] = $value;
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function __get($name) {

        if (array_key_exists($name, $this->data)) {

            return $this->data[$name];
        }

        return null;
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name) {

        return isset($this->data[$name]);
    }

    /**
     * @param $name
     */
    public function __unset($name) {

        unset($this->data[$name]);
    }

    /**
     * @param bool $status
     * @return \App\Classes\ClassResponse
     */
    public function setStatus (bool $status) {

        $this->status = $status;
        $this->type = $status ? 'success' : 'error';

        return $this;
    }

    /**
     * @return bool
     */
    public function getStatus() : bool {

        return $this->status;
    }

    /**
     * @param null $messageKey
     * @return string
     */
    public function getType($messageKey = null) : string {

        return $this->type . (is_null($messageKey) ? "" : ".{$messageKey}");
    }
}
