@extends('layouts.wura')
@section('page_heading','Audit Log')
@section('content')

    <style>
        th {
            color: #000;
            text-align: center;
        }

        .nav-tabs>li {
            color: #01c0c8;
            display: block;
            position: relative;
        }

        .nav-tabs>li:hover {
            display: block;
            color: #01c0c8;
            position: relative;
            background-color: #7c0e3b;
        }
    </style>

    <div class="row">
        <div class="col-md-5">
            <label class="control-label"> Audit Source equal to: </label>
            <br />
            <select id="auditsources" name="multiselect[]" multiple="multiple" class="multiselect form-control">
                <option value="User">User</option>
                <option value="Cards">Cards</option>
                <option value="Drivers">Drivers</option>
                <option value="Wallets">Wallets</option>
                <option value="Transactions">Transactions</option>
            </select>
        </div>

        <div class="col-md-5">
            <label class="control-label"> Select Period: </label>
            <br />
            <div id="daterange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                <span></span> 
                <b class="caret"></b>
            </div>
        </div>

        <div class="col-md-2">
            <br />
            <button class="btn btn-wura" id="LogSearch" name="LogSearch" type="button">
                <i class="fa fa-search" aria-hidden="true">&nbsp;&nbsp;</i>
                Search
            </button>
        </div>
    </div>

    <hr />

    <div>

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist" id="timelineheader" name="timelineheader" style="display:none;"></ul>

        <!-- Tab panes -->
        <div class="tab-content" id="timelinepanel" name="timelinepanel"></div>

    </div>

    <!-- <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-block">
                    <section class="cd-horizontal-timeline">
                        <div class="timeline">
                            <div class="events-wrapper">
                                <div class="events">
                                    <ol id="eventdates" name="eventdates">
                                        <li><a href="#0" data-date="16/01/2014" class="selected">16 Jan</a></li>
                                        <li><a href="#0" data-date="28/02/2014">28 Feb</a></li>
                                        <li><a href="#0" data-date="20/04/2014">20 Mar</a></li>
                                        <li><a href="#0" data-date="20/05/2014">20 May</a></li>
                                        <li><a href="#0" data-date="09/07/2014">09 Jul</a></li>
                                        <li><a href="#0" data-date="30/08/2014">30 Aug</a></li>
                                        <li><a href="#0" data-date="15/09/2014">15 Sep</a></li>
                                        <li><a href="#0" data-date="01/11/2014">01 Nov</a></li>
                                        <li><a href="#0" data-date="10/12/2014">10 Dec</a></li>
                                        <li><a href="#0" data-date="19/01/2015">29 Jan</a></li>
                                        <li><a href="#0" data-date="03/03/2015">3 Mar</a></li>
                                    </ol>
                                    <span class="filling-line" aria-hidden="true"></span>
                                </div>
                            </div>
                            <ul class="cd-timeline-navigation">
                                <li><a href="#0" class="prev inactive">Prev</a></li>
                                <li><a href="#0" class="next">Next</a></li>
                            </ul>
                        </div>
                        <div class="events-content">
                            <ol>
                                <li class="selected" data-date="16/01/2014">
                                    <h2><img class="img-circle pull-left m-r-20 m-b-10" width="60" alt="user" src="../assets/images/users/1.jpg" alt="user"> Horizontal Timeline<br/><small>January 16th, 2014</small></h2>
                                    <hr class="m-t-40">
                                    <p class="m-t-40">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.
                                        <button class="btn btn-info btn-rounded btn-outline m-t-20">Read more</button>
                                    </p>
                                </li>
                                <li data-date="28/02/2014">
                                    <h2><img class="img-circle pull-left m-r-20 m-b-10" width="60" alt="user" src="../assets/images/users/8.jpg" alt="user"> Horizontal Timeline<br/><small>Feb 28th, 2014</small></h2>
                                    <hr class="m-t-40">
                                    <p class="m-t-40">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.
                                        <button class="btn btn-info btn-rounded btn-outline m-t-20">Read more</button>
                                    </p>
                                </li>
                                <li data-date="20/04/2014">
                                    <h2><img class="img-circle pull-left m-r-20 m-b-10" width="60" alt="user" src="../assets/images/users/7.jpg" alt="user"> Horizontal Timeline<br/><small>March 20th, 2014</small></h2>
                                    <hr class="m-t-40">
                                    <p class="m-t-40">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.
                                        <button class="btn btn-info btn-rounded btn-outline m-t-20">Read more</button>
                                    </p>
                                </li>
                                <li data-date="20/05/2014">
                                    <h2><img class="img-circle pull-left m-r-20 m-b-10" width="60" alt="user" src="../assets/images/users/6.jpg" alt="user"> Horizontal Timeline<br/><small>May 20th, 2014</small></h2>
                                    <hr class="m-t-40">
                                    <p class="m-t-40">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.
                                        <button class="btn btn-info btn-rounded btn-outline m-t-20">Read more</button>
                                    </p>
                                </li>
                                <li data-date="09/07/2014">
                                    <h2><img class="img-circle pull-left m-r-20 m-b-10" width="60" alt="user" src="../assets/images/users/5.jpg" alt="user"> Horizontal Timeline<br/><small>July 9th, 2014</small></h2>
                                    <hr class="m-t-40">
                                    <p class="m-t-40">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.
                                        <button class="btn btn-info btn-rounded btn-outline m-t-20">Read more</button>
                                    </p>
                                </li>
                                <li data-date="30/08/2014">
                                    <h2><img class="img-circle pull-left m-r-20 m-b-10" width="60" alt="user" src="../assets/images/users/4.jpg" alt="user"> Horizontal Timeline<br/><small>August 30th, 2014</small></h2>
                                    <hr class="m-t-40">
                                    <p class="m-t-40">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.
                                        <button class="btn btn-info btn-rounded btn-outline m-t-20">Read more</button>
                                    </p>
                                </li>
                                <li data-date="15/09/2014">
                                    <h2><img class="img-circle pull-left m-r-20 m-b-10" width="60" alt="user" src="../assets/images/users/3.jpg" alt="user"> Horizontal Timeline<br/><small>September 15th, 2014</small></h2>
                                    <hr class="m-t-40">
                                    <p class="m-t-40">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.
                                        <button class="btn btn-info btn-rounded btn-outline m-t-20">Read more</button>
                                    </p>
                                </li>
                                <li data-date="01/11/2014">
                                    <h2><img class="img-circle pull-left m-r-20 m-b-10" width="60" alt="user" src="../assets/images/users/2.jpg" alt="user"> Horizontal Timeline<br/><small>November 01st, 2014</small></h2>
                                    <hr class="m-t-40">
                                    <p class="m-t-40">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.
                                        <button class="btn btn-info btn-rounded btn-outline m-t-20">Read more</button>
                                    </p>
                                </li>
                                <li data-date="10/12/2014">
                                    <h2><img class="img-circle pull-left m-r-20 m-b-10" width="60" alt="user" src="../assets/images/users/1.jpg" alt="user"> Horizontal Timeline<br/><small>December 10th, 2014</small></h2>
                                    <hr class="m-t-40">
                                    <p class="m-t-40">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.
                                        <button class="btn btn-info btn-rounded btn-outline m-t-20">Read more</button>
                                    </p>
                                </li>
                                <li data-date="19/01/2015">
                                    <h2>Event title here</h2>
                                    <em>January 19th, 2015</em>
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.
                                    </p>
                                </li>
                                <li data-date="03/03/2015">
                                    <h2>Event title here</h2>
                                    <em>March 3rd, 2015</em>
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.
                                    </p>
                                </li>
                            </ol>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div> -->

@endsection