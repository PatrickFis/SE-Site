<?php
$target_dir = "sponsorimg/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
include_once ('../dbconnect.php');
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
      // echo $_POST['sponName'];
      // echo $_POST['sideName'];
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (copy($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        // print_r($_POST);
        // Add code to update sponsor table here
        $sponname = $_POST['sponName'];
        $sidename = $_POST['sideName'];
        $insertQuery = "INSERT INTO sponsors (imgpath, sponsorName, sidebarName) VALUES('$target_file', '$sponname', '$sidename')";
        // echo $insertQuery;
        $res = mysql_query($insertQuery);
        echo mysql_error();
    } else {
        echo "Sorry, there was an error uploading your file.";
        echo "</p>";
        echo '<pre>';
        echo 'Here is some more debugging info:';
        print_r($_FILES);
        echo basename( $_FILES["fileToUpload"]["name"]);
        echo "<br>";
        echo $_FILES["fileToUpload"]["tmp_name"];
        echo "<br>";
        echo $target_file;
        print "</pre>";
    }
}
// Redirect the user back to the admin page.
header("Location: ../admin.php");
?>
