<?php

class JsonController extends JsonControllerBase
{
    public function getTestValAction()
    {
        $config = $this->getDI()->get('config');
        $values = array(
            'testval' => $config['testval'],
            'testval2' => $config['testval2']
        );
        return $this->respondOkJson($values);
    }
}

