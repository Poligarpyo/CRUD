<?php 

	Class Model{

		private $server = "localhost";
		private $username = "root";
		private $password = "";
		private $db = "oop_crud";
		private $conn;

		public function __construct(){
			try { 
				$this->conn = new mysqli($this->server,$this->username,$this->password,$this->db);
			} catch (Exception $e) {
				echo "connection failed" . $e->getMessage();
			}
		}

		public function insert(){ 
			if (isset($_POST['submit'])) {
				$name = $_POST['name'];
				$email = $_POST['email'];
				$mobile = $_POST['mobile'];
				$address = $_POST['address'];
				
				if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['mobile']) && isset($_POST['address'])) 
				{
					if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['mobile']) && !empty($_POST['address']) ) {
						
						$name = $_POST['name'];
						$mobile = $_POST['mobile'];
						$email = $_POST['email'];
						$address = $_POST['address'];

						$query = "INSERT INTO records (name,email,mobile,address) VALUES ('$name','$email','$mobile','$address')";
						if ($sql = $this->conn->query($query)) {
							echo "<script>alert('records added successfully');</script>";
							echo "<script>window.location.href = 'index.php';</script>";
						}else{
							echo "<script>alert('failed');</script>";
							echo "<script>window.location.href = 'index.php';</script>";
						}

					}else{
						echo "<script>alert('empty');</script>";
						echo "<script>window.location.href = 'index.php';</script>";
					}
				}
				else{
					echo 'ss';
				}
			} 
		}

		public function fetch(){
			$data = null;

			// "SELECT * FROM personal_information INNER JOIN family_background on personal_information.pds_id=family_background.pds_id
			// INNER JOIN child on personal_information.pds_id=child.pds_id";
		   
			$query = "SELECT * FROM records ";
			if ($sql = $this->conn->query($query)) {
				while ($row = mysqli_fetch_assoc($sql)) {
					$data[] = $row;
				}
			}
			return $data;
		}

		public function delete($id){

			$query = "DELETE FROM records where records.id = '$id'";
			if ($sql = $this->conn->query($query)) {
				return true;
			}else{
				return false;
			}
		}

		public function fetch_single($id){ 
			$data = null; 
			$query = "SELECT * FROM records INNER JOIN fam on records.id=fam.id INNER JOIN child on records.id=child.id WHERE records.id = '$id'";
			if ($sql = $this->conn->query($query)) {
				while ($row = $sql->fetch_assoc()) {
					$data = $row;
				}
			}
			return $data;
		}

		public function edit($id){

			$data = null;

			$query = "SELECT * FROM records WHERE records.id = '$id'";
			if ($sql = $this->conn->query($query)) {
				while($row = $sql->fetch_assoc()){
					$data = $row;
				}
			}
			return $data;
		}

		public function update($data){

			$query = "UPDATE records SET name='$data[name]', email='$data[email]', mobile='$data[mobile]', address='$data[address]' WHERE id='$data[id] '";

			if ($sql = $this->conn->query($query)) {
				return true;
			}else{
				return false;
			}
		}
	}

 ?>