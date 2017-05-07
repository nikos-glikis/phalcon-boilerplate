<?php

class Persons extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=true)
     */
    public $PersonID;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    public $LastName;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    public $FirstName;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    public $Address;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    public $City;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'Persons';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Persons[]|Persons
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Persons
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
