<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Payment;
use yii\data\Pagination;
use Carbon\Carbon;


/**
 * PaymentSearch represents the model behind the search form about `app\models\Payment`.
 */
class PaymentSearch extends Payment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'ext_id', 'pnum', 'status', 'created_at', 'paid_at'], 'integer'],
            [['client', 'manager'], 'safe'],
            [['sum'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param Pagination $pagination
     *
     * @return ActiveDataProvider
     */
    public function search($params, &$pagination=null)
    {
        $limit = 50;
        $page = (empty($_GET['page']) ? 1 : $_GET['page']);
        $page--;
        if ($page < 0) { $page = 1; }

        $selectedStatuses = @$_GET['PaymentSearch']['status'];

        $query = Payment::find();

        $this->load($params);

        if (empty($selectedStatuses)) {
            // default filter
            $_GET['PaymentSearch']['status'] = $selectedStatuses = [Payment::STATUS_WAIT, Payment::STATUS_PAID];
        }
        $query->andFilterWhere(['in', 'status', $selectedStatuses]);
        $query->andFilterWhere(['in', 'status', $selectedStatuses]);

        $query->andFilterWhere([
            'sum' => $this->sum,
        ]);

        if ($this->pnum > 0) {
            $query->andFilterWhere(['=', 'pnum', $this->pnum]);
        }


        // dates (@see http://carbon.nesbot.com/docs/)
        foreach (['paid_at', 'created_at'] as $column) {
            if (empty($this->{$column})) continue;
            $date = explode('-', $this->{$column});
            $dateFrom = Carbon::createFromFormat('d.m.Y H:i:s', $date[0] . '00:00:00');
            $dateTo = isset($date[1]) ?
                Carbon::createFromFormat('d.m.Y H:i:s', $date[1] . ' 23:59:59') :
                Carbon::createFromFormat('d.m.Y H:i:s', $date[0] . ' 23:59:59');
            $query->andFilterWhere(['>=', $column, $dateFrom->getTimestamp()]);
            $query->andFilterWhere(['<=', $column, $dateTo->getTimestamp()]);
        }

        $query->andFilterWhere(['like', 'client', $this->client])
            ->andFilterWhere(['like', 'manager', $this->manager]);

        $query->limit($limit);
        $query->offset($page * $limit);

        if (isset($_GET['sort'])) {
            $column = $_GET['sort'];
            $attrib = (new Payment())->getAttributes();
            if (key_exists($column, $attrib)) {
                $direction = isset($_GET['direction']) ? $_GET['direction'] : 'ASC';
                $direction = ($direction == 'ASC') ? SORT_ASC : SORT_DESC;
                $sorting[$column] = $direction;
                $query->orderBy($sorting);
            }
        } else {
            $query->orderBy(['created_at' => SORT_DESC]);
        }

        // pagination
        $countQuery = clone $query;
        $pagination = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => $limit]);
        $pagination->pageSizeParam = false;

        return $query->all();
    }
}
