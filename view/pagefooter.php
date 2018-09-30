        </div>
        <!-- END MAIN CONTENT -->
        </section>

<?php
require_once APPROOT . '/config/labels/model/clsLabel.php';


//Get Labels
$objLabel = New Labels;
$lblNoteCategory = $objLabel->get_Label("lblNoteCategory", $SelLang);
$lblNoteTitle = $objLabel->get_Label("lblNoteTitle", $SelLang);
$lblLanguage = $objLabel->get_Label("lblLanguage", $SelLang);
$lblText = $objLabel->get_Label("lblText", $SelLang);
$lblCopy = $objLabel->get_Label("lblCopy", $SelLang);
$lblClose = $objLabel->get_Label("lblClose", $SelLang);
$lblUnableToCopyText = $objLabel->get_Label("lblUnableToCopyText", $SelLang);
$lblCopiedToClipboard = $objLabel->get_Label("lblCopiedToClipboard", $SelLang);

?>
    <style>
        textarea[name=noteText] {
            resize: vertical;
        }
    </style>

        <!--<div id="quickview-sidebar" class="">
            <div class="quickview-header">
                <ul class="nav nav-tabs">

                    <li class="closeQuickview-toggle">
                        <i class="fas fa-plus fa-1"></i>
                    </li>
                    <li class="active"><a href="#chat" data-toggle="tab">Chat</a></li>
                    <li><a href="#notes" data-toggle="tab">Notes</a></li>
                    <li><a href="#settings" data-toggle="tab" class="settings-tab">Settings</a></li>
                </ul>
            </div>
            <div class="quickview">
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="chat">
                        <div class="chat-body current">
                            <!--<div class="chat-search">
                                <form class="form-inverse" action="#" role="search">
                                    <div class="append-icon">
                                        <input type="text" class="form-control" placeholder="Search contact...">
                                        <i class="icon-magnifier"></i>
                                    </div>
                                </form>
                            </div>
                            <div class="chat-groups">
                                <div class="title">GROUP CHATS</div>
                                <ul>
                                    <li><i class="turquoise"></i> Favorites</li>
                                    <li><i class="turquoise"></i> Office Work</li>
                                    <li><i class="turquoise"></i> Friends</li>
                                </ul>
                            </div>
                            <div class="chat-list">
                                <div class="title">FAVORITES</div>
                                <ul>
                                    <li class="clearfix">
                                        <div class="user-img">
                                            <img src="/<?=APPBASE?>assets/images/avatars/avatar13.png" alt="avatar">
                                        </div>
                                        <div class="user-details">
                                            <div class="user-name">Bobby Brown</div>
                                            <div class="user-txt">On the road again...</div>
                                        </div>
                                        <div class="user-status">
                                            <i class="online"></i>
                                        </div>
                                    </li>
                                    <li class="clearfix">
                                        <div class="user-img">
                                            <img src="/<?=APPBASE?>assets/images/avatars/avatar5.png" alt="avatar">
                                            <div class="pull-right badge badge-danger">3</div>
                                        </div>
                                        <div class="user-details">
                                            <div class="user-name">Alexa Johnson</div>
                                            <div class="user-txt">Still at the beach</div>
                                        </div>
                                        <div class="user-status">
                                            <i class="away"></i>
                                        </div>
                                    </li>
                                    <li class="clearfix">
                                        <div class="user-img">
                                            <img src="/<?=APPBASE?>assets/images/avatars/avatar10.png" alt="avatar">
                                        </div>
                                        <div class="user-details">
                                            <div class="user-name">Bobby Brown</div>
                                            <div class="user-txt">On stage...</div>
                                        </div>
                                        <div class="user-status">
                                            <i class="busy"></i>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="chat-list">
                                <div class="title">FRIENDS</div>
                                <ul>
                                    <li class="clearfix">
                                        <div class="user-img">
                                            <img src="/<?=APPBASE?>assets/images/avatars/avatar7.png" alt="avatar">
                                            <div class="pull-right badge badge-danger">3</div>
                                        </div>
                                        <div class="user-details">
                                            <div class="user-name">James Miller</div>
                                            <div class="user-txt">At work...</div>
                                        </div>
                                        <div class="user-status">
                                            <i class="online"></i>
                                        </div>
                                    </li>
                                    <li class="clearfix">
                                        <div class="user-img">
                                            <img src="/<?=APPBASE?>assets/images/avatars/avatar11.png" alt="avatar">
                                        </div>
                                        <div class="user-details">
                                            <div class="user-name">Fred Smith</div>
                                            <div class="user-txt">Waiting for tonight</div>
                                        </div>
                                        <div class="user-status">
                                            <i class="offline"></i>
                                        </div>
                                    </li>
                                    <li class="clearfix">
                                        <div class="user-img">
                                            <img src="/<?=APPBASE?>assets/images/avatars/avatar8.png" alt="avatar">
                                        </div>
                                        <div class="user-details">
                                            <div class="user-name">Ben Addams</div>
                                            <div class="user-txt">On my way to NYC</div>
                                        </div>
                                        <div class="user-status">
                                            <i class="offline"></i>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="chat-conversation">
                            <div class="conversation-header">
                                <div class="user clearfix">
                                    <div class="chat-back">
                                        <i class="icon-action-undo"></i>
                                    </div>
                                    <div class="user-details">
                                        <div class="user-name">James Miller</div>
                                        <div class="user-txt">On the road again...</div>
                                    </div>
                                </div>
                            </div>
                            <div class="conversation-body">
                                <ul>
                                    <li class="img">
                                        <div class="chat-detail">
                                            <span class="chat-date">today, 10:38pm</span>
                                            <div class="conversation-img">
                                                <img src="/<?=APPBASE?>assets/images/avatars/avatar4.png" alt="avatar 4">
                                            </div>
                                            <div class="chat-bubble">
                                                <span>Hi you!</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="img">
                                        <div class="chat-detail">
                                            <span class="chat-date">today, 10:45pm</span>
                                            <div class="conversation-img">
                                                <img src="/<?=APPBASE?>assets/images/avatars/avatar4.png" alt="avatar 4">
                                            </div>
                                            <div class="chat-bubble">
                                                <span>Are you there?</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="img">
                                        <div class="chat-detail">
                                            <span class="chat-date">today, 10:51pm</span>
                                            <div class="conversation-img">
                                                <img src="/<?=APPBASE?>assets/images/avatars/avatar4.png" alt="avatar 4">
                                            </div>
                                            <div class="chat-bubble">
                                                <span>Send me a message when you come back.</span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="conversation-message">
                                <input type="text" placeholder="Your message..." class="form-control form-white send-message">
                                <div class="item-footer clearfix">
                                    <div class="footer-actions">
                                        <i class="icon-rounded-marker"></i>
                                        <i class="icon-rounded-camera"></i>
                                        <i class="icon-rounded-paperclip-oblique"></i>
                                        <i class="icon-rounded-alarm-clock"></i>
                                    </div>
                                </div>
                            </div>
                        </div>-->
                    <!--</div>
                    <div class="tab-pane fade" id="notes">
                        <!--<div class="list-notes current withScroll mCustomScrollbar _mCS_15" style="height: auto;"><div class="mCustomScrollBox mCS-light" id="mCSB_15" style="position:relative; height:100%; overflow:hidden; max-width:100%;"><div class="mCSB_container mCS_no_scrollbar" style="position:relative; top:0;">
                                    <div class="notes ">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div id="add-note">
                                                    <i class="fas fa-plus"></i>ADD A NEW NOTE
                                                </div>
                                            </div>
                                        </div>
                                        <div id="notes-list">
                                            <div class="note-item media current fade in">
                                                <button class="close">×</button>
                                                <div>
                                                    <div>
                                                        <p class="note-name">Reset my account password</p>
                                                    </div>
                                                    <p class="note-desc hidden">Break security reasons.</p>
                                                    <p><small>Tuesday 6 May, 3:52 pm</small></p>
                                                </div>
                                            </div>
                                            <div class="note-item media fade in">
                                                <button class="close">×</button>
                                                <div>
                                                    <div>
                                                        <p class="note-name">Call John</p>
                                                    </div>
                                                    <p class="note-desc hidden">He have my laptop!</p>
                                                    <p><small>Thursday 8 May, 2:28 pm</small></p>
                                                </div>
                                            </div>
                                            <div class="note-item media fade in">
                                                <button class="close">×</button>
                                                <div>
                                                    <div>
                                                        <p class="note-name">Buy a car</p>
                                                    </div>
                                                    <p class="note-desc hidden">I'm done with the bus</p>
                                                    <p><small>Monday 12 May, 3:43 am</small></p>
                                                </div>
                                            </div>
                                            <div class="note-item media fade in">
                                                <button class="close">×</button>
                                                <div>
                                                    <div>
                                                        <p class="note-name">Don't forget my notes</p>
                                                    </div>
                                                    <p class="note-desc hidden">I have to read them...</p>
                                                    <p><small>Wednesday 5 May, 6:15 pm</small></p>
                                                </div>
                                            </div>
                                            <div class="note-item media current fade in">
                                                <button class="close">×</button>
                                                <div>
                                                    <div>
                                                        <p class="note-name">Reset my account password</p>
                                                    </div>
                                                    <p class="note-desc hidden">Break security reasons.</p>
                                                    <p><small>Tuesday 6 May, 3:52 pm</small></p>
                                                </div>
                                            </div>
                                            <div class="note-item media fade in">
                                                <button class="close">×</button>
                                                <div>
                                                    <div>
                                                        <p class="note-name">Call John</p>
                                                    </div>
                                                    <p class="note-desc hidden">He have my laptop!</p>
                                                    <p><small>Thursday 8 May, 2:28 pm</small></p>
                                                </div>
                                            </div>
                                            <div class="note-item media fade in">
                                                <button class="close">×</button>
                                                <div>
                                                    <div>
                                                        <p class="note-name">Buy a car</p>
                                                    </div>
                                                    <p class="note-desc hidden">I'm done with the bus</p>
                                                    <p><small>Monday 12 May, 3:43 am</small></p>
                                                </div>
                                            </div>
                                            <div class="note-item media fade in">
                                                <button class="close">×</button>
                                                <div>
                                                    <div>
                                                        <p class="note-name">Don't forget my notes</p>
                                                    </div>
                                                    <p class="note-desc hidden">I have to read them...</p>
                                                    <p><small>Wednesday 5 May, 6:15 pm</small></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><div class="mCSB_scrollTools" style="position: absolute; display: none;"><div class="mCSB_draggerContainer"><div class="mCSB_dragger" style="position: absolute; top: 0px;" oncontextmenu="return false;"><div class="mCSB_dragger_bar" style="position:relative;"></div></div><div class="mCSB_draggerRail"></div></div></div></div></div>
                        <div class="detail-note note-hidden-sm">
                            <div class="note-header clearfix">
                                <div class="note-back">
                                    <i class="icon-action-undo"></i>
                                </div>
                                <div class="note-edit">Edit Note</div>
                                <div class="note-subtitle">title on first line</div>
                            </div>
                            <div id="note-detail">
                                <div class="note-write">
                                    <textarea class="form-control" placeholder="Type your note here"></textarea>
                                </div>
                            </div>
                        </div>-->
                    <!--</div>
                    <div class="tab-pane fade" id="settings">
                        <!--<div class="settings">
                            <div class="title">ACCOUNT SETTINGS</div>
                            <div class="setting">
                                <span> Show Personal Statut</span>
                                <label class="switch pull-right">
                                    <input type="checkbox" class="switch-input" checked="">
                                    <span class="switch-label" data-on="On" data-off="Off"></span>
                                    <span class="switch-handle"></span>
                                </label>
                                <p class="setting-info">Lorem ipsum dolor sit amet consectetuer.</p>
                            </div>
                            <div class="setting">
                                <span> Show my Picture</span>
                                <label class="switch pull-right">
                                    <input type="checkbox" class="switch-input" checked="">
                                    <span class="switch-label" data-on="On" data-off="Off"></span>
                                    <span class="switch-handle"></span>
                                </label>
                                <p class="setting-info">Lorem ipsum dolor sit amet consectetuer.</p>
                            </div>
                            <div class="setting">
                                <span> Show my Location</span>
                                <label class="switch pull-right">
                                    <input type="checkbox" class="switch-input">
                                    <span class="switch-label" data-on="On" data-off="Off"></span>
                                    <span class="switch-handle"></span>
                                </label>
                                <p class="setting-info">Lorem ipsum dolor sit amet consectetuer.</p>
                            </div>
                            <div class="title">CHAT</div>
                            <div class="setting">
                                <span> Show User Image</span>
                                <label class="switch pull-right">
                                    <input type="checkbox" class="switch-input" checked="">
                                    <span class="switch-label" data-on="On" data-off="Off"></span>
                                    <span class="switch-handle"></span>
                                </label>
                            </div>
                            <div class="setting">
                                <span> Show Fullname</span>
                                <label class="switch pull-right">
                                    <input type="checkbox" class="switch-input" checked="">
                                    <span class="switch-label" data-on="On" data-off="Off"></span>
                                    <span class="switch-handle"></span>
                                </label>
                            </div>
                            <div class="setting">
                                <span> Show Location</span>
                                <label class="switch pull-right">
                                    <input type="checkbox" class="switch-input">
                                    <span class="switch-label" data-on="On" data-off="Off"></span>
                                    <span class="switch-handle"></span>
                                </label>
                            </div>
                            <div class="setting">
                                <span> Show Unread Count</span>
                                <label class="switch pull-right">
                                    <input type="checkbox" class="switch-input" checked="">
                                    <span class="switch-label" data-on="On" data-off="Off"></span>
                                    <span class="switch-handle"></span>
                                </label>
                            </div>
                            <div class="title">STATISTICS</div>
                            <div class="settings-chart">
                                <div class="clearfix">
                                    <div class="chart-title">Stat 1</div>
                                    <div class="chart-number">82%</div>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-primary setting1" data-transitiongoal="82"></div>
                                </div>
                            </div>
                            <div class="settings-chart">
                                <div class="clearfix">
                                    <div class="chart-title">Stat 2</div>
                                    <div class="chart-number">43%</div>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-primary setting2" data-transitiongoal="43"></div>
                                </div>
                            </div>
                            <div class="m-t-30" style="width:100%">
                                <canvas id="setting-chart" height="300"></canvas>
                            </div>
                        </div>-->
                   <!-- </div>
                </div>
            </div>
        </div>
        <div id="morphsearch" class="morphsearch">

            <!--<form class="morphsearch-form">
                <input class="morphsearch-input" type="search" placeholder="Search...">
                <button class="morphsearch-submit" type="submit">Search</button>
            </form>
            <div class="morphsearch-content withScroll mCustomScrollbar _mCS_16" style="height: auto;"><div class="mCustomScrollBox mCS-light" id="mCSB_16" style="position:relative; height:100%; overflow:hidden; max-width:100%;"><div class="mCSB_container mCS_no_scrollbar" style="position:relative; top:0;">
                        <div class="dummy-column user-column">
                            <h2>Users</h2>
                            <a class="dummy-media-object" href="#">
                                <img src="/<?=APPBASE?>assets/images/avatars/avatar1_big.png" alt="Avatar 1">
                                <h3>John Smith</h3>
                            </a>
                            <a class="dummy-media-object" href="#">
                                <img src="/<?=APPBASE?>assets/images/avatars/avatar2_big.png" alt="Avatar 2">
                                <h3>Bod Dylan</h3>
                            </a>
                            <a class="dummy-media-object" href="#">
                                <img src="/<?=APPBASE?>assets/images/avatars/avatar3_big.png" alt="Avatar 3">
                                <h3>Jenny Finlan</h3>
                            </a>
                            <a class="dummy-media-object" href="#">
                                <img src="/<?=APPBASE?>assets/images/avatars/avatar4_big.png" alt="Avatar 4">
                                <h3>Harold Fox</h3>
                            </a>
                            <a class="dummy-media-object" href="#">
                                <img src="/<?=APPBASE?>assets/images/avatars/avatar5_big.png" alt="Avatar 5">
                                <h3>Martin Hendrix</h3>
                            </a>
                            <a class="dummy-media-object" href="#">
                                <img src="/<?=APPBASE?>assets/images/avatars/avatar6_big.png" alt="Avatar 6">
                                <h3>Paul Ferguson</h3>
                            </a>
                        </div>
                        <div class="dummy-column">
                            <h2>Articles</h2>
                            <a class="dummy-media-object" href="#">
                                <img src="/<?=APPBASE?>assets/images/gallery/1.jpg" alt="1">
                                <h3>How to change webdesign?</h3>
                            </a>
                            <a class="dummy-media-object" href="#">
                                <img src="/<?=APPBASE?>assets/images/gallery/2.jpg" alt="2">
                                <h3>News From the sky</h3>
                            </a>
                            <a class="dummy-media-object" href="#">
                                <img src="/<?=APPBASE?>assets/images/gallery/3.jpg" alt="3">
                                <h3>Where is the cat?</h3>
                            </a>
                            <a class="dummy-media-object" href="#">
                                <img src="/<?=APPBASE?>assets/images/gallery/4.jpg" alt="4">
                                <h3>Just another funny story</h3>
                            </a>
                            <a class="dummy-media-object" href="#">
                                <img src="/<?=APPBASE?>assets/images/gallery/5.jpg" alt="5">
                                <h3>How many water we drink every day?</h3>
                            </a>
                            <a class="dummy-media-object" href="#">
                                <img src="/<?=APPBASE?>assets/images/gallery/6.jpg" alt="6">
                                <h3>Drag and drop tutorials</h3>
                            </a>
                        </div>
                        <div class="dummy-column">
                            <h2>Recent</h2>
                            <a class="dummy-media-object" href="#">
                                <img src="/<?=APPBASE?>assets/images/gallery/7.jpg" alt="7">
                                <h3>Design Inspiration</h3>
                            </a>
                            <a class="dummy-media-object" href="#">
                                <img src="/<?=APPBASE?>assets/images/gallery/8.jpg" alt="8">
                                <h3>Animals drawing</h3>
                            </a>
                            <a class="dummy-media-object" href="#">
                                <img src="/<?=APPBASE?>assets/images/gallery/9.jpg" alt="9">
                                <h3>Cup of tea please</h3>
                            </a>
                            <a class="dummy-media-object" href="#">
                                <img src="/<?=APPBASE?>assets/images/gallery/10.jpg" alt="10">
                                <h3>New application arrive</h3>
                            </a>
                            <a class="dummy-media-object" href="#">
                                <img src="/<?=APPBASE?>assets/images/gallery/11.jpg" alt="11">
                                <h3>Notification prettify</h3>
                            </a>
                            <a class="dummy-media-object" href="#">
                                <img src="/<?=APPBASE?>assets/images/gallery/12.jpg" alt="12">
                                <h3>My article is the last recent</h3>
                            </a>
                        </div>
                    </div><div class="mCSB_scrollTools" style="position: absolute; display: none;"><div class="mCSB_draggerContainer"><div class="mCSB_dragger" style="position: absolute; top: 0px;" oncontextmenu="return false;"><div class="mCSB_dragger_bar" style="position:relative;"></div></div><div class="mCSB_draggerRail"></div></div></div></div></div>
                    -->
            <!-- /morphsearch-content -->
           <!-- <span class="morphsearch-close"></span>
        </div>
        <!-- Preloader -->
        <div class="loader-overlay">
            <div class="spinner">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </div>
        <a href="#" class="scrollup"><i class="fas fa-angle-up"></i></a>
        <script src="/<?=APPBASE?>assets/plugins/jquery/jquery-1.11.1.min.js"></script>
        <script src="/<?=APPBASE?>assets/plugins/jquery/jquery-migrate-1.2.1.min.js"></script>
        <script src="/<?=APPBASE?>assets/plugins/gsap/main-gsap.min.js"></script> <!-- HTML Animations -->
        <script src="/<?=APPBASE?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
        <script src='/<?=APPBASE?>assets/plugins/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js' type='text/javascript'></script>
        <script src="/<?=APPBASE?>assets/plugins/jquery-block-ui/jquery.blockUI.min.js"></script> <!-- simulate synchronous behavior when using AJAX -->
        <script src="/<?=APPBASE?>assets/plugins/bootbox/bootbox.min.js"></script>
        <script src="/<?=APPBASE?>assets/plugins/mcustom-scrollbar/jquery.mCustomScrollbar.concat.min.js"></script> <!-- Custom Scrollbar sidebar -->
        <script src="/<?=APPBASE?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="/<?=APPBASE?>assets/plugins/bootstrap-dropdown/bootstrap-hover-dropdown.min.js"></script> <!-- Show Dropdown on Mouseover -->
        <script src="/<?=APPBASE?>assets/plugins/bootstrap-progressbar/bootstrap-progressbar.min.js"></script> <!-- Animated Progress Bar -->
        <script src="/<?=APPBASE?>assets/plugins/switchery/switchery.min.js"></script> <!-- IOS Switch -->
        <script src="/<?=APPBASE?>assets/plugins/charts-sparkline/sparkline.min.js"></script> <!-- Charts Sparkline -->
        <!--<script src="/<?=APPBASE?>assets/plugins/retina/retina.min.js"></script>  <!-- Retina Display -->
        <script src="/<?=APPBASE?>assets/plugins/jquery-cookies/jquery.cookies.js"></script> <!-- Jquery Cookies, for theme -->
        <script src="/<?=APPBASE?>assets/plugins/bootstrap/js/jasny-bootstrap.min.js"></script> <!-- File Upload and Input Masks -->
        <!--<script src="/<?=APPBASE?>assets/plugins/select2/select2.min.js"></script> <!-- Select Inputs -->
        <script src="/<?=APPBASE?>assets/plugins/bootstrap-tags-input/bootstrap-tagsinput.min.js"></script> <!-- Select Inputs -->
        <script src="/<?=APPBASE?>assets/plugins/bootstrap-loading/lada.min.js"></script> <!-- Buttons Loading State -->
        <script src="/<?=APPBASE?>assets/plugins/timepicker/jquery-ui-timepicker-addon.min.js"></script> <!-- Time Picker -->
        <script src="/<?=APPBASE?>assets/plugins/multidatepicker/multidatespicker.min.js"></script> <!-- Multi dates Picker -->
        <script src="/<?=APPBASE?>assets/plugins/colorpicker/spectrum.min.js"></script> <!-- Color Picker -->
        <script src="/<?=APPBASE?>assets/plugins/touchspin/jquery.bootstrap-touchspin.min.js"></script> <!-- A mobile and touch friendly input spinner component for Bootstrap -->
        <script src="/<?=APPBASE?>assets/plugins/autosize/autosize.min.js"></script> <!-- Textarea autoresize -->
        <script src="/<?=APPBASE?>assets/plugins/icheck/icheck.min.js"></script> <!-- Icheck -->
        <script src="/<?=APPBASE?>assets/plugins/bootstrap-editable/js/bootstrap-editable.min.js"></script> <!-- Inline Edition X-editable -->
        <script src="/<?=APPBASE?>assets/plugins/bootstrap-context-menu/bootstrap-contextmenu.min.js"></script> <!-- File Upload and Input Masks -->
        <script src="/<?=APPBASE?>assets/plugins/prettify/prettify.min.js"></script> <!-- Show html code -->
        <script src="/<?=APPBASE?>assets/plugins/slick/slick.min.js"></script> <!-- Slider -->
        <script src="/<?=APPBASE?>assets/plugins/countup/countUp.min.js"></script> <!-- Animated Counter Number -->
        <script src="/<?=APPBASE?>assets/plugins/noty/jquery.noty.packaged.min.js"></script>  <!-- Notifications -->
        <script src="/<?=APPBASE?>assets/plugins/backstretch/backstretch.min.js"></script> <!-- Background Image -->
        <script src="/<?=APPBASE?>assets/plugins/charts-chartjs/Chart.min.js"></script>  <!-- ChartJS Chart -->
        <script src="/<?=APPBASE?>assets/plugins/bootstrap-slider/bootstrap-slider.js"></script> <!-- Bootstrap Input Slider -->
        <script src="/<?=APPBASE?>assets/plugins/visible/jquery.visible.min.js"></script> <!-- Visible in Viewport -->
        <script src="/<?=APPBASE?>assets/js/sidebar_hover.js"></script>
        <script src="/<?=APPBASE?>assets/js/application.js"></script> <!-- Main Application Script -->
        <script src="/<?=APPBASE?>assets/js/plugins.js"></script> <!-- Main Plugin Initialization Script -->
        <script src="/<?=APPBASE?>assets/js/widgets/notes.js"></script>
        <script src="/<?=APPBASE?>assets/js/quickview.js"></script> <!-- Quickview Script -->
        <script src="/<?=APPBASE?>assets/js/pages/search.js"></script> <!-- Search Script -->
        <script src="/<?=APPBASE?>assets/plugins/inititaljs/initial.min.js"></script><!-- Avatar Icon Script -->
        <!--load everything-->
        <script defer src="/<?=APPBASE?>assets/plugins/fontawesome-pro/svg-with-js/js/fontawesome-all.min.js"  integrity="sha384-DtPgXIYsUR6lLmJK14ZNUi11aAoezQtw4ut26Zwy9/6QXHH8W3+gjrRDT+lHiiW4" crossorigin="anonymous"></script>
        <script src="/<?=APPBASE?>assets/plugins/fontawesome-pro/svg-with-js/js/fa-v4-shims.min.js" type="text/javascript"></script>
        <!--<script src="/<?=APPBASE?>assets/js/builder.js"></script>-->
        <!-- END PAGE SCRIPTS -->
        <script src="/<?=APPBASE?>assets/js/custom.js"></script>
        <script src="/<?=APPBASE?>assets/js/clipboard.js" type="text/javascript"></script> <!-- Copy to Clipboard Script -->
        <script>

            //Makes a modal draggable.
            jQuery('.modal-dialog').draggable({
                handle: ".modal-header"
            });


            jQuery("select[name='languageSelection']").change(function() {
                var selectedNoteLanguageId = document.getElementById("languageSelection").value;
                var selectedNoteTitleId = document.getElementById("noteTitle").value;
                //var selectedNoteCategoryId = document.getElementById("noteCategory").value;
                //debugger;
                if(selectedNoteTitleId !== ""){
                    jQuery.ajax({
                        type: 'POST',
                        url: '/<?= APPBASE ?>notes/controller/sendNoteLanguage.php',
                        data: {
                            id: selectedNoteTitleId,
                            langId: selectedNoteLanguageId
                        },
                        success: function (result) {
                            var html = jQuery.parseHTML(result); // parseHTML returns HTMLCollection.
                            var formattedText = jQuery(html).text(); // Use jQuery() to get .text() method.
                            jQuery('#noteText').val(formattedText); // Sets text into textarea.
                            jQuery('#copiedNoteText').val(formattedText); // Sets text into auxiliary input.
                        } // end success
                    }); //end ajax
                }
            });

 

        </script>
