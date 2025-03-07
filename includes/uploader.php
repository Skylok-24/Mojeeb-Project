<?php

$uploadDir = 'uploads/products';
function filterString($field)
{
    $field = filter_var(trim($field),FILTER_SANITIZE_SPECIAL_CHARS);
    if (empty($field)) {
        return false;
    }else {
        return $field;
    }
}

function filterEmail($field)
{
    $field = filter_var(trim($field),FILTER_SANITIZE_EMAIL);

    if (filter_var($field,FILTER_VALIDATE_EMAIL)) {
        return $field;
    }else {
        return false;
    }
}

function canUpload($file)
{
    $allowed = [
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'gif' => 'image/gif'
    ];

    $filetype = $file['type'];
    $filemimetype = mime_content_type($file['tmp_name']);

    $maxfilesize = 1024 * 1024;
    $filesize = $file['size'];
//        echo $filemimetype;
//    echo $filesize;
    if (!in_array($filemimetype,$allowed)) {
        return 'File Type Not Allowed';
    }
    if ($filesize > $maxfilesize) {
        return 'File Size Not Allowed . Allowed size : '.$maxfilesize;
    }else {
        return true;
    }
}

$nameError = $emailError = $textError = $fileError = '';
$name = $email = $text = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = filterString($_POST['name']);
    if (!$name) {
        $_SESSION['contact_form']['user'] = '';
        $nameError = 'Your Name is required';
    }else {
        $_SESSION['contact_form']['user'] = $name;
    }

    $email = filterEmail($_POST["email"]);
    if (!$email) {
        $_SESSION['contact_form']['email'] = '';
        $emailError = 'Your Email is Invalide';
    }else {
        $_SESSION['contact_form']['email'] = $email;
    }

    $text = filterString($_POST['text']);
    if (!$text) {
        $_SESSION['contact_form']['text'] = '';
        $textError = 'Text is required';
    }else {
        $_SESSION['contact_form']['text'] = $text;
    }

    $fileError = 'File is required';
    if (isset($_FILES['document']) && $_FILES['document']['error'] == 0) {
//        print_r($_FILES);
        if (canUpload($_FILES['document'])) {
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir,0775);
            }

            $fileName = time().$_FILES['document']['name'];
            if (file_exists($uploadDir.'/'.$fileName)) {
                $fileError = 'file already exists';
            }else {
                move_uploaded_file($_FILES['document']['tmp_name'],$uploadDir.'/'.$fileName);
                $fileError = false;
            }
        }else {
            $fileError = canUpload($_FILES['document']);
        }
    }
    if (!$nameError && !$emailError && !$textError && !$fileError) {
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
        $headers .= 'From: ' .$email. "\r\n".
            'Reply-To: ' .$email. "\r\n".
            'X-Mailer: PHP/' . phpversion();
        $message = '<htm><body>';
        $message .= '<p style="color: #ff0000;" >' .$message .'</p>';
        $message .= '</body></html>';

//        if (mail($config['mail_admin'],'New Message',$text)){
//            unset($_SESSION['contact_form']);
//
//        }else
//            echo "Error sending Your Email";

        $query = $pdo->prepare("INSERT INTO messages (email, name, document, description,services_id)
VALUES (?, ?,?, ?,?)");

        $filePath = '/uploads/products/'.$fileName;
        $query->execute([$email,$name,$filePath,$text,$_POST['services']]);
        header('Location: /mojeeb/index.php');
    }
}

