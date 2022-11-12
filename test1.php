<!doctype html>
<html>
<head>
    <meta charset="utf-8">
     <title>Admin Functions</title>
    <link rel="stylesheet" href="styles.css" />
  </head>
    <body>
    <div class='image'>
        <div class='transparentbox'>
            <p>Bifur's Web Admin Portal<br></p>
        </div>

    </div>                

    <div>
        <form method="get">
            <select name="function">
                <option value="files.php">Log Files</option>
                <option value="time.php">Server Time</option>
                <option value="net.php">Network Information</option>
            </select>
            <input type="submit">
        </form>
    </div>
    </body> 
    <main>
        <?php

        if ( isset( $_GET['function'] ) ) {
            $knowngood = array("files.php", "time.php", "net.php");
            $userinput = $_GET['function'];
            $valid = false;
            foreach($knowngood as $item)
            { 
                if (strpos($userinput, $item) !== false)
                {
                    $valid=true;
                }
            }
            if($valid)
            {
                include($userinput);
            }
            else
            {
                echo "<b>Intruder Alert!</b>";
            }
        }

        ?>

    </main>
    </html>
