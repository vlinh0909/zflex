<?php

namespace DoctrineORMModule\Proxy\__CG__\ZFlex\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Customer extends \ZFlex\Entity\Customer implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = array();



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return array('__isInitialized__', 'id', 'fb_id', 'fb_name', 'money', 'open_shop', 'is_block', 'time_created', 'shop', 'banned', 'rent', 'history_rent', 'history_rent_boss', 'report_rent', 'comment_shop', 'report_shop', 'withdraw');
        }

        return array('__isInitialized__', 'id', 'fb_id', 'fb_name', 'money', 'open_shop', 'is_block', 'time_created', 'shop', 'banned', 'rent', 'history_rent', 'history_rent_boss', 'report_rent', 'comment_shop', 'report_shop', 'withdraw');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Customer $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', array());
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', array());
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function setId($id)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setId', array($id));

        return parent::setId($id);
    }

    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', array());

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function setMoney($money)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMoney', array($money));

        return parent::setMoney($money);
    }

    /**
     * {@inheritDoc}
     */
    public function getMoney()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMoney', array());

        return parent::getMoney();
    }

    /**
     * {@inheritDoc}
     */
    public function setFbId($fb_id)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFbId', array($fb_id));

        return parent::setFbId($fb_id);
    }

    /**
     * {@inheritDoc}
     */
    public function getFbId()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFbId', array());

        return parent::getFbId();
    }

    /**
     * {@inheritDoc}
     */
    public function setFbName($fb_name)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFbName', array($fb_name));

        return parent::setFbName($fb_name);
    }

    /**
     * {@inheritDoc}
     */
    public function getFbName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFbName', array());

        return parent::getFbName();
    }

    /**
     * {@inheritDoc}
     */
    public function setOpenShop($open_shop)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setOpenShop', array($open_shop));

        return parent::setOpenShop($open_shop);
    }

    /**
     * {@inheritDoc}
     */
    public function getOpenShop()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getOpenShop', array());

        return parent::getOpenShop();
    }

    /**
     * {@inheritDoc}
     */
    public function setTimeCreated($time_created)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTimeCreated', array($time_created));

        return parent::setTimeCreated($time_created);
    }

    /**
     * {@inheritDoc}
     */
    public function getTimeCreated()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTimeCreated', array());

        return parent::getTimeCreated();
    }

    /**
     * {@inheritDoc}
     */
    public function setShop($shop)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setShop', array($shop));

        return parent::setShop($shop);
    }

    /**
     * {@inheritDoc}
     */
    public function getShop()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getShop', array());

        return parent::getShop();
    }

    /**
     * {@inheritDoc}
     */
    public function setIsBlock($is_block)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIsBlock', array($is_block));

        return parent::setIsBlock($is_block);
    }

    /**
     * {@inheritDoc}
     */
    public function getIsBlock()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIsBlock', array());

        return parent::getIsBlock();
    }

    /**
     * {@inheritDoc}
     */
    public function setBanned($banned)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setBanned', array($banned));

        return parent::setBanned($banned);
    }

    /**
     * {@inheritDoc}
     */
    public function getBanned()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBanned', array());

        return parent::getBanned();
    }

    /**
     * {@inheritDoc}
     */
    public function setRent($rent)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setRent', array($rent));

        return parent::setRent($rent);
    }

    /**
     * {@inheritDoc}
     */
    public function getRent()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRent', array());

        return parent::getRent();
    }

    /**
     * {@inheritDoc}
     */
    public function setHistoryRent($history_rent)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setHistoryRent', array($history_rent));

        return parent::setHistoryRent($history_rent);
    }

    /**
     * {@inheritDoc}
     */
    public function getHistoryRent()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getHistoryRent', array());

        return parent::getHistoryRent();
    }

    /**
     * {@inheritDoc}
     */
    public function setHistoryRentBoss($history_rent_boss)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setHistoryRentBoss', array($history_rent_boss));

        return parent::setHistoryRentBoss($history_rent_boss);
    }

    /**
     * {@inheritDoc}
     */
    public function getHistoryRentBoss()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getHistoryRentBoss', array());

        return parent::getHistoryRentBoss();
    }

    /**
     * {@inheritDoc}
     */
    public function setReportRent($report_rent)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setReportRent', array($report_rent));

        return parent::setReportRent($report_rent);
    }

    /**
     * {@inheritDoc}
     */
    public function getReportRent()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getReportRent', array());

        return parent::getReportRent();
    }

    /**
     * {@inheritDoc}
     */
    public function setCommentShop($comment_shop)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCommentShop', array($comment_shop));

        return parent::setCommentShop($comment_shop);
    }

    /**
     * {@inheritDoc}
     */
    public function getCommentShop()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCommentShop', array());

        return parent::getCommentShop();
    }

    /**
     * {@inheritDoc}
     */
    public function setReportShop($report_shop)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setReportShop', array($report_shop));

        return parent::setReportShop($report_shop);
    }

    /**
     * {@inheritDoc}
     */
    public function getReportShop()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getReportShop', array());

        return parent::getReportShop();
    }

}
