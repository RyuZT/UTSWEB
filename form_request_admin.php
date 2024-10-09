<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Request To Become Admin</title>
</head>
<body>
    <div class="container">
        <h2>Request To Become Admin</h2>

        <?php
        if (isset($_SESSION['error'])) {
            echo '<div style="color: red;">' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']); // Clear the error message after displaying it
        }
        ?>
        
        <!-- Form yang mengizinkan upload file harus menggunakan enctype multipart/form-data -->
        <form action="proses_request_admin.php" method="post" enctype="multipart/form-data">
            <label for="Ename">Event Name</label><br>
            <input type="text" name="Ename" required/><br />
            
            <label for="cname">Company Name</label><br>
            <input type="text" name="cname" required/><br />
            
            <label for="Epurpose">Event Purpose</label><br>
            <input type="text" name="Epurpose" required/><br />
            
            <label for="Elocation">Event Location</label><br>
            <input type="text" name="Elocation" required/><br />
            
            <label for="Edate">Event Date</label><br>
            <input type="date" name="Edate" required/><br />
            
            <label for="Eproposal">Event Proposal (PDF only)</label><br>
            <input type="file" name="Eproposal" accept=".pdf" required/><br />

            <input type="submit" value="Submit" href="index.php"/>
        </form>
    </div>
</body>
</html>
