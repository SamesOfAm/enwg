<?php
if(isset($_POST['submit'])){
    $to = $_POST['emailRecipient'];
    $from = $_POST['emailSender'];
    $senderName = $_POST['nameSender'];
    $subject = $senderName . ' sendet Ihnen eine Weihnachtsbotschaft';
    $subject2 = "Kopie Ihrer Weihnachtsbotschaft";
    $message = nl2br($_POST['userInput']);
    $encodedMessage = base64_encode($_POST['userInput']);
    $image = $_POST['imageSelect'];
    $link = "https://klapproth-koch.de/grusskarte/enwg/?text=" . $encodedMessage . "&image=" . $image;
    $emailContent = '<html lang="de"><head></head><body><p>' . $senderName . ' sendet Ihnen eine Weihnachtsbotschaft. <a href="' . $link . '">Klicken Sie hier, um sich die Botschaft anzuschauen</a></p></body></html>';
    $message2 = '<html>
        <head>
            <title>Weihnachtsbotschaft</title>
            <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Merriweather:400,400i">
            <style>
                body {font-family:"Merriweather";}
            </style>
        </head>
        <body>
        <p>Diese Weihnachtsbotschaft haben Sie an ' . $_POST['emailRecipient'] . ' gesendet: ' . '<br><a href=' . $link . '>Botschaft ansehen</a></p>
        </body>
        </html>';
    $headers = "From:" . $from . "\r\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n";
    $headers .= "Bcc: " . $to . "\r\n";
    $headers2 = "From:" . $from .  "\r\n";
    $headers2 .= "Content-type: text/html; charset=utf-8\r\n";
    mail("weihnachten@enwg.de",$subject,$emailContent,$headers);
    if(isset ($_POST['getCopy'])) {
        mail($from, $subject2, $message2, $headers2);
    }
    header('Location: verschickt.php');
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Merriweather:400,400i" type="text/css">
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
    <div id="background" <?php if($_GET['image'] != null): ?>style="background-image:url('img<?php echo $_GET['image']; ?>.jpg')" <?php endif; ?>>
        <div class="wrapper">
            <div class="content">
                <?php if($_GET['image'] != null): ?>
                <div class="output">
                    <div class="message">
                        <div class="logo">
                            <div class="logo-placeholder">
                                <img src="ENWG.jpg">
                            </div>
                        </div>
                        <div class="address">
                            <div class="address-text">
                                <p>ENWG Weimar</p>
                                <p>Industriestraße 14</p>
                                <p>99423 Weimar</p>
                            </div>
                        </div>
                        <h1>Frohes Fest</h1>
                        <p>Die ENWG Weimar wünschen Ihnen und Ihren Liebsten eine fröhliche Weihnachten. Machen Sie es sich in der besinnlichen Zeit gemütlich - mit Energie der ENWG!</p>
                        <p><?php $decoded = base64_decode($_GET['text']); echo nl2br($decoded)?></p>
                    </div>
                </div>
                <?php endif; ?>
                <?php if($_GET['image'] == null): ?>
                    <div class="input">
                        <form class="form" name="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" onsubmit="return validateForm();" >
                            <div class="logo">
                                <div class="logo-placeholder">
                                    <img src="ENWG.jpg">
                                </div>
                            </div>
                            <div class="address">
                                <div class="address-text">
                                    <p>ENWG Weimar</p>
                                    <p>Industriestraße 14</p>
                                    <p>99423 Weimar</p>
                                </div>
                            </div>
                            <input name="nameSender" required type="text" placeholder="Ihr Name"><div id="nameSenderError" class="error-bubble">Bitte geben Sie Ihren Namen ein</div>
                            <input name="emailSender" required type="text" placeholder="Ihre E-Mail-Adresse"><div id="emailSenderError" class="error-bubble">Bitte geben Sie eine gültige E-Mail-Adresse als Absender ein</div>
                            <input name="emailRecipient" required type="text" placeholder="E-Mail des Empfängers"><div id="emailRecipientError" class="error-bubble">Bitte geben Sie eine gültige E-Mail-Adresse für den Empfänger ein</div>
                            <div class="recipient-info">
                                (Mehrere Adressen mit Komma trennen)
                            </div>
                            <div class="copyOptIn">
                                <input type="checkbox" id="getCopy" name="getCopy">
                                <label for="getCopy">Ich möchte eine Kopie erhalten</label>
                            </div>
                            <p class="info-text">Wählen Sie ein Hintergrundbild</p>
                            <div id="select-image" class="img-options">
                                <ul>
                                    <li data-option="" data-value="1" onclick="selectImage(this)" class="button selected">
                                        <span>1</span>
                                    </li>
                                    <li data-option="" data-value="2" onclick="selectImage(this)" class="button">
                                        <span>2</span>
                                    </li>
                                    <li data-option="" data-value="3" onclick="selectImage(this)" class="button">
                                        <span>3</span>
                                    </li>
                                    <li data-option="" data-value="4" onclick="selectImage(this)" class="button">
                                        <span>4</span>
                                    </li>
                                    <li data-option="" data-value="5" onclick="selectImage(this)" class="button">
                                        <span>5</span>
                                    </li>
                                    <li data-option="" data-value="6" onclick="selectImage(this)" class="button">
                                        <span>6</span>
                                    </li>
                                    <li data-option="" data-value="7" onclick="selectImage(this)" class="button">
                                        <span>7</span>
                                    </li>
                                    <li data-option="" data-value="8" onclick="selectImage(this)" class="button">
                                        <span>8</span>
                                    </li>
                                    <li data-option="" data-value="9" onclick="selectImage(this)" class="button">
                                        <span>9</span>
                                    </li>
                                </ul>
                            </div>
                            <select name="imageSelect" id="imageSelect" onchange="onImageSelect();">
                                <option selected="selected">1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                                <option>6</option>
                                <option>7</option>
                                <option>8</option>
                                <option>9</option>
                            </select>
                            <div class="info-text-custom">
                                <p>Botschaft:</p>
                            </div>
                            <div class="generic-text">
                                <p>Die ENWG Weimar wünschen Ihnen und Ihren Liebsten ein frohes Weihnachtsfest. Machen Sie es sich in der besinnlichen Zeit gemütlich - mit Energie der ENWG!</p>
                                <div class="customWrapper">
                                    <input type="checkbox" id="addCustomMessage" onclick="showCustomMessage('customMessage', this);">
                                    <label for="addCustomMessage">Eigenen Text hinzufügen</label>
                                </div>
                            </div>
                            <textarea id="customMessage" class="user-input" name="userInput" type="textarea" rows="8" cols="50" resize="none" placeholder="Ihre Weihnachtsbotschaft" accept-charset="UTF-8"></textarea>
                            <div class="privacy">
                                <input type="checkbox" id="consent" name"consent" required><label class="consent-label" for="consent"> Ja, ich stimme den <a href="privacy.html" target="_blank">Datenschutzbestimmungen</a> zu.</label>
                            </div>
                            <input type="submit" name="submit" value="Weihnachts-Freude versenden">
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <canvas id="content"></canvas>
        <script src="script.js"></script>
    </div>
</body>
</html>
