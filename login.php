<?php include_once 'nav.php' ?>

<section class="login-form">
    <h2>Log In</h2>
    <form action="includes/login-inc.php" method="POST"> <!-- POST method so that data is not seen inside URL --> 
        <input type="text" name="name" placeholder="Username/Email">
        <input type="password" name="password" placeholder="Password">
        <button type="submit" name="submit">Log In</button>
    </form>
</section>


<?php include_once 'footer.php' ?>