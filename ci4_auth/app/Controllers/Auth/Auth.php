<?php namespace App\Controllers\Auth;

use App\Models\AuthModel;


class Auth extends AuthBaseController
{


	public function __construct(){


		$this->AuthModel = new AuthModel();

	}

	public function login(){
		if ($this->session->logged_in) {
			#kalo misalnya dia uda login
			return redirect()->to(site_url().'/Home');
		}else{

			#cek apakah ada inputan username dan password atau engga, kalo ada berarti diproses
			if (null !==  $this->request->getPost('username')  && !empty($this->request->getPost('username'))) {
				 if (! $this->validate([
				 		'username' => 'required',
				 		'password' => 'required'
				 ]))
	                {
	                        echo view('auth/v_login', [
	                                'validation' => $this->validator
	                        ]);
	                }
	                else
	                {
	                        #proses loginnya
	                	#kita ambil dari database, ngecek ada engga data username dan password sesuai dengan yang diinputkan
	                	$get_data = $this->AuthModel->get_user_data($this->request->getPost('username'))->getRowArray();
	                	
	                	
	                	if ($get_data['userName'] !='') {
	                		#kalo datanya lebih dari nol, ebrarti user ditemukan, bisa kita cek pasword sama input passwordnya sama enggak
	                		$input_password = $this->request->getPost('password');
	                		$hash_input_password = md5($input_password);

	                		if ($hash_input_password==$get_data['userPassword']) {
	                			# valid, username sama passwordnya bener
	                			#bisa mulai disimpen sessionya
	                			$new_session_data = [
	                				'logged_in' => true,
	                				'username' => $get_data['userName']
	                			];

	                			$this->session->set($new_session_data);
	                			return redirect()->to(site_url().'/Home');
	                		}else{
	                			#gagal, karena passwordnya salah

	                			$this->session->setFlashdata('message','Incorect username or password');
	                			return view('auth/v_login');
	                		}


	                	}else{
	                			$this->session->setFlashdata('message','Incorect username or password');
	                			return view('auth/v_login');	                		
	                	}


	                }
			}
			return view('auth/v_login');
		}
	}


	public function logout(){
		$this->session->destroy();
		$this->session->setFlashdata('message','Anda berhasil logout');
		return redirect()->to(site_url().'/Auth/Auth/login');
	}

	//--------------------------------------------------------------------

}
