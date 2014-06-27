<?php namespace SCM\Controller;

use SCM\Classes\View;
use SCM\Model\Course;
use SCM\Model\Payment;
use SCM\Model\User;

/**
 * Class MainPageController
 * @package SCM\Controller
 *
 * @since 1.0
 * @author Darryl Coder
 */

class MainPageController {

    /**
     * displays main page
     */
    public function index()
    {
        $payment = array();
        $course  = array();
        $student = array();

        // for payments
        $payment['total_count'] = Payment::all()->count();
        $payment['total_unconfirmed'] = Payment::ofUnPaid()->count();
        $payment['total_confirmed']  = Payment::ofPaid()->count();

        $totalSales = 0;
        $payments = Payment::with('course')->get();
        $payments->each(function($payment) use (&$totalSales) {
            $totalSales = ($totalSales + intval($payment->course->fee));
        });

        // for courses
        $course['total_courses'] = Course::all()->count();

        // for students
        $student['total_students'] = User::all()->count();

        View::make('templates/admin/dashboard.php',compact('payment','course','student','totalSales'));
    }

}