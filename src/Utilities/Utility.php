<?php

namespace Bondacom\LaravelFileManager\Utilities;


class Utility
{
    /**
     * @var array
     */
    private $config;

    /**
     * File constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param string|array $data
     * @return mixed|boolean
     */
    public function config($data)
    {
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


        return $this->config[$data] ?? null;
    }
}