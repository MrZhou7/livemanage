<?php
namespace app\model;

class Interview extends BaseModel
{

    public function addInfo($data)
    {
        return $this->baseSaveInfo($data);
    }
}