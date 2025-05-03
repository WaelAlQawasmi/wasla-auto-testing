<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;

// test comment
// ok
use Tests\DuskTestCase;

class DashboardTest extends DuskTestCase
{
    /**
     * Log in to the application.
     */
    public function testLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('https://wasla-jo.laravel.cloud/admin/login')
                ->type('email', 'dev@wasla.com') // Type your email
                ->type('password', 'wasla2@25')      // Type your password
                ->press('#login-button')                           // Press the login button
                ->waitForLocation('/dashboard');
        });
    }

    /**
     * Test Dashboard
     */

    public function testDashboard()
    {
        $this->browse(function (Browser $browser) {
            // We are already logged in at this point

            // Click on the "Uncompleted Orders" link/button
            $browser
                ->assertSee('Dashboard')
                ->assertSee('Update Data')
                ->waitFor('.card-body')  // Wait for the cards to load

                // Check that "Total Orders Today" label exists
                ->assertSeeIn('.card-label', 'TOTAL ORDERS TODAY')

                // Check that "Active Orders" label exists
                ->assertSee('ACTIVE ORDERS')
                ->assertSee('COMPLETED ORDERS')
                ->assertSee('NEW CUSTOMERS (WEEK)')
                ->assertSee('AVG. ORDER VALUE')
                ->assertSee('COMPLETED ORDERS THIS YEAR')
                ->assertSee('REVENUE TODAY')
                ->assertSee('AVAILABLE DRIVERS')
                ->assertSee('IN PROGRESS ORDERS')
                ->assertSee('PENDING ORDERS')
                ->assertSee('CANCELED ORDERS')
                ->assertSee('ACTIVE STATUS DRIVERS')
                ->assertSee('Completed')
                ->assertSee('Offer Accepted')
                ->assertSee('Driver Started')
                ->assertSee('Unknown Status')
                ->assertSee('Weekly Order Trend')
                ->assertSee('Daily Revenue (Last 7 Days)')
                ->assertSee('Top Regions by Order Volume')

                ->click('#btn-dashboard-refresh')
                ->assertSee('Dashboard data has been refreshed successfully.')

                ;
        });
    }

    /**
     * Test side bar on the dashboard.
     */
    public function testSideBar()
    {
        $this->browse(function (Browser $browser) {
            // We are already logged in at this point
            $browser
                ->waitFor('.sidebar')
                ->assertSee('Uncompleted Orders')
                ->assertSee('Advertising')
                ->assertSee('Admins')
                ->assertSee('Drivers')
                ->assertSee('Loyalty Points')
                ->assertSee('Orders')
                ->assertSee('Customers')
                ->assertSee('Push Notifications')
                ->assertSee('System Settings')
                ;
        });
    }

    public function testcolumn()
    {
        $this->browse(function (Browser $browser) {
            // We are already logged in at this point
            $browser
                ->press('#UncompletedOrders')
                ->assertSee('No Uncompleted Orders')

                ->press('#Admins')
                ->assertSee('Search & Filters')
                ->assertSee('Toggle Filters')
                ->assertSee('Add New Admin')
                ->assertSee('Admins List')
                ->assertSee('Search')
                ->assertSee('Filter by Role')
                ->assertSee('All Role')
                ->assertSee('All')
                ->assertSee('Active')
                ->assertSee('Inactive')
                ->assertSee('Id')
                ->assertSee('Name')
                ->assertSee('Email')
                ->assertSee('Mobile')
                ->assertSee('Role')
                ->assertSee('Status')
                ->assertSee('Actions')
             // ->assertSee('Showing 0 to 0 of 0 entries')
                ->assertSee('Previous')
                ->assertSee('Next')
                ->assertSee('records')


                ->press('#Advertising')
                ->assertSee('Advertising Images')
                ->assertSee('Upload New Image')



                ->press('#Drivers')
                ->assertSee('Drivers')
                ->assertSee('Search & Filters')
                ->assertSee('Search')
                ->assertSee('Filter by Status')
                ->assertSee('Toggle Filters')
                ->assertSee('All Status')
                ->assertSee('Reset All Filters')
                ->assertSee('Quick Filters:')
                ->assertSee('Pending Accounts')
                ->assertSee('Active Accounts')
                ->assertSee('Drivers List')
                ->assertSee('ID')
                ->assertSee('Name')
                ->assertSee('Mobile')
                ->assertSee('Availability')
                ->assertSee('Previous')
                ->assertSee('Next')
                ->assertSee('Account Status')
                ->assertSee('Account Actions')
                ->assertSee('View')

                ->press('#LoyaltyPoints')
                ->assertSee('Manage Loyalty Points Requests')
                ->assertSee('Loyalty Points')
                ->assertSee('Filter by Status:')
                ->assertSee('Pending')
                ->assertSee('Search:')
                ->assertSee('ID')
                ->assertSee('Driver Name')
                ->assertSee('Points')
                ->assertSee('Request Date')
                ->assertSee('Status')
                ->assertSee('Note')
                ->assertSee('Actions')
                ->assertSee('Previous')
                ->assertSee('Next')
                ->assertSee('Showing')
                ->assertSee('entries')



                ->press('#Orders')
                ->assertSee('Orders')
                ->assertSee('Search & Filters')
                ->assertSee('Filter by Status')
                ->assertSee('Search')
                ->assertSee('Toggle Filters')
                ->assertSee('Reset All Filters')
                ->assertSee('Orders List')
                ->assertSee('records')
                ->assertSee('ID')
                ->assertSee('Order Number')
                ->assertSee('Driver')
                ->assertSee('Cost')
                ->assertSee('Status')
                ->assertSee('Showing')
                ->assertSee('entries')
                ->assertSee('Previous')
                ->assertSee('Next')


                ->press('#Customers')
                ->assertSee('Customers')
                ->assertSee('Customers Management')
                ->assertSee('Add New Customer')
                ->assertSee('Search & Filters')
                ->assertSee('Toggle Filters')
                ->assertSee('Search')
                ->assertSee('Filter by Status')
                ->assertSee('Reset All Filters')
                ->assertSee('Customers List')
                ->assertSee('ID')
                ->assertSee('Name')
                ->assertSee('Mobile')
                ->assertSee('Status')
                ->assertSee('Note')
                ->assertSee('View')
                ->assertSee('Action')
                ->assertSee('Showing')
                ->assertSee('entries')
                ->assertSee('Previous')
                ->assertSee('Next')


                ->press('#PushNotifications')
                ->assertSee('Send Push Notification')
                ->assertSee('Push Notifications')
                ->assertSee('Target Audience')
                ->assertSee('Notification Title')
                ->assertSee('Notification Body')
                ->assertSee('Send Notification')


                ->press('#SystemSettings')
                ->assertSee('Admin Panel')
                ->assertSee('System Settings')
                ->assertSee('Online Payment')
                ->assertSee('Maintenance Mode')
                ->assertSee('App Version')
                ->assertSee('Format: X.XXX (e.g., 1.001)')
                ->assertSee('Update Setting')
                ->assertSee('Developer Tools')
                ->assertSee('Telescope')
                ->assertSee('Swagger')
                ;
        });
    }

    public function testadmin()
    {

        $this->browse(function (Browser $browser) {
            // We are already logged in at this point
            $randomEmail = 'rania' . \Illuminate\Support\Str::random(5) . '@wasla.com';
            $randomMobile = '078' . rand(1000000, 9999999);

            $browser ->visit('https://wasla-jo.laravel.cloud/admin/create')
            ->waitForLocation('/admin/create')

            ->assertSee('Admin Panel')
            ->assertSee('Admin Information')
            ->assertSee('Name')
            ->assertSee('Email')
            ->assertSee('Password')
            ->assertSee('Confirm Password')
            ->assertSee('Mobile')
            ->assertSee('Role')
            ->assertSee('Create Admin')
            ->assertSee('Back to List')
            ->assertSee('Add New Admin')

            ->type('name','rania')
            ->type('email',$randomEmail)
            ->type('password','r1234567')
            ->type('password_confirmation','r1234567')
            ->type('mobile',$randomMobile)
            ->select('role_id','1')
            ->press('#btn-create-admin')
            ->waitForLocation('/admin')
            ->waitForText('Admin created successfully')
            ->assertSee('Admin created successfully')



            ->press('#btn-add-new-admin')
            ->waitForLocation('/admin/create')
            ->type('name','rania')
            ->type('email','ran@wasla.com')
            ->type('password','r1234567')
            ->type('password_confirmation','r1234567j')
            ->type('mobile','0786742345')
            ->select('role_id','1')
            ->press('#btn-create-admin')
            ->assertSee('The email has already been taken.')
            ->assertSee('The password field confirmation does not match.')


            ->press('#btn-back-to-admin-list')
            ->type('#globalSearch','ran@wasla.com')
           // ->assertSee('rania')
           // ->assertSee('General Manager')
          //  ->press('#btn-admin-actions-3')

            ;

        });
    }
    public function testAdvertising()
    {
        $this->browse(function (Browser $browser) {
            // We are already logged in at this point
            $browser ->visit('https://wasla-jo.laravel.cloud/advertising')
                ->waitForLocation('/advertising')
                ->press('#btn-upload-new-image')
                ->waitForLocation('/advertising/create')
                ->assertSee('Upload Advertising Image')
                ->assertSee('Select Image')
                ->assertSee('Upload Image')
                ->assertSee('Cancel')
               // ->attach('image',public_path('favicon.ico'))


                ;

            });
            }

            public function testDrivers()
            {
                $this->browse(function (Browser $browser) {
                    // We are already logged in at this point
                    $browser ->visit('https://wasla-jo.laravel.cloud/admin/drivers')
                        ->waitForLocation('/admin/drivers')

                        ->assertSee('Drivers')
                        ->assertSee('Search & Filters')
                        ->assertSee('Toggle Filters')
                        ->assertSee('Search')
                        ->assertSee('Filter by Status')
                        ->assertSee('Quick Filters:')
                        ->assertSee('All Statuses')
                        ->assertSee('Reset All Filters')
                        ->assertSee('Drivers List')
                        ->assertSee('ID')
                        ->assertSee('Name')
                        ->assertSee('Availability')
                        ->assertSee('Mobile')
                        ->assertSee('Account Actions')
                        ->assertSee('View')
                        ->assertSee('Previous')
                        ->assertSee('Next')
                        ->check('#select-all')


                        ->assertSee('Send Notification')
                        ->assertSee('Notify about Order')
                        ->assertSee('Clear')
                        ->assertSee('drivers selected')

                        ->press('#orderOverlayBtn')
                        ->waitForText('Notify Drivers about Order')
                        ->assertSee('Order ID')
                        ->assertSee('Cancel')


/*
                        //اللي قبل ما فيهم اي مشكلة
                        ->click('#bulkNotificationBtn')
                        ->waitForText('Bulk Notification')
                        ->assertSee('Recipients')
                        ->assertSee('Notification Title')
                        ->assertSee('Notification Message')
                        ->assertSee('Cancel')
                        ->assertSee('Send Notification')
                        ->assertSee('users selected')
                        ->type('title','hi')
                        ->type('#multi_notification_body','hi')
                        ->press('#sendMultiNotificationBtn')
                        ->assertSee('Notification has been queued for sending to')
*/
                ;

            });
            }


            public function testOrders()
            {
                $this->browse(function (Browser $browser) {
                    // We are already logged in at this point
                    $browser ->visit('https://wasla-jo.laravel.cloud/admin/orders')
                        ->waitForLocation('/admin/orders')

                        ->assertSee('Orders')
                        ->assertSee('Search & Filters')
                        ->assertSee('Search')
                        ->assertSee('Filter by Status')
                        ->assertSee('ID')
                        ->assertSee('Toggle Filters')
                        ->assertSee('Reset All Filter')
                        ->assertSee('Orders List')
                        ->assertSee('Customer')
                        ->assertSee('Cost')
                        ->assertSee('Driver')
                        ->assertSee('Status')
                        ->assertSee('Created At')
                        ->assertSee('Actions')
                        ->assertSee('Showing')
                        ->assertSee('entries')
                        ->assertSee('Next')
                        ->assertSee('Previous')
                        ;

                    });
                    }

                    public function testLoyaltyPoints()
                    {
                        $this->browse(function (Browser $browser) {
                            // We are already logged in at this point
                            $browser ->visit('https://wasla-jo.laravel.cloud/admin/point-convert-requests')
                                ->waitForLocation('/admin/point-convert-requests')
                                ->assertSee('Loyalty Points')
                                ->assertSee('Manage Loyalty Points Requests')
                                ->assertSee('Search:')
                                ->assertSee('Filter by Status')
                                ->assertSee('ID')
                                ->assertSee('Driver Name')
                                ->assertSee('Points')
                                ->assertSee('Request Date')
                                ->assertSee('Status')
                                ->assertSee('Note')
                                ->assertSee('Actions')
                                ->assertSee('Next')
                                ->assertSee('Previous')
                                ;

                            });
                            }


                            public function testCustomers()
                            {
                                $this->browse(function (Browser $browser) {
                                    // We are already logged in at this point
                                    $browser ->visit('https://wasla-jo.laravel.cloud/admin/customers')
                                        ->waitForLocation('/admin/customers')
                                        ->assertSee('Customers')
                                        ->assertSee('Customers Management')
                                        ->assertSee('Search')
                                        ->assertSee('Filter by Status')
                                        ->assertSee('ID')
                                        ->assertSee('Name')
                                        ->assertSee('Mobile')
                                        ->assertSee('View')
                                        ->assertSee('Status')
                                        ->assertSee('Note')
                                        ->assertSee('Actions')
                                        ->assertSee('Next')
                                        ->assertSee('Previous')
                                        ->assertSee('Showing')
                                        ->assertSee('entries')
                                        ->assertSee('Add New Customer')


                                        ->press('#btn-add-new-customer')
                                        ->waitForLocation('/admin/customers/create')
                                        ->assertSee('Add New Customer')
                                        ->assertSee('Customer Information')
                                        ->assertSee('Full Name')
                                        ->assertSee('Mobile Number')
                                        ->assertSee('Status ')
                                        ->assertSee('Create Customer')
                                        ->assertSee('Back to List')

                                        ->type('#full_name','rania')
                                        ->type('#mobile','0786453425')

                                        /*->waitForText('Customer created successfully')
                                        ->assertSee('rania')
                                        ->assertSee('0786453425')
                                        */



                                        ;

                                    });
                                    }

                                    public function testPushNotifications()
                                    {
                                        $this->browse(function (Browser $browser) {
                                            // We are already logged in at this point
                                            $browser ->visit('https://wasla-jo.laravel.cloud/notifications')
                                                ->waitForLocation('/notifications')
                                                ->assertSee('Push Notifications')
                                                ->assertSee('Send Push Notification')
                                                ->assertSee('Target Audience')
                                                ->assertSee('Notification Title')
                                                ->assertSee('Notification Body')
                                                ->assertSee('Send Notification')
                                                ->type('#title','Hi')
                                                ->type('#body','Hi')
                                                ->select('#topic','driver_topic')
                                                ->press('#btn-send-notification')
                                                ->assertSee('Notification has been queued for sending.')
                                                ;

                                            });
                                            }

                                            public function testSettings()
                                            {
                                                $this->browse(function (Browser $browser) {
                                                    // We are already logged in at this point
                                                    $browser ->visit('https://wasla-jo.laravel.cloud/admin/system-settings')
                                                        ->waitForLocation('/admin/system-settings')
                                                        ->assertsee('Admin Panel')
                                                        ->assertsee('System Settings')
                                                        ->assertsee('Online Payment')
                                                        ->assertsee('Maintenance Mode')
                                                        ->assertsee('App Version')
                                                        ->assertsee('Apple API Link')
                                                        ->assertsee('Google Play API Link')
                                                        ->assertsee('WhatsApp Link')
                                                        ->assertsee('Facebook Page Link')
                                                        ->assertsee('Instagram Page Link')
                                                        ->assertsee('Update Settings')
                                                        ->assertsee('Developer Tools')
                                                        ->assertsee('Telescope')
                                                        ->assertsee('Swagger')


                                                        ;

                                                    });
                                                    }









    }
