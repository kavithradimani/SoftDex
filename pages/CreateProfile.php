<!DOCTYPE html>
<?php
require '../Classes/Select.php';

use Classes\Select;

$select = new \Classes\Select();

session_start();
if (isset($_SESSION["user"])) {
    $user = $_SESSION["user"];

    foreach ($select->selectUser($user) as $u) {
        $uname = $u->username;
        $fname = $u->fname;
        $lname = $u->lname;
        $email = $u->email;
        $country = $u->country;
    }
} else {
    header("Location: ../index.php");
}
?>
<html>
    <head>
       <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/createAccount.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/css/bootstrap.min.css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" />
        <script src="https://kit.fontawesome.com/b0ede3d087.js" crossorigin="anonymous"></script>

        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

        <script src="../JS/CreateAccount.js"></script>
    </head>
    <body>
        <div class="header">
            <h1>Welcome to SoftDex!  </h1>
        </div>

        <div class="container">
            <br>
            <?php
            if (isset($_GET['m'])) {
                if ($_GET['m'] === "2") {
                    ?>
                    <div class="alert alert-danger " role="alert">Something went wrong. Try again</div>
                    <?php
                } else if ($_GET['m'] === "1") {
                    ?>
                    <div class="alert alert-success " role="alert">Sucessfully saved your data!</div>
                    <?php
                }
            }
            ?>
            <br>
        </div>
        <div class="container">
            <br>
            <form action="../Process/ProfileEdit.php" class="needs-validation" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="left-side">
                        <h1>Create Your Profile </h1>
                        <br>
                        <div class="d-flex justify-content-center">
                        <div class="profile-pic-container " >
                            
                            <?php
                                    $imageFormats = ['png', 'jpg'];
                                    $imagePath = '../img/user/' . $user . '/' . $user;

                                    foreach ($imageFormats as $format) {
                                        $imageUrl = $imagePath . '.' . $format;

                                        if (file_exists($imageUrl)) {
                                            echo '<img class="d-block mx-auto mb-3 mt-3" src="' . $imageUrl . '" height="130px" alt="Logo Image" />';
                                            break;
                                        }
                                    }
                                    ?>
                        </div>
                        </div>
                       


                        <div class="container">
                            <div class="form-group">

                            </div>
                        </div>
                    </div>

                    <div class="right-side">

                        <div id="userFields" ><br>

                            <!--First Name-->
                            <div class="form-group">
                                <div class="row">
                                    <div class="input-group col-lg-6 mb-2">
                                        <label for="firstname">First Name</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                                    <i class="fa fa-user text-muted"></i>
                                                </span>
                                            </div>
                                            <input id="firstName" type="text" name="firstname" placeholder="First Name" value="<?php echo $fname; ?>" class="form-control bg-white border-left-0 border-md" oninput="validateName('firstName')" required>

                                        </div>

                                    </div>
                                    <!--Last Name-->
                                    <div class="input-group col-lg-6 mb-2">
                                        <label for="lastname">Last Name</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                                    <i class="fa fa-user text-muted"></i>
                                                </span>
                                            </div>
                                            <input id="lastName" type="text" name="lastname" placeholder="Last Name" value="<?php echo $lname; ?>" class="form-control bg-white border-left-0 border-md" oninput="validateName('lastName')" required>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="input-group col-lg-6">
                                        <p id="firstNameError" style="color: red;"></p> 

                                    </div>
                                    <!--Last Name-->
                                    <div class="input-group col-lg-6">
                                        <p id="lastNameError" style="color: red;"></p>
                                    </div>
                                </div>
                            </div>


                            <!--username-->
                            <div class="form-group">
                                <div class="row">
                                    <div class="input-group col-lg-6 mb-4">
                                        <label for="username">Username</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                                    <i class="fa fa-user text-muted"></i>
                                                </span>
                                            </div>
                                            <input id="firstName" type="text" name="user2" value="<?php echo $user; ?>" class="form-control bg-white border-left-0 border-md" disabled>
                                            <input type="hidden" name="user" value="<?php echo $uname; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--Email-->
                            <div class="form-group">
                                <div class="row">
                                    <div class="input-group col-lg-12 mb-4">
                                        <label for="email">Email</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                                    <i class="fa fa-envelope text-muted"></i>
                                                </span>
                                            </div>
                                            <input id="email" type="email" name="email" placeholder="Email Address" value="<?php echo $email; ?>" class="form-control bg-white border-left-0 border-md" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--                            password
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="input-group col-lg-6 mb-4">
                                                                    <label for="password">Password</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text bg-white px-4 border-md border-right-0">
                                                                                <i class="fa fa-lock text-muted"></i>
                                                                            </span>
                                                                        </div>
                                                                        <input id="password" type="password" name="password" placeholder="Password" class="form-control bg-white border-left-0 border-md">
                                                                    </div>
                            
                                                                </div>
                            
                                                                 Password Confirmation
                                                                <div class="input-group col-lg-6 mb-4">
                                                                    <label for="confirmpassword">Confirm Password</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text bg-white px-4 border-md border-right-0">
                                                                                <i class="fa fa-lock text-muted"></i>
                                                                            </span>
                                                                        </div>
                                                                        <input id="passwordConfirmation" type="password" name="passwordConfirmation" placeholder="Confirm Password" class="form-control bg-white border-left-0 border-md" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>-->

                            <!-- country -->
                            <div class="form-group">
                                <div class="row">

                                    <div class="input-group col-lg-12 mb-4">
                                        <label for="country">Country</label> 
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                                    <i class="fa fa-flag text-muted"></i>
                                                </span>
                                            </div>
                                            <select id="country" name="country" style="max-width: 300px" class="custom-select form-control bg-white border-left-0 border-md h-100 font-weight-bold text-muted">
                                                <option value="Sri Lanka">Sri Lanka</option>
                                                <option value="Americ">America</option>
                                                <option value="Austraila">Austraila</option>
                                                <option value="Bangladesh">Bangladesh</option>
                                                <option value="Brazil">Brazil</option>          
                                                <option value="Canada">Canada</option>
                                                <option value="China">China</option>
                                                <option value="Denmark">Denmark</option>
                                                <option value="France">France</option>
                                                <option value="Germany">Germany</option>
                                                <option value="India">India</option>
                                                <option value="Iraq">Iraq</option>
                                                <option value="Canada">Canada</option>
                                                <option value="Nepal">Nepal</option>
                                                <option value="America">America</option>
                                                <option value="Japan">Japan</option>
                                                <option value="India">India</option>
                                                <option value="Austraila">Austraila</option>
                                                <option value="Vietnam">Vietnam</option>
                                                <option value="<?php echo $country; ?>" selected><?php echo $country; ?></option>

                                            </select>
                                        </div> 
                                    </div>
                                </div>
                            </div>


                            <!--Add a profile pic-->
                            <div class="form-group">
                                <label for="profilepic">Profile Picture</label>
                                <input type="file" id="profilepic" name="profilepic" class="form-control-file">
                            </div>
                        </div>

                        <br>
                        <div class="form-group text-center">
                            <div class="d-flex justify-content-center">
                                <?php if ($fname === null) { ?>
                                    <button type="submit" id="createAccountBtn" class="btn btn-primary w-50" name="createProfile">Create Profile</button>
                                <?php } else {
                                    ?>
                                    <button type="submit" id="createAccountBtn" class="btn btn-primary w-50" name="createProfile">Edit Profile</button>
                                    <?php
                                }
                                ?>

                            </div>
                        </div>



                    </div>


                </div>
            </form>
        </div>

        <script>
            function validateName(fieldName) {
                const input = document.getElementById(fieldName);
                const error = document.getElementById(`${fieldName}Error`);
                const namePattern = /^[A-Za-z]+$/;

                if (!namePattern.test(input.value)) {
                    error.textContent = 'Please enter a valid name with only letters.';
                } else {
                    error.textContent = '';
                }
            }
        </script>
  

    </body>
</html>

