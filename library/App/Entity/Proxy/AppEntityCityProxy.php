<?php

namespace App\Entity\Proxy;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ORM. DO NOT EDIT THIS FILE.
 */
class AppEntityCityProxy extends \App\Entity\City implements \Doctrine\ORM\Proxy\Proxy
{
    private $_entityPersister;
    private $_identifier;
    public $__isInitialized__ = false;
    public function __construct($entityPersister, $identifier)
    {
        $this->_entityPersister = $entityPersister;
        $this->_identifier = $identifier;
    }
    private function _load()
    {
        if (!$this->__isInitialized__ && $this->_entityPersister) {
            $this->__isInitialized__ = true;
            if ($this->_entityPersister->load($this->_identifier, $this) === null) {
                throw new \Doctrine\ORM\EntityNotFoundException();
            }
            unset($this->_entityPersister, $this->_identifier);
        }
    }

    
    public function __get($name)
    {
        $this->_load();
        return parent::__get($name);
    }

    public function __set($name, $value)
    {
        $this->_load();
        return parent::__set($name, $value);
    }

    public function toArray()
    {
        $this->_load();
        return parent::toArray();
    }

    public function getId()
    {
        $this->_load();
        return parent::getId();
    }

    public function setId($id)
    {
        $this->_load();
        return parent::setId($id);
    }

    public function getName()
    {
        $this->_load();
        return parent::getName();
    }

    public function setName($name)
    {
        $this->_load();
        return parent::setName($name);
    }

    public function getIsactive()
    {
        $this->_load();
        return parent::getIsactive();
    }

    public function setIsactive($isactive)
    {
        $this->_load();
        return parent::setIsactive($isactive);
    }

    public function getArea()
    {
        $this->_load();
        return parent::getArea();
    }

    public function setArea($data)
    {
        $this->_load();
        return parent::setArea($data);
    }

    public function getDoctors()
    {
        $this->_load();
        return parent::getDoctors();
    }

    public function setDoctors($doctors)
    {
        $this->_load();
        return parent::setDoctors($doctors);
    }

    public function getSupermarkets()
    {
        $this->_load();
        return parent::getSupermarkets();
    }

    public function setSupermarkets($supermarkets)
    {
        $this->_load();
        return parent::setSupermarkets($supermarkets);
    }

    public function getSalons()
    {
        $this->_load();
        return parent::getSalons();
    }

    public function setSalons($salons)
    {
        $this->_load();
        return parent::setSalons($salons);
    }

    public function getPharmacies()
    {
        $this->_load();
        return parent::getPharmacies();
    }

    public function setPharmacies($pharmacies)
    {
        $this->_load();
        return parent::setPharmacies($pharmacies);
    }


    public function __sleep()
    {
        return array('__isInitialized__', 'id', 'name', 'isactive', 'area', 'doctors');
    }
}