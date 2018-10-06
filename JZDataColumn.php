<?php
/**
 * @link http://www.atlanticbits.com/
 * @copyright Copyright (c) 2018 Eugene Zemskov
 * @license MIT
 */
namespace vendor\jz;

use yii\grid\DataColumn;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * JZDataColumn is the extantion of DataColumn column type for the [[GridView]] widget.
 *
 * It is used to show data columns and allows data of type string to be edited directly in GridVie by setting [[editable]] to true.
 *
 * @author Eugene Zemskov <www@atlanticbits.com>
 */

class JZDataColumn extends DataColumn{

    /**
     * @var bool if set to true makes possible to edit the value of the attribute.
     */
	public $editable=false;
    /**
     * @var string url to action responsible for editin of the attribute.
     */
	public $editUrl='#';
    /**
     * @var string label (clickable) for empty attribute.
     */
	public $emptyLabel='Click me to add!';
    /**
     * @var string label for save button.
     */
	public $saveLabel='SAVE';
    /**
     * @var string label for deny button.
     */
	public $denyLabel='CANCEL';
    /**
     * @var integer number of characters allowed for input.
     */
	public $editMaxLen=100;
    /**
     * @var string css class names for the components.
     */
	public $emptyCssClass='jzdc_empty';
	public $editCssClass='jzdc_edit';
	public $infoCssClass='jzdc_info';
	public $saveCssClass='jzdc_save';
	public $denyCssClass='jzdc_deny';
    /**
     * @var string path to a loader which showed during activity.
     */
	public $loaderPath='loader.gif';

    /**
	 * see parent class for the details
     */
	public function getDataCellValue($model, $key, $index){
		if ($this->value !== null) {
            if (is_string($this->value)) {
				return ArrayHelper::getValue($model, $this->attribute);
            }

			return call_user_func($this->value, $model, $key, $index, $this);

		} elseif ($this->attribute !== null) {
			
			$val=ArrayHelper::getValue($model, $this->attribute);
			
			if($this->editable){
				$this->format='raw';
				$uniqId=uniqid();
				if(isset($val) && $val!=''){
					$clickMe='';
				} else {
					$clickMe='<span id="jzdc_empty_id_'.$uniqId.'" class="'.$this->emptyCssClass.'" onclick="jzDataColumnTextEdit(\''.$uniqId.'\',\''.$this->attribute.'\',\''.$key.'\',\''.$this->editUrl.'\',\''.$this->loaderPath.'\');" onmouseover="$(this).css(\'text-decoration\',\'underline\');" onmouseout="$(this).css(\'text-decoration\',\'none\');" style="cursor:pointer;">'.$this->emptyLabel.'</span>';
				}				
                return '<span id="jzdc_title_id_'.$uniqId.'" onclick="jzDataColumnTextEdit(\''.$uniqId.'\',\''.$this->attribute.'\',\''.$key.'\',\''.$this->editUrl.'\',\''.$this->loaderPath.'\');" onmouseover="$(this).css(\'text-decoration\',\'underline\');" onmouseout="$(this).css(\'text-decoration\',\'none\');" style="cursor:pointer;">'.$val.'</span>'.$clickMe.' <span id="jzdc_info_id_'.$uniqId.'" class="'.$this->infoCssClass.'"></span>'.Html::input('text','jzdc_input_'.$uniqId,$val,['id'=>'jzdc_input_id_'.$uniqId,'maxlength'=>$this->editMaxLen, 'class'=>$this->editCssClass, 'style'=>'display:none;']).'&nbsp;&nbsp;&nbsp;&nbsp;<span id="jzdc_save_id_'.$uniqId.'" class="'.$this->saveCssClass.'" style="display:none;" onclick="jzDataColumnTextSave(\''.$uniqId.'\',\''.$this->attribute.'\',\''.$key.'\',\''.$this->editUrl.'\',\''.$this->loaderPath.'\');">'.$this->saveLabel.'</span>&nbsp;&nbsp;&nbsp;&nbsp;<span id="jzdc_deny_id_'.$uniqId.'" class="'.$this->denyCssClass.'" style="display:none;" onclick="jzDataColumnTextDeny(\''.$uniqId.'\');">'.$this->denyLabel.'</span>';
			} else {
				return $val;
			}
        }

        return null;
    }

}
