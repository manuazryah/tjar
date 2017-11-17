<?php include './includes/header.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pad-t-b-30 bg-white">
            <div class="my-account-sidebar">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <h3 class="MyAccount-title">My Account</h3>
                    <nav>
                        <ul>
                            <li><a href="my-account.php">Dashboard</a></li>
                            <li><a href="orders.php">orders</a></li>
                            <li><a href="reviews-ratings.php">Reviews & Ratings</a></li>
                            <li><a href="addresses.php">Addresses</a></li>
                            <li class="active"><a href="account-details.php">Account Details</a></li>
                            <li><a href="wishlist.php">Wish List</a></li>
                            <li><a>Log Out</a></li>
                        </ul>
                    </nav>
                </div>
            </div>

            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                <div class="MyAccount-content">
                    <div class="edit-account"
                         <form>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 marg-btm-20">
                                <label>First Name*</label>
                                <input type="text">
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 marg-btm-20">
                                <label>Last Name*</label>
                                <input type="text">
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 marg-btm-20">
                                <label>Email Address*</label>
                                <input type="email">
                            </div>
                        </form>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 marg-top-20">
                            <fieldset>
                                <legend>Password change</legend>

                                <p class=" marg-btm-20">
                                    <label for="password_current">Current password (leave blank to leave unchanged)</label>
                                    <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_current" id="password_current">
                                </p>
                                <p class=" marg-btm-20">
                                    <label for="password_1">New password (leave blank to leave unchanged)</label>
                                    <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_1" id="password_1">
                                </p>
                                <p class=" marg-btm-20">
                                    <label for="password_2">Confirm new password</label>
                                    <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_2" id="password_2">
                                </p>
                            </fieldset>
                        </div>
                         
                         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 marg-top-20">
                             <button class="Proceed center">Save Changes</button>
                        </div>
                         
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './includes/footer.php'; ?>

