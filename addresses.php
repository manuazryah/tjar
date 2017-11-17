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
                            <li class="active"><a href="addresses.php">Addresses</a></li>
                            <li><a href="account-details.php">Account Details</a></li>
                            <li><a href="wishlist.php">Wish List</a></li>
                            <li><a>Log Out</a></li>
                        </ul>
                    </nav>
                </div>
            </div>

            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                <div class="MyAccount-content">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 welcome-msg">
                        <p>The following addresses will be used on the checkout page by default.</p>
                    </div>

                    <div id="divAnim">
                        <!--<input type="button" id="btAnimate" value="Click it" />-->
                        <button type="button" id="btAnimate"><span>+</span> ADD A NEW ADDRESS</button>
                        <div id="divC" class="edit-address-popup ">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 shipping-address">
                                <!--<h2 class="section__title">Billing Address</h2>-->
                                <form>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 padlft0 first-name">
                                        <input placeholder="First name" required="" autocomplete="" data-backup="first_name" class="field__input input-width" size="" type="text" name="" id="checkout_shipping_address_first_name">
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 padlft0 last-name padright0">
                                        <input placeholder="Last name" required="" autocomplete="" data-backup="last_name" class="field__input input-width" size="" type="text" name="" id="checkout_shipping_address_last_name">
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 padlft0 address">
                                        <input placeholder="Address" required="" autocomplete="" data-backup="" class="field__input input-width" size="" type="text" name="" id="">
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 padlft0 padright0 apt">
                                        <input placeholder="Apt, suite, etc. (optional)" required="" autocomplete="" data-backup="" class="field__input input-width" size="" type="text" name="" id="">
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padlft0 padright0 city">
                                        <input placeholder="City" required="" autocomplete="" data-backup="" class="field__input input-width" size="" type="text" name="" id="">
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 padlft0">
                                        <select class="country-select input-width"  required name="school" id="schoolContainer">
                                            <option value="None" selected=""> Your Country</option>
                                            <option value="uae">UAE</option>
                                            <option value="india">INDIA</option>
                                            <option value="usa">USA</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 padlft0">
                                        <select class="country-select input-width"  required name="school" id="schoolContainer">
                                            <option value="None" selected=""> State</option>
                                            <option value="uae">OMAN</option>
                                            <option value="india">KERALA</option>
                                            <option value="usa">LAS VEGAS</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 padlft0 padright0">
                                        <input placeholder="Pincode" autocomplete="shipping postal-code" required="" data-backup="zip" data-google-autocomplete="true" data-google-autocomplete-title="Suggestions" class="field__input field__input--zip input-width" aria-required="true" size="" type="text" name="" id="">
                                    </div>
                                    <!--                                    <div class="clearfix"></div>
                                                                        <input class="input-checkbox" data-backup="" type="checkbox" value="1" name="" id="save-info"><label class="checkbox__label" for="save-info">Save this information for next time</label>-->
                                    <div class="clearfix"></div>
                                    <div class="clearfix"></div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pad0">
                                        <div class="marg-top-20">
                                            <!--<a href="" class="continue-shopping">Return to Cart</a>-->
                                            <button style="width: 25%;margin-right: 40px;" class="Proceed">Save</button>
                                            <a class="Cancel" id="btHide" >Cancel</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="marg-top-btm20 my-account-address">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 address">
                            <div class="option-space">
                                <b><span>Name</span><span class="number">8907366563</span></b> <span><button class="default">DEFAULT</button></span>
                                <ul class="nav navbar-nav">
                                    <li class="option-btn dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0IiBoZWlnaHQ9IjE2IiB2aWV3Qm94PSIwIDAgNCAxNiI+CiAgICA8ZyBmaWxsPSIjODc4Nzg3IiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPgogICAgICAgIDxjaXJjbGUgY3g9IjIiIGN5PSIyIiByPSIyIi8+CiAgICAgICAgPGNpcmNsZSBjeD0iMiIgY3k9IjgiIHI9IjIiLz4KICAgICAgICA8Y2lyY2xlIGN4PSIyIiBjeT0iMTQiIHI9IjIiLz4KICAgIDwvZz4KPC9zdmc+Cg=="/></a>
                                        <ul class="dropdown-menu options">
                                            <li><a href="#">Edit</a></li>
                                            <li><a href="#">Set as default</a></li>
                                            <li><a href="#">Delete</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <address>
                                Azryah Networks,
                                vishal ramesh,
                                Azryah Networks,
                                Azryah Networks,
                                Ernakulam - 682037,
                                Kerala, India
                            </address>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 address">
                            <div class="option-space">
                                <b><span>Name</span><span class="number">8907366563</span></b> 
                                <ul class="nav navbar-nav">
                                    <li class="option-btn dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0IiBoZWlnaHQ9IjE2IiB2aWV3Qm94PSIwIDAgNCAxNiI+CiAgICA8ZyBmaWxsPSIjODc4Nzg3IiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPgogICAgICAgIDxjaXJjbGUgY3g9IjIiIGN5PSIyIiByPSIyIi8+CiAgICAgICAgPGNpcmNsZSBjeD0iMiIgY3k9IjgiIHI9IjIiLz4KICAgICAgICA8Y2lyY2xlIGN4PSIyIiBjeT0iMTQiIHI9IjIiLz4KICAgIDwvZz4KPC9zdmc+Cg=="/></a>
                                        <ul class="dropdown-menu options">
                                            <li><a href="#">Edit</a></li>
                                            <li><a href="#">Set as default</a></li>
                                            <li><a href="#">Delete</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <address>
                                Azryah Networks,
                                vishal ramesh,
                                Azryah Networks,
                                Azryah Networks,
                                Ernakulam - 682037,
                                Kerala, India
                            </address>
                        </div>

                    </div>
                </div>

                <div class="modal fade edit-address-popup" role="dialog"  id="editbillingaddress">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 modal-dialog bg-white checkout-lft-box">
                        <div class="step__sections">

                            <div class="section section--contact-information">
                                <div class="section__header">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 shipping-address">
                                        <h2 class="section__title">Billing Address</h2>
                                        <form>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 padlft0 first-name">
                                                <input placeholder="First name" required="" autocomplete="" data-backup="first_name" class="field__input input-width" size="" type="text" name="" id="checkout_shipping_address_first_name">
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 padlft0 last-name padright0">
                                                <input placeholder="Last name" required="" autocomplete="" data-backup="last_name" class="field__input input-width" size="" type="text" name="" id="checkout_shipping_address_last_name">
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 padlft0 address">
                                                <input placeholder="Address" required="" autocomplete="" data-backup="" class="field__input input-width" size="" type="text" name="" id="">
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 padlft0 padright0 apt">
                                                <input placeholder="Apt, suite, etc. (optional)" required="" autocomplete="" data-backup="" class="field__input input-width" size="" type="text" name="" id="">
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padlft0 padright0 city">
                                                <input placeholder="City" required="" autocomplete="" data-backup="" class="field__input input-width" size="" type="text" name="" id="">
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 padlft0">
                                                <select class="country-select input-width"  required name="school" id="schoolContainer">
                                                    <option value="None" selected=""> Your Country</option>
                                                    <option value="uae">UAE</option>
                                                    <option value="india">INDIA</option>
                                                    <option value="usa">USA</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 padlft0">
                                                <select class="country-select input-width"  required name="school" id="schoolContainer">
                                                    <option value="None" selected=""> State</option>
                                                    <option value="uae">OMAN</option>
                                                    <option value="india">KERALA</option>
                                                    <option value="usa">LAS VEGAS</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 padlft0 padright0">
                                                <input placeholder="Pincode" autocomplete="shipping postal-code" required="" data-backup="zip" data-google-autocomplete="true" data-google-autocomplete-title="Suggestions" class="field__input field__input--zip input-width" aria-required="true" size="" type="text" name="" id="">
                                            </div>
                                            <!--                                    <div class="clearfix"></div>
                                                                                <input class="input-checkbox" data-backup="" type="checkbox" value="1" name="" id="save-info"><label class="checkbox__label" for="save-info">Save this information for next time</label>-->
                                            <div class="clearfix"></div>
                                            <div class="clearfix"></div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pad0">
                                                <div class="">
                                                    <!--<a href="" class="continue-shopping">Return to Cart</a>-->
                                                    <button class="Proceed center">Save Changes</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>

                <div class="modal fade edit-address-popup" role="dialog"  id="editshippingaddress">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 modal-dialog bg-white checkout-lft-box">
                        <div class="step__sections">

                            <div class="section section--contact-information">
                                <div class="section__header">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 shipping-address">
                                        <h2 class="section__title">Shipping Address</h2>
                                        <form>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 padlft0 first-name">
                                                <input placeholder="First name" required="" autocomplete="" data-backup="first_name" class="field__input input-width" size="" type="text" name="" id="checkout_shipping_address_first_name">
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 padlft0 last-name padright0">
                                                <input placeholder="Last name" required="" autocomplete="" data-backup="last_name" class="field__input input-width" size="" type="text" name="" id="checkout_shipping_address_last_name">
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 padlft0 address">
                                                <input placeholder="Address" required="" autocomplete="" data-backup="" class="field__input input-width" size="" type="text" name="" id="">
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 padlft0 padright0 apt">
                                                <input placeholder="Apt, suite, etc. (optional)" required="" autocomplete="" data-backup="" class="field__input input-width" size="" type="text" name="" id="">
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padlft0 padright0 city">
                                                <input placeholder="City" required="" autocomplete="" data-backup="" class="field__input input-width" size="" type="text" name="" id="">
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 padlft0">
                                                <select class="country-select input-width"  required name="school" id="schoolContainer">
                                                    <option value="None" selected=""> Your Country</option>
                                                    <option value="uae">UAE</option>
                                                    <option value="india">INDIA</option>
                                                    <option value="usa">USA</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 padlft0">
                                                <select class="country-select input-width"  required name="school" id="schoolContainer">
                                                    <option value="None" selected=""> State</option>
                                                    <option value="uae">OMAN</option>
                                                    <option value="india">KERALA</option>
                                                    <option value="usa">LAS VEGAS</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 padlft0 padright0">
                                                <input placeholder="Pincode" autocomplete="shipping postal-code" required="" data-backup="zip" data-google-autocomplete="true" data-google-autocomplete-title="Suggestions" class="field__input field__input--zip input-width" aria-required="true" size="" type="text" name="" id="">
                                            </div>
                                            <!--                                    <div class="clearfix"></div>
                                                                                <input class="input-checkbox" data-backup="" type="checkbox" value="1" name="" id="save-info"><label class="checkbox__label" for="save-info">Save this information for next time</label>-->
                                            <div class="clearfix"></div>
                                            <div class="clearfix"></div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pad0">
                                                <div class="">
                                                    <!--<a href="" class="continue-shopping">Return to Cart</a>-->
                                                    <button class="Proceed center">Save Changes</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include './includes/footer.php'; ?>

