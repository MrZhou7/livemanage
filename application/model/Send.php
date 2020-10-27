<?php
namespace app\model;

class Send extends BaseModel
{

    public function addInfo($data)
    {
        return $this->baseSaveInfo($data);
    }
}