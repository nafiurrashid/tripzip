<html>
<head>
    <title>Website</title>

    <style type="text/css" media="screen">
        .active {
            font-weight: bold;
        }
    </style>
</head>
<body>

<?php

// This is your menu
$items = array("home", "index", "cms", "memories");

foreach ($items as $item)
{
    if (isset($_GET['page']) && $_GET['page'] == $item)
    {
        echo '<a href="?page=' . $item . '" class="active"> ' . $item . '</a></br>';
        $activePage = $item . ".php";
    }
    else
    {
        echo '<a href="?page=' . $item . '"> ' . $item . '</a></br>';
    }
}

// Include your page
if (isset($activePage))
{
    include $activePage;   
}
else
{
    include "home.php";
}

?>

</body>
</html>