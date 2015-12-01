<nav> 
    <ol>
        <?php
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
        ?>
    </ol>
</nav>