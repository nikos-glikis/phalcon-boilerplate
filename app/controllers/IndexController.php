<?php

class IndexController extends ControllerBase
{
    public function getTestValAction()
    {
        $config = $this->getDI()->get('config');
        $values = array(
            'testval' => $config['testval'],
            'testval2' => $config['testval2']
        );
        $this->view->setVar('values', $values);
    }

    public function exceptionAction()
    {
        throw new \Exception("Something bad happened.");
    }

    public function indexAction()
    {

        $robot = new Persons();

        // Get Phalcon\Mvc\Model\Metadata instance
        $metadata = $robot->getModelsMetaData();

        // Get robots fields names
        $attributes = $metadata->getAttributes($robot);
        $this->view->setVar('attributes', $attributes);


        // Get robots fields data types
        $dataTypes = $metadata->getDataTypes($robot);


        $this->view->setVar('dataTypes', $dataTypes);

    }


}

