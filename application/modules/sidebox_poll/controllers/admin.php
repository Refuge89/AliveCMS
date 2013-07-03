<?php

class Admin extends MX_Controller
{
	public function __construct()
	{
		// Make sure to load the administrator library!
		$this->load->library('administrator');
		$this->load->model('poll_model');

		parent::__construct();
	}

	public function index()
	{
		// Change the title
		$this->administrator->setTitle("Manage polls");
		
		$polls = $this->poll_model->getPolls();
		
		if($polls)
		{
			$polls[0]['active'] = true;
			
			foreach($polls as $key => $value)
			{
				$polls[$key]['answers'] = $this->poll_model->getAnswers($value['questionid']);

				if($polls[$key]['answers'])
				{
					$polls[$key]['total'] = 0;
					foreach($polls[$key]['answers'] as $k => $v)
					{
						$polls[$key]['answers'][$k]['votes'] = $this->poll_model->getVoteCount($value['questionid'], $v['answerid']);
						$polls[$key]['total'] += $polls[$key]['answers'][$k]['votes'];
					}
				}
			}
		}
			
		// Prepare my data
		$data = array(
			'url' => $this->template->page_url,
			'polls' => $polls
		);

		// Load my view
		$output = $this->template->loadPage("admin.tpl", $data);

		// Put my view in the main box with a headline
		$content = $this->administrator->box('Polls', $output);

		// Output my content. The method accepts the same arguments as template->view
		$this->administrator->view($content, false, "modules/sidebox_poll/js/admin.js");
	}

	public function create()
	{
		$data["question"] = $this->input->post("question");
		
		$answers = array();

		$id = 1;

		while($this->input->post('answer_'.$id) != false)
		{
			$answers[$id]['answer'] = $this->input->post('answer_'.$id);
			$id++;
		}

		if(count($answers) < 2)
		{
			die("You must have at least two options");
		}

		$this->poll_model->add($data, $answers);

		die('window.location.reload(true)');
	}

	public function delete($id = false)
	{
		if(!$id || !is_numeric($id))
		{
			die();
		}

		$this->poll_model->delete($id);
	}
}