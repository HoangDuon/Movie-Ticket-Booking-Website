# Cinema Ticket Booking Website

A responsive web application for booking movie tickets online
## 🚀 Features

- Browse movies and showtimes
- Dynamic seat selection with real-time availability
- User authentication & booking history
- Concession (combo) selection during booking
- Admin panel for managing movies, rooms, and schedules, users
- VNPAY integration for online payment
- Email confirmation via PHPMailer
- Rich text editing for movie descriptions using CKEditor
- Mobile-friendly, responsive design (Bootstrap, jsDelivr CDN)

## 🛠️ Technologies Used

### 🔧 Back-end
- **PHP** (Core logic & routing)
- **MySQL** (Database management)
- **PHPMailer** (Email confirmation & notifications)
- **VNPAY API** (Secure payment gateway integration)

### 💻 Front-end
- **JavaScript + AJAX** (Dynamic seat selection, countdown timer)
- **Bootstrap 5** (Responsive UI)
- **CKEditor** (Movie content editing)

---

## 🧪 How to Run (XAMPP + phpMyAdmin)

1. **Clone or download this repository** into your `htdocs` folder (e.g. `C:\xampp\htdocs\`):
2. **Start Apache and MySQL in the XAMPP Control Panel.

3. **Create the database:

- Go to http://localhost/phpmyadmin

- Create a new database (e.g. cinema_db)

- Import the file movi_ticket_booking.sql in /congfig/ provided in the project.

4. **Configure your database in config.php:
5. **Run the application:

- Open your browser and go to: http://localhost/Movie-Ticket-Booking-Website/
