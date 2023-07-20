<!DOCTYPE html>
<html lang="en">

<?php 
define("ROOT_PATH", $_SERVER["DOCUMENT_ROOT"]);
require_once(ROOT_PATH . '/pages/includes/header.html');
?>

<body>
    <section>
        <div class="container py-4">
            <header class="pb-3 mb-4 border-bottom">
                <a href="/" class="d-flex align-items-center text-body-emphasis text-decoration-none">
                    <img src="./static/images/expense_tracker.png" alt="brand logo" width="32px" height="32px" style="margin-right: 6px !important" />
                    <span class="fs-4">Expense Tracker - Dashboard</span>
                </a>
            </header>
            <div class="p-5 mb-4 bg-body-secondary rounded-3 head-block">
                <h5>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem eveniet recusandae aspernatur</h5>
                <div id="frontPanelCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <!-- card carousel -->
                            <div class="card mb-3">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <!-- https://via.placeholder.com/500/f65050/FFFFFF/?text=Sample+Image -->
                                        <img src="./static/images/expense_tracker.png" class="img-fluid rounded-start" alt="placehold img1">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title">Date: Today</h5>
                                            <h5 class="card-text">Activities</h5>
                                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                            <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <!-- card carousel -->
                            <div class="card mb-3">
                                <div class="row g-0">
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title">Card title 02</h5>
                                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                            <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <img src="./static/images/expense_tracker.png" class="img-fluid rounded-start" alt="placehold img1">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <!-- card carousel -->
                            <div class="card mb-3">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <img src="./static/images/expense_tracker.png" class="img-fluid rounded-start" alt="placehold img1">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title">Card title 03</h5>
                                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                            <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <div class="row mt-5 mb-5">
                <div class="btn-group btn-group-lg" role="group" aria-label="Large button group">
                    <button type="button" class="btn btn-outline-warning" id="navbudgetPlanner">Plan your budget</button>
                    <button type="button" class="btn btn-outline-warning" id="navtransactions">Transactions</button>
                    <button type="button" class="btn btn-outline-warning" id="navreports">Reports</button>
                </div>
            </div>
            <div class="row align-items-md-stretch">
                <div class="yearly col-md-4">
                    <div class="h-100 p-5 text-bg-dark rounded-3">Lorem ipsum dolor sit amet consectetur adipisicing elit.</div>
                </div>
                <div class="monthly col-md-4">
                    <div class="h-100 p-5 text-bg-dark rounded-3">Lorem ipsum dolor sit amet consectetur adipisicing elit.</div>
                </div>
                <div class="daily col-md-4">
                    <div class="h-100 p-5 text-bg-dark rounded-3">Lorem ipsum dolor sit amet consectetur adipisicing elit.</div>
                </div>
            </div>
            <div class="footer pt-3 mt-4 text-body-secondary border-top">Lorem ipsum dolor sit amet consectetur adipisicing elit.</div>
        </div>
    </section>
</body>

<?php
require_once(ROOT_PATH . '/pages/includes/footer.html');
?>