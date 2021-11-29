<?php include_once 'nav.php' ?>

<section class="signup-form">
    <h2>Sign Up</h2>
    <form action="includes/signup-inc.php" method="POST"> <!-- POST method so that data is not seen inside URL --> 
        <input type="text" name="first-name" placeholder="First name">
        <input type="text" name="second-name" placeholder="Second name">
        <input type="text" name="email" placeholder="Email">
        <input type="password" name="password" placeholder="Password">
        <input type="password" name="verify-password" placeholder="Confirm Password">
        <button type="submit" name="submit">Sign Up</button>
    </form>
</section>

<?php include_once 'footer.php' ?>