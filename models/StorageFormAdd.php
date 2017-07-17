<?php
	namespace app\models;
	use Yii;
	use yii\base\Model;
	
	class StorageFormAdd extends Model
	{
		public $name, $type, $massa, $value, $status, $from, $to, $operation, $type_img_name, $name_img_name, $type_desc_send, $type_title_send, $name_title_send, $name_desc_send, $name_type_send, $date_send, $time_send;
		
		public function rules(){
			return [
				// username and password are both required
				//[['type','massa','value', 'status', 'from', 'to', 'operation', 'name'], 'required', message => ''],
				[['massa','value', 'from', 'to', 'operation'], 'required', 'message' => ''],
				// rememberMe must be a boolean value
				['type', 'default', 'message' => ''],
				['date_send', 'default', 'message' => ''],
				['time_send', 'default', 'message' => ''],
				['type_img_name', 'default', 'message' => ''],
				['name_img_name', 'default', 'message' => ''],
				['type_desc_send', 'default', 'message' => ''],
				['type_title_send', 'default', 'message' => ''],
				['name_title_send', 'default', 'message' => ''],
				['name_desc_send', 'default', 'message' => ''],
				['name_type_send', 'default', 'message' => ''],
				['name', 'default', 'message' => ''],
				['value', 'default', 'message' => ''],
				['massa', 'default', 'message' => ''],
				['status', 'default', 'message' => ''],
				['from', 'default', 'message' => ''],
				['to', 'default', 'message' => ''],
				['operation', 'default', 'message' => ''],
				
			];
		}
		
	}
?>