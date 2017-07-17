<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use Carbon\Carbon;
use app\models\Amo;
use yii\helpers\ArrayHelper;

/**
 * JobSearch represents the model behind the search form about `app\models\Job`.
 */
class JobSearch extends Job
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'ext_id'], 'integer'],
            [['name', 'client', 'collection', 'sketch', 'plan', 'description', 'started_at', 'finished_at', 'created_at', 'deadline', 'status', 'adminchek'], 'safe'],
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
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $selectedStatuses = @$_GET['JobSearch']['status'];
        $user = Yii::$app->user->identity; /* @var $user User */

        $this->load($params);
        $query = Job::find();

        if (empty($selectedStatuses)) {
            // default filter
            $_GET['JobSearch']['status'] = $selectedStatuses = [
                Job::STATUS_NEW, Job::STATUS_ETCHING, Job::STATUS_ETCHING_DONE, Job::STATUS_WOOD_MILLING,
                Job::STATUS_WOOD_DONE, Job::STATUS_WAX_MILLING, Job::STATUS_WAX_DONE, Job::STATUS_CASTING,
                Job::STATUS_GRINDING, Job::STATUS_PILOTING];
        }
        $query->andFilterWhere(['in', 'status', $selectedStatuses]);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
        ]);

        if (!$user->hasRole('superadmin')) {
            $query->andFilterWhere(['<', 'status', '90']);
        }

        // dates (@see http://carbon.nesbot.com/docs/)
        foreach (['created_at', 'finished_at', 'deadline'] as $column) {
            if (empty($this->{$column})) continue;
            $date = explode('-', $this->{$column});
            $dateFrom = Carbon::createFromFormat('d.m.Y H:i:s', $date[0] . '00:00:00');
            $dateTo = isset($date[1]) ?
                Carbon::createFromFormat('d.m.Y H:i:s', $date[1] . ' 23:59:59') :
                    Carbon::createFromFormat('d.m.Y H:i:s', $date[0] . ' 23:59:59');
            $query->andFilterWhere(['>=', $column, $dateFrom->getTimestamp()]);
            $query->andFilterWhere(['<=', $column, $dateTo->getTimestamp()]);
        }

        if (is_numeric($this->name)) {
            $query->andFilterWhere(['ext_id' => $this->name]);
        } else {
            $query->andFilterWhere(['like', 'name', $this->name]);
        }

        $query->andFilterWhere(['like', 'client', $this->client])
            ->andFilterWhere(['like', 'collection', $this->collection])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['ext_id' => $this->ext_id]);

        //$query->limit(200);

        if (isset($_GET['sort'])) {
            $column = $_GET['sort'];
            $attrib = (new Job())->getAttributes();
            if (key_exists($column, $attrib)) {
                $direction = isset($_GET['direction']) ? $_GET['direction'] : 'ASC';
                $direction = ($direction == 'ASC') ? SORT_ASC : SORT_DESC;
                $sorting[$column] = $direction;
                $query->orderBy($sorting);
            }
        } else {
            $query->orderBy(['deadline' => SORT_ASC]);
        }

        return $query->all();
    }

    public function searchAllStatusJob()
    {
        $selectedStatuses = [
            Job::STATUS_NEW, Job::STATUS_ETCHING, Job::STATUS_ETCHING_DONE, Job::STATUS_WOOD_MILLING,
            Job::STATUS_WOOD_DONE, Job::STATUS_WAX_MILLING, Job::STATUS_WAX_DONE, Job::STATUS_CASTING,
            Job::STATUS_GRINDING, Job::STATUS_PILOTING];

        return Job::find()->where(['in', 'status', $selectedStatuses])->count();


    }
    

    public function searchCountStatusJob()
    {
        $selectedStatuses = [
            Job::STATUS_NEW, Job::STATUS_ETCHING, Job::STATUS_ETCHING_DONE, Job::STATUS_WOOD_MILLING,
            Job::STATUS_WOOD_DONE, Job::STATUS_WAX_MILLING, Job::STATUS_WAX_DONE, Job::STATUS_CASTING,
            Job::STATUS_GRINDING, Job::STATUS_PILOTING];
        $status = Job::getStatuses();
        $querystatus = Yii::$app->db->createCommand('SELECT status, COUNT(id) AS count FROM job WHERE status IN ('.implode(",", $selectedStatuses).') GROUP BY status')
            ->queryAll();
        $arrayall = array();
        foreach ($querystatus as $stat){
            $arrayall[$status[$stat['status']]] = $stat['count'];
        }

        return $arrayall;
        
    }

    public function searchJobId($params)
    {
        if(strripos($params['id'],',') === false){
            $id = Yii::$app->db->createCommand('SELECT ext_id FROM job WHERE id = '.$params['id'].'')
                ->queryOne();
            $amo = new Amo(\Yii::$app->params);
            $fields = $amo->getLead($id['ext_id']);
        }else{

            $id = Yii::$app->db->createCommand('SELECT ext_id FROM job WHERE id IN ('.$params['id'].')')
                ->queryAll();
            $massjobs = ArrayHelper::getColumn($id, 'ext_id');
            $amo = new Amo(\Yii::$app->params);
            $fields = $amo->getLeads($massjobs);
        }

        return $fields;

    }


}
