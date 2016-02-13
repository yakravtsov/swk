<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Landing;
use app\models\User;

/**
 * LandingSearch represents the model behind the search form about `app\models\Landing`.
 */
class LandingSearch extends Landing
{

    public $agent;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['request_id', 'form_id'], 'integer'],
            [['name', 'email', 'phone', 'agent', 'agent_id', 'params'], 'safe'],
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
    public function search($params,$custom_query = false)
    {
        if($custom_query){
            $query = $custom_query;
        } else {
            $query = Landing::find();
            $query->joinWith(['agent']);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $dataProvider->sort->attributes['agent'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['agent.fullname' => SORT_ASC],
            'desc' => ['agent.fullname' => SORT_DESC],
        ];

        $query->andFilterWhere([
            'request_id' => $this->request_id,
            'form_id' => $this->form_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'agent.fullname', $this->agent])
            ->andFilterWhere(['like', 'params', $this->params]);

        return $dataProvider;
    }
}
