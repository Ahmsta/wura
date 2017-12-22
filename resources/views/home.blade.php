@extends('layouts.wura')
@section('content')

<style>

    /* Hero Widgets */
    .hero-widget {
        color: #31708f;
        padding-top: 20px;
        text-align: center;
        padding-bottom: 20px;
        border-color: #bce8f1;
        background-color: #d9edf7;
    }
    .hero-widget .icon {
        display: block;
        font-size: 96px;
        line-height: 96px;
        margin-bottom: 10px;
        text-align: center;
    }
    .hero-widget .value {
        display: block;
        height: 64px;
        font-size: 64px;
        line-height: 64px;
        font-style: normal;
    }
    .hero-widget label { font-size: 17px; }
    .hero-widget .options { margin-top: 10px; }

    /* Chat Widgets */
    .chat {
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .chat li {
        margin-bottom: 10px;
        padding-bottom: 5px;
        border-bottom: 1px dotted #999;
    }

    .chat li.left .chat-body {
        margin-left: 60px;
    }

    .chat li.right .chat-body {
        margin-right: 60px;
    }

    .chat li .chat-body p {
        margin: 0;
    }

    .panel .slidedown .glyphicon,
    .chat .glyphicon {
        margin-right: 5px;
    }

    .chat-panel .panel-body {
        height: 350px;
        overflow-y: scroll;
    }
</style>

<div class="container">

    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-car fa-5x" aria-hidden="true"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{ $dashboardinfo->activedrivers }}</div>
                            <div>Active Driver(s)</div>
                        </div>
                        <br />
                        <div class="col-xs-9 text-right text-danger">
                            <div class="huge">{{ $dashboardinfo->inactivedrivers }}</div>
                            <div>Inactive Driver(s)</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-credit-card fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{ $dashboardinfo->activecards }}</div>
                            <div>Active Cards(s)</div>
                        </div>
                        <br />
                        <div class="col-xs-9 text-right text-danger">
                            <div class="huge">{{ $dashboardinfo->inactivedcards }}</div>
                            <div>Inactive Card(s)</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-info-circle fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{ $dashboardinfo->expiredcards }}</div>
                            <div>Expired Cards(s)</div>
                        </div>
                        <br />
                        <div class="col-xs-9 text-right text-danger">
                            <div class="huge">{{ $dashboardinfo->deletedcards }}</div>
                            <div>Deleted Card(s)</div>
                        </div>
                        </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-frown-o fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{ $dashboardinfo->pendingcardrequest }}</div>
                            <div>Card(s) Request</div>
                        </div>
                        <br />
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{ $dashboardinfo->disputedcards }}</div>
                            <div>Disputed Card(s)</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <br />

    <div class="row">
        <div class="col-sm-3">
            <div class="hero-widget well well-sm">
                <div class="icon">
                    <h5> Last 10 successful transactions </h5>
                    <i class="glyphicon glyphicon-user"></i>
                </div>
                <div class="text">
                    <span class="value">3</span>
                    <label class="text-muted">Hero Widget</label>
                </div>
                <div class="options">
                    <a href="javascript:;" class="btn btn-primary btn-lg"><i class="glyphicon glyphicon-plus"></i> Primary Action</a>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="hero-widget well well-sm">
                <div class="icon">
                    <h5> Last 10 failed transactions </h5>
                    <i class="glyphicon glyphicon-star"></i>
                </div>
                <div class="text">
                    <span class="value">614</span>
                    <label class="text-muted">Hero Widget</label>
                </div>
                <div class="options">
                    <a href="javascript:;" class="btn btn-primary btn-lg"><i class="glyphicon glyphicon-search"></i> Secondary Action</a>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="hero-widget well well-sm">
                <div class="icon">
                    <h5> Last 10 failed transactions </h5>
                    <i class="glyphicon glyphicon-tags"></i>
                </div>
                <div class="text">
                    <span class="value">73</span>
                    <label class="text-muted">Hero Widget</label>
                </div>
                <div class="options">
                    <a href="javascript:;" class="btn btn-primary btn-lg"><i class="glyphicon glyphicon-search"></i> Secondary Action</a>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="hero-widget well well-sm">
                <div class="icon">
                    <h5> Last 10 failed transactions </h5>
                    <i class="glyphicon glyphicon-cog"></i>
                </div>
                <div class="text">
                    <span class="value">75%</span>
                    <label class="text-muted">Hero Widget</label>
                </div>
                <div class="options">
                    <a href="javascript:;" class="btn btn-primary btn-lg"><i class="glyphicon glyphicon-wrench"></i> Secondary Action</a>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="chat-panel panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-comments fa-fw"></i>
            Chat
            <div class="btn-group pull-right">
                <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-chevron-down"></i>
                </button>
                <ul class="dropdown-menu slidedown">
                    <li>
                        <a href="#">
                            <i class="fa fa-refresh fa-fw"></i> Refresh
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-check-circle fa-fw"></i> Available
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-times fa-fw"></i> Busy
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-clock-o fa-fw"></i> Away
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <i class="fa fa-sign-out fa-fw"></i> Sign Out
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="panel-body">
            <ul class="chat">
                <li class="left clearfix">
                        <span class="chat-img pull-left">
                            <img src="http://placehold.it/50/55C1E7/fff" alt="User Avatar" class="img-circle">
                        </span>

                    <div class="chat-body clearfix">
                        <div class="header">
                            <strong class="primary-font">Jack Sparrow</strong>
                            <small class="pull-right text-muted">
                                <i class="fa fa-clock-o fa-fw"></i> 12 mins ago
                            </small>
                        </div>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum
                            ornare dolor, quis ullamcorper ligula sodales.
                        </p>
                    </div>
                </li>
                <li class="right clearfix">
                        <span class="chat-img pull-right">
                            <img src="http://placehold.it/50/FA6F57/fff" alt="User Avatar" class="img-circle">
                        </span>

                    <div class="chat-body clearfix">
                        <div class="header">
                            <small class=" text-muted">
                                <i class="fa fa-clock-o fa-fw"></i> 13 mins ago
                            </small>
                            <strong class="pull-right primary-font">Bhaumik Patel</strong>
                        </div>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum
                            ornare dolor, quis ullamcorper ligula sodales.
                        </p>
                    </div>
                </li>
                <li class="left clearfix">
                        <span class="chat-img pull-left">
                            <img src="http://placehold.it/50/55C1E7/fff" alt="User Avatar" class="img-circle">
                        </span>

                    <div class="chat-body clearfix">
                        <div class="header">
                            <strong class="primary-font">Jack Sparrow</strong>
                            <small class="pull-right text-muted">
                                <i class="fa fa-clock-o fa-fw"></i> 14 mins ago
                            </small>
                        </div>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum
                            ornare dolor, quis ullamcorper ligula sodales.
                        </p>
                    </div>
                </li>
                <li class="right clearfix">
                        <span class="chat-img pull-right">
                            <img src="http://placehold.it/50/FA6F57/fff" alt="User Avatar" class="img-circle">
                        </span>

                    <div class="chat-body clearfix">
                        <div class="header">
                            <small class=" text-muted">
                                <i class="fa fa-clock-o fa-fw"></i> 15 mins ago
                            </small>
                            <strong class="pull-right primary-font">Bhaumik Patel</strong>
                        </div>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum
                            ornare dolor, quis ullamcorper ligula sodales.
                        </p>
                    </div>
                </li>
            </ul>
        </div>

        <div class="panel-footer">
            <div class="input-group">
                <input id="btn-input" type="text" class="form-control input-sm" placeholder="Type your message here...">
                    <span class="input-group-btn">
                        <button class="btn btn-warning btn-sm" id="btn-chat">
                            Send
                        </button>
                    </span>
            </div>
        </div>

    </div> -->
</div>

@endsection