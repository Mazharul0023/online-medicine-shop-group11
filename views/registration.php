<!DOCTYPE html>
<html>

<head>
    <title>Registration</title>
    <link rel="stylesheet" href="../public/contact.css">
</head>

<body>
    <h2>User Registration</h2>
    <form method="post" action="../controllers/AuthController.php?action=register">
        <table class="form-table">
            <tr>
                <td>Name <span class="required">*</span></td>
                <td><input type="text" name="name" required></td>
            </tr>
            <tr>
                <td>Email <span class="required">*</span></td>
                <td><input type="email" name="email" required></td>
            </tr>
            <tr>
                <td>Password <span class="required">*</span></td>
                <td><input type="password" name="password" required></td>
            </tr>
            <tr>
                <td>Address <span class="required">*</span></td>
                <td><textarea name="address" rows="4" required></textarea></td>
            </tr>
            <tr>
                <td>Phone <span class="required">*</span></td>
                <td><input type="text" name="phone" required></td>
            </tr>
            <tr>
                <td>Role <span class="required">*</span></td>
                <td>
                    <select name="role">
                        <option value="customer">Customer</option>
                        <option value="admin">Admin</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Register"></td>
            </tr>
        </table>
    </form>
</body>

</html>