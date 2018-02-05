<?php

namespace Bondacom\LaravelFileManager\Utilities;


trait Configurable
{
    /**
     * @var array
     */
    private $config;

    /**
     * @param string|array $data
     * @param null $defaultValue
     * @return bool|mixed
     */
    public function config($data = null, $defaultValue = null)
    {
        if (is_null($data)) {
            return $this->config;
        }

        if (is_array($data)) {
            reset($data);
            $attribute = key($data);
            $value = current($data);

            if (array_key_exists($attribute, $this->config)) {
                $this->config[$attribute] = $value;
                return true;
            }
            return false;
        }


        return $this->config[$data] ?? $defaultValue;
    }

    /**
     * @param array $config
     * @return $this
     */
    public function setConfig(array $config)
    {
        $this->config = $config;

        return $this;
    }
}