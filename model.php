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

  
		
		public function insert()
				{
					if (isset($_POST['submit'])) 
					{
						$name = $_POST['name'];
						$email = $_POST['email'];
						$mobile = $_POST['mobile'];
						$address = $_POST['address']; 
  
						$query = "INSERT INTO records (name, email, mobile, address) VALUES (?, ?, ?, ?)";
						$stmt = $this->conn->prepare($query);
						if ($stmt) 
						{ 
							$stmt->bind_param("ssss", $name, $email, $mobile, $address);
							if ($stmt->execute()) 
							{
								echo "<script>alert('records added successfully');</script>";
							} 
							else 
							{
								echo "<script>alert('failed');</script>";
							}
							$stmt->close();
						} 
						 
						echo "<script>window.location.href = 'index.php';</script>";
					}
				}






				// Better for show all data in tables
				public function fetch() {
					$data = array();
					$query = "SELECT * FROM records";
					$stmt = $this->conn->prepare($query); 
					if ($stmt->execute()) {
						$result = $stmt->get_result(); 
						while ($row = $result->fetch_assoc()) {
							$data[] = $row;
						}
					} 
					return $data;
				}
				






		//Delete
		public function delete($id) {
			$query = "DELETE FROM records WHERE records.id = '$id'";
			if ($sql = $this->conn->query($query)) {
				echo "<script>alert('Delete successful');</script>";
				echo "<script>window.location.href = 'records.php';</script>";
				return true;
			} else {
				return false;
			}
		}
		



		// VIEW
		 	





		public function edit($id)
			{
				$data = null; 
				try { 
					$query = "SELECT * FROM records WHERE id = ?";
					$stmt = $this->conn->prepare($query);
					$stmt->bind_param("i", $id);  
					$stmt->execute(); 
					$result = $stmt->get_result(); 
					if ($result->num_rows > 0) { 
						$data = $result->fetch_assoc();
					} 
					$stmt->close();
				} catch (Exception $e) { 
					echo "Error: " . $e->getMessage();
				} 
				return $data;
			}
  
			public function update($id) {
				if (isset($_POST['update'])) {
					// Sanitize user input to prevent SQL injection and other malicious activities
					$name = mysqli_real_escape_string($this->conn, $_POST['name']);
					$mobile = mysqli_real_escape_string($this->conn, $_POST['mobile']);
					$email = mysqli_real_escape_string($this->conn, $_POST['email']);
					$address = mysqli_real_escape_string($this->conn, $_POST['address']);
			
					// Prepare the query using parameterized statements to prevent SQL injection
					$query = "UPDATE records SET name=?, email=?, mobile=?, address=? WHERE id=?";
					$stmt = mysqli_prepare($this->conn, $query);
					mysqli_stmt_bind_param($stmt, "ssssi", $name, $email, $mobile, $address, $id);
			
					if (mysqli_stmt_execute($stmt)) {
						echo "<script>alert('Record updated successfully');</script>";
						echo "<script>window.location.href = 'edit.php?id=$id';</script>";
					} else {
						echo "Error updating record: " . mysqli_error($this->conn);
					}
				}
			}

			// SELECT table only
			public function selectAll($tables)
			{
				$tables = $this->conn->real_escape_string($tables); 
				$query = "SELECT * FROM userlog"; 
				$result = $this->conn->query($query); 
				if ($result) { 
					$rows = $result->fetch_all(MYSQLI_ASSOC);  
					$result->free_result(); 
					return $rows;
				} else { 
					die("Error executing the query: " . $this->conn->error);
				}
			}  
	}
	



	
	class userlog
	{
		private $server = "localhost";
		private $username = "root";
		private $password = "";
		private $db = "test";
		private $conn;

		public function __construct() {
			$this->conn = new mysqli($this->server, $this->username, $this->password, $this->db); 
			if ($this->conn->connect_errno) {
				die("Connection failed: " . $this->conn->connect_error);
			}
		}

		


		
		// public function selectAll($tables)
		// 	{
		// 		// Sanitize the table name to prevent SQL injection
		// 		$tables = $this->conn->real_escape_string($tables);  
		// 		$query = "SELECT * FROM person";  
		// 		$result = $this->conn->query($query); 
		// 		if ($result) { 
		// 			$rows = $result->fetch_all(MYSQLI_ASSOC);  
		// 			$result->free_result(); 
		// 			return $rows;
		// 		} else { 
		// 			die("Error executing the query: " . $this->conn->error);
		// 		}
		// 	} 
			
			public function selectAll() {
				$data = array();
				$query = "SELECT * FROM person";
				$stmt = $this->conn->prepare($query); 
				if ($stmt->execute()) {
					$result = $stmt->get_result(); 
					while ($row = $result->fetch_assoc()) {
						$data[] = $row;
					}
				} 
				return $data;
			}

			






			public function insert()
				{
					if (isset($_POST['submit'])) 
					{
						$name = $_POST['name']; 
						$query = "INSERT INTO person (name ) VALUES (?)";
						$stmt = $this->conn->prepare($query);
						$stmt->bind_param("s", $name);
						return $stmt->execute();
						echo "<script>window.location.href = 'index.php';</script>";
					}
				}

				public function delete($id) {
					$query = "DELETE FROM person WHERE id = ?"; 
					if ($stmt = $this->conn->prepare($query)) {
						$stmt->bind_param("i", $id);
						$stmt->execute();
						$stmt->close();
						return true; // Operation successful
						echo "<script>alert('Deleted added successfully');</script>";
						echo "<script>window.location.href = 'records.php';</script>";
					} else {
						return false; // Operation failed
					}
				}
				


				public function fetch_single($id) {
					$data = null;
					$query = "SELECT * FROM person WHERE id = ?";
					
					if ($stmt = $this->conn->prepare($query)) {
						$stmt->bind_param("i", $id);
						$stmt->execute();
						$result = $stmt->get_result();
						
						if ($result->num_rows == 1) {
							$data = $result->fetch_assoc();
						} 
					} 
					return $data;
				}
				



				public function edit($id)
					{
						$data = null; 
						try { 
							$query = "SELECT * FROM person WHERE id = ?";
							$stmt = $this->conn->prepare($query);
							$stmt->bind_param("i", $id);  
							$stmt->execute(); 
							$result = $stmt->get_result(); 
							if ($result->num_rows > 0) { 
								$data = $result->fetch_assoc();
							} 
							$stmt->close();
						} catch (Exception $e) { 
							echo "Error: " . $e->getMessage();
						} 
						return $data;
					}
  
			public function update($id) {
				if (isset($_POST['update'])) {
					// Sanitize user input to prevent SQL injection and other malicious activities
					$name = mysqli_real_escape_string($this->conn, $_POST['name']);
					$age = mysqli_real_escape_string($this->conn, $_POST['age']); 
					// Prepare the query using parameterized statements to prevent SQL injection
					$query = "UPDATE person SET name=?, age=? WHERE id=?";
					$stmt = mysqli_prepare($this->conn, $query);
					mysqli_stmt_bind_param($stmt, "ssi", $name, $age, $id);
			
					if (mysqli_stmt_execute($stmt)) {
						echo "<script>alert('Person updated successfully');</script>";
						echo "<script>window.location.href = 'edit.php?id=$id';</script>";
					} else {
						echo "Error updating Person: " . mysqli_error($this->conn);
					}
				}
			}
	
	}

 ?>