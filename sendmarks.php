<?php

use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';

?>
<head>
    <meta charset="UTF-8">
</head>

<?php
    // Set parameters
    require 'parameters.php';
?>

<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
    <input type="file" id="file" name="file">
    <br />
    <label for="matiere">Indiquez une matière</label>
    <input type="text" placeholder="Algo.." name="matiere">
    <input type="submit" value="Valider" name="submit">
</form>


<?php

if(isset($_POST["submit"])) {
    if ( isset($_FILES["file"])) {
        $file = $_FILES["file"]["name"];
        $matiere = $_POST["matiere"];
        move_uploaded_file($_FILES["file"]["tmp_name"],$file);
        if (isset($file)) {
            $row = 1;
            $tab = array();
            echo '<form method="post">';
            echo '<input type="hidden" name="matiereValue" value="'.$matiere.'" />';            
            echo '<button id="sendmail" type="submit" name="sendMail">Envoyer les notes</button>';
            echo '<table border=1>';
            echo '<thead><tr><th>ID</th><th>Numéro Etudiant</th><th>Adresse mail</th><th>Note</th></thead>';
            if (($handle = fopen($file, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $num = count($data);
                    $row++;
                    for ($c=0; $c < $num; $c++) {
                        $value = explode(";",$data[$c]);
                    }              
                    foreach($etudiants as $etudiant){
                        if($etudiant['numero'] == $value[0]){ 
                            echo '<tr><td>
                            <input type="hidden" name="tableau['.$etudiant["id"].'][email]" value="'.$etudiant['email'].'" />
                            <input type="hidden" name="tableau['.$etudiant["id"].'][note]" value="'.$value[1].'" />
                            '.$etudiant['id'].'</td><td>'.$etudiant['numero'].'</td><td>'.$etudiant['email'].'</td><td>'.$value[1].'</td></tr>';                     
                        }
                    }                    

                }        
                fclose($handle);
                unlink($file);
            }
            echo '</table>';
            echo '</form>';            
        }
    }
}

if(isset($_POST["sendMail"])) {
    $matiere = $_POST["matiereValue"];
    foreach($_POST["tableau"] as $case){
        $mail = new PHPMailer;
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->isHTML();

        // Set email_account
        require 'email_account.php';

        $mail->addAddress($case["email"]);
        $mail->Subject = 'Nouvelle note dans la matière '. $matiere.'';
        $mail->Body = '<div style="max-width:550px; min-width:320px;  background-color: white; border: 1px solid #DDDDDD; margin-right: auto; margin-left: auto;">
                            <div style="margin-left:30px;margin-right:30px;">
                                <p>&nbsp;</p>
                                <p style="font-family:Verdana, Geneva, sans-serif;font-weight: bold; color: #3D3D3D;font-size: 15px;">LP-CréaWeb</p>
                                <hr style="margin-top:10px;margin-bottom:65px;border:none;border-bottom:1px solid red;" />
                                <h1 style="font-family: Tahoma, Geneva, sans-serif; font-weight: normal; color: #2A2A2A; text-align: center; margin-bottom: 65px;font-size: 20px; letter-spacing: 6px;font-weight: normal; border: 2px solid black; padding: 15px;">VOUS AVEZ UNE NOUVELLE NOTE !</h1>
                                <h3 style="font-family:Palatino Linotype, Book Antiqua, Palatino, serif;font-style:italic;font-weight:500;">Note dans la matière <span style="border-bottom: 1px solid red;">' . $matiere . ' : ' . '</span></h3>
                                <p style="text-align:center;font-family:Palatino Linotype, Book Antiqua, Palatino, serif;font-size: 18px; margin-left: auto; margin-right: auto;;color: #666;line-height:1.5;margin-bottom:75px;">'.$case["note"].' / 20</p>
                                <p style="text-align:center;font-family:Palatino Linotype, Book Antiqua, Palatino, serif;font-size: 18px; margin-left: auto; margin-right: auto;;color: #666;line-height:1.5;margin-bottom:75px;">Merci de ne pas répondre à ce mail</p>
                                <hr style="margin-top:10px;margin-top:75px;" />
                                <p style="text-align:center;margin-bottom:15px;"><small style="text-align:center;font-family:Courier New, Courier, monospace;font-size:10px;color#666;">Fait avec <span style="color:red;">&hearts;</span> à Lens</small></p>
                                <p>&nbsp;</p>
                            </div>
                        </div>';
        $mail->AltBody = 'This is a plain-text message body';
        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "Message sent!";
            if (save_mail($mail)) {
                echo "Message saved!";
            }
        }
    }
}

?>