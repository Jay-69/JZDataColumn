//Example for usage in GridView
Pjax::begin(['id' => 'pjax_id_1', 'options'=> ['class'=>'pjax', 'loader'=>'loader_id_1', 'neverTimeout'=>true]]);
    echo GridView::widget([
        'dataProvider' => $dp,
        'filterModel' => $model,
        'options'=>['class'=>'grid-view','id'=>'grid_id_1'],
        'summaryOptions'=>['style'=>'text-align:right;'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['width' => '40','style'=>'text-align:center;'],
                'contentOptions' => ['align'=>'right']
            ],
			      [
        				'class' => 'vendor\jz\JZDataColumn',
                'attribute' => 'tbl_attribute',
				        'editable' => true,	//even it is true by default, better to keep just for information
				        'editUrl' => Url::to(['controller/jzdatacolumn']),
      				  'emptyLabel' => 'Click me to add',
				        'loaderPath' => Yii::getAlias('@cssImg').'/img_loader.gif',
                'headerOptions' => ['style'=>'text-align:center;'],
            ],
        ],
    ]); 
Pjax::end();

//Example of action for editin attribute
public function actionJzDataColumn(){
        if(isset($_GET['data'])){
            $json=json_decode($_GET['data']);
            if(isset($json->id) && isset($json->attribute) && isset($json->value)){
                $model=YourClass::find()->where(['id'=>$json->id])->one();
                if(isset($model)){
                    $attribute=$json->attribute;
                    $model->$attribute=trim($json->value);//variable variable used!!!
                    if($model->save()){
                        return json_encode(['msg'=>1,'val'=>$model->$attribute]);
                    } else {
                        //The following is just to get the first error.
                        $errors=array_values($model->errors);
                        if($errors[0][0]!=''){$error=$errors[0][0];} else {$error='Some data not correct.';}
                        return json_encode(['msg'=>0,'val'=>$error;
                    }                       
                } else {return json_encode(['msg'=>0,'val'=>'No model found.']);}
            } else {return json_encode(['msg'=>0,'val'=>'No correct data set provided.']);}
        } else {return json_encode(['msg'=>0,'val'=>'No data provided.']);}
    }
