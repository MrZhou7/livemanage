<?php

namespace app\model;

class CleanDetail extends BaseModel
{

    public function add($data)
    {
        return $this->baseSaveAll($data);
    }

    public function editEnabled($enabled, $assessment_id)
    {
        $this->baseSaveInfo(['enabled' => $enabled], ['assessment_id' => $assessment_id], 'edit');
        $this->exists(false);
        return;
    }


    public function getGroupByList($assessment_id)
    {
        $map = [
            ['enabled', "=", "1"],
            ['assessment_id', "in", $assessment_id],
        ];
        return $this->field("sum(num) num,type,DATE_FORMAT(create_time,'%Y-%m-%d') date")->where($map)->group("type,date")->select();
    }
}
