<div class="contactsWrapper">

    <div class="row">
        <div class="header col-xs-12">
            <div class="row">
                <div class="col-md-6 col-xs-3 col-md-offset-2">
                    <h1>Контакти</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="contactsContainer">
                <div class="row">
                    <div class="col-md-6">
                        <div class="formWrapper">
                            <form class="form-horizontal" method="post"
                                  action="http://localhost:1234/xampp/algaivel/back/contact">
                                <fieldset>
                                    <!--<legend class="text-center header">Contact us</legend>-->

                                    <div class="form-group">
                                        <span class="col-md-1 col-md-offset-2 text-center"><i
                                                class="fa fa-user bigicon"></i></span>

                                        <div class="col-md-8">
                                            <input id="fname" name="name" type="text" placeholder="Име"
                                                   class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <span class="col-md-1 col-md-offset-2 text-center"><i
                                                class="fa fa-user bigicon"></i></span>

                                        <div class="col-md-8">
                                            <input id="lname" name="nickname" type="text" placeholder="Псевдоним"
                                                   class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <span class="col-md-1 col-md-offset-2 text-center"><i
                                                class="fa fa-envelope-o bigicon"></i></span>

                                        <div class="col-md-8">
                                            <input id="email" name="email" type="text" placeholder="Email Адрес"
                                                   class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <span class="col-md-1 col-md-offset-2 text-center"><i
                                                class="fa fa-phone-square bigicon"></i></span>

                                        <div class="col-md-8">
                                            <input id="phone" name="phone" type="text" placeholder="Телефон"
                                                   class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <span class="col-md-1 col-md-offset-2 text-center"><i
                                                class="fa fa-pencil-square-o bigicon"></i></span>

                                        <div class="col-md-8">
                                            <textarea class="form-control" id="message" name="message"
                                                      placeholder="Благодарим за запитването. Ще се свържем с вас скоро!"
                                                      rows="7" required></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 text-center">
                                            <span class="col-md-1 col-md-offset-2 text-center"><i
                                                    class="fa fa-pencil-square-o bigicon"></i></span>
                                            <script src='https://www.google.com/recaptcha/api.js'></script>
                                            <div class="g-recaptcha col-md-8"
                                                 data-sitekey="6LesQhcTAAAAAMe98xwztYC3AAYD3U_7FffvW1Zc"></div>
                                        </div>


                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 text-center">
                                            <input name="submitbutton" type="submit" class="btn btn-primary btn-lg"
                                                   value="Изпрати">
                                        </div>
                                    </div>


                                </fieldset>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-4">

                        <div class="contactPreview col-md-12">

                            <div class="row">
                                <h3>{{name}}</h3>
                            </div>
                            <div class="row">
                                <span class="glyphicon glyphicon-phone"></span>
                                <span>{{phone}}</span>
                            </div>
                            <div class="row">
                                <span class="glyphicon glyphicon-envelope"></span>
                                <a href="mailto:{{email}}Subject=Hello" target="_top"> <span>{{email}}</span></a>
                            </div>
                            <img id="aboutMeImage" src="images/aboutMe/about-me-default-icon.png">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <style>
            .header {
                color: #36A0FF;
                font-size: 27px;
                padding: 10px;
            }

            .bigicon {
                font-size: 35px;
                color: #36A0FF;
            }
        </style>


    </div>
</div>