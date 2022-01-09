
<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">

    <a class="navbar-brand col-md-3 col-lg-3 me-0 px-3" href="#">Company name</a>
    <ul class="nav col-md-6  mb-2 justify-content-start mb-md-0">


        <li><a  class="nav-link px-2 link-secondary" href="/categories/categories.php">List</a></li>
        <li><a  class="nav-link px-2 link-light" href="/categories/category-add.php">Add</a></li>

    </ul>
    <ul class="nav col-md-3 mb-2 justify-content-start mb-md-0">
        <li><a  class="nav-link px-2 link-secondary"  >
                Welcome, <?php echo $_SESSION["userInfo"]; ?>
            </a>
        </li>
        <li><a  class="nav-link px-2 link-secondary" href="/logout.php" >
               Logout
            </a>
        </li>

    </ul>
</header>