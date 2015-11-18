<?php
if (!empty($_POST['id'])) {
	
	$id = $_POST['id'];
	
	try {
		
		$objDb = new PDO('mysql:host=localhost;dbname=feedback', 'root', 'password');
		$objDb->exec('SET CHARACTER SET utf8');
		
		$sql = "DELETE FROM `comments`
				WHERE `id` = ?";
		
		$statement = $objDb->prepare($sql);
		
		if ($statement->execute(array($id))) {
			
			$sql = "SELECT *
					FROM `comments`
					WHERE `active` = 1
					ORDER BY `date` ASC";
					
			$statement = $objDb->query($sql);
			$posts = $statement->fetchAll(PDO::FETCH_ASSOC);
			
			echo json_encode(array('error' => false, 'posts' => count($posts)));
			
		} else {
			echo json_encode(array('error' => true, 'case' => 3));
		}
		
		
	} catch(Exception $e) {
		echo json_encode(array('error' => true, 'case' => 2));
	}
	
} else {
	echo json_encode(array('error' => true, 'case' => 1));
}




