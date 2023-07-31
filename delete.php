<?php 

	include 'model.php';
	// $model = new Model();
	$model = new userlog();
	$id = $_REQUEST['id'];
	$delete = $model->delete($id); 
	if ($delete) {
		echo "<script>alert('delete successfully');</script>";
		echo "<script>window.location.href = 'records.php';</script>";
	}

 ?>

					public function delete($id) {
					$data = null;
					$query = "DELETE FROM person WHERE person.id = ?'";
				  
					if ($stmt = $this->conn->prepare($query)) {
						$stmt->bind_param("i", $id);
						$stmt->execute();
						$result = $stmt->get_result();
						if($result->num_rows ==1 ){
							$data = $result->fetch_assoc();
						}
						return $data; 
					}  
				}