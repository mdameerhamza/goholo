<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends GH_Controller {

	public $data = array();

	public function __construct() {
		parent::__construct();

		$this->data['menu_class'] = "admin_menu";
		$this->data['title'] = "Admin";
		$this->data['sidebar_file'] = "admin/admin_sidebar";
	}

	public function index()
	{

		$this->load->view('common/header',$this->data);
		$this->load->view('common/sidebar',$this->data);
		$this->load->view('admin/admin');
		$this->load->view('common/footer');
	}

	public function manage_resource_center($id = ""){

		$form_data = $this->input->post();

		if (!empty($form_data)) {
			
			$resource_file = $this->crud_model->upload_file($_FILES['resource_file'],'resource_file',RESOURCE_CENTER_UPLOAD_PATH);

			if ($resource_file) {
				
				$form_data['resource_file'] = $resource_file;

			}elseif ($form_data['old_resource_file'] != "") {
				
				$form_data['resource_file']= $form_data['old_resource_file'];
			}

			unset($form_data['old_resource_file']);
			$edit = false;
			if ($form_data['resource_id'] != "") {
				$edit = true;
				$where['resource_id'] = $form_data['resource_id'];
				unset($form_data['resource_id']);

				$resource_id = $this->crud_model->update_data('resource_center',$where,$form_data);

			}else{

				unset($form_data['resource_id']);

				$resource_id = $this->crud_model->add_data('resource_center',$form_data);

				$notify['message'] = $this->lang->line('new_resource');
				$notify['link'] = "admin/view_resource_center";

				$this->add_notifications($notify,array("2","3","4","5"));
			}

			if ($resource_id) {

				if (isset($edit)) {
					$this->session->set_flashdata("success_msg","Resource Updated successfully");
				}else{
					$this->session->set_flashdata("success_msg","Resource created successfully");
				}

				
				redirect(base_url()."admin/view_resource_center");

			}else{

				if (isset($edit)) {
					$this->session->set_flashdata("error_msg","Resource Not Updated");
				}else{
					$this->session->set_flashdata("error_msg","Resource Not created");
				}

				redirect($_SERVER['HTTP_REFERER']);
			}

		}

		if ($id != "") {
			$where['resource_id'] = $id;

			$this->data['resource'] = $this->crud_model->get_data('resource_center',$where,true);
		}



		$this->load->view('common/header',$this->data);
		$this->load->view('common/sidebar',$this->data);
		$this->load->view('resource_center/manage_resource_center');
		$this->load->view('common/footer');

	}

	public function view_resource_center(){


		$this->data['resources'] = $this->crud_model->get_data('resource_center');

		$this->load->view('common/header',$this->data);
		$this->load->view('common/sidebar',$this->data);
		$this->load->view('resource_center/admin_resource_center',$this->data);
		$this->load->view('common/footer');
	}

	public function delete_resource($id){

		$where['resource_id'] = $id;

		$result = $this->crud_model->delete_data('resource_center',$where);

		if ($result) {
			
			redirect($_SERVER['HTTP_REFERER']);
		}
		


	}

		public function delete_package($id){

			$where['package_id'] = $id;

		$package =  $this->crud_model->get_data("packages",$where,true,'','','item_qb_id');

		 $qb_inactive_package = $this->quick_books->inactive_item($package->item_qb_id);

		if ($qb_inactive_package['error'] == false) {


			$result = $this->crud_model->delete_data("packages",$where);

		}else{

			$this->session->set_flashdata("error_msg",$qb_inactive_package['msg']);

		}


		if ($result) {
			
			redirect($_SERVER['HTTP_REFERER']);
		}
		


	}

		public function manage_packages($id = ""){

		$form_data = $this->input->post();

		if (!empty($form_data)) {
			
			$edit = false;

			$form_data['total_cost'] = ($form_data['total_impressions']*$form_data['cost_per_impression'])+$form_data['hologram_price'];

			if ($form_data['package_id'] != "") {
				$edit = true;
				$qb_update_item = $this->quick_books->update_item($form_data);
				if ($qb_update_item['error'] == false) {
				$where['package_id'] = $form_data['package_id'];
				unset($form_data['package_id']);

				$package_id = $this->crud_model->update_data('packages',$where,$form_data);
			}else{
				$package_id = false;
				$msg = $qb_update_item['msg'];
			}

			}else{

				$qb_add_item = $this->quick_books->add_item($form_data);

				if ($qb_add_item['error'] == false) {
						$form_data['item_qb_id'] = $qb_add_item['msg'];

				unset($form_data['package_id']);

				$package_id = $this->crud_model->add_data('packages',$form_data);

					}else{

						$package_id = false;
						$msg = $qb_add_item['msg'];

					}

				//$notify['message'] = $this->lang->line('new_package');
				//$notify['link'] = "admin/view_resource_center";

				//$this->add_notifications($notify,array("2","3","4","5"));
			}

			if ($package_id) {

				if (isset($edit)) {
					$this->session->set_flashdata("success_msg","Package Updated successfully");
				}else{
					$this->session->set_flashdata("success_msg","Package created successfully");
				}

				
				redirect(base_url()."admin/view_packages");

			}else{

				if (isset($edit)) {
					if (!isset($msg)) {
						$msg = "Package Not Updated";
					}
				}else{
					if (!isset($msg)) {
						$msg = "Package Not created";
					}
				}

				$this->session->set_flashdata("error_msg",$msg);

				redirect($_SERVER['HTTP_REFERER']);
			}

		}

		if ($id != "") {
			$where['package_id'] = $id;

			$this->data['package'] = $this->crud_model->get_data('packages',$where,true);
		}



		$this->load->view('common/header',$this->data);
		$this->load->view('common/sidebar',$this->data);
		$this->load->view('packages/manage_packages');
		$this->load->view('common/footer');

	}


	public function view_packages(){


		$this->data['packages'] = $this->crud_model->get_data('packages');

		$this->load->view('common/header',$this->data);
		$this->load->view('common/sidebar',$this->data);
		$this->load->view('packages/view_packages',$this->data);
		$this->load->view('common/footer');
	}


	public function change_record_status(){

		$where[$this->input->post("where")] = $this->input->post("record_id");

		$update_data['status'] = $this->input->post("status");

		$res = $this->crud_model->update_data($this->input->post("table"),$where,$update_data);

		$this->notify_status();

		if ($res) {
			
			$response['success'] = true;
		}else{
			$response['error'] = true;
		}


		echo json_encode($response);

	}


	public function unapproved_locations(){
		$join['users ou'] = "ou.user_id=l.location_owner";
		$join['users su'] = "su.user_id=l.created_by";

		$where = array();
		$user_role = get_user_role();

		$this->data['user_role'] = $user_role;



		if ($user_role != 1) {

			if ($user_role == 3) {
				$where['l.created_by'] = get_user_id();
			}elseif ($user_role == 2) {
				$where['l.location_owner'] = get_user_id();
			}
			
			
		}

		$where['l.status'] = 0;

		$this->data['locations'] =  $this->crud_model->get_data("locations l",$where,'',$join,'','*,l.status as location_status,CONCAT(ou.first_name, " " ,ou.last_name) AS owner_name,CONCAT(su.first_name, " " ,su.last_name) AS satff_name');

		$this->load->view('common/header',$this->data);
		$this->load->view('common/sidebar',$this->data);
		$this->load->view('location/view_locations',$this->data);
		$this->load->view('common/footer');
	}


}
