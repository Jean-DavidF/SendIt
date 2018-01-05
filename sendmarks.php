<?php

use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';

?>

<html>
<head>
    <meta charset="UTF-8">

    <title>SendMark</title>

    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0">

    <!-- Style -->
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://fonts.googleapis.com/css?family=Lato|Philosopher:400,400i,700,700i" rel="stylesheet">

    <!-- Javascript -->
    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/functions.js"></script>
</head>

<?php
    // Set parameters
    require 'parameters.php';
?>
    <body>

        <div id="alerts"></div>

        <ul id="progressbar">
            <li class="active">Ajout des notes</li>
            <li>Envoi des mails</li>
            <li>Terminé</li>
        </ul>

        <div class="wrapper">
            <div class="container">
                <div class="header">
                    <h1>IUT de Lens</h1>
                    <p>Ajout des notes</p>
                </div>
                <div class="content" id="content-1">
                    <form id="form-sendmarks" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" enctype="multipart/form-data">
                        <label for="file">Insérez le fichier de note</label>
                        <div class="input-form">
                            <div class="file-upload-wrapper" data-text="Sélectionnez votre fichier">
                                <input name="file" id="file" type="file" class="file-upload-field" value="">
                            </div>
                        </div>
                        <br />
                        <label for="matiere">Indiquez une matière</label>
                        <input type="text" placeholder="Exemple : Algorithmique" name="matiere">
                        <br />
                        <label for="bareme">Indiquez votre barême</label>
                        <input type="text" placeholder="Exemple : / 20" name="bareme">
                        <br />
                        <input id="submit" class="submit" type="submit" value="Valider" name="submit">
                    </form>
                </div>
            </div>

            <div class="container">
                <div class="header">
                    <h1>IUT de Lens</h1>
                    <p>Envoi des mails</p>
                </div>
                <div class="content" id="content-2">
                    <?php
                        if(isset($_POST)) {
                            if ( isset($_FILES["file"])) {
                                $file = $_FILES["file"]["name"];
                                $matiere = $_POST["matiere"];
                                $bareme = $_POST["bareme"];
                                move_uploaded_file($_FILES["file"]["tmp_name"],$file);
                                if (isset($file)) {
                                    $row = 1;
                                    $tab = array();
                                    echo '<form method="post">';
                                    echo '<input type="hidden" name="matiereValue" value="'.$matiere.'" />';            
                                    echo '<input type="hidden" name="baremeValue" value="'.$bareme.'" />';    
                                    echo '<div class="table-content">';     
                                    echo '<table align="center">';
                                    echo '<thead><tr><th>ID</th><th>N° Étudiant</th><th>Email</th><th>Note</th></thead>';
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
                                    echo '</div>';
                                    echo '<button id="sendmail" type="submit" class="submit" name="sendMail">Envoyer les notes</button>';
                                    echo '</form>';            
                                }
                            }
                        }
                    ?>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>SendMarks, IUT de Lens</p>
            <a href="http://www.iut-lens.univ-artois.fr/"><img src="img/LOGO_IUT_LENS.jpg" alt="logo-iut-lens" /></a>
        </div>
    </body>
</html>


<?php

// Send email
if(isset($_POST["sendMail"])) {
    $matiere = $_POST["matiereValue"];
    $bareme = $_POST["baremeValue"];
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
                                <p style="text-align:center;font-family:Palatino Linotype, Book Antiqua, Palatino, serif;font-size: 18px; margin-left: auto; margin-right: auto;;color: #666;line-height:1.5;margin-bottom:75px;">'.$case["note"]. ' '.$bareme.'</p>
                                <p style="text-align:center;font-family:Palatino Linotype, Book Antiqua, Palatino, serif;font-size: 18px; margin-left: auto; margin-right: auto;;color: #666;line-height:1.5;margin-bottom:75px;">Merci de ne pas répondre à ce mail</p>
                                <hr style="margin-top:10px;margin-top:75px;" />
                                <p style="text-align:center;margin-bottom:15px;"><small style="text-align:center;font-family:Courier New, Courier, monospace;font-size:10px;color#666;">Fait avec <span style="color:red;">&hearts;</span> à Lens</small></p>
                                <p>&nbsp;</p>
                            </div>
                        </div>';
        $mail->AltBody = 'This is a plain-text message body';
        if (!$mail->send()) {
            echo "Erreur Mailer : " . $mail->ErrorInfo;
        } else {
            echo "Message envoyé !";
            // if (save_mail($mail)) {
            //     echo "Message saved!";
            // }
        }
    }
}

?>