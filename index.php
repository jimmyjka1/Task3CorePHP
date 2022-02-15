<?php 
    session_start();
    require_once "Utilities/helpers.php";

    // code to get profile image url 
    if (isset($_SESSION['user_id'])){
        $query = "SELECT profile_image_url FROM `User` WHERE id=:id";
        $params = array(
            ":id" => $_SESSION['user_id']
        );

        $result = executeQueryResult($pdo, $query, $params);
        $profile_url = $result[0]['profile_image_url'];
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Styles/indexStyle.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous"> -->
    <?php importBootstrapCSS(); ?>


    <title>Shop</title>
</head>

<body>
    <?php require_once "Views/navbar.php" ?>
    <div class="container px-md-5" id="firstContainer">
    <img scr="images/exploreImages2.jpeg">
        <div class="row mx-md-n5">
            <div class="col-12 col-lg-6 w-100 p-md-2">
                <div class="" id="firstContainerItems1">
                    <div class="firstContainerDataItem w-100 h-100 d-flex flex-column justify-content-center align-items-center text-white"
                        id="firstDataItem1">
                        <div id="flCont">
                            <span class="largeText">We are Hexashop</span>
                            <p class="itallic">Aewsome, clean & creative HTML5 template</p>
                            <button>Purchase Now</button>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-12 col-lg-6">
                <div class="row">
                    <div class="col-12 col-lg-6 p-md-2">
                        <div class="" id="firstContainerItems2">
                            <div class="firstContainerDataItem w-100 h-100 d-flex flex-column justify-content-center align-items-center text-white"
                                id="firstDataItem2">
                                <span class="mediumText">Women</span>
                                <p class="itallic">Best Clothes for Women</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 p-md-2">
                        <div class="" id="firstContainerItems3">
                            <div class="firstContainerDataItem w-100 h-100 d-flex flex-column justify-content-center align-items-center text-white"
                                id="firstDataItem3">
                                <span class="mediumText">Men</span>
                                <p class="itallic">Best Clothes for Men</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-6 p-md-2">
                        <div class="" id="firstContainerItems4">
                            <div class="firstContainerDataItem w-100 h-100 d-flex flex-column justify-content-center align-items-center text-white"
                                id="firstDataItem4">
                                <span class="mediumText">Kids</span>
                                <p class="itallic">Best Clothes for Kids</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 p-md-2">
                        <div class="" id="firstContainerItems5">
                            <div class="firstContainerDataItem w-100 h-100 d-flex flex-column justify-content-center align-items-center text-white"
                                id="firstDataItem5">
                                <span class="mediumText">Accessories</span>
                                <p class="itallic">Best Trend Accessories</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <!-- <hr class="afterFirst"> -->

    <div class="mensContainer d-flex flex-row justify-content-between" id="menSection">
        <div class="arrow1 d-none d-md-flex justify-content-center align-items-center">
            <i class="material-icons">&#xe5cb;</i>
        </div>
        <div class="arrowItems h-100 w-100">
            <h1>Men's Latest</h1>
            <p class="itallic color-grey no-margins">
                Details to details is what makes Hexashop different from the other themes
            </p>
            <div class="imageListContainer row mx-auto">
                <div class="imageListItem col-12 col-md-4 pt-3">
                    <img class="" src="images/mensImage1.jpg" alt="mens1">
                    <p class="m-0 mb-lg-2 d-lg-inline-block mt-lg-2">Classic Spin</p>
                    <i
                        class="material-icons stars m-0 float-lg-right mt-lg-2">&#xe838;&#xe838;&#xe838;&#xe838;&#xe838;</i><br>
                    <span class="color-grey price m-0">$200.00</span>
                </div>
                <div class="imageListItem col-12 col-md-4 pt-3">
                    <img src="images/mensImage2.jpg" alt="mens1">
                    <p class="m-0 mb-lg-2 d-lg-inline-block mt-lg-2">AirForce 1 X</p>
                    <i
                        class="material-icons stars m-0 float-lg-right mt-lg-2">&#xe838;&#xe838;&#xe838;&#xe838;&#xe838;</i><br>
                    <span class="color-grey price m-0">$202.00</span>
                </div>
                <div class="imageListItem col-12 col-md-4 pt-3">
                    <img src="images/mensImage3.jpg" alt="mens1">
                    <p class="m-0 mb-lg-2 d-lg-inline-block mt-lg-2">Love Nana 20</p>
                    <i
                        class="material-icons stars m-0 float-lg-right mt-lg-2">&#xe838;&#xe838;&#xe838;&#xe838;&#xe838;</i><br>
                    <span class="color-grey price m-0">$2000.00</span>
                </div>

            </div>
        </div>
        <div class="arrow3 d-none d-md-flex justify-content-center align-items-center" id="menarrow3">
            <i class="material-icons">&#xe5cc;</i>
        </div>
    </div>

    <div class="mensContainer d-flex flex-row justify-content-between" id="menSection">
        <div class="arrow1 d-none d-md-flex justify-content-center align-items-center">
            <i class="material-icons">&#xe5cb;</i>
        </div>
        <div class="arrowItems h-100 w-100">
            <h1>Women's Latest</h1>
            <p class="itallic color-grey no-margins">
                Details to details is what makes Hexashop different from the other themes
            </p>
            <div class="imageListContainer row mx-auto">
                <div class="imageListItem col-12 col-md-4 pt-3">
                    <img src="images/womensImage1.jpg" alt="mens1">
                    <p class="m-0 mb-lg-2 d-lg-inline-block mt-lg-2">New Green Jacket</p>
                    <i
                        class="material-icons stars m-0 float-lg-right mt-lg-2">&#xe838;&#xe838;&#xe838;&#xe838;&#xe838;</i><br>
                    <span class="color-grey price m-0">$200.00</span>
                </div>
                <div class="imageListItem col-12 col-md-4 pt-3">
                    <img src="images/womensImage2.jpg" alt="mens1">
                    <p class="m-0 mb-lg-2 d-lg-inline-block mt-lg-2">Classic Dress</p>
                    <i
                        class="material-icons stars m-0 float-lg-right mt-lg-2">&#xe838;&#xe838;&#xe838;&#xe838;&#xe838;</i><br>
                    <span class="color-grey price m-0">$202.00</span>
                </div>
                <div class="imageListItem col-12 col-md-4 pt-3">
                    <img src="images/womensImage3.jpg" alt="mens1">
                    <p class="m-0 mb-lg-2 d-lg-inline-block mt-lg-2">Spring Collection</p>
                    <i
                        class="material-icons stars m-0 float-lg-right mt-lg-2">&#xe838;&#xe838;&#xe838;&#xe838;&#xe838;</i><br>
                    <span class="color-grey price m-0">$2000.00</span>
                </div>

            </div>
        </div>
        <div class="arrow3 d-none d-md-flex justify-content-center align-items-center" id="menarrow3">
            <i class="material-icons">&#xe5cc;</i>
        </div>
    </div>


    <!-- ---------------------------- -->
    <div class="mensContainer d-flex flex-row justify-content-between" id="menSection">
        <div class="arrow1 d-none d-md-flex justify-content-center align-items-center">
            <i class="material-icons">&#xe5cb;</i>
        </div>
        <div class="arrowItems h-100 w-100">
            <h1>Kids's Latest</h1>
            <p class="itallic color-grey no-margins">
                Details to details is what makes Hexashop different from the other themes
            </p>
            <div class="imageListContainer row mx-auto">
                <div class="imageListItem col-12 col-md-4 pt-3">
                    <img src="images/kidsImages1.jpg" alt="mens1">
                    <p class="m-0 mb-lg-2 d-lg-inline-block mt-lg-2">School Collection</p>
                    <i
                        class="material-icons stars m-0 float-lg-right mt-lg-2">&#xe838;&#xe838;&#xe838;&#xe838;&#xe838;</i><br>
                    <span class="color-grey price m-0">$200.00</span>
                </div>
                <div class="imageListItem col-12 col-md-4 pt-3">
                    <img src="images/kidsImages2.jpg" alt="mens1">
                    <p class="m-0 mb-lg-2 d-lg-inline-block mt-lg-2">Summer Camp</p>
                    <i
                        class="material-icons stars m-0 float-lg-right mt-lg-2">&#xe838;&#xe838;&#xe838;&#xe838;&#xe838;</i><br>
                    <span class="color-grey price m-0">$202.00</span>
                </div>
                <div class="imageListItem col-12 col-md-4 pt-3">
                    <img src="images/kidsImages3.jpg" alt="mens1">
                    <p class="m-0 mb-lg-2 d-lg-inline-block mt-lg-2">Classic Kid</p>
                    <i
                        class="material-icons stars m-0 float-lg-right mt-lg-2">&#xe838;&#xe838;&#xe838;&#xe838;&#xe838;</i><br>
                    <span class="color-grey price m-0">$2000.00</span>
                </div>

            </div>
        </div>
        <div class="arrow3 d-none d-md-flex justify-content-center align-items-center" id="menarrow3">
            <i class="material-icons">&#xe5cc;</i>
        </div>
    </div>

    <div class="row justify-content-between exploreContainer1 mx-auto">
        <div class="col-12 col-lg-6" id="exploreItem11">
            <h1 class="ml-5 ml-md-auto">Explore Our Products</h1>
            <p class="color-grey">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam corporis ut consequuntur
                delectus harum ea eos! Iusto accusamus vel blanditiis earum odit dignissimos?</p>
            <p class="quotationMark1">
                <img src="images/quotation.png" alt="">
            <p class="itallic" id="quote1">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Lorem ipsum dolor
                sit.</p>
            </p>
            <p class="color-grey">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam corporis ut consequuntur
                delectus harum ea eos! Iusto accusamus vel blanditiis earum odit dignissimos? Lorem ipsum dolor sit
                <br><br>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nihil, vero consequuntur fugit incidunt
                repellat rem sequi provident delectus eos molestias accus
            </p>
            <button>Discover More</button>
        </div>
        <div class="col-12 col-lg-6">
            <div class="row">
                <div class="col-12 col-md-6 px-0 py-1 py-md-0" id="exploreItem21">
                    <h2>Leather Bags</h2>
                    <p class="color-grey itallic">Latest Collection</p>
                </div>
                <div class="col-12 col-md-6 px-0 py-1 py-md-0" id="exploreItem31">
                    <img class="w-100" src="images/exploreImages2.jpeg" alt="leather bags">
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 px-0 py-1 py-md-0 order-2 order-md-1" id="exploreItem41">
                    <img class="w-100" src="images/exploreImages.jpeg" alt="Accessories">
                </div>
                <div class="col-12 col-md-6 px-0 py-1 py-md-0 order-1 order-md-2" id="exploreItem51">
                    <h2>Different Types</h2>
                    <p class="color-grey itallic">Over 304 products</p>
                </div>
            </div>
        </div>
    </div>

    <!-- ----------------- explore section ------------ -->

    <div class="socialMedia" id="socialMediaCnt">
        <h1>Social Media</h1>
        <p class="no-margins color-grey itallic">Detail to details is what makes hexashop different from other themes
        </p>
        <div class="socialImageList row">
            <img class="col-6 col-md-2 px-2 p-md-0" src="images/mediaImage1.jpeg" alt="mediaImage1">
            <img class="col-6 col-md-2 px-2 p-md-0" src="images/mediaImage2.jpg" alt="mediaImage2">
            <img class="col-6 col-md-2 px-2 p-md-0" src="images/mediaImage3.jpg" alt="mediaImage3">
            <img class="col-6 col-md-2 px-2 p-md-0" src="images/mediaImage4.jpg" alt="mediaImage4">
            <img class="col-6 col-md-2 px-2 p-md-0" src="images/mediaImage5.jpeg" alt="mediaImage5">
            <img class="col-6 col-md-2 px-2 p-md-0" src="images/mediaImage6.jpg" alt="mediaImage6">
        </div>
    </div>

    <div id="contactContainer" class="row">
        <div class="col-12 col-lg-8 contactItems d-flex justify-content-center flex-column align-items-center" id="contactItem1">
            <div class="bigText w-100 w-md-50">
                By Subscribing To Our Newsletter Your Can Get 30% Off
            </div>
            <p class="no-margins color-grey itallic">Detail to details is what makes hexashop different from other
                themes</p>
            <form action="" id="newsLetterForm">
                <input type="text" name="name" id="newsLetterForm_input_name" placeholder="Enter Your Name">
                <input type="email" name="email" id="newsLetterForm_input_email" placeholder="Enter Your Email">
                <button class="mx-5 px-5 ml-lg-auto px-lg-3"><i style="font-size:24px" class="fa">&#xf1d8;</i></button>

            </form>
        </div>
        <div class="col-12 col-md-6 col-lg-2 contactItems m-0 pt-3 p-lg-0" id="contactItem2">
            <div class="detailItems" id="detailItems1">
                <p class="mediumBoldText">Store Location:</p>
                <p class="color-grey smallText">Sunny Isles Beach, Fl, 33160, United States</p>
            </div>
            <div class="detailItems" id="detailItems2">
                <p class="mediumBoldText">Phone:</p>
                <p class="color-grey smallText">909-239-2938</p>
            </div>
            <div class="detailItems" id="detailItems3">

                <p class="mediumBoldText">Office Location:</p>
                <p class="color-grey smallText">North Miami Beach</p>
            </div>

        </div>
        <div class="contactItems col-12 col-md-6 col-lg-2 m-0 pt-3 p-lg-0" id="contactItem3">
            <div class="detailItems" id="detailItems1">
                <p class="mediumBoldText">Work Hours:</p>
                <p class="color-grey smallText">07:30 AM - 9:30 PM Daily</p>
            </div>
            <div class="detailItems" id="detailItems3">
                <p class="mediumBoldText">Email:</p>
                <p class="color-grey smallText">info@company.com</p>
            </div>
            <div class="detailItems" id="detailItems2">
                <p class="mediumBoldText">Social Media:</p>
                <p class="color-grey smallText">Facebook, Instagram, Behance, Linkedin</p>
            </div>




        </div>
    </div>

    <footer>
        <div id="userfulLinks" class="row">
            <div class="userFulLinksItem col-12 col-sm-6 col-lg-3" id="userfulLinkItem1">
                <img src="images/logo.png" alt="" id="footerLogo">
                <p class="no-margins smallText">Lorem ipsum dolor sit amet consectetur adipisicing elit. Impedit,
                    corporis.</p>
                <p class="smallText">email@company.com</p>
                <p class="smallText">+1-111-111-1111</p>
            </div>
            <div class="userFulLinksItem col-12 col-sm-6 col-lg-3" id="userfulLinkItem2">
                <p class="mediumBoldText">Shopping & Categories</p>
                <p class="smallText"><a href="">Mens Shopping</a></p>
                <p class="smallText"><a href="">Women Shopping</a></p>
                <p class="smallText"><a href="">Kid's Shopping </a></p>
            </div>
            <div class="userFulLinksItem col-12 col-sm-6 col-lg-3" id="userfulLinkItem3">
                <p class="mediumBoldText">Useful Links</p>
                <p class="smallText"><a href="">Homepage</a></p>
                <p class="smallText"><a href="">About Us</a></p>
                <p class="smallText"><a href="">Help</a></p>
                <p class="smallText"><a href="">Contact Us</a></p>
            </div>
            <div class="userFulLinksItem col-12 col-sm-6 col-lg-3" id="userfulLinkItem4">
                <p class="mediumBoldText">Help & Information</p>
                <p class="smallText"><a href="">Help</a></p>
                <p class="smallText"><a href="">FAQ's</a></p>
                <p class="smallText"><a href="">Shipping</a></p>
                <p class="smallText"><a href="">Tracking ID</a></p>

            </div>
        </div>
        <div id="sep"></div>
        <div class="copyrightContainer d-flex justify-content-center align-items-center flex-column">
            <p class="smallText no-margins">Copyright © 2022 HexaShop. All Rights Reserved.</p>
            <p class="smallText no-margins">Lorem, ipsum dolor.</p>
            <div class="copyrightSocialMediaIcons">
                <i style="font-size:24px" class="fa">&#xf09a;</i>
                <i style="font-size:24px" class="fa">&#xf099;</i>
                <i style="font-size:24px" class="fa">&#xf0e1;</i>
                <i style="font-size:24px" class="fa">&#xf1b4;</i>
            </div>
        </div>
    </footer>


    <!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF"
        crossorigin="anonymous"></script> -->
    <?php importBootstrapJS(); ?>

</body>

</html>