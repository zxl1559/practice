<?php

namespace frontend\controllers;

class ApiController extends BaseController
{
    /**
     * 平台首页-总任务数.
     *
     * @return string
     */
    public function actionActivityCount()
    {
        $data = [];
        //总任务数
        $sql = <<<SQL
        SELECT
            count(*) AS total_count
        FROM
            ce_activity
        SQL;
        $data['total'] = Yii::$app->db->createCommand($sql)->queryScalar();
    }
}
