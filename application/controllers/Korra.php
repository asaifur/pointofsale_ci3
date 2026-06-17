<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Korra extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url','form'));
        $this->load->library(array('form_validation','email','session'));
        $this->load->model('Contact_model','contact');
    }

    public function index()
    {
        $data = array(
            'title' => 'PT Elpifour Land And Property - Home'
        );
        $this->load->view('templates/header',$data);
        $this->load->view('home',$data);
        $this->load->view('templates/footer',$data);
    }


    public function submit_contact()
    {
        // Validasi form
        $this->form_validation->set_rules('name','Name','trim|required|min_length[2]');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email');
        $this->form_validation->set_rules('message','Message','trim|required|min_length[5]');

        if ($this->form_validation->run() == FALSE) {
            // kembali ke halaman home dengan error (simpler: taruh flashdata)
            $this->session->set_flashdata('contact_errors', validation_errors());
            redirect('korra#contact');
        } else {
            $post = [
                'name' => $this->input->post('name', TRUE),
                'email' => $this->input->post('email', TRUE),
                'phone' => $this->input->post('phone', TRUE),
                'message' => $this->input->post('message', TRUE),
                'created_at' => date('Y-m-d H:i:s'),
            ];

            // simpan ke DB
            $insert_id = $this->contact->insert($post);

            // kirim email ke admin (konfigurasi di application/config/email.php)
            $this->email->from($post['email'], $post['name']);
            $this->email->to('korra@korra.co.id');
            $this->email->subject('New Contact from website');
            $body = "Name: {$post['name']}\nEmail: {$post['email']}\nPhone: {$post['phone']}\n\nMessage:\n{$post['message']}";
            $this->email->message($body);

            $sent = $this->email->send();

            $this->load->view('templates/header', ['title'=>'Thank you']);
            $this->load->view('contact_success', ['insert_id'=>$insert_id,'email_sent'=>$sent]);
            $this->load->view('templates/footer');
        }
    }
public function projects($page = 1)
{
    $this->load->model('Project_model','project_model');
    $per_page = 9;
    $offset = max(0, ($page-1) * $per_page);

    $data['projects'] = $this->project_model->get_all($per_page, $offset);
    $data['title'] = 'Project Portfolio - PT Elpifour Land And Property';

    $this->load->view('templates/header', $data);
    $this->load->view('projects_list', $data);
    $this->load->view('templates/footer', $data);
}

public function project($slug = null)
{
    if(!$slug) show_404();
    $this->load->model('Project_model','project_model');
    $project = $this->project_model->get_by_slug($slug);
    if(!$project || $project->status !== 'published') show_404();

    $data['project'] = $project;
    $data['images'] = $this->project_model->get_images($project->id);
    $data['title'] = $project->title;

    $this->load->view('templates/header', $data);
    $this->load->view('project_detail', $data);
    $this->load->view('templates/footer', $data);
}


}
