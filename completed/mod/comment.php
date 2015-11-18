<?php
if (!empty($_POST['full_name']) && !empty($_POST['email']) && !empty($_POST['comment'])) {
	
	$full_name = $_POST['full_name'];
	$email = $_POST['email'];
	$comment = $_POST['comment'];
	
	try {
		
		$objDb = new PDO('mysql:host=localhost;dbname=feedback', 'root', 'password');
		$objDb->exec('SET CHARACTER SET utf8');
		
		$sql = "INSERT INTO `comments` (`full_name`, `email`, `comment`)
				VALUES (?, ?, ?)";
		$statement = $objDb->prepare($sql);
		
		if ($statement->execute(array($full_name, $email, $comment))) {
			
			$id = $objDb->lastInsertId();
			
			$sql = "SELECT *,
					DATE_FORMAT(`date`, '%d/%m/%Y') AS `date_formatted`
					FROM `comments`
					WHERE `id` = ?";
			
			$statement = $objDb->prepare($sql);
			$statement->execute(array($id));
			$post = $statement->fetch(PDO::FETCH_ASSOC);
			
			$comment  = '<div class="comment">';
			$comment .= '<a href="#" class="remove flr" data-id="';
			$comment .= $post['id'];
			$comment .= '">Remove</a>';
			$comment .= '<span class="name">Posted by ';
			$comment .= htmlentities(stripslashes($post['full_name']));
			$comment .= ' on <time datetime="';
			$comment .= date('Y-m-d', $post['date']);
			$comment .= '">';
			$comment .= $post['date_formatted'];
			$comment .= '</time></span><p>';
			$comment .= htmlentities(stripslashes($post['comment']));
			$comment .= '</p></div>';
			
			echo json_encode(array('error' => false, 'comment' => $comment));
			
			
		} else {
			echo json_encode(array('error' => true, 'case' => 3));
		}
		
		
	} catch(Exception $e) {
		echo json_encode(array('error' => true, 'case' => 2));
	}
	
} else {
	echo json_encode(array('error' => true, 'case' => 1));
}






