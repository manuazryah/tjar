<section>
    <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 sm-pad-right0 xs-pad-right0" id="slider">
        <!-- Add this css File in head tag-->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" media="all">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css" rel="stylesheet" media="all">


        <!--
               If you want to change #bootstrap-touch-slider id then you have to change Carousel-indicators and Carousel-Control  #bootstrap-touch-slider slide as well
               Slide effect: slide, fade
               Text Align: slide_style_center, slide_style_left, slide_style_right
               Add Text Animation: https://daneden.github.io/animate.css/
        -->


        <div id="bootstrap-touch-slider" class="carousel bs-slider fade  control-round indicators-line" data-ride="carousel" data-pause="hover" data-interval="5000" >

            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#bootstrap-touch-slider" data-slide-to="0" class="active"></li>
                <li data-target="#bootstrap-touch-slider" data-slide-to="1"></li>
                <li data-target="#bootstrap-touch-slider" data-slide-to="2"></li>
            </ol>

            <!-- Wrapper For Slides -->
            <div class="carousel-inner" role="listbox">

                <!-- Third Slide -->
                <div class="item active">

                    <!-- Slide Background -->
                    <img src="images/banner/banner1.jpg" alt="Bootstrap Touch Slider"  class="slide-image"/>
                    <!--<div class="bs-slider-overlay"></div>-->

                    <div class="container">
                        <div class="row">
                            <!-- Slide Text Layer -->
                            <!--                                    <div class="slide-text slide_style_left">
                                                                    <h1 data-animation="animated zoomInRight">Bootstrap Carousel</h1>
                                                                    <p data-animation="animated fadeInLeft">Bootstrap carousel now touch enable slide.</p>
                                                                </div>-->
                        </div>
                    </div>
                </div>
                <!-- End of Slide -->

                <!-- Second Slide -->
                <div class="item">

                    <!-- Slide Background -->
                    <img src="images/banner/banner1.jpg" alt="Bootstrap Touch Slider"  class="slide-image"/>
                    <!--<div class="bs-slider-overlay"></div>-->
                    <!-- Slide Text Layer -->
                    <!--                            <div class="slide-text slide_style_center">
                                                    <h1 data-animation="animated flipInX">Bootstrap touch slider</h1>
                                                    <p data-animation="animated lightSpeedIn">Make Bootstrap Better together.</p>
                                                </div>-->
                </div>
                <!-- End of Slide -->

                <!-- Third Slide -->
                <div class="item">

                    <!-- Slide Background -->
                    <img src="images/banner/banner1.jpg" alt="Bootstrap Touch Slider"  class="slide-image"/>
                    <!--<div class="bs-slider-overlay"></div>-->
                    <!-- Slide Text Layer -->
                    <!--                            <div class="slide-text slide_style_right">
                                                    <h1 data-animation="animated zoomInLeft">Beautiful Animations</h1>
                                                    <p data-animation="animated fadeInRight">Lots of css3 Animations to make slide beautiful .</p>
                                                </div>-->
                </div>
                <!-- End of Slide -->


            </div><!-- End of Wrapper For Slides -->

            <!-- Left Control -->
            <a class="left carousel-control" href="#bootstrap-touch-slider" role="button" data-slide="prev">
                <span class="fa fa-angle-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>

            <!-- Right Control -->
            <a class="right carousel-control" href="#bootstrap-touch-slider" role="button" data-slide="next">
                <span class="fa fa-angle-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>

        </div> <!-- End  bootstrap-touch-slider Slider -->
    </div>



    <div class="col-lg-2 col-md-2 hidden-sm hidden-xs" id="top-product-slider">
        <div class="container" style="min-width: 100%; max-width: 100%; padding: 0px;">
            <div>
                <div class='col-md-12' style="padding: 0px">
                    <div class="hot-deals-heading">
                        <img class="img-responsive" src="images/hot-deals-strip.png"/>
                        <h3>DEALS OF THE DAY</h3>
                    </div>
                    <div class="carousel slide media-carousel" id="media">
                        <div class="carousel-inner">
                            <div class="item  active"  >
                                <div class="" >
                                    <div class="col-md-4 product">
                                        <a href="product-detail.php">
                                            <div class="thumbnail">
                                                <img alt="" src="images/hot-deals/img-1.png">
                                                <div class="hot-deals-details">
                                                    <h3 class="product-name">Product Name</h3>
                                                    <div class="rating">
                                                        <input type="number" class="rating" id="test" name="test" data-min="1" data-max="5" value="0">
                                                    </div>
                                                    <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="row">

                                    <div class="col-md-4 product">
                                        <a href="product-detail.php">
                                            <div class="thumbnail">
                                                <img alt="" src="images/hot-deals/img-1.png">
                                                <div class="hot-deals-details">
                                                    <h3 class="product-name">Product Name</h3>
                                                    <div class="rating">
                                                        <input type="number" class="rating" id="test" name="test" data-min="1" data-max="5" value="0">
                                                    </div>
                                                    <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="row">

                                    <div class="col-md-4 product">
                                        <a href="product-detail.php">
                                            <div class="thumbnail">
                                                <img alt="" src="images/hot-deals/img-1.png">
                                                <div class="hot-deals-details">
                                                    <h3 class="product-name">Product Name</h3>
                                                    <div class="rating">
                                                        <input type="number" class="rating" id="test" name="test" data-min="1" data-max="5" value="0">
                                                    </div>
                                                    <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a data-slide="prev" href="#media" class="left carousel-control">‹</a>
                        <a data-slide="next" href="#media" class="right carousel-control">›</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="clearfix"></div>
<section id="col-3-specialoff">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <a href="#">
                    <img class="img-responsive" src="images/col-3-specialoff/off-1.png">
                </a>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <a href="#">
                    <img class="img-responsive" src="images/col-3-specialoff/off-2.png">
                </a>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <a href="#">
                    <img class="img-responsive" src="images/col-3-specialoff/off-3.png">
                </a>
            </div>
        </div>
    </div>
</section>

<section id="product-slider">
    <div class="container">
        <div class="category-heading">Featured Products</div>
        <div class="row">
            <div class="MultiCarousel" data-items="1,3,5,6" data-slide="1" id="MultiCarousel"  data-interval="1000">
                <div class="MultiCarousel-inner">
                    <div class="item">
                        <div class="pad25">
                            <a href="#">
                                <div class="product-img">
                                    <img class="img-responsive" src="images/products/featured/product1.png"/>
                                </div>
                                <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                <h5 class="product-discount">Upto 50% off</h5>
                                <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="pad25">
                            <a href="#">
                                <div class="product-img">
                                    <img class="img-responsive" src="images/products/featured/product2.png"/>
                                </div>
                                <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                <h5 class="product-discount">Upto 50% off</h5>
                                <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="pad25">
                            <a href="#">
                                <div class="product-img">
                                    <img class="img-responsive" src="images/products/featured/product3.png"/>
                                </div>
                                <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                <h5 class="product-discount">Upto 50% off</h5>
                                <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="pad25">
                            <a href="#">
                                <div class="product-img">
                                    <img class="img-responsive" src="images/products/featured/product4.png"/>
                                </div>
                                <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                <h5 class="product-discount">Upto 50% off</h5>
                                <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="pad25">
                            <a href="#">
                                <div class="product-img">
                                    <img class="img-responsive" src="images/products/featured/product5.png"/>
                                </div>
                                <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                <h5 class="product-discount">Upto 50% off</h5>
                                <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="pad25">
                            <a href="#">
                                <div class="product-img">
                                    <img class="img-responsive" src="images/products/featured/product1.png"/>
                                </div>
                                <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                <h5 class="product-discount">Upto 50% off</h5>
                                <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="pad25">
                            <a href="#">
                                <div class="product-img">
                                    <img class="img-responsive" src="images/products/featured/product2.png"/>
                                </div>
                                <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                <h5 class="product-discount">Upto 50% off</h5>
                                <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="pad25">
                            <a href="#">
                                <div class="product-img">
                                    <img class="img-responsive" src="images/products/featured/product3.png"/>
                                </div>
                                <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                <h5 class="product-discount">Upto 50% off</h5>
                                <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="pad25">
                            <a href="#">
                                <div class="product-img">
                                    <img class="img-responsive" src="images/products/featured/product4.png"/>
                                </div>
                                <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                <h5 class="product-discount">Upto 50% off</h5>
                                <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="pad25">
                            <a href="#">
                                <div class="product-img">
                                    <img class="img-responsive" src="images/products/featured/product5.png"/>
                                </div>
                                <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                <h5 class="product-discount">Upto 50% off</h5>
                                <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                            </a>
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary leftLst"><</button>
                <button class="btn btn-primary rightLst">></button>
            </div>
        </div>
    </div>
</section>

<section id="col-3-specialoff" class="text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 xs-pad-botm30">
                <img class="img-responsive xs-align-center" src="images/col-3-specialoff/off-4.png">
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 xs-pad-botm30">
                <img class="img-responsive xs-align-center" src="images/col-3-specialoff/off-5.png">
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 xs-pad-botm30 xs-align-center">
                <img class="img-responsive xs-align-center" src="images/col-3-specialoff/off-6.png">
            </div>
        </div>
    </div>
</section>

<section id="product-slider">
    <div class="container">
        <div class="category-heading">Eletronic Products</div>
        <div class="row">
            <div class="MultiCarousel" data-items="1,3,5,6" data-slide="1" id="MultiCarousel"  data-interval="1000">
                <div class="MultiCarousel-inner">
                    <div class="item">
                        <div class="pad25">
                            <a href="#">
                                <div class="product-img">
                                    <img class="img-responsive" src="images/products/eletronic/product1.png"/>
                                </div>
                                <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                <h5 class="product-discount">Upto 50% off</h5>
                                <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="pad25">
                            <a href="#">
                                <div class="product-img">
                                    <img class="img-responsive" src="images/products/eletronic/product2.png"/>
                                </div>
                                <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                <h5 class="product-discount">Upto 50% off</h5>
                                <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="pad25">
                            <a href="#">
                                <div class="product-img">
                                    <img class="img-responsive" src="images/products/eletronic/product3.png"/>
                                </div>
                                <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                <h5 class="product-discount">Upto 50% off</h5>
                                <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="pad25">
                            <a href="#">
                                <div class="product-img">
                                    <img class="img-responsive" src="images/products/eletronic/product4.png"/>
                                </div>
                                <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                <h5 class="product-discount">Upto 50% off</h5>
                                <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="pad25">
                            <a href="#">
                                <div class="product-img">
                                    <img class="img-responsive" src="images/products/eletronic/product5.png"/>
                                </div>
                                <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                <h5 class="product-discount">Upto 50% off</h5>
                                <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="pad25">
                            <a href="#">
                                <div class="product-img">
                                    <img class="img-responsive" src="images/products/eletronic/product1.png"/>
                                </div>
                                <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                <h5 class="product-discount">Upto 50% off</h5>
                                <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="pad25">
                            <a href="#">
                                <div class="product-img">
                                    <img class="img-responsive" src="images/products/eletronic/product2.png"/>
                                </div>
                                <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                <h5 class="product-discount">Upto 50% off</h5>
                                <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="pad25">
                            <a href="#">
                                <div class="product-img">
                                    <img class="img-responsive" src="images/products/eletronic/product3.png"/>
                                </div>
                                <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                <h5 class="product-discount">Upto 50% off</h5>
                                <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="pad25">
                            <a href="#">
                                <div class="product-img">
                                    <img class="img-responsive" src="images/products/eletronic/product4.png"/>
                                </div>
                                <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                <h5 class="product-discount">Upto 50% off</h5>
                                <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="pad25">
                            <a href="#">
                                <div class="product-img">
                                    <img class="img-responsive" src="images/products/eletronic/product5.png"/>
                                </div>
                                <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                <h5 class="product-discount">Upto 50% off</h5>
                                <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                            </a>
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary leftLst"><</button>
                <button class="btn btn-primary rightLst">></button>
            </div>
        </div>
    </div>
</section>

<section id="col-6-specialoff">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <img class="img-responsive" src="images/col-6-specialoff/off1.png">
            </div>
            <div class="col-md-6 col-sm-6">
                <img class="img-responsive" src="images/col-6-specialoff/off2.png">
            </div>
        </div>
    </div>
</section>

<section id="product-slider">
    <div class="container">
        <div class="category-heading">Home & Furniture</div>
        <div class="row">
            <div class="MultiCarousel" data-items="1,3,5,6" data-slide="1" id="MultiCarousel"  data-interval="1000">
                <div class="MultiCarousel-inner">
                    <div class="item">
                        <div class="pad25">
                            <a href="#">
                                <div class="product-img">
                                    <img class="img-responsive" src="images/products/hom&furniture/product1.png"/>
                                </div>
                                <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                <h5 class="product-discount">Upto 50% off</h5>
                                <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="pad25">
                            <a href="#">
                                <div class="product-img">
                                    <img class="img-responsive" src="images/products/hom&furniture/product2.png"/>
                                </div>
                                <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                <h5 class="product-discount">Upto 50% off</h5>
                                <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="pad25">
                            <a href="#">
                                <div class="product-img">
                                    <img class="img-responsive" src="images/products/hom&furniture/product3.png"/>
                                </div>
                                <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                <h5 class="product-discount">Upto 50% off</h5>
                                <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="pad25">
                            <a href="#">
                                <div class="product-img">
                                    <img class="img-responsive" src="images/products/hom&furniture/product4.png"/>
                                </div>
                                <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                <h5 class="product-discount">Upto 50% off</h5>
                                <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="pad25">
                            <a href="#">
                                <div class="product-img">
                                    <img class="img-responsive" src="images/products/hom&furniture/product5.png"/>
                                </div>
                                <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                <h5 class="product-discount">Upto 50% off</h5>
                                <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="pad25">
                            <a href="#">
                                <div class="product-img">
                                    <img class="img-responsive" src="images/products/hom&furniture/product1.png"/>
                                </div>
                                <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                <h5 class="product-discount">Upto 50% off</h5>
                                <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="pad25">
                            <a href="#">
                                <div class="product-img">
                                    <img class="img-responsive" src="images/products/hom&furniture/product2.png"/>
                                </div>
                                <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                <h5 class="product-discount">Upto 50% off</h5>
                                <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="pad25">
                            <a href="#">
                                <div class="product-img">
                                    <img class="img-responsive" src="images/products/hom&furniture/product3.png"/>
                                </div>
                                <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                <h5 class="product-discount">Upto 50% off</h5>
                                <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="pad25">
                            <a href="#">
                                <div class="product-img">
                                    <img class="img-responsive" src="images/products/hom&furniture/product4.png"/>
                                </div>
                                <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                <h5 class="product-discount">Upto 50% off</h5>
                                <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="pad25">
                            <a href="#">
                                <div class="product-img">
                                    <img class="img-responsive" src="images/products/hom&furniture/product5.png"/>
                                </div>
                                <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                <h5 class="product-discount">Upto 50% off</h5>
                                <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                            </a>
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary leftLst"><</button>
                <button class="btn btn-primary rightLst">></button>
            </div>
        </div>
    </div>
</section>

<section id="special-features">
    <div class="container">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 feature">
            <h4><span><i class="fa fa-shopping-cart" aria-hidden="true"></i></span>FREE SHIPPING ON ORDER OVER $99</h4>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 feature">
            <h4><span><i class="fa fa-shopping-cart" aria-hidden="true"></i></span>24/7 CUSTOMER SUPPORT SERVICE</h4>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 feature">
            <h4><span><i class="fa fa-shopping-cart" aria-hidden="true"></i></span>5% DISCOUNT ON ORDER OVER $200</h4>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 feature">
            <h4><span><i class="fa fa-shopping-cart" aria-hidden="true"></i></span>30 DAYS MONEY BACK GUARANTEE</h4>
        </div>
    </div>
</section>