<?php
include "top.php";
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// Validating image upload
// Do not show notice errors
//error_reporting (E_ALL ^ E_NOTICE);
//
//if(!empty($_FILES) AND isset($_POST['btnSubmit'])) // Has the image been uploaded?
//{
//include 'lib/config.php';
//// TEST
////print "<pre>";
////print_r($_FILES);
//
//$file = $_FILES['imgFileToUpload'];
//
//$file_name = $file['name'];
//
//$fileERROR = false; 
//
//// Get File Extension (if any)
//$ext = strtolower(substr(strrchr($file_name, "."), 1));
//
//// Check for a correct extension. The image file hasn't an extension? Add one
//
////%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//// Validation
//   if($validation_type == 1)
//   {
//   $file_info = getimagesize($_FILES['imgFileToUpload']['tmp_name']);
//
//      if(empty($file_info)) // No Image?
//      {
//      $errorMsg[] = "The uploaded file doesn't seem to be an image.";
//      }
//      else // An Image?
//      {
//      // little confused here
//      $file_mime = $file_info['mime'];
//     // TESTING
////      print "<pre>";
////      print_r($file_mime);   // returns img/jpeg
//
//         if($ext == 'jpc' || $ext == 'jpx' || $ext == 'jb2')
//         {
//         $extension = $ext;
//         }
//         else
//         {
//         $extension = ($mime[$file_mime] == 'jpeg') ? 'jpg' : $mime[$file_mime];
//         }
//
//         if(!$extension)
//         {
//         $extension = '';  
//         $file_name = str_replace('.', '', $file_name); 
//         }
//	  }
//   }
//   else if($validation_type == 2)
//   {
//	  if(!in_array($ext, $image_extensions_allowed))
//	  {
//	  $exts = implode(', ',$image_extensions_allowed);
//	  $errorMsg[] = "You must upload a file with one of the following extensions: ".$exts;
//	  }
//
//	  $extension = $ext;
//   }
//
//   if(empty($errorMsg)) // No errors were found?
//   {
//   $new_file_name = strtolower($file_name);
//   $new_file_name = str_replace(' ', '-', $new_file_name);
//   $new_file_name = substr($new_file_name, 0, -strlen($ext));
//   $new_file_name .= $extension;
//   
//   // File Name
//   $move_file = move_uploaded_file($file['tmp_name'], $upload_image_to_folder.$new_file_name);
//
//   if($move_file)
//	   {
//	   $done = 'The image has been uploaded.';
//	   }
//   }
//   else
//   {
//   @unlink($file['tmp_name']);
//   }
//
//   $file_uploaded = true;
//   //print("<pre>");
////print_r($file_name);
//} // closes the first if button was submitted & there is something in the $_FILES array
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1 Initialize variables
//
// SECTION: 1a.
// variables for the classroom purposes to help find errors.
$debug = false;
if (isset($_GET["debug"])) { // ONLY do this in a classroom environment
    $debug = true;
}
if ($debug)
    print "<p>DEBUG MODE IS ON</p>";

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1b Security
//
// define security variable to be used in SECTION 2a.
$yourURL = $domain . $phpSelf;

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1c form variables
//
// Initialize variables one for each form element
// in the order they appear on the form
// If activity is included in URL, then the admin wants to edit a record
// We need to get the record's info from the database

$activityID = -1;  // default is a non valid activity ID
// get the activity Id from a mini form whose link is on the list
$activityID = (int) htmlentities($_GET["hidActivityId"], ENT_QUOTES, "UTF-8");

$user = $username;

// file Variables
$fileName = "";
$fileLocation = "";

$photoDescription = "";
$photoCaption = "";
$approved = 0;

// TESTING
//print_r($user); aychu
// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION 1d: Form error flags: Initalize ERROR flags, one for each form element
// we validate, in the order they appear in SECTION 1c

$userError = False;
$activityIDError = False;

// Assume no error in uploading file
$uploadError = False;
$movedFile = False;

$descriptionError = False;
$captionError = False;



// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION 1e: Misc. variables
// Array to hold error messages
$errorMsg = array();
$photoData = array();   // array to hold the data on the photo submitted
$mailed = false; // Not mailed yet
// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION 2: Process for when the form is submitted
// Ideal Situation - user submits form & $_FILES array is not empty
if (isset($_POST['btnSubmit']) AND ! empty($_FILES)) {
    // config.php is used to validate the image file
    include 'lib/config.php';

//    DEBUGGING   
//print "<pre>";
//print_r($_FILES);
//print "</pre>";
    // %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
    //
    // SECTION 2a: Security
// TURN BACK ON WHEN YOU SWITCH TO POST!!
    if (!securityCheck($path_parts, $yourURL, true)) {
        $msg = '<p>Sorry, you cannot access this page. ';
        $msg.= 'Security breach detected and reported.';
        die($msg);
    }
    // %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
    //
    // SECTION 2b: Sanitize data
    // Remove any potential JS or HTML code from users input on the form.
    // Follow same order as declared in SECTION 1c.
    // Already sanitized when initalized, add direct to data array
    // CODE WITH GET FOR EASY TESTING
    // array of PhotoData order: ActivityId, NetId, imageLink, Caption, approve
    // 1.) Add the activityId to the photoData array
    $activityID = (int) htmlentities($_POST["hidActivityId"], ENT_QUOTES, "UTF-8");
    $photoData[] = $activityID;

//    if ($activityID > 0) {
//        $update = true;
//    } else {
//        $update = false;
//    }
//    
    // 2.) Add the netId of the user to the photoData array
    $photoData[] = $user;

    // 3.) ADD THE IMAGE HERE!!
    $file = $_FILES['imgFileToUpload'];
    $fileName = $file['name'];
    
//    print("<pre>");
//    print_r($fileName);
    // 4.) Add the Caption of the photo to the array
    $photoCaption = htmlentities($_POST['txtPhotoCaption'], ENT_QUOTES, "UTF-8");
    $photoData[] = $photoCaption;

    // 5.) Add the approve value to the end
    // $approved will always be 0, assume false
//    $photoData[] = $approved;

// DEBUGGING 
//    print "<h4>";
//    print_r($photoData);
//    print "</h4>";
    // For all OPTION DATA, add it to array only if it's not empty
//    $photoDescription = htmlentities($_GET['txtPhotoDescription'], ENT_QUOTES, "UTF-8");
//    if ($photoDescription != "") {
//        $photoData[] = $photoDescription;
//    }
    // %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
    //
    // SECTION 2c: Validation: Check each value for possible errors or empty.
    // But check all passed in variables
    // Validation for image!!!
    // %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
    // Get File Extension (if any)
    $ext = strtolower(substr(strrchr($fileName, "."), 1));
    // Check for a correct extension. The image file hasn't an extension? Add one
    ////%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
    //// Validation
    if ($validation_type == 1) {
        $fileLocation = getimagesize($_FILES['imgFileToUpload']['tmp_name']);

        if (empty($fileLocation)) { // No file, should never go here b/c of if statement
            $errorMsg[] = "The uploaded file doesn't seem to be an image.";
            $uploadERROR = true;
        } else { // An Image?
            $file_mime = $fileLocation['mime'];
            // TESTING
//      print "<pre>";
//      print_r($file_mime);   // returns img/jpeg

            if ($ext == 'jpc' || $ext == 'jpx' || $ext == 'jb2') {
                $extension = $ext;
            } else {
                $extension = ($mime[$file_mime] == 'jpeg') ? 'jpg' : $mime[$file_mime];
            }

            if (!$extension) {
                $extension = '';
                $file_name = str_replace('.', '', $file_name);
            }
        }
    } // closes validation if == 1
    else if ($validation_type == 2) {
        if (!in_array($ext, $image_extensions_allowed)) {
            $exts = implode(', ', $image_extensions_allowed);
            $errorMsg[] = "You must upload a file with one of the following extensions: " . $exts;
            $uploadERROR = true;
        }

        $extension = $ext;
    }


    // %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%

    if ($user == "") {
        $errorMsg[] = "Please enter your NetID.";
        $userError = true;
    } elseif (!verifyAlphaNum($user)) {
        $errorMsg[] = "Your NetID appears to include invalid characters.";
        $userError = true;
    }

//    if (!verifyAlphaNum($user)) {
//        $errorMsg[] = "Your NetID appears to include invalid characters.";
//        $userError = true;
//    }

    if ($photoCaption == "") {
        $errorMsg[] = "The photo caption can not be empty.";
        $captionError = true;
    } elseif (!verifyAlphaNum($photoCaption)) {
        $errorMsg[] = "The name you've provided for the activity contains invalid characters.";
        $captionError = true;
    }


    // Verify Optional data - photoDescription
//    if ($photoDescription != "" AND !verifyAlphaNum($photoDescription)) {
//        $errorMsg[] = "The photo description appears to contain invalid characters.";
//        $descriptionError = true;
//    }
    // %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
    //
    // SECTION 2d: Process form - passed validation (errorMsg is empty)


    if (!$errorMsg) {
        if ($debug) {
            print "<p>Form is valid.</p>";
        }
        // %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
        //
        // SECTION 2e: Save data: Insert data into database
        // and upload the file to the 'uploads' directory
        // %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
        
        // Rename the fileName!!! Query to find a unique name:
        // activityId#_numphotos $activityID
        // query to get $photoCount
        // query = SELECT count(pmkPhotoId) FROM `tblPhotos` WHERE fnkActivityId = 9
        $query = "SELECT count(pmkPhotoId) FROM tblPhotos";
        $query .= " WHERE fnkActivityId = ?";
        
        $data = array($activityID);
        $info = $thisDatabaseReader->select($query, $data, 1, 0, 0, 0, false, false);
//        print_r($info[0][0]);
        $photoCount = $info[0][0];
        
        # rename the file
        $new_file_name = $activityID . "_";
        $new_file_name .= $photoCount;
        $new_file_name .= ".";
        $new_file_name .= $extension;
//        print_r($new_file_name);
        // NEED to add new file to whitepage listing!!!
        // no need ... its working?
        
//        print "<pre>";
//        print_r($new_file_name);
        
        // upload the file to upload directory
//        $new_file_name = strtolower($fileName);
//        $new_file_name = str_replace(' ', '-', $new_file_name);
//        $new_file_name = substr($new_file_name, 0, -strlen($ext));
//        $new_file_name .= $extension;
        // Attemps to move file to upload directory, moveFile boolean!
        $movedFile = move_uploaded_file($file['tmp_name'], $upload_image_to_folder.$new_file_name);
        // add the new filename to the photoData array for insert query
        $photoData[] = $new_file_name;
        
        // QUERY, insert data the valid data into the table
        // INSERT INTO tblPhotos SET pmkPhotoId = NULL, fnkActivityId = 8, 
        // fnkNetId = 'aychu', fldCaption = 'everyone loves wine', 
        // fldApproved =0, fldFileName = "wine.jpg"
        
        // Add required fields to query
//        $query .= " fnkActivityId = ?,";
//        $query .= " fnkNetId = ?,";
//        $query .= " fldCaption = ?,";
//        $query .= " fldLink = ?,";
//        $query .= " fldApproved = ?,";
        
        $query = "INSERT INTO tblPhotos SET";
        $query .= " pmkPhotoId = NULL";
        $query .= ", fnkActivityId = ?";
        $query .= ", fnkNetId = ?";
        $query .= ", fldCaption = ?";
        $query .= ", fldApproved = 0";
        $query .= ", fldFileName = ?";


        $photoInsert = $thisDatabaseWriter->insert($query, $photoData, 0, 0, 0, 0, false, false);
        if ($photoInsert != 1){
            $uploadERROR = true;
        }
//        print_r($photoInsert);
//        $query = ;
        // SECTION 2f: Create message
        $message = "<h2>Thank you! Your activity has been submitted for approval</h2>";

        $message .= "<p>An administrator will review the submission to ensure";
        $message .= " that it does not violate our guidelines.";
        $message .= " You should receive a follow-up email if the information";
        $message .= " is inappropriate, incomplete, etc.</p>";

        $message.= "<p>A copy of the submitted information appears below.</p>";

//        print "<h4>";
//        print_r($_POST);
//        print "<\h4>";

        foreach ($_POST as $key => $value) {
            if ($key != 'btnSubmit') {
                $message.= "<p>";
                $camelCase = preg_split('/(?=[A-Z])/', substr($key, 3));
//                $camelCase = $key;
//                $message .= $camelCase;


                foreach ($camelCase as $one) {
                    $message.= $one . ' ';
                }
                $message = trim($message);

                $message.= ": " . htmlentities($value, ENT_QUOTES, "UTF-8") . "</p>";
            }
        }

        // Print out info on the $_FILES array
//        print"<pre>";
//        print_r($_FILES['imgFileToUpload']);
//        print "<hr>";
//        print_r($_POST);
        $message.= "<hr>";

        foreach ($file as $key => $value) {
            if ($key == "name") {
                $message.="<p>";
//                $message.=$key . " ";
                $message.="File Name ";
                $message = trim($message);
                $message.= ": " . htmlentities($value, ENT_QUOTES, "UTF-8") . "</p>";
            }
            // returns to user all info of file, not necessary
//            $message.="<p>";
//            $message.=$key . " ";
//            $message = trim($message);
//            $message.= ": " . htmlentities($value, ENT_QUOTES, "UTF-8") . "</p>";
        }

        $message .= "<br><p>Thanks again!</p>";
        $message .= "<br><p>The UVM Checkkit admin team</p>";


        // %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
        //
        // SECTION 2g: Mail to user

        $email = $user . "@uvm.edu";

        $to = $email; // the person who filled out form
        $cc = ""; // admins
        $bcc = "";
        $from = "UVM Chekkit <aychu@uvm.edu>";

        // subject of mail should match form
        $subject = "Thanks for your Photo Submission to UVM Chekkit!";

        // send mail
        $mailed = sendMail($to, $cc, $bcc, $from, $subject, $message);
    } // ends form is valid
} // closes btn submit   // ends if form was submitted
?>

<article>

    <?php
// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION 3a
// If its the first time coming to form or there are errors, display form.
    if (isset($_POST["btnSubmit"]) AND empty($errorMsg) AND ! empty($_FILES)) {

        print "<h2>Your request has ";

        if (!$mailed AND !$movedFile) {
            print 'not ';
        }

        print "been processed.</h2>";

        if ($mailed) {
            print '<section class="panel success-panel">';
            print "<p>A copy of this message has been sent to: " . $email . ".</p>";
            print $message;
            print "</section>";
        }
    } else {
        // %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
        //
        // SECTION 3b: Error messages: Display any error message before we print form

        if ($errorMsg) {
            print '<div class="panel alert-panel">';
            print '<h4>You need to address the following issues:</h4>';
            print "<ol>\n";
            foreach ($errorMsg as $err) {
                print "\t<li>" . $err . "</li>\n";
            }
            print "</ol>\n";
            print "</div>";
        }


// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION 3c: HTML form: Display HTML form
// Action is to this same page. $phpSelf is defined in top.php
        /* Note lines like: value="<?php print $email; ?>
         * These make the form sticky by displaying the default value or
         * the value that was typed in previously.
         * Also note lines like <?php if ($emailERROR) print 'class="mistake"'; ?>
         * These allow us to use CSS to identify errors with style. */
        ?>



        <h2>Submit a photo to Chekkit!</h2>
        <form action = "<?php print $phpSelf; ?>" 
              method = "post" 
              id="frmAddPhoto"
              enctype= "multipart/form-data">


            <!--Select image to upload:-->
            <fieldset class="wrapper">
                <legend></legend>
                <!--<p>Please provide the following information about the activity.</p>-->
                <legend>Activity You Selected: </legend>
                <!-- Display data of activity Name etc. from query!!! -->           
                <div class="row">
                    <div class="large-12 columns">
                        <!--Get the activity name!-->
                        <?php
                        $query = "SELECT fldName";
                        $query .= " FROM tblActivities";
                        $query .= " WHERE pmkActivityId = ?";
                        $data = array($activityID);

                        // Fetch data from database
//                $info = $thisDatabaseReader->testquery($query, $data, 1, 0, 0, 0, false, false);

                        $info = $thisDatabaseReader->select($query, $data, 1, 0, 0, 0, false, false);
//    $info2 = $thisDatabaseReader->testquery($query, $data, 1, 0, 0, 0, false, false);
//    print "<pre>";
//    print_r($info[0]["fldName"]);
                        print "<div><p>" . $info[0]["fldName"] . "</p></div>";
                        ?>

                        <input type="hidden" id="hidActivityId" name="hidActivityId"
                               value="<?php print $activityID; ?>"
                               >
<!--                        <input type="text" id="hidFldName" name="hidFldName"
                               value= "<?php // print $info[0]['fldName'];?>"
                               >-->
                            
                        <input type="hidden" id="hidNetId" name="hidNetId"
                               value="<?php print $user; ?>"
                               >
                    </div>  <!-- ends class="large-12 columns" -->
                </div> <!-- ends class="row" -->

                <label> Select image to upload:
                    <input type="file" name="imgFileToUpload" id="imgFileToUpload">
    <!--                <input type = "submit" value = "Upload Image" name = "submit">-->
                </label>
                <label> Add a photo caption! 
                    <input type ="text" id="txtPhotoCaption" name="txtPhotoCaption" 
                           value="<?php print $photoCaption; ?>"
                </label>

            </fieldset> <!-- ends basic info-->

            <!--        <fieldset class="optional-info">
                        <legend>Optional Information</legend>
                        <label for="txtDescription" class="required">Description
                            <input type="text" id="txtDescription" name="txtDescription"
                                                   value= "--> <?php // print $photoDescription;         ?> <!--"
                                                   tabindex="100" maxlength="45">
                        </label>
                    </fieldset> -->  <!--end optional-info--> 

            <fieldset class="buttons">
                <!--<legend></legend>-->
                <div class="row">
                    <div class="large-12 columns">
                        <input type="submit" id="btnSubmit" name="btnSubmit" value="Submit" tabindex="900" class="button">
                    </div>
                </div>
            </fieldset> <!-- ends buttons -->

            </fieldset> <!-- end wrapper! -->

        </form> <!-- end form! -->


    </article>

    <?php
}; // ends submit
include 'footer.php';
?>
