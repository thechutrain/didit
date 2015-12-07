<?php

include '../top.php';

print "<article>";
if (!adminCheck($thisDatabaseReader, $username)) {
    print "<h2>Sorry.</h2>";
    print "<p>You don't have access to this page.</p>";
} else {
    // check to see if photo id sent to the url has an unapproved status
    if (isset($_GET['photo'])) {
        $photoID = (int) $_GET['photo'];
        // query to check if its in the database
        $check = " SELECT pmkPhotoId";
        $check .= " FROM tblPhotos";
        $check .= " WHERE fldApproved = 0";
        $check .= " AND pmkPhotoId = ?";
        $checkData = array($photoID);

        // Call select method
        $checkQuery = $thisDatabaseReader->select($check, $checkData, 1, 1, 0, 0, false, false);
        
        // assumes its not valid, unless the query result matches the GET submission ID
        $validID = false;
        if($checkQuery[0]["pmkPhotoId"]==$photoID){
            $validID = true;
        }
        
        //if is valid, then go in update the record:
        print '<section id="update-status">';
        
        if($validID){
            $update = " UPDATE tblPhotos SET";
            $update .= " fldApproved = ?";
            $update .= " WHERE pmkPhotoId = ?";
            $updateData = array(1, $photoID);
            
            $updated = $thisDatabaseWriter->update($update, $updateData, 1, 0, 0, 0, false, false);
            if($updated){
                print '<p>Photo ' .$photoID. ' has been approved</p>';
            } else{
                print "<p>Invalid Id! Unapproved photo " .$photoID . " does not exist</p>";
            }
        }
        
        print '</section>';
        
        
    } // closes the $_GET['photo] statement

    print "<section>";    
    print "<h2>Unapproved Photos</h2>";
    print "<p>The following submitted photos need to be approved:</p>";

    // query = SELECT pmkPhotoId, fldFileName, tblPhotos.fldDateSubmitted, 
    // fldName FROM tblPhotos INNER JOIN tblActivities ON 
    // fnkActivityId = pmkActivityId WHERE tblPhotos.fldApproved = 0 
    // ORDER BY tblPhotos.fldDateSubmitted DESC
    $query = "SELECT pmkPhotoId, fldName, fldCaption, fldFileName, fnkSubmitNetId";
    $query .= " FROM tblPhotos INNER JOIN tblActivities ON";
    $query .= " fnkActivityId = pmkActivityId";
    $query .= " WHERE tblPhotos.fldApproved = ?";
    $query .= " ORDER BY tblPhotos.fldDateSubmitted DESC";
    $queryData = array(0);


    $unapproved = $thisDatabaseReader->select($query, $queryData, 1, 1, 0, 0, false, false);
//    print "<pre>";
//    print_r($unapproved);
//    $test = $thisDatabaseReader->testquery($query, $queryData, 1, 1, 0, 0, false, false);
    if (isset($_GET["debug"])) {
        print "<pre>";
        print_r($unapproved);
    }

    // check to see if there are unapproved activities
    if ($unapproved) {
        // Start printing table
        print '<table>';
        print '<tr>';
        $fields = array_keys($unapproved[0]);
        $headers = array_filter($fields, 'is_string'); // Picks up only str values
//                print_r($headers);
        // Print headings
        foreach ($headers as $head) {
            $camelCase = preg_split('/(?=[A-Z])/', substr($head, 3));

            $heading = "";

            foreach ($camelCase as $oneWord) {
                $heading .= $oneWord . " ";
            }

            print '<th>' . $heading . '</th>';
        }
        // add header columns for approve button
        print "<th></th>";
        print "</tr>";
        // for loop to print each record in search query
        foreach ($unapproved as $record) {
            $appendURL = '?photo=' . $record['pmkPhotoId'];
            // print the row
            print '<tr>';
            // Uses field names (AKA headers) as keys to pick from arrays
            foreach ($headers as $field) {
                if ($field == "fldFileName") {
                    print '<td><a href="../uploads/' . htmlentities($record[$field]) . '">'
                            . htmlentities($record[$field]) . '<a></td>';
                } else {
                    print '<td>' . htmlentities($record[$field]) . '</td>';
                }
            }
            // after printing out all fields, now links to approve
            print '<td><a href="' . $appendURL . '">Approve</a></td>';


            print '</tr>';
        } // closes foreach ($unapproved as $record) loop
    }
    // else -- to if $unapproved is empty
    else {
        print '<p>No activities need approval at this time.</p>';
    }
}

print "</article>";


print "</article";

include '../footer.php';
?>