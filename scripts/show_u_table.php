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
            <label for="delete_user"><strong>DELETE USER</strong></label><br><br>
            <label for="d_userID"><b>User ID:</b></label><br>
            <input type="text" name="delete_user" id="d_userID"><br>
            <input class="submit_form_button" type="submit" name="delete_user_action" value="Delete User">
        </form>
        <br><br>
        <form name="modify_user_privileges_form" method="POST" action="<?php echo($_SERVER["PHP_SELF"]); ?>">
            <label for="change_user"><strong>CHANGE USER'S PRIVILEGES</strong></label><br><br>
            <label for="c_userID"><b>User ID:</b></label><br>
            <input type="text" name="change_user" id="c_userID"><br>
            <label for="privileges"><b>New Privileges:</b></label><br>
            <input type="radio" name="privileges" id="regular_user" value="Regular User">
            <label for="regular_user">Regular User</label>&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" name="privileges" id="admin_user" value="Admin User">
            <label for="admin_user">Administrator</label>
            <p><input class="submit_form_button" type="submit" name="change_user_action" value="Change Privileges"></p>
        </form>
        <br><br>
        <form name="add_user_form" method="POST" action="<?php echo($_SERVER["PHP_SELF"]); ?>">
            <label for="add_user"><strong>ADD USER</strong></label><br><br>
            <label for="login_name_reg"><b>Login Name:</b></label><br>
            <input type="input" class="reg" name="login_name_reg" placeholder="Enter Login Name" required><br>
            <br>
            <label for="password_reg"><b>Password:</b></label><br>
            <input type="password" class="reg" id="js_pass" name="password_reg" placeholder="Enter Password" required><br>
            <br>
            <label for="password_repeat_reg"><b>Repeat Password:</b></label><br>
            <input type="password" class="reg" id="js_pass_rep" name="password_repeat_reg" placeholder="Repeat Password" required><br>
            <br>
            <label for="email_reg"><b>Email:</b></label><br>
            <input type="text" class="reg" name="email_reg" placeholder="Enter Email" required><br>
            <br>
            <label for="firstname_reg"><b>Fistname:</b></label><br>
            <input type="text" class="reg" name="firstname_reg" placeholder="Enter Firstname" required><br>
            <br>
            <label for="lastname_reg"><b>Lastname:</b></label><br>
            <input type="text" class="reg" name="lastname_reg" placeholder="Enter Lastname" required><br>
            <br>
            <label for="gender_reg"><b>Gender:</b></label><br>
            <input type="radio" name="gender_reg" id="male" value="MA">
            <label for="male">Male</label>&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" name="gender_reg" id="female" value="FE">
            <label for="female">Female</label>&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" name="gender_reg" id="non_binary" value="NB">
            <label for="non_binary">Non Binary</label><br>
            <br>
            <label for="birthdate_reg"><b>Date of Birth:</b></label><br>
            <input type="date" name="birthdate_reg" required><br>
            <br>
            <label for="address_reg"><b>Address:</b></label><br>
            <input type="text" name="address_reg" placeholder="Enter Address" required><br>
            <p><input class="submit_form_button" type="submit" name="add_user_action" value="Add User"></p>
        </form>
    </div>

<?php
    echo("hi");
    if (isset($_POST["delete_user_action"]) && !empty($_POST["d_userID"]))
    {
        echo("deleting");
        require("./scripts/connection.php");
        $delete_query = "DELETE FROM Users WHERE userID= ?"; 
        $stm = mysqli_prepare($link, $delete_query);
        $given_id = $_POST["d_userID"];
        mysqli_stmt_bind_param($stmt, "s", $given_id);
        mysqli_stmt_execute($stmt);
        echo mysqli_stmt_num_rows($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($link);
    }
    elseif (isset($_POST["change_user_action"]) && !empty($_POST["c_userID"]) && !empty($_POST["privileges"]))
    {
        echo("changing");
        require("./scripts/connection.php");
        $new_role = $_POST["privileges"] == "admin_user" ? 1 : 0;
        $change_role_query = "UPDATE Users SET isAdmin=? WHERE userID=?";
        $stm = mysqli_prepare($link, $change_role_query);
        $given_id = $_POST["c_userID"];
        mysqli_stmt_bind_param($stmt, "ss", $new_role, $given_id);
        mysqli_stmt_execute($stmt);
        echo mysqli_stmt_num_rows($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($link);
    }
?>