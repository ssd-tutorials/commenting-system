<?php
try {
	
	$objDb = new PDO('mysql:host=localhost;dbname=feedback', 'root', 'password');
	$objDb->exec('SET CHARACTER SET utf8');
	
	$sql = "SELECT *,
			DATE_FORMAT(`date`, '%d/%m/%Y') AS `date_formatted`
			FROM `comments`
			WHERE `active` = 1
			ORDER BY `date` ASC";
	$statement = $objDb->query($sql);
	$posts = $statement->fetchAll(PDO::FETCH_ASSOC);
	
	
} catch(Exception $e) {
	echo $e->getMessage();
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Commenting with PHP and jQuery</title>
	<meta name="description" content="Commenting with PHP and jQuery" />
	<meta name="keywords" content="Commenting with PHP and jQuery" />
	<link href="/css/core.css" rel="stylesheet" type="text/css" />
	<!--[if lt IE 9]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>
<body>

<div id="wrapper">

	<div id="comments">
		
		<?php if (!empty($posts)) { ?>
			
			<?php foreach($posts as $row) { ?>
				
				<div class="comment">
					<a href="#" class="remove flr"
						data-id="<?php echo $row['id']; ?>">
							Remove
					</a>
					<span class="name">
						Posted by <?php echo htmlentities(stripslashes($row['full_name'])); ?> 
						on <time datetime="<?php echo date('Y-m-d', $row['date']); ?>"><?php echo $row['date_formatted']; ?></time>
					</span>
					<p><?php echo htmlentities(stripslashes($row['comment'])); ?></p>
				</div>
				
			<?php } ?>
			
		<?php } else { ?>
		
			<p>There are currently no comments.</p>
		
		<?php } ?>
		
	</div>
	
	<form method="post">
		<table class="tblInsert">
			<tr>
				<td>
					<input type="text" name="full_name" 
						class="field" placeholder="Your full name *" />
				</td>			
			</tr>
			<tr>
				<td>
					<input type="text" name="email" 
						class="field" placeholder="Your email address *" />
				</td>			
			</tr>
			<tr>
				<td>
					<textarea name="comment" class="area"
						placeholder="Your comment *"></textarea>
				</td>			
			</tr>
			<tr>
				<td>
					<a href="#" class="button submit">Submit comment</a>
				</td>
			</tr>
		</table>
	</form>

</div>



<script src="/js/jquery-1.7.1.min.js" type="text/javascript"></script>
<script src="/js/core.js" type="text/javascript"></script>
</body>
</html>