<?php 
class Blob
{
    public function __construct()
    {
        $this->ci = &get_instance(); // JANGAN load library upload di sini!
    }

    public function upload_img() {
        $upload_path = realpath(FCPATH . 'assets/uploads');
        if (!$upload_path || !is_dir($upload_path)) {
            die("Folder tidak ditemukan: " . $upload_path);
        }

        if (!isset($_FILES['files']) || empty($_FILES['files']['name'][0])) {
            return array(
                'status' => 'success',
                'files' => ''
            );
        }

        $config['upload_path']   = $upload_path;
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size']      = 5120; // 5MB
        $config['encrypt_name']  = TRUE;

        $this->ci->load->library('upload', $config);

        $uploaded_file_names = [];

        $file_count = count($_FILES['files']['name']);

        for ($i = 0; $i < $file_count; $i++) {
            $_FILES['file']['name']     = $_FILES['files']['name'][$i];
            $_FILES['file']['type']     = $_FILES['files']['type'][$i];
            $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
            $_FILES['file']['error']    = $_FILES['files']['error'][$i];
            $_FILES['file']['size']     = $_FILES['files']['size'][$i];

            $this->ci->upload->initialize($config);

            if ($this->ci->upload->do_upload('file')) {
                $data = $this->ci->upload->data();
                $uploaded_file_names[] = $data['file_name'];
            } else {
                return array(
                    'status' => 'error',
                    'message' => strip_tags($this->ci->upload->display_errors())
                );
            }
        }

        $imploded_names = implode(',', $uploaded_file_names);

        return array(
            'status' => 'success',
            'files' => $imploded_names
        );
    }
}
