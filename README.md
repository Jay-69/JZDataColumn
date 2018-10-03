# JZDataColumn
Editable DataColumn for Yii2 GridView

This is extansion of DataColumn of Yii2.
Allows to edit data of type string directly in GridView column.

TO SET UP:
1. Create folder "jz" in "vendor" in your project.
2. Place JZDataColumn.php in "jz" folder. Or any other reachable one.
3. Place jzdatacolumn.js in you JavaScript folder.
4. Place jzdatacolumn.css in your CSS folder.
5. Make necessary changes to AppAsset.php.
  For Ex:
  class AppAsset extends AssetBundle{
    public $css = [
        'css/jzdatacolumn.css',
    ];
    public $js = [
		    'js/jzdatacolumn.js',
    ];
}

TO USE:
1. In GridView:
  [
	  'class' => 'vendor\jz\JZDataColumn',
    'attribute' => 'attr',
		'editable' => true,	//It is true by default, but better keep to see that attribute is editable
		'editUrl' => Url::to(['controller/jzdataedit']),
		'loaderPath' => Yii::getAlias('@cssImages').'/img_loader.gif',
    'headerOptions' => ['style'=>'text-align:center;'],
  ],
  
  2. In action:
  public function actionJZDataEdit(){
    if(isset($_GET['data'])){
      $json=json_decode($_GET['data']);
      if(isset($json->id) && isset($json->attribute) && isset($json->value)){
        $model=YourClass::find()->where(['id'=>$json->id])->one();
        if(isset($model)){
          $attribute=$json->attribute;
          $model->$attribute=trim($json->value);//variable variable!!!
          if($model->save()){
            return json_encode(['msg'=>1,'val'=>$model->$attribute]);
          } else {
            $errors=array_values($model->errors);
            if($errors[0][0]!=''){$error=$errors[0][0];} else {$error='Some data is not correct.';}
            return json_encode(['msg'=>0,'val'=>$error);
          }                       
        } else {return json_encode(['msg'=>0,'val'=>'No model found.']);}
      } else {return json_encode(['msg'=>0,'val'=>'No correct dataset provided.']);}
    } else {return json_encode(['msg'=>0,'val'=>'No data provided.']);}
  }
