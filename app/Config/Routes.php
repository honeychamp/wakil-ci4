<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('about', 'Home::about');
$routes->get('services', 'Home::services');
$routes->get('services/(:segment)', 'Home::serviceDetail/$1');
$routes->post('services/submit-case', 'Home::submitCaseRequest');
$routes->get('team', 'Home::team');
$routes->get('contact', 'Home::contact');
$routes->get('blog', 'Home::blog');
$routes->get('blog/(:segment)', 'Home::blogDetail/$1');
$routes->post('contact/submit', 'Contact::submit');

// Admin Routes
$routes->get('admin', 'Admin::index');
$routes->post('admin/loginAuth', 'Admin::loginAuth');
$routes->get('admin/dashboard', 'Admin::dashboard');
$routes->get('admin/logout', 'Admin::logout');
$routes->post('admin/updateLeadStatus', 'Admin::updateLeadStatus');
$routes->get('admin/deleteLead/(:num)', 'Admin::deleteLead/$1');

// Admin Clients Management
$routes->get('admin/clients', 'Admin::clients');
$routes->post('admin/addClient', 'Admin::addClient');
$routes->get('admin/deleteClient/(:num)', 'Admin::deleteClient/$1');
$routes->post('admin/resetClientPassword', 'Admin::resetClientPassword');

// Admin Cases Management
$routes->get('admin/cases', 'Admin::cases');
$routes->post('admin/addCase', 'Admin::addCase');
$routes->get('admin/case/(:num)', 'Admin::caseDetail/$1');
$routes->post('admin/updateCaseStatus', 'Admin::updateCaseStatus');
$routes->post('admin/uploadCaseDocument', 'Admin::uploadCaseDocument');
$routes->post('admin/sendCaseMessage', 'Admin::sendCaseMessage');

// Admin Blog CMS
$routes->get('admin/blogs', 'Admin::blogs');
$routes->get('admin/blogs/add', 'Admin::addBlogForm');
$routes->post('admin/blogs/store', 'Admin::storeBlog');
$routes->get('admin/blogs/edit/(:num)', 'Admin::editBlogForm/$1');
$routes->post('admin/blogs/update/(:num)', 'Admin::updateBlog/$1');
$routes->get('admin/blogs/delete/(:num)', 'Admin::deleteBlog/$1');

// Admin Team CMS
$routes->get('admin/team', 'Admin::team');
$routes->post('admin/team/store', 'Admin::storeTeam');
$routes->get('admin/team/delete/(:num)', 'Admin::deleteTeam/$1');

// Admin Invoices & Calendar
$routes->get('admin/invoices', 'Admin::invoices');
$routes->post('admin/invoices/store', 'Admin::storeInvoice');
$routes->post('admin/invoices/updateStatus', 'Admin::updateInvoiceStatus');
$routes->get('admin/invoices/delete/(:num)', 'Admin::deleteInvoice/$1');
$routes->get('admin/calendar', 'Admin::calendar');
$routes->get('admin/notifications', 'Admin::notifications');

// Client Portal Routes
$routes->get('client', 'ClientPortal::index');
$routes->post('client/loginAuth', 'ClientPortal::loginAuth');
$routes->get('client/dashboard', 'ClientPortal::dashboard');
$routes->get('client/case/(:num)', 'ClientPortal::caseDetail/$1');
$routes->post('client/uploadCaseDocument', 'ClientPortal::uploadCaseDocument');
$routes->post('client/sendCaseMessage', 'ClientPortal::sendCaseMessage');
$routes->get('client/invoices', 'ClientPortal::invoices');
$routes->get('client/invoice/(:num)', 'ClientPortal::invoiceDetail/$1');
$routes->post('client/invoice/pay/(:num)', 'ClientPortal::payInvoice/$1');
$routes->get('client/calendar', 'ClientPortal::calendar');
$routes->get('client/logout', 'ClientPortal::logout');


