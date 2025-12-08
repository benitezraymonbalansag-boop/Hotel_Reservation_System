 Hotel Reservation System

 Overview

This system is a Hotel Reservation Management System that allows Admins, Staff, and Customers (Users) to manage hotel room bookings efficiently. It implements a multi-level verification and approval system where reservations must be verified by both Staff and Admin before being fully approved.  


 User Roles

1. Admin
   -The Admin has final approval authority over reservations.
    Admin credentials:
      Email: admin@gmail.com
      Password: admin
    Admin can approve, cancel, or mark reservations as unavailable.
    Admins are recognized as ID = 1.

2. Staff
    Staff verifies and checks reservations to ensure no conflicts.
    Staff credentials:
      Email: staff@gmail.com
      Password: staff
    Staff can approve or cancel customer reservations.
    Staff are recognized as ID = 2.

3. Customers (Users)
    Users can sign up, fill in their information, and book hotel rooms.
    Users can view, update, or delete their reservations.
    Reservations by customers start as PENDING and require verification by Staff and Admin.
    User IDs start from 3 and up.


 Reservation Workflow

1. Customer Reservation
   The customer fills out a form with their information.
   Selects room(s) for booking.
   Reservations are saved as PENDING.

2. Staff Verification
    Staff can view all customer reservations.
    Checks for conflicts or double bookings.
    Staff can Approve or Cancel reservations.
    Customers are notified about the Staff’s action.
    Admin receives notifications about Staff’s actions.

3. Admin Final Approval
    Admin views reservations verified by Staff.
    Can Approve, Cancel, or mark reservations as Unavailable.
    Both Admin and Staff approvals are required for a reservation to be considered fully approved.
    Staff and Customers are notified about the Admin’s decision.


Notifications

   Notifications are sent to relevant users whenever:
   Staff approves or cancels a reservation.
   Admin approves, cancels, or marks a reservation as unavailable.

 Important Notes

 Reservation Statuses:
   Pending → Awaiting Staff verification.
   Approved by Staff → Verified by Staff, awaiting Admin approval.
   Approved → Fully approved by both Staff and Admin.
   Cancelled → Cancelled by Staff or Admin.
   Unavailable → Marked by Admin as unavailable.


 Group Members

 Amaro, Johnly  
 Benitez, Raymon  
 Cabanag, Anale  
 Gonzalez, Maria Nica  
 Quiroquiro, Khiven  


 System Requirements

 PHP 7.4+  
 MySQL Database  
 Web Server (e.g., XAMPP, WAMP)  
 Modern Web Browser  

