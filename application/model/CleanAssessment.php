<?php

namespace app\model;

class CleanAssessment extends BaseModel
{

    public function add($data)
    {

        return $this->addOne($data);

    }

    public function getStatusList($mall_id, $date)
    {
        $field = "*";
        $where = [
            ['mall_id', '=', $mall_id],
            ['date', '=', $date],
            ['enabled', '=', 1],
        ];
        return $this->getList($field, $where);

    }

}
