<?php
namespace Backend\Controller\Member;
/**
 * 业主用户管理
 * @author llf
 * @time 2016-06-30
 */
class OwnerController extends IndexController {
	/**
	 * 表名
	 * @var string
	 */
	protected $table 		= 'Member';
	protected $table_view	= 'MemberView';
	protected $map			= array('is_del'=>0,'type'=>2);
	
	/**
	 * 列表函数
	 */
	public function index(){

		$map = $this->_search();
		
		$state   = get_table_state($this->table,'state');

		$result = $this->page(D($this->table_view),$map,'register_time desc');
		
		/*$result['type'] = get_table_state($this->table,'type');*/

		$result['district'] = array_to_select(get_no_hid('district','add_time desc'), I('district_id'));

		$result['state'] 	= $state;

		$this->assign($result);
		$this->display();
	}

	private function _search(){


		$map = $this->map;
		/**禁用*/
		if(strlen(I('is_hid'))){
			$map['is_hid'] = I('is_hid');
		}
		/**手机|昵称|姓名*/
		if(strlen(trim(I('keyword')))) {
			$map['mobile|nickname|username|car_num'] = array('like','%' . trim(I('keyword')) . '%');
		}
		/**小区*/
		if(strlen(I('district_id'))){
			$map['district_id'] = I('district_id',0,'int');
		}
		/**类型*/
/*		if(strlen(I('type'))){
			$map['type'] = I('type',0,'int');
		}*/
		if(session('is_owner')){
			$map['district_id'] = array('IN',session('district_ids'));
		}

		return $map;
	}

	/**
	 * 添加
	 * @author llf
	 * @time 2017-09-14
	 */
	public function add(){
		if(IS_POST){
			$this->update();
		}else{
			$this->operate();
		}
	}

	/**
	 * 编辑
	 * @author llf
	 * @time 2017-09-14
	 */
	public function edit(){
		if(IS_POST){
			$this->update();
		}else{
			$this->operate();
		}
	}

	/**
	 * 显示
	 * @author llf
	 * @time 2017-09-14
	 */
	public function detail(){
		$this->operate('detail');
	}

	/**
	 * 显示
	 * @author llf
	 * @time 2017-09-14
	 */
	protected function operate($tpl='operate'){
		$info = get_info($this->table, array('id'=>I('ids')));

		if(!empty($info)){

			$type = get_table_state($this->table,'type');

			$info['type_title'] = $type[$info['type']]['title'];

			if($info['pid']){
				$info['pinfo'] = M($this->table)->where('id='.$info['pid'])->find();
			}
			if($info['district_id']){
				$info['district_info'] = M('district')->where('id='.$info['district_id'])->find();
			}
		}

		$data['district'] = array_to_select(get_no_hid('district','add_time desc'), $info['district_id']);


		if(!empty(session('district_ids'))){
			// $list = get_no_hid('district','add_time desc');
			$list = M('district')->where('is_del=0','is_hid=0')->select();
			$district_ids = session('district_ids');
			array_walk($list, function($a) use($district_ids,&$html){
				if(in_array($a['id'], $district_ids)){
					$html .= "<option value='{$a['id']}'>{$a['title']}</option>";
				}
			});
			$data['district'] = $html;
		}

		$data['type'] = get_table_state($this->table,'type');
		$data['info'] = $info;
		$this->assign($data);
		$this->display($tpl);
	}
	
	/**
	 * 修改
	 * @author llf
	 * @time 2017-09-14
	 */
	protected function update(){

		if(!IS_POST)	$this->error('提交方式错误');

		$data = I('post.');

		/*基本信息*/
		$post = array();

		/*公司信息*/
		$post['type']			= 2;
		$post['email']			= I('email','','trim');
		$post['mobile']			= I('mobile','','trim');
		$post['nickname']		= I('nickname','','trim');
		$post['username']		= I('username','','trim');
		$post['sex']			= I('sex',1,'int');
		$post['birthday']		= I('birthday','','trim');
		$post['idcard']			= I('idcard','','trim');
		$post['signature']		= I('signature','','trim');
		$post['password']		= I('password','','trim');
		$post['district_id']	= I('district_id','','int');
		$post['age']			= I('age',0,'int');	
		// $post['register_code']	= I('register_code','','trim');
		if(!empty(I('car_num','','trim'))){
			$post['car_num'] = I('car_num','','trim');
		}else{
			$post['car_num'] = '';
		}

		$Member = D($this->table);
		if(is_numeric($data['id'])){
			$has = $Member->where('id='.intval($data['id']))->find();
			if(!empty($has)){
				$post['id'] = intval($has['id']);
			}
		}
		if(empty($post['id'])){
			$post['state'] = 2;
		}
		if(empty($post['password'])){
			unset($post['password']);
		}
		if(!empty($post['id']) && !empty($post['password'])){
			$Member->_auto[] = array('password','sys_password_encrypt', $Member::MODEL_UPDATE,'function');
		}
		try {
            $M = M();
            $M->startTrans();
		
			/*基本信息*/
			$result = update_data($Member, [], [], $post);
			if(!is_numeric($result)){
				throw new \Exception($result);
			}

		} catch (\Exception $e) {
			$M->rollback();
			$this->error($e->getMessage());
		}

		$M->commit();
		$this->success('操作成功',U('index'));
	}
	

	/**
	 * 业主身份审核
	 * @author llf
	 * @time 2017-10-09
	 */
	public function stated(){

		if(IS_POST){

			$member_id 	= I('member_id',0,'int'); 
			$state 		= I('state',0,'int');
			
			$arr   = get_table_state($this->table,'state');
			if(!in_array($state,array_keys($arr))){
				$this->error('请选择审核状态');
			}
			$condition = array(
					'is_del'=>0,
					'type'  =>2,
					'id'	=>$member_id
				);
			$member_info = M($this->table)->where($condition)->find();
			if(empty($member_info)){
				$this->error('业主信息不存在');
			}
			if($member_info['is_hid']){
				$this->error('业主账号已禁用');
			}
			if(!$member_info['district_id']){
				$this->error('业主小区信息不存在');
			}
			try {
	            $M = M();
	            $M->startTrans();

	            $res = M($this->table)->where('id='.$member_info['id'])->setField('state',$state);
	            if(!$res){
	            	throw new \Exception('状态更新失败');
	            }
	            if(empty($member_info['register_code'])){
					//设置注册邀请码
					$register_code = get_register_code($member_info['district_id']);
	            	$set = M($this->table)->where('id='.$member_info['id'])->setField('register_code',$register_code);
	            	if(!$set){
	            		throw new \Exception('注册邀请码设置失败');
	            	}
	            	//短信通知 -- 
					send_sms($member_info['mobile'],'SMS_123672216',0,$register_code,$member_info['id']);
	            }

			} catch (\Exception $e) {
				$M->rollback();
				$this->error($e->getMessage());
			}
			$M->commit();
			$this->success('操作成功',U('index',I()));

		}else{

			/** 获取用户信息*/
			$member_id = I('ids',0,'int');
			$condition = array(
					'is_del'=>0,
					'id'	=>$member_id
				);
			$member_info = M($this->table)->where($condition)->find();
			if(empty($member_info)){
				$this->error('用户信息不存在');
			}
			if($member_info['is_hid']){
				$this->error('该用户已禁用');
			}

			$arr   = get_table_state($this->table,'state');

			$this->assign('arr',$arr);
			$this->assign('member_info',$member_info);
			$this->display();

		}
	}


	/**
     * 用户导出
     * @author llf
     * @param
     */
    public function export(){

		$map 	= $this->_search();
		$result = get_result(D($this->table_view), $map,'register_time desc');

		if(!empty($result)){
			$sex = array('0'=>'未知','1'=>'男','2'=>'女');
			array_walk($result, function(&$a) use($sex){
				$a['sex_title'] = $sex[$a['sex']];
			});
		}
		/*填充数据*/
		$data['result']    = $result;
		/*填充表名*/
		$data['sheetName'] = 'order_export_'.date('Ymd_His');

		$export_config = array(
			array('title' => '姓名', 'field' => 'username'),
			array('title' => '性别', 'field' => 'sex_title'),
			array('title' => '昵称', 'field' => 'nickname'),
			array('title' => '年龄', 'field' => 'age'),
			array('title' => '手机号', 'field' => 'mobile'),
			array('title' => '身份证号', 'field' => 'idcard'),
			array('title' => '小区', 'field' => 'district_title'),
			array('title' => '楼层', 'field' => 'building_no'),
			array('title' => '房号', 'field' => 'room_no'),
			array('title' => '注册时间', 'field' => 'register_time'),
		);
		A('Common/Excel','',1)->export_data($export_config,$data);
    }
}

