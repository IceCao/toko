<?php 
class Blob
{
    public function __construct()
    {
		$this->ci = &get_instance();
        $this->ci->load->library('upload');
    }

    public function upload_img()
    {
        if (empty($_FILES['file_foto']['name'])) {
            return null;
        }

        $config['upload_path']   = './assets/uploads/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']      = 2048; // 2MB
        $config['file_name']     = date('YmdHis'); // Nama file unik

        $this->ci->upload->initialize($config);

        if (!$this->ci->upload->do_upload('file_foto')) {
            $error = array('error' => $this->ci->upload->display_errors());
            $this->ci->session->set_flashdata('error', $error['error']);
            redirect($this->ci->uri->uri_string());
        } else {
            $upload_data = $this->ci->upload->data();
            $file_name = $upload_data['file_name'];

            $response = array(
                'nama_file' => $file_name,
                'path'      => 'assets/uploads/' . $file_name
            );
        }

        return $response;
    }
}
?>