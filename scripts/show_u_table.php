<?php
    require("./scripts/connection.php");
    $users_query = "SELECT * FROM Users";
    $result = mysqli_query($link, $users_query) or die ("There is a problem with the implementation of the query: \"$users_query\"");
    echo("\n");
    $number_of_users = mysqli_num_rows($result);
?>
    <div class="table_container">
        <table>
            <tr>
                <th>User ID</th> <th>Login Name</th> <th>Email</th> <th>Firstname</th> <th>LastName</th> <th>gender</th> <th>Privileges</th> <th>Date of Birth</th> <th>Address</th> 
            </tr>
<?php
    while ($row = mysqli_fetch_array($result))
    {
        $t_userID = htmlspecialchars($row["userID"]);
        $t_loginName = htmlspecialchars($row["loginName"]);
        $t_email = htmlspecialchars($row["email"]);
        $t_firstName = htmlspecialchars($row["firstName"]);
        $t_lastName = htmlspecialchars($row["lastName"]);
        $t_gender = htmlspecialchars($row["gender"]);
        $t_isAdmin = htmlspecialchars($row["isAdmin"]);
        $t_dateOfBirth = htmlspecialchars($row["dateOfBirth"]);
        $t_address = htmlspecialchars($row["address"]);
?>
<?php
        $t_isAdmin = $t_isAdmin == "1" ? "Administrator" : "Regular User";
        if ($_SESSION["userID"] != $t_userID)   // to avoid modify current user -- that would break the logic of the current settings
        {
            echo("\t\t<tr>\n");
                echo("\t\t\t<td>" . $t_userID . "</td> <td>" . $t_loginName .  "</td> <td>" . $t_email . "</td> <td>" . $t_firstName . "</td> <td>" . $t_lastName . "</td> <td>" . $t_gender . "</td> <td>" . $t_isAdmin . "</td> <td>" . $t_dateOfBirth . "</td> <td>" . $t_address . "</td>\n");
            echo("\t\t</tr>\n");
        }
    }
        mysqli_close($link);
?>
        </table>
        <p class="table_legend">*MA = Male, *FE = Female, *NB = Non Binary</p>
    </div>

    <div class="admin_actions_container">
        <form name="delete_user_form" method="POST" action="<?php echo($_SERVER["PHP_SELF"]); ?>">
            <label><strong>DELETE USER</strong></label><br><br>
            <label><b>User ID:</b></label><br>
            <input type="text" name="d_userID" id="d_user"><br>
            <input class="submit_form_button" type="submit" name="delete_action" value="Delete User">
        </form>
        <br><br>
        <form name="modify_user_privileges_form" method="POST" action="<?php echo($_SERVER["PHP_SELF"]); ?>">
            <label><strong>CHANGE USER'S PRIVILEGES</strong></label><br><br>
            <label for="change_userID"><b>User ID:</b></label><br>
            <input type="text" name="c_userID" id="change_userID"><br>
            <label><b>New Privileges:</b></label><br>
            <label for="regular_user">Regular User</label>
            <input type="radio" name="privileges" id="regular_user" value="Regular User">&nbsp;&nbsp;&nbsp;&nbsp;
            <label for="admin_user">Administrator</label>
            <input type="radio" name="privileges" id="admin_user" value="Admin User">
            <p><input class="submit_form_button" type="submit" name="modify_action" value="Change Privileges"></p>
        </form>
        <br><br>
        <form name="add_user_form" method="POST" action="<?php echo($_SERVER["PHP_SELF"]); ?>">
            <label><strong>ADD NEW USER</strong></label><br><br>
            <label><b>Login Name:</b></label><br>
            <input type="text" class="reg" name="login_name_reg" placeholder="Enter Login Name" required><br>
            <br>
            <label><b>Password:</b></label><br>
            <input type="password" class="reg" id="js_pass" name="password_reg" placeholder="Enter Password" required><br>
            <br>
            <label><b>Repeat Password:</b></label><br>
            <input type="password" class="reg" id="js_pass_rep" name="password_repeat_reg" placeholder="Repeat Password" required><br>
            <br>
            <label><b>Email:</b></label><br>
            <input type="text" class="reg" name="email_reg" placeholder="Enter Email" required><br>
            <br>
            <label><b>Fistname:</b></label><br>
            <input type="text" class="reg" name="firstname_reg" placeholder="Enter Firstname" required><br>
            <br>
            <label><b>Lastname:</b></label><br>
            <input type="text" class="reg" name="lastname_reg" placeholder="Enter Lastname" required><br>
            <br>
            <label><b>Gender:</b></label><br>
            <input type="radio" name="gender_reg" id="male" value="MA">
            <label for="male">Male</label>&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" name="gender_reg" id="female" value="FE">
            <label for="female">Female</label>&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" name="gender_reg" id="non_binary" value="NB">
            <label>Non Binary</label><br>
            <br>
            <label><b>Date of Birth:</b></label><br>
            <input type="date" name="birthdate_reg" required><br>
            <br>
            <label><b>Address:</b></label><br>
            <input type="text" name="address_reg" placeholder="Enter Address" required><br>
            <p><input class="submit_form_button" type="submit" name="add_action" value="Add User"></p>
        </form>
    </div>