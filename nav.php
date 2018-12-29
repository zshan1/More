<!-- ######################     Main Navigation   ########################## -->
<nav class="t">
    <ol class="top">
        <?php
        if ($path_parts['filename'] == "index") {
            print '<li class="activePage">Home</li>';
        } else {
            print '<li><a href="index.php">Home</a></li>';
        }
         if ($path_parts['filename'] == "products") {
            print '<li class="activePage">Products</li>';
        } else {
            print '<li><a href="products.php">Products</a></li>';
        }
        if ($path_parts['filename'] == "form") {
            print '<li class="activePage">Help</li>';
        } else {
            print '<li><a href="form.php">Help</a></li>';
        }
        if ($path_parts['filename'] == "contact") {
            print '<li class="activePage">Contact</li>';
        } else {
            print '<li><a href="contact.php">Contact</a></li>';
        }
        if ($path_parts['filename'] == "questionaire") {
            print '<li class="activePage">Questionaire</li>';
        } else {
            print '<li><a href="questionaire.php">Questionaire</a></li>';  
        }
        ?>
    </ol>
</nav>