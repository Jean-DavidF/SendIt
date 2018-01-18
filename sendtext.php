<?php

use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';

?>

<html>
<head>
    <meta charset="UTF-8">

    <title>SendText</title>

    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0">

    <!-- Style -->
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/sendtext.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato|Philosopher:400,400i,700,700i">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Javascript -->
    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/sendtext.js"></script>
    <script type="text/javascript" src="js/functions.js"></script>
</head>

<?php
    // Set parameters
    require 'parameters.php';
?>
    <body>

        <div id="alerts"></div>

        <ul id="progressbar">
            <li class="active">Ajout de contact</li>
            <li>Envoi des mails</li>
            <li>Terminé</li>
        </ul>

        <div class="get-csv">
            <button class="open-csv" type="button">+</button>
            <ul class="list-csv hide">
                <li><a href="img/LOGO_IUT_LENS.jpg">MMI 1</a></li>
                <li><a href="img/LOGO_IUT_LENS.jpg">MMI 2</a></li>
                <li><a href="csv/lp_creaweb.csv" download>LP Créaweb</a></li>
            </ul>
        </div>

        <div class="wrapper">
            <div class="container 1" id="container-1">
                <div class="header">
                    <h1>SendText</h1>
                    <p>Ajout de contact</p>
                </div>
                <div class="content content-text" id="content-1">
                    <form id="form-sendtext" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" enctype="multipart/form-data">
                        <label for="file">Insérez le fichier de contacts</label>
                        <div class="input-form">
                            <div class="file-upload-wrapper file-upload-block" data-text="Sélectionnez votre fichier">
                                <input name="file" id="file" type="file" class="file-upload-field" value="">
                            </div>
                        </div>
                        <br />
                        <label for="name">Indiquez votre nom</label>
                        <input type="text" placeholder="Exemple : M. Dupont" name="name">
                        <br />
                        <label for="object">Indiquez l'objet du mail</label>
                        <input type="text" placeholder="Exemple : Informations horaires" name="object">
                        <br />
                        <label for="message">Saisissez votre message</label>
                        <textarea id="mailMessage" rows="5" placeholder="Exemple : Bonjour, ..." name="message"></textarea>
                        <br />
                        <br />
                        <label for="attachment">Ajouter une ou plusieurs pièces jointes (optionnel)</label>                        
                        <div class="input-form">
                            <div class="file-upload-wrapper attachment-upload-block" data-text="Sélectionnez votre fichier">
                                <input name="attachment" id="attachment" type="file" class="file-upload-field" value="">
                            </div>
                        </div>
                        <br />                        
                        <input id="submit" class="submit-text text-button text-button-submit" type="submit" value="Valider" name="submit">
                        <button style="display: none;" class="submit-text text-button text-button-load" type="button">Chargement <i class="fa fa-cog fa-spin fa-2x fa-fw"></i></button>
                    </form>
                </div>
            </div>

            <div class="container" id="container-2">
                <div class="header">
                    <h1>SendText</h1>
                    <p>Envoi des mails</p>
                </div>
                <div class="content" id="content-2">
                    <?php
                        if(isset($_POST)) {
                            if ( isset($_FILES["file"])) {
                                $file = $_FILES["file"]["name"];
                                $name = $_POST["name"];
                                $object = $_POST["object"];
                                $message = $_POST["message"];
                                move_uploaded_file($_FILES["file"]["tmp_name"],$file);
                                if (isset($file)) {
                                    $row = 1;
                                    $tab = array();
                                    echo '<form method="post" id="form-sendtext-mails">';
                                    echo '<input type="hidden" name="nameValue" value="'.$name.'" />';            
                                    echo '<input type="hidden" name="objectValue" value="'.$object.'" />';  
                                    echo '<input type="hidden" name="messageValue" value="'.$message.'" />';  
                                    echo '<div class="table-content">';     
                                    echo '<table class="tabletext" align="center">';
                                    echo '<thead><tr><th>ID</th><th>N° Étudiant</th><th>Email</th></thead>';
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
                                                    '.$etudiant['id'].'</td><td>'.$etudiant['numero'].'</td><td>'.$etudiant['email'].'</td></tr>';                     
                                                }
                                            }                    

                                        }        
                                        fclose($handle);
                                        unlink($file);
                                    }
                                    echo '</table>';
                                    echo '</div>';
                                    echo '<button id="sendmail" type="submit" class="submit mail-button mail-button-submit" name="sendMail">Envoyer les messages</button>';
                                    echo '<button style="display:none;" type="button" class="submit mail-button mail-button-load">Chargement <i class="fa fa-cog fa-spin fa-2x fa-fw"></i></button>';
                                    echo '</form>';            
                                }
                            }
                        }
                    ?>
                </div>
            </div>

            <div class="container" id="container-3">
                <div class="header">
                    <h1>SendText</h1>
                    <p>Terminé</p>
                </div>
                <div class="content" id="content-3">
                    <?php
                        // Send email
                        if(isset($_POST["nameValue"]) && isset($_POST["objectValue"]) && isset($_POST["messageValue"])) {
                            $name = $_POST["nameValue"];
                            $object = $_POST["objectValue"];
                            $message = $_POST["messageValue"];
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
                                $mail->Subject = 'Objet : '. $object . '';
                                $mail->Body = '<div style="max-width:550px; min-width:320px;  background-color: white; border: 1px solid #DDDDDD; margin-right: auto; margin-left: auto;">
                                                    <div style="margin-left:30px;margin-right:30px;">
                                                        <p>&nbsp;</p>
                                                        <p style="font-family:Lato, serif;font-weight: bold; color: #000232;font-size: 15px;">LP-CréaWeb</p>
                                                        <hr style="margin-top:10px;margin-bottom:65px;border:none;border-bottom:1px solid #e71d73;" />
                                                        <h1 style="font-family: Philosopher, serif; font-weight: normal; color: #000232; text-align: center; margin-bottom: 65px;font-size: 20px; letter-spacing: 6px;font-weight: normal; border: 2px solid black; padding: 15px;">VOUS AVEZ UN NOUVEAU MESSAGE !</h1>
                                                        <h3 style="font-family:Lato, serif;font-weight:500;">Message reçu par : <span style="border-bottom: 1px solid #e71d73;">' . $name . ' : ' . '</span></h3>
                                                        <p style="text-align:center;font-family:Lato, serif; font-size: 18px; margin-left: auto; margin-right: auto;;color: #000232;line-height:1.5;margin-bottom:75px;">"'.$message.'"</p>
                                                        <p style="text-align:center;font-family:Lato, serif; font-size: 18px; margin-left: auto; margin-right: auto;;color: #000232;line-height:1.5;margin-bottom:75px;">Merci de ne pas répondre à ce mail</p>
                                                        <hr style="margin-top:10px;margin-top:75px;border:none;border-bottom:1px solid #e71d73;" />
                                                        <p style="text-align:center;margin-bottom:15px;"><small style="text-align:center;font-family:Lato, serif;font-size:10px;color#000232;">Fait avec <span style="color:#e71d73;">&hearts;</span> à Lens</small></p>
                                                        <p>&nbsp;</p>
                                                    </div>
                                                </div>';
                                $mail->AltBody = 'This is a plain-text message body';
                                if (!$mail->send()) {
                                    echo "<div class='msg m-error'><i class='fa fa-times'></i><p>Erreur Mailer : " . $mail->ErrorInfo . "</p></div>";
                                } else {
                                    echo "<div class='msg m-success'><i class='fa fa-check'></i><p> Messages envoyés avec succès !</p></div>";
                                    echo "<div class='again'><a href='choice.php'>Retour à l'accueil</a></div>";
                                    echo "<div class='credits'>Développé avec <i class='fa fa-heart'></i> par <a href='http://thomaslaigneau.com/'>Thomas Laigneau</a> et <a href='https://github.com/Jean-DavidF'>Jean-David Flament</a></div>";
                                }
                            }
                        }

                        ?>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>SendIt, IUT de Lens</p>
            <a href="http://www.iut-lens.univ-artois.fr/"><img src="img/LOGO_IUT_LENS.jpg" alt="logo-iut-lens" /></a>
        </div>
    </body>
</html>