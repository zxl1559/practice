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

        //一周任务数
        //获取最近一周时间
        $sevenArr = $this->get_recent_date(7);
        $weekMonthSql = <<<SQL
        SELECT
            count(*) AS total
        FROM
            ce_activity
        WHERE
            created_at>=:created_at
        AND
            created_at<=:created_at2
        SQL;
        $thisweekStart = strtotime(date('Y-m-d 00:00:00', strtotime($sevenArr[1]))) * 1000;
        $thisweekEnd = strtotime(date('Y-m-d 23:59:59', strtotime($sevenArr[7]))) * 1000;
        $data['week_total'] = Yii::$app->db->createCommand($weekMonthSql)
                            ->bindValue(':created_at', $thisweekStart)
                            ->bindValue(':created_at2', $thisweekEnd)
                            ->queryScalar();
        //一个月内任务数
        $thirtyArr = $this->get_recent_date(30);
        $thismonthStart = strtotime(date('Y-m-d 00:00:00', strtotime($thirtyArr[1]))) * 1000;
        $thismonthEnd = strtotime(date('Y-m-d 23:59:59', strtotime($thirtyArr[30]))) * 1000;
        $data['month_total'] = Yii::$app->db->createCommand($weekMonthSql)
                            ->bindValue(':created_at', $thismonthStart)
                            ->bindValue(':created_at2', $thismonthEnd)
                            ->queryScalar();

        return $data;
    }

    /*
    * 平台首页-检测任务新增趋势(最近一周).
    *
    * @return string
    */
    public function actionActivityTrend()
    {
    }
}
