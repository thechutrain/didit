<!-- ######################     Main Navigation   ########################## -->

    <ul class="menu">
        <?php
        // This sets the current page to not be a link. Repeat this if block for
        //  each menu item

        if ($path_parts['filename'] == "index") {
            print '<li class="activePage">Home</li>';
        } else {
            print '<li><a href="' . $path . 'index.php">Home</a></li>';
        }

        if ($path_parts['filename'] == "top-10") {
            print '<li class="activePage">The Top 10</li>';
        } else {
            print '<li><a href="' . $path . 'top-10.php">The Top 10</a></li>';
        }

        if ($path_parts['filename'] == "form") {
            print '<li class="activePage">Suggest an Activity!</li>';
        } else {
            print '<li><a href="' . $path . 'form.php">Suggest an Activity!</a></li>';
        }

        if ($path_parts['filename'] == "about") {
            print '<li class="activePage">About the List</li>';
        } else {
            print '<li><a href="' . $path . 'about.php">About the List</a></li>';
        }

        if (adminCheck($thisDatabaseReader, $username)) {
            print "<li><a>Admin Only</a></li>";
//            nested menu
            print "<ul class='menu'>";

            if ($path_parts['filename'] == "approve") {
                print '<li class="activePage">Approve</li>';
            } else {
                print '<li><a href="' . $adminPath . 'approve.php">Approve</a></li>';
            }
            
            if ($path_parts['filename'] == "remove") {
                print '<li class="activePage">Remove</li>';
            } else {
                print '<li><a href="' . $adminPath . 'remove.php">Remove</a></li>';
            }
           print "</ul>"; 
        }
        ?>
    </ul>

<!-- #################### Ends Main Navigation    ########################## -->

<!--<ul class="dropdown menu" data-dropdown-menu>
  <li>
    <a>Item 1</a>
    <ul class="menu">
      <li><a href="#">Item 1A Loooong</a></li>
      <li>
        <a href='#'> Item 1 sub</a>
        <ul class='menu'>
          <li><a href='#'>Item 1 subA</a></li>
          <li><a href='#'>Item 1 subB</a></li>
          <li>
            <a href='#'> Item 1 sub</a>
            <ul class='menu'>
              <li><a href='#'>Item 1 subA</a></li>
              <li><a href='#'>Item 1 subB</a></li>
            </ul>
          </li>
          <li>
            <a href='#'> Item 1 sub</a>
            <ul class='menu'>
              <li><a href='#'>Item 1 subA</a></li>
            </ul>
          </li>
        </ul>
      </li>
      <li><a href="#">Item 1B</a></li>
    </ul>
  </li>
  <li>
    <a href="#">Item 2</a>
    <ul class="menu">
      <li><a href="#">Item 2A</a></li>
      <li><a href="#">Item 2B</a></li>
    </ul>
  </li>
  <li><a href="#">Item 3</a></li>
  <li><a href='#'>Item 4</a></li>
</ul>-->