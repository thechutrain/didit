<?php

include "top.php";

$numberRecords = 10;

print "<article>";
print "<h2>The Most Recently Submitted Activities!</h2>";
print "<p>You can click on the names of the activities to get more information.";
print " Up vote for your favorite activities</p>";


    // Query database looking for activity ID
    $checkActivityQuery = "SELECT pmkActivityId";
    $checkActivityQuery .= " FROM tblActivities";
    $checkActivityQuery .= " WHERE pmkActivityId = ?";
    $checkActivityData = array($activityID);

    $checkActivity = $thisDatabaseReader->select($checkActivityQuery, $checkActivityData, 1, 0, 0, 0, false, false);


$query = "SELECT pmkActivityId, fldName, fldCategory, fldOnCampus, fldTownName,"; 
$query .= " fldState, fldDistance, fldLocation, fldDescription, fnkSubmitNetId";
$query .= " FROM tblActivities A INNER JOIN tblVotes V ON";
$query .= " A.pmkActivityId = V.fnkActivityId INNER JOIN tblTowns T";
$query .= " ON A.fnkTownId = T.pmkTownId";
$query .= " WHERE fldApproved = 1";
$query .= " GROUP BY A.fldName";
$query .= " ORDER BY fldDateSubmitted DESC LIMIT 3";
$data = array(""); // for some reason, variables don't work in array for this
$val = array(1, 1, 0, 0);

// Call select method
$info = $thisDatabaseReader->select($query, $data, $val[0], $val[1], $val[2], $val[3], false, false);
//$info2 = $thisDatabaseReader->testquery($query, $data, $val[0], $val[1], $val[2], $val[3], false, false);
//print "<pre>";
//print_r($info);
// To troubleshoot returned array
if ($debug) {
    print "<p>DATA: <pre>";
    print_r($info);
    print "</pre></p>";
}

$rank = 1;

// For loop to print records
foreach ($info as $record) {
    print '<div id="dropdown-' . $rank . '" ';
    print 'class="panel dropdown dropdown-processed">';
    
    print '<p>';
    
        // Make admin-only [Edit] column, which allows admin to edit records
    if (adminCheck($thisDatabaseReader, $username)) {
        $appendURL = '?activity=' . $record['pmkActivityId'];
        print '[<a href="form.php' . $appendURL . '">';
        print 'Edit</a>] ';
        print '[<a href="' . $adminPath . 'remove.php' . $appendURL . '">';
        print 'Remove</a>] ';
    }
    
    print $rank . '. ';
    print '<a class="dropdown-link" href="#">';
    print $record['fldName'];
    print '</a>';
    
    print '</p>';
    
    print '<div class="dropdown-container" style="display: none;">';
    print '<ol class="no-bullet">';
    print '<li><b>Submitted by:</b> ' . $record['fnkSubmitNetId'] . '</li>';
    print '<li><b>Category:</b> ' . $record['fldCategory'] . '</li>';
    print '<li><b>On Campus?</b> ';
    if ($record['fldOnCampus'] == 1) {
        print "YES";
    } else {
        print "NO";
    }
    print "</li>";
    print '<li><b>Town:</b> ' . $record['fldTownName'] . ', ' . $record['fldState'] . '</li>';
    if ($record['fldDistance'] != 0) {
        print '<li><b>Distance from Burlington:</b> ~' . $record['fldDistance'] . ' miles</li>';
    }
    if ($record['fldCost'] == 0 AND $record['fldCost'] != "") {
        print "<li><b>Cost:</b> FREE";
    } else if($record['fldCost'] != "") {
        print '<li><b>Cost:</b> $' . $record['fldCost'] . '</li>';
        
    }
    if ($record['fldURL'] != '') {
        print '<li><b>URL:</b> <a href="' . $record['fldURL'] . '">Click here</a></li>';
    }
    if ($record['fldDescription'] != "") {
        print '<li><b>Description:</b> ' . $record['fldDescription'] . '</li>';
    }

    print '</ol></div></div>';

    $rank++;
}

if (adminCheck($thisDatabaseReader, $username)) {
    print '<section class="panel">';

    print "<h2>For administrators</h2>";
    print '<p>Click <a href="' . $adminPath . 'approve.php">here</a>';
    print ' to see a list of submitted';
    print ' activities that are awaiting approval.</p>';

    print "</section>";
}

print "</article>";

include "footer.php";
?>