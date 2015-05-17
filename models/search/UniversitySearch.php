<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\University;

/**
 * UniversitySearch represents the model behind the search form about `app\models\University`.
 */
class UniversitySearch extends University
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created', 'updated', 'name', 'db_host', 'db_user', 'db_pass', 'db_name', 'paid_till', 'subdomain'], 'safe'],
            [['author_id', 'university_id', 'db_port', 'tarif', 'status'], 'integer'],
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
        $query = University::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'created' => $this->created,
            'updated' => $this->updated,
            'author_id' => $this->author_id,
            'university_id' => $this->university_id,
            'db_port' => $this->db_port,
            'paid_till' => $this->paid_till,
            'tarif' => $this->tarif,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'db_host', $this->db_host])
            ->andFilterWhere(['like', 'db_user', $this->db_user])
            ->andFilterWhere(['like', 'db_pass', $this->db_pass])
            ->andFilterWhere(['like', 'db_name', $this->db_name])
            ->andFilterWhere(['like', 'subdomain', $this->subdomain]);

        return $dataProvider;
    }
}
