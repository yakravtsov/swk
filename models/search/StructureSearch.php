<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Structure;

/**
 * StructureSearch represents the model behind the search form about `app\models\Structure`.
 */
class StructureSearch extends Structure
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created', 'updated', 'name'], 'safe'],
            [['author_id', 'structure_id', 'type', 'university_id'], 'integer'],
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
    public function search($params,$customQuery = false)
    {
        if(!$customQuery){
            $query = Structure::find();
        } else {
            $query = $customQuery;
        }

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
            'structure_id' => $this->structure_id,
            'type' => $this->type,
            'university_id' => $this->university_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
