<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use Carbon\Carbon;


/**
 * JobSearch represents the model behind the search form about `app\models\Job`.
 */
class MoneySearch extends Money
{

    public $status = '';
    public $yandex_summ = 0;
    public $card_summ = 0;
    public $bso_summ = 0;
    public $cash_summ = 0;
    public $bank_summ = 0;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules = $rules + [ [['status'], 'string', 'max' => 20], ];
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return Model::scenarios();
    }
/*
    public function getAllExtId(){
        return $this->find()->all();
    }
*/
    /**
     * @param array $params
     * @return Money[]
     */
    public function search($params)
    {
        $this->load($params);
        $query = Money::find();

        $query->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['=', 'total_amount', $this->total_amount])
            ->andFilterWhere(['=', 'first_payment_amount', $this->first_payment_amount])
            ->andFilterWhere(['=', 'second_payment_amount', $this->second_payment_amount])
            ->andFilterWhere(['like', 'comment_fin', $this->comment_fin])
            ->andFilterWhere(['like', 'goods_bill_comment', $this->goods_bill_comment])
            ->andFilterWhere(['like', 'collection', $this->collection])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['=', 'count', $this->count])
            ->andFilterWhere(['=', 'goods_bill_num', $this->goods_bill_num]);

        // status
        if (!empty($_GET['MoneySearch']['status'])) {
            $query->andFilterWhere(['in', 'lead_status', $_GET['MoneySearch']['status']]);
        }
        // client name or ext_id in one field
        if (!empty($_GET['MoneySearch']['client_name'])) {
            $query->andWhere(['or', ['like', 'client_name', $this->client_name], ['=', 'ext_id', $this->client_name]]);
        }
        if (!empty($this->status)) {
            $query->with([
                'status' => [
                    'condition' => ['like', 'status.label', $this->status]
                ]
            ]);
        }

        // dates (@see http://carbon.nesbot.com/docs/)
        foreach (['first_payment_date', 'second_payment_date', 'goods_bill_date', 'deadline', 'finished_at'/*, 'created_at'*/] as $column) {
            if (empty($this->{$column})) continue;
            $date = explode('-', $this->{$column});
            $dateFrom = Carbon::createFromFormat('d.m.Y H:i:s', $date[0] . '00:00:00');
            $dateTo = isset($date[1]) ?
                Carbon::createFromFormat('d.m.Y H:i:s', $date[1] . ' 23:59:59') :
                Carbon::createFromFormat('d.m.Y H:i:s', $date[0] . ' 23:59:59');
            $query->andFilterWhere(['>=', $column, $dateFrom->getTimestamp()]);
            $query->andFilterWhere(['<=', $column, $dateTo->getTimestamp()]);
        }

        // TODO special fields
        // public $yandex_summ = 0;
        // public $card_summ = 0;
        // public $bso_summ = 0;
        // public $cash_summ = 0;
        // public $bank_summ = 0;

        // by default use current month
        $days = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
        $fromDate = strtotime(date('Y-m-01 00:00:00'));
        $toDate = strtotime(date('Y-m-' . $days . ' 23:59:59'));
        if (!empty($params['date_period']) && strcmp($params['date_period'], "year") == 0) {
            $period = date('Y-m-d', strtotime(date('Y-m-d')." -1 year"));
            $days = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
            $fromDate = strtotime(date(date('Y-m-d', strtotime(date('Y-m-d')." -1 year")).' 00:00:00'));
            $toDate = strtotime(date(date('Y-m-d').' 00:00:00'));
        } else if (!empty($params['date_period'])) {
            $period = explode('-', $params['date_period']);
            $month = substr('0' . $period[0], -2, 2);
            $year = $period[1];
            $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $fromDate = strtotime($year . '-' . $month . '-01 00:00:00');
            $toDate = strtotime($year . '-' . $month . '-' . $days . ' 23:59:59');
        }

        // выборка по умолчанию
        $query->andWhere("(`first_payment_date` >= {$fromDate} AND `first_payment_date` <= {$toDate}) "
            . " OR (`second_payment_date` >= {$fromDate} AND `second_payment_date` <= {$toDate}) "
            . " OR (`created_at` >= {$fromDate} AND `created_at` <= {$toDate})");

        if (isset($_GET['sort'])) {
            $column = $_GET['sort'];
            $attr = (new Job())->getAttributes();
            if (key_exists($column, $attr)) {
                $direction = isset($_GET['direction']) ? $_GET['direction'] : 'ASC';
                $direction = ($direction == 'ASC') ? SORT_ASC : SORT_DESC;
                $sorting[$column] = $direction;
                $query->orderBy($sorting);
            }
        }

        return $query->all();
    }
}
