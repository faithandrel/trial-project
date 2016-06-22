<!DOCTYPE html>
<html>
    <head>
        <title>Contacts</title>

        <link href="styles/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="styles/trial-project-style.css" rel="stylesheet">
        <link href="styles/jquery-ui/jquery-ui.min.css" rel="stylesheet">

    </head>
    <body>
        <div ng-cloak ng-app="contactsApp" ng-controller="ContactsCtrl" class="container">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                  <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                      <span class="sr-only">Toggle navigation</span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#"><img ng-show="loading" width=20 src="styles/images/loading_gif.gif" /></a>
                  </div>
                  <div style="height: 1px;" aria-expanded="false" id="navbar" class="navbar-collapse collapse">
                    
                    <ul class="nav navbar-nav navbar-right">
                      <li class="active"><a href="./">Default <span class="sr-only">(current)</span></a></li>
                      <li><a href="../navbar-static-top/">Static top</a></li>
                      <li><a href="../navbar-fixed-top/">Fixed top</a></li>
                    </ul>
                  </div><!--/.nav-collapse -->
                </div><!--/.container-fluid -->
            </nav>
                
            <div class="content">
                <div class="row">
                    <% contact %>
                </div>
                <div class="row">
                    <form>
                        <div class="col-md-6">
                        <input type="hidden" ng-model="contact.id">
                            <div class="form-group">
                              <label for="contact-name">Name</label>
                              <input type="text" ng-model="contact.name" class="form-control" id="contact-name" placeholder="Name">
                            </div>
                            <div class="form-group">
                              <label for="contact-nickname">Nickname</label>
                              <input type="text" ng-model="contact.nickname" class="form-control" id="contact-nickname" placeholder="Nickname">
                            </div>
                            <div class="form-group">
                              <label for="contact-date-met">Date Met</label>
                              <input datepicker the-model="contact" date-attribute="date_met" type="text" ng-model="contact.date_met" class="form-control" id="contact-date-met" placeholder="Date">
                            </div>
                            <div class="form-group">
                              <label for="contact-notes">Notes</label>
                               <textarea id="contact-notes" ng-model="contact.notes" class="form-control" rows="3"></textarea>
                            </div>
                
                            <button type="submit" ng-click="saveContact()" class="btn btn-success">Submit</button>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Preferred Contact Method</label><br/>
                              <div class="radio-inline">
                                <label class="col-xs-4">
                                  <input type="radio" ng-model="contact.contact_method" name="contact_method" value="method1">
                                  Method 1
                                </label>
                                <label class="col-xs-4">
                                  <input type="radio" ng-model="contact.contact_method" name="contact_method" value="method2">
                                  Method 2
                                </label>
                                <label class="col-xs-4">
                                  <input type="radio" ng-model="contact.contact_method" name="contact_method" value="method3">
                                  Method 3
                                </label>
                              </div>
                            </div>
                            <div class="form-group">
                              <label for="contact-phone">Phone</label>
                              <input type="password" class="form-control" id="contact-phone" placeholder="Phone">
                            </div>
                            <div class="form-group">
                              <label for="contact-email">Email</label>
                              <input type="email" class="form-control" id="contact-email" placeholder="Email">
                            </div>
                            <div class="form-group">
                              <label for="other-contact">Other Contact Info</label>
                               <textarea id="other-contact" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <br/>
                <div class="row">
                    <table class="table table-striped">
                        <tr>
                            <th>Name</th>
                            <th>Nickname</th>
                            <th>Actions</th>
                        </tr>
                        <tr ng-repeat="one in contacts">
                            <td ng-bind="one.name"></td>
                            <td ng-bind="one.nickname"></td>
                            <td><button ng-click="getOneContact(one.id)" class="btn btn-warning btn-xs">Edit</button></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="styles/jquery-ui/jquery-ui.min.js"></script>
    <script src="bower_components/angular/angular.min.js"></script>
    <script src="bower_components/angular-sanitize/angular-sanitize.min.js"></script>
    <script src="js/contact-app.js"></script>
    </body>
</html>
