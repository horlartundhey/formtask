<?php 
//Data coming from the registration Page

$error ='';
$name = '';
$email = '';
$dob = '';
$gender = '';
$country = '';

function clean_text($string)
{
    $string = trim($string);
    $string = stripslashes($string);
    $string = htmlspecialchars($string);
    return $string;
}

if(isset($_POST["submit"]))
{
    if(empty($_POST["name"]))
    {
        $error .= '<p><label class="text-danger">Please enter your Name</label></p>';
    }
    else{
        $name = clean_text($_POST["name"]);
        if(!preg_match("/^[a-zA-Z]*$/",$name))
        {
            $error.='<p><label class="text-danger">Only letters and White spaces are allowed</label></p>';
        }
    }
    if(empty($_POST["email"]))
    {
        $error .= '<p><label class="text-danger">Please Enter Your Name</label></p>';
    }
    else{
        $email = clean_text($_POST["email"]);
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $error .= '<p><label class="text-danger">You have entered an invalid Email Format</label></p>';
        }
    }
    if(empty($_POST["dob"]))
    {
        $error .= '<p><label class="text-danger">Please Enter Your Date Of Birth</label></p>';
    }
    else
    {
        $dob = clean_text($_POST["dob"]);
        
    }
    if(empty($_POST["gender"]))
    {
        $error .= '<p><label class="text-danger">Please Enter Your Gender</label></p>';
    }
    else
    {
        $gender= clean_text($_POST["gender"]);
        
    }
    if(empty($_POST["country"]))
    {
        $error .= '<p><label class="text-danger">Please Enter Your Correct Country</label></p>';
    }
    else
    {
        $country = clean_text($_POST["country"]);        
    }


    if($error == '')
    {
        $file_open = fopen("userdata.csv", "a");
        $no_rows = count(file("userdata.csv"));
        if($no_rows > 1)
        {
            $no_rows = ($no_rows - 1) + 1;
        }
        $form_data = array(
            'sr_no' => $no_rows,
            'name' => $name, 
            'email' => $email, 
            'dob' => $dob,
            'gender' => $gender,
            'country' => $country
        );
        fputcsv($file_open, $form_data);
        $error = '<label class="text-success">Thank you for Registering, Your Data has been Added Successfully. </label>';
        $name = '';
        $email = '';
        $dob = '';
        $gender = '';
        $country = '';
    }
}
// header('location: registration.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <title>Registration form</title>
</head>
<body>
    <h1 class="text-success text-center py-4">REGISTRATION FORM</h1>
    <h4 class="text-center"><?php echo $error; ?></h4>
    <div class="container">
        <div class="row">
        <form class="row g-3" method="post" action="user_data.php">
        <div class="col-12">
                <label for="Name" class="form-label">Name</label>
                <input type="text" class="form-control" id="Name" placeholder="Type in your Name Here" name="name" value="<?php echo $name; ?>" >
            </div>
            <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="inputEmail4" value="<?php echo $email; ?>">
            </div>
            <div class="col-md-6">
                <label for="dob" class="form-label">Date of Birth</label>
                <input type="text" name="dob" class="form-control" id="dob" value="<?php echo $dob; ?>">
            </div>            
            <div class="col-md-6">
                <label for="gender" class="form-label">Gender</label>
                <input type="text" name="gender" class="form-control" id="gender" value="<?php echo $gender; ?>">
            </div>           
            <div class="col-md-6">
                <label for="country" class="form-label">Country</label>
                <input type="text" name="country" value="<?php echo $country; ?>" class="form-control" id="country">
            </div>            
            <div class="col-12">
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>       
        </div>
        <?php

            echo "<table class='table'>\n\n";

            $form_data = fopen("userdata.csv", "r");
            // fetch data from csv file

            while(($data = fgetcsv($form_data)) !== false){
                echo "<tr>";
                foreach ($data as $i){
                    echo "<td colspan='2'>". htmlspecialchars($i). "</td>";
                }
                echo "</tr> \n";
            }

            //close the file open
            fclose($form_data);



            echo "\n</table>";

  ?>
    </div>
</body>
</html>