<?php
class News extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('News_model');
		$this->load->helper('url_helper');
	}

	public function index() {

		$data['news'] = $this->News_model->get_news();
		$data['title'] = 'All News';

		$this->load->view('templates/header', $data);
		$this->load->view('news/index', $data);
		$this->load->view('templates/footer', $data);

	}

	public function view($uri){
		$data['news_item'] = $this->News_model->get_news($uri);

		if(empty($data['news_item'])) {
			show_404();
		}

		$data['title'] = $data['news_item']['title'];

		$this->load->view('templates/header', $data);
		$this->load->view('news/view', $data);
		$this->load->view('templates/footer', $data);

	}

	public function create() {

		$this->load->helper('form');
		$this->load->library('form_validation');

		$data['title'] = "Criar nova new";

		$this->form_validation->set_rules('title', 'Título', 'required');
		$this->form_validation->set_rules('text', 'Texto', 'required');

		if($this->form_validation->run() === false) {

			$this->load->view('templates/header', $data);
			$this->load->view('news/create', $data);
			$this->load->view('templates/footer', $data);

		} else {

			$this->News_model->set_news();
			$this->load->view('news/success');
		}

	}


}