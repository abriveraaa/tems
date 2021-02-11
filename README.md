# Tools and Equipment Monitoring System | Laravel 7

A simple system that will greatly help the college department' s laboratory office in updating, maintaining records of their tools and equipment, providing transaction history of the borrower and providing a monitoring system that will speed up the process in request and inventory of the tools and equipment in the laboratory office.

The system admin has two roles; the administrator and the assistant. The administrator has all the permission(including changing the permission of the assistant) in the system while the assistant can only manage the dashboard and request. 

You can manage your Admin, Borrower, Tools and Equipment, Tool Categories, Colleges, Courses, Room, Reports.

---
System requirements:

- [Laravel 7+](https://laravel.com/docs/7.x/releases)
- [PHP V7.3](https://www.apachefriends.org/download.html)

System is mostly generated with [AdminLTE](https://github.com/jeroennoten/Laravel-AdminLTE).

Other assets used:

- [CoreUI Free theme](https://coreui.io/demo/#main.html) (Bootstrap 4)
- [DOMPDF V0.9](https://github.com/dompdf/dompdf)
- [ID Generator V1](https://github.com/haruncpi/laravel-id-generator)
- [DataTables V9](https://yajrabox.com/docs/laravel-datatables/master/installation)

---

## How to use

### Preparation

- Clone the repository with __git clone__ or download the file
- Copy __.env.example__ file to __.env__ and edit database credentials
- Run __composer install__
- Run __php artisan key:generate__
- Run __php artisan migrate --seed__ [has a default data(admin and assistant)to access the system]
- Run __php artisan serve__

### Deployment
Run the following command or read the official documentation for [deployment](https://laravel.com/docs/7.x/deployment)
- Run __composer install --optimize-autoloader --no-dev__
- Run __php artisan config:cache__
- Run __php artisan route:cache__
- Run __php artisan view:cache__

### Default credentials
You can login to adminpanel with the following credentials:
#### Administrator:
- username - __administrator@tems.com__ 

- password - __password__

#### Assistant:
- username - __assistant@tems.com__ 

- password - __password__


## License

Basically, feel free to use any way you want.

---

## Connect with me
- [Facebook](http://facebook.com/abriveraaa)
