<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Site\IndexController');
$routes->setDefaultMethod( 'loadIndex' );
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute( FALSE );

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get( '/' , 'Site\IndexController::index');

$routes->group( "login", [ "filter" => "IsNotLogin" ], function( $routes ) {
    $routes->get( ''        , 'Dashboard\LoginController::index' );
    $routes->post( 'submit' , 'Dashboard\LoginController::submit' );
} );

$routes->group( "recovery", [ "filter" => "IsNotLogin" ], function( $routes ) {
    $routes->get( ''        , 'Dashboard\LoginController::recoveryPage' );
    $routes->post( 'submit' , 'Dashboard\LoginController::submitRecovery' );
} );

$routes->group( "register",[ "filter" => "IsNotLogin" ], function( $routes ) {
    $routes->get( ''                , 'Dashboard\RegisterController::index' );
    $routes->post( 'submit'         , 'Dashboard\RegisterController::submit' );

    $routes->get( 'verify'          , 'Dashboard\RegisterController::verify', [ "filter" => "IsFromRequest" ] );
    $routes->post( 'verify/submit'  , 'Dashboard\RegisterController::verifySubmit' );
} );

$routes->get('/logout'      , 'Dashboard\DashboardController::logout');

$routes->group( "dashboard" , [ "filter" => "IsLogin" ], function( $routes ) {
    $routes->get( ''        , 'Dashboard\DashboardController::index' );
    $routes->post( 'update' , 'Dashboard\DashboardController::updateProfile' );

    $routes->group( "booking" , function( $routes ) {
        $routes->get( ''        , 'Dashboard\BookingController::index' );
        $routes->post( 'submit' , 'Dashboard\BookingController::submit' );

        $routes->get( 'data-patient' , 'Dashboard\BookingController::getBookingPatientData' ); // in patient panel

        $routes->get( "turns", "Dashboard\BookingController::showTurns" );
        $routes->get( "turns-data", "Dashboard\BookingController::turnsData" );
    } );

    $routes->group( "reserve" , function( $routes ) {
        $routes->get( ''        , 'Dashboard\ReservationController::index' );
        $routes->post( 'submit' , 'Dashboard\ReservationController::submit' );

        $routes->get( "turns", "Dashboard\ReservationController::showTurns" );
        $routes->get( "turns-data", "Dashboard\ReservationController::turnsData" );
    } );

    $routes->group( "question-answer" , function( $routes ) {
        $routes->group( "patient" , function( $routes ) {
            $routes->get( ""        , "Dashboard\QuestionAndAnswerController::indexPatient" );
            $routes->get( "create"  , "Dashboard\QuestionAndAnswerController::createPatient" );
            $routes->post( "submit" , "Dashboard\QuestionAndAnswerController::submitPatient" );
            $routes->get( "show"    , "Dashboard\QuestionAndAnswerController::showPatient" );
            $routes->get( "detail"  , "Dashboard\QuestionAndAnswerController::detailPatient" );
            $routes->post( "submit-answer" , "Dashboard\QuestionAndAnswerController::submitAnswer" );
            $routes->post( "close" , "Dashboard\QuestionAndAnswerController::closePatient" );
            $routes->post( "delete", "Dashboard\QuestionAndAnswerController::deletePatient" );
        } );
        $routes->group( "doctor" , function( $routes ) {
            $routes->get( ""        , "Dashboard\QuestionAndAnswerController::indexDoctor" );
            $routes->get( "show"    , "Dashboard\QuestionAndAnswerController::showDoctor" );
            $routes->get( "detail"  , "Dashboard\QuestionAndAnswerController::detailDoctor" );
            $routes->post( "submit-answer" , "Dashboard\QuestionAndAnswerController::submitAnswer" );
            $routes->post( "close" , "Dashboard\QuestionAndAnswerController::closeDoctor" );
            $routes->post( "delete", "Dashboard\QuestionAndAnswerController::deleteDoctor" );
        } );
    } );

    $routes->group( "exam", function( $routes ) {
        $routes->get( "", "Dashboard\ExamController::index" );
        $routes->get( "data", "Dashboard\ExamController::get" );
        $routes->get( "page", "Dashboard\ExamController::page" );
        $routes->get( "page/data", "Dashboard\ExamController::getQuestions" );
        $routes->post( "submit", "Dashboard\ExamController::submitAnswer" );
    } );
} );

$routes->group( "admin", [ "filter" => "IsAdmin" ], function( $routes ) {
    $routes->get( "dashboard", "Admin\DashboardController::index" );
} );

//callback payment /Dashboard\reserve/callback
//separate from group because login may be expired after payment
$routes->get( 'callback-reservation' , 'Dashboard\ReservationController::callbackPayment' );

$routes->get( "/(:segment)/(:any)"  , "Site\PostController::index/$1/$2" );

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
