# SendMarks
SendMarks application developped by <a href="https://github.com/ThomasLaigneau">Thomas Laigneau</a> and <a href="https://github.com/Jean-DavidF">Jean-David Flament</a>

### Requirements
Create a "parameters.php" file at the project root with this content :

```php
<?php
	$user = "{Your username database}";
	$pass = "{Your password database}";
	$db = new PDO( 'mysql:host={Your database host};dbname={Your database name}', $user, $pass );
	$sql = "SELECT * FROM etudiant";
	$query = $db->prepare( $sql );
	$query->execute(); 
	$etudiants = $query->fetchAll( PDO::FETCH_ASSOC );
?>
```

Then, create a "email_account.php" file at the project root too :

```php
<?php
	$mail->Username = "{Your username mail}";
	$mail->Password = "{Your password mail}";
	$mail->setFrom('{Your email address}');
?>
```

Finally, go to your terminal, change your directory to the project folder and write :

```
composer install
```

Don't forget ! You need a database with you're students id's, students numbers and email adress, like this example :

id | number | email
------------ | ------------- | -------------
1 | 20183678 | johndoe@mail.com

<p style="text-align: center;">Enjoy and send some marks !</p>
