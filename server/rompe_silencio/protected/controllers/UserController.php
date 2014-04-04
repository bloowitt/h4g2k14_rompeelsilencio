<?php

class UserController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('create'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('delete','enable','list'),
				'roles' => array ('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new User;
		$model->attributes=$_POST;
		
		if (Yii::app()->user->checkAccess("admin")) {
			$model->enabled = 1;
		}
		
		if ($model->validate()) {

			if($model->save()) {
				if (!empty($_POST['tags'])) {
					foreach ($_POST['tags'] as $tagId)  {
						$t = new UserTag;
						$t->UserId = $model->UserId;
						$t->TagId = $tagId;
						$t->insert();
					}
				}
				
				Yii::app()->end();
			} else {
				$this->_sendResponse(500, "Could not create the user");
			}
		} else {
			$this->_sendResponse(400,
					json_encode($model->errors));
		}
	}
	
	public function actionEnable() {
		if (empty($_POST['id_user'])){
			$this->_sendResponse(400,"id_user missing");
		} else {
			$model = User::model()->findByPk($_POST);
			if (!isset($model)) {
				$this->_sendResponse(404,"unknown user");
			} else {
				$model->enabled = 1;
				if (!$model->save()) {
					$this->_sendResponse(400,json_encode($model->errors));
				}
			}
		}
	}

}
