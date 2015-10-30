<?php

namespace app\models\search;

use app\components\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\StudentWorks;
use yii\db\ActiveQuery;
use app\models\User as UserModel;

/**
 * StudentWorksSearch represents the model behind the search form about `app\models\StudentWorks`.
 */
class StudentWorksSearch extends StudentWorks
{

    public $author;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                [['created', 'updated', 'filename', 'comment','title','author'], 'safe'],
            [['author_id', 'work_id', 'type', 'mark', 'discipline_id', 'student_id', 'status'], 'integer'],
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
    public function search($params,$customQuery = false) {

        if(!$customQuery){
            $query = StudentWorks::find();
        } else {

            $query = $customQuery;
        }

        $role_id = Yii::$app->user->isGuest ? UserModel::ROLE_GUEST : Yii::$app->user->identity->role_id;

        if($role_id == UserModel::ROLE_STUDENT){

        } else {
            $query->joinWith(['author'],[]);
        }


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                //'pageSize' => 1
            ]
        ]);

        $dataProvider->sort->attributes['author'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['user.phio' => SORT_ASC],
            'desc' => ['user.phio' => SORT_DESC],
        ];



        $this->load($params);

        //die(var_dump($this));

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'created' => $this->created,
            'updated' => $this->updated,
            //'author_id' => $this->author_id,
            'work_id' => $this->work_id,
            'type' => $this->type,
            'mark' => $this->mark,
            'discipline_id' => $this->discipline_id,
            'student_id' => $this->student_id,
            'student_works.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'filename', $this->filename])
            ->andFilterWhere(['like', 'user.phio', $this->author])
            ->andFilterWhere(['ILIKE', 'title', $this->title])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
