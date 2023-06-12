<?php

namespace App\Controllers;

use App\Models\PeopleModel;

class Home extends BaseController
{
    protected $peoples;
    public function __construct()
    {
        $this->peoples = new PeopleModel();
    }
    public function index()
    {
        return view('welcome', [
            'title' => 'Home Page',
            'data' => $this->peoples->getPeople()
        ]);
    }
    public function detail($slug)
    {
        if (empty($this->peoples->getPeople($slug))) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Opps, terjadi kesalahan! ' . $slug);
        }

        return view('detail', [
            'title' => 'Detail Page ' . $this->peoples->getPeople($slug)['name'],
            'data' => $this->peoples->getPeople($slug)
        ]);
    }
    public function about()
    {
        return view('about', [
            'title' => 'About Page'
        ]);
    }
    public function tambahdata()
    {
        return view('tambahdata', [
            'title' => 'Create Data Page',
        ]);
    }
    public function simpan()
    {
        if ($this->request->getVar('jenis_kelamin') != "Laki-Laki" && $this->request->getVar('jenis_kelamin') != "Perempuan") {
            $jenis_kelamin = 'Laki-Laki';
        }
        else {
            $jenis_kelamin = htmlspecialchars($this->request->getVar('jenis_kelamin'));
        }

        if (!$this->validate([
            'name' => [
                'rules' => 'required|is_unique[peoples.name]',
                'errors' => [
                    'required' => 'Nama Wajib Diisi!',
                    'is_unique' => 'Nama Sudah Terdaftar!',
                ]
            ],
            'jenis_kelamin' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jenis Kelamin Wajib Ditentukan'
                ]
            ],
            'gambar' => [
                'rules' => 'is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg]|max_size[gambar, 1024]',
                'errors' => [
                    'is_image' => 'Harus Berupa File Gambar',
                    'mime_in' => 'Format gambar yang diperbolehkan (JPG, JPEG)',
                    'max_size' => 'Ukuran gambar maksimal 1024 MB',
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();

            session()->setFlashdata('name', $validation->getError('name'));
            session()->setFlashdata('gambar', $validation->getError('gambar'));

            return redirect()->to(base_url('tambahdata'))->withInput();
        }

        $fileGambar = $this->request->getFile('gambar');

        if ($fileGambar->getName() == "") {
            $namaGambar = 'none.jpg';
        } else {
            $namaGambar = $fileGambar->getRandomName();
            $fileGambar->move('img', $namaGambar);
            // $namaGambar = $fileGambar->getName();
        }

        $slug = url_title($this->request->getVar('name'), '-', true);

        $this->peoples->save([
            'name' => htmlspecialchars($this->request->getVar('name')),
            'slug' => $slug,
            'jenis_kelamin' => $jenis_kelamin,
            'gambar' => $namaGambar,
        ]);

        session()->setFlashdata('messageSuccess', 'Data berhasil ditambahkan!');

        return redirect()->to(base_url('/tambahdata'));
    }
    public function edit($slug)
    {
        if (empty($this->peoples->getPeople($slug))) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Opps, terjadi kesalahan! ' . $slug);
        }

        return view('edit', [
            'title' => 'Detail Page ' . $this->peoples->getPeople($slug)['name'],
            'data' => $this->peoples->getPeople($slug),
        ]);
    }
    public function update($id)
    {
        $dataLama = $this->peoples->find($id);

        if ($this->request->getVar('jenis_kelamin') != "Laki-Laki" && $this->request->getVar('jenis_kelamin') != "Perempuan") {
            $jenis_kelamin = 'Laki-Laki';
        } else {
            $jenis_kelamin = htmlspecialchars($this->request->getVar('jenis_kelamin'));
        }

        if ($dataLama['name'] == $this->request->getVar('name')) {
            $rules_name = 'required';
        } else {
            $rules_name = 'required|is_unique[peoples.name]';
        }

        if (!$this->validate([
            'name' => [
                'rules' => $rules_name,
                'errors' => [
                    'required' => 'Nama Wajib Diisi!',
                    'is_unique' => 'Nama Sudah Terdaftar!',
                ]
            ],
            'jenis_kelamin' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jenis Kelamin Wajib Ditentukan'
                ]
            ],
            'gambar' => [
                'rules' => 'is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg]|max_size[gambar, 1024]',
                'errors' => [
                    'is_image' => 'Harus Berupa File Gambar',
                    'mime_in' => 'Format gambar yang diperbolehkan (JPG, JPEG)',
                    'max_size' => 'Ukuran gambar maksimal 1024 MB',
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();

            session()->setFlashdata('name', $validation->getError('name'));
            session()->setFlashdata('gambar', $validation->getError('gambar'));

            return redirect()->to(base_url('/edit/' . $dataLama['slug']))->withInput();
        }

        $fileGambar = $this->request->getFile('gambar');

        if ($fileGambar->getName() == "") {
            $namaGambar = $this->request->getVar('gambar_lama');
        } else {
            if($this->request->getVar('gambar_lama') != 'none.jpg') {
                unlink('img/' . $this->request->getVar('gambar_lama'));
            }
            $namaGambar = $fileGambar->getRandomName();
            $fileGambar->move('img', $namaGambar);
            // $namaGambar = $fileGambar->getName();
        }

        $slug = url_title($this->request->getVar('name'), '-', true);

        $this->peoples->save([
            'id' => $id,
            'name' => htmlspecialchars($this->request->getVar('name')),
            'slug' => $slug,
            'jenis_kelamin' => $jenis_kelamin,
            'gambar' => $namaGambar,
        ]);

        session()->setFlashdata('messageSuccess', 'Data berhasil di Update!');

        return redirect()->to(base_url('/edit/' . $slug))->withInput();
    }
    public function hapus($id)
    {
        $people = $this->peoples->find($id);

        if($people['gambar'] != 'none.jpg') {
            unlink('img/' . $people['gambar']);
        }
    
        $this->peoples->delete($id);

        return redirect()->back();
    }
}
