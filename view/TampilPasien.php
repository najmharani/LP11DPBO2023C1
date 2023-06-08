<?php


include_once("kontrak/KontrakPasien.php");
include_once("presenter/ProsesPasien.php");

class TampilPasien implements KontrakPasienView
{
	private $prosespasien; //presenter yang dapat berinteraksi langsung dengan view
	private $tpl;

	function __construct()
	{
		//konstruktor
		$this->prosespasien = new ProsesPasien();
	}

	function tampil()
	{
		$this->prosespasien->prosesDataPasien();
		$data = null;

		//semua terkait tampilan adalah tanggung jawab view
		for ($i = 0; $i < $this->prosespasien->getSize(); $i++) {
			$no = $i + 1;
			$data .= "<tr>
			<td>" . $no . "</td>
			<td>" . $this->prosespasien->getNik($i) . "</td>
			<td>" . $this->prosespasien->getNama($i) . "</td>
			<td>" . $this->prosespasien->getTempat($i) . "</td>
			<td>" . $this->prosespasien->getTl($i) . "</td>
			<td>" . $this->prosespasien->getGender($i) . "</td>
			<td>" . $this->prosespasien->getEmail($i) . "</td>
			<td>" . $this->prosespasien->getTelp($i) . "</td>
			<td>
				<a href='form.php?id=" . $this->prosespasien->getId($i) . "' class='btn btn-warning' '>Edit</a>
				<a href='index.php?id_hapus=" . $this->prosespasien->getId($i) . "' class='btn btn-danger' '>Hapus</a>
	 		</td>";
		}
		// Membaca template skin.html
		$this->tpl = new Template("templates/skin.html");

		// Mengganti kode Data_Tabel dengan data yang sudah diproses
		$this->tpl->replace("DATA_TABEL", $data);

		// Menampilkan ke layar
		$this->tpl->write();
	}

	function form($id)
	{
		$data = null;
		$action = 'Create';

		$nik = '';
		$nama = '';
		$tempat = '';
		$tl = '';
		$gender = '';
		$email = '';
		$telp = '';

		if ($id != null) {
			$action = 'Update';
			$this->prosespasien->prosesSatuPasien($id);

			$nik = $this->prosespasien->getNik(0);
			$nama = $this->prosespasien->getNama(0);
			$tempat = $this->prosespasien->getTempat(0);
			$tl = $this->prosespasien->getTl(0);
			$gender = $this->prosespasien->getGender(0);
			$email = $this->prosespasien->getEmail(0);
			$telp = $this->prosespasien->getTelp(0);
		}

		//semua terkait tampilan adalah tanggung jawab view
		$data .= "<br />

			<label> NIK: </label>
			<input
			  type='text'
			  name='nik'
			  class='form-control'
			  value='" . $nik . "'
			/>
			<br />
  
			<label> Nama: </label>
			<input
			  type='text'
			  name='nama'
			  class='form-control'
			  value='" . $nama . "'
			/>
			<br />

			<label> Tempat: </label>
			<input
			  type='text'
			  name='tempat'
			  class='form-control'
			  value='" . $tempat . "'
			/>
			<br />
  
			<label> Tanggal Lahir: </label>
			<input
			  type='text'
			  name='tl'
			  class='form-control'
			  value='" . $tl . "'
			/>
			<br />
  
			<label> Gender: </label>
			<input
			  type='text'
			  name='gender'
			  class='form-control'
			  value='" . $gender . "'
			/>
			<br />

			<label> Email: </label>
			<input
			  type='text'
			  name='email'
			  class='form-control'
			  value='" . $email . "'
			/>
			<br />

			<label> Telp: </label>
			<input
			  type='text'
			  name='telp'
			  class='form-control'
			  value='" . $telp . "'
			/>
			<br />"
		;

		// Membaca template skin.html
		$this->tpl = new Template("templates/skin_form.html");

		// Mengganti kode Data_Tabel dengan data yang sudah diproses
		$this->tpl->replace("ACTION_NAME", $action);
		$this->tpl->replace("FORM_DATA", $data);

		// Menampilkan ke layar
		$this->tpl->write();
	}

	function create($data)
	{
		$this->prosespasien->createPasien($data);
		header("location:index.php");
	}
	function update($id, $data)
	{
		$this->prosespasien->updatePasien($id, $data);
		header("location:index.php");
	}
	function delete($id)
	{
		$this->prosespasien->deletePasien($id);
		header("location:index.php");
	}
}