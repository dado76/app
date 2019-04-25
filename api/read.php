<?php
/**
 * Returns the list of policies.
 */
require 'database.php';

$utilisateur = [];
$sql = "SELECT id, nom, email FROM utlisateurs";

if($result = mysqli_query($con,$sql))
{
    $i = 0;
    while($row = mysqli_fetch_assoc($result))
    {
        $utilisateur[$i]['id']    = $row['id'];
        $utilisateur[$i]['nom'] = $row['nom'];
        $utilisateur[$i]['email'] = $row['email'];
        $i++;
    }

    echo json_encode($utilisateur);
}
else
{
    http_response_code(404);
}