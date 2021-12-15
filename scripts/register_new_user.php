<?php
				/*
				The email can start with _ then a-z0-9 then a period . and then the same repeats and then wildcard
				*(anything) then @ then . then a-00-9 followed again by wildcard *(anything) another period . a-z
				the last pattern can repeat only two or three times {2,3}  
				ALTERNATIVE OPTION!! --> https://www.php.net/manual/en/filter.filters.validate.php
				*/
				// $regex = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";		// Regex in PHP need delimeters, in our case we used "/"REGEX"/"
				// Hold your breath BIG if statement comming:
				if (!empty($_POST["login_name_reg"]) && !empty($_POST["password_reg"]) &&  !empty($_POST["password_repeat_reg"])
				 &&  !empty($_POST["email_reg"]) &&  !empty($_POST["firstname_reg"]) &&  !empty($_POST["lastname_reg"])
				 &&  !empty($_POST["gender_reg"]) &&  !empty($_POST["birthdate_reg"]) &&  !empty($_POST["address_reg"]))
				{
					if (!filter_var($_POST["email_reg"], FILTER_VALIDATE_EMAIL) || $_POST["password_reg"] != $_POST["password_repeat_reg"])
					{
                        if (!filter_var($_POST["email_reg"], FILTER_VALIDATE_EMAIL))
                        {
?>
						<div class="login_container">
							<br>
							The email register is not valid. Please insert a valid email. Example: "john.doe@enterprise.com"
							<br>
                            <br>
						</div>
<?php
                        }
                        else
                        {
?>
						<div class="login_container">
							<br>
							The passwords given did not match. Please verify the password.
							<br>
                            <br>
						</div>
<?php
                        }
					}
					else
					{
						require("./scripts/connection.php");
						/* 
						Here begins SQL Injection Security with the function mysqli_real_escape_string() which does:
						(1) Escapes all ' and " without writing backslashes to the database
						(2) Returns the string int a valid SQL statement taking into account the charset of connection (link needed!)
						*/
						$new_login_name = mysqli_real_escape_string($link, $_POST["login_name_reg"]);
                        $check_query = "SELECT * FROM Users WHERE loginName=\"" . $new_login_name ."\"";
                        $result_check = mysqli_query($link, $check_query) or die ("An error occurred during the execution of the query: \"$check_query\"");
                        $record_number = mysqli_num_rows($result_check);
                        if ($record_number > 0)
                        {
?>
                            <div class="login_container">
                                <br>
                                The login name: <?php echo("\"$new_login_name\""); ?> is already in use, please choose a different login name.
                                <br>
                                <br>
                            </div>
<?php
                        }
                        elseif($record_number == 0)
                        {
                            $new_password = mysqli_real_escape_string($link, $_POST["password_reg"]);
                            $new_password_repeat = mysqli_real_escape_string($link, $_POST["password_repeat_reg"]);
                            $new_email = mysqli_real_escape_string($link, $_POST["email_reg"]);

                            $check_query = "SELECT * FROM Users WHERE email=\"" . $new_email ."\"";
                            $result_check = mysqli_query($link, $check_query) or die ("An error occurred during the execution of the query: \"$check_query\"");
                            $record_number = mysqli_num_rows($result_check);
                            if ($record_number > 0)
                            {
?>
                                <div class="login_container">
                                    <br>
                                    There is already an accont linked to the email:  <?php echo("\"$new_email\""); ?>. Please choose a different email.
                                    <br>
                                    <br>
                                </div>
<?php
                            }
                            elseif($record_number == 0)
                            {
                                $new_firstname = mysqli_real_escape_string($link, $_POST["firstname_reg"]);
                                $new_lastname = mysqli_real_escape_string($link, $_POST["lastname_reg"]);
                                $new_gender = mysqli_real_escape_string($link, $_POST["gender_reg"]);
                                $new_birthdate = mysqli_real_escape_string($link, $_POST["birthdate_reg"]);
                                $new_address = mysqli_real_escape_string($link, $_POST["address_reg"]);
                                // Here ends SQL Injection Security
                                $isAdmin = 0;
                                $new_hash_password = password_hash($new_password_repeat, PASSWORD_DEFAULT);

                                $query = "INSERT INTO Users 
                                        (loginName, email, firstName, lastName, gender, isAdmin, dateOfBirth, address, hashPassword)
                                        VALUES
                                            (" . "\"" . $new_login_name . "\", " . "\"" . $new_email . "\", " . "\"" . $new_firstname . "\", " .
                                            "\"" . $new_lastname . "\", " . "\"" . $new_gender . "\", " . $isAdmin . ", " . 
                                            "\"" . $new_birthdate . "\", " . "\"" . $new_address . "\", " . "\"" . $new_hash_password . "\")";  
                                
                                $result = mysqli_query($link, $query) or die ("An error occurred during the execution of the query: \"$query\"");
    ?>
                                <div class="login_container">
                                    <br>
                                    The registration completed successfully.
                                    <br>
                                    <br>
                                </div>
<?php
                            }
                        }
                        mysqli_close($link);
					}
				}
?>